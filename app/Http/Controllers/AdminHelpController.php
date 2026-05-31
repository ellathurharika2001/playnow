<?php

namespace App\Http\Controllers;

use App\Models\HelpConversation;
use App\Models\HelpMessage;
use App\Models\HelpMessageReaction;
use App\Models\Turf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminHelpController extends Controller
{
    /**
     * Display the help chat interface with vendor selection
     */
    public function help(Request $request)
    {
        // Get selected vendor ID from request or session
        $selectedVendorId = $request->input('vendor_id', session('admin_help_vendor_id'));
        
        // Get all vendors with active conversations or all vendors
        $vendors = Turf::select('id', 'owner_name', 'turf_name', 'email')
            ->whereHas('helpConversation')
            ->orWhereHas('helpMessages')
            ->with(['helpConversation', 'latestHelpMessage'])
            ->withCount(['unreadHelpMessages'])
            ->orderByDesc('unread_help_messages_count')
            ->orderBy('owner_name')
            ->get();
        
        // If no vendors found, get all vendors
        if ($vendors->isEmpty()) {
            $vendors = Turf::select('id', 'owner_name', 'turf_name', 'email')
                ->orderBy('owner_name')
                ->get();
        }
        
        $messages = collect();
        $conversation = null;
        $selectedVendor = null;
        
        if ($selectedVendorId) {
            // Store selected vendor in session
            session(['admin_help_vendor_id' => $selectedVendorId]);
            
            // Get selected vendor details
            $selectedVendor = Turf::find($selectedVendorId);
            
            if ($selectedVendor) {
                // Get or create conversation
                $conversation = HelpConversation::firstOrCreate(
                    ['vendor_id' => $selectedVendorId],
                    ['status' => 'active']
                );

                // Get all messages for this vendor
               $messages = HelpMessage::where(function ($query) use ($selectedVendorId) {
                    $query->where('sender_type', 'vendor')
                        ->where('sender_id', $selectedVendorId);
                })
                ->orWhere(function ($query) use ($selectedVendorId) {
                    $query->where('sender_type', 'admin')
                        ->where('sender_id', $selectedVendorId);
                })
                ->with('messageReactions')
                ->orderBy('created_at', 'asc')
                ->get()
                ->map(function ($message) use ($selectedVendor) {
                    return [
                        'id' => $message->id,
                        'sender' => $message->sender_type,
                        'sender_name' => $message->sender_type === 'admin'
                            ? 'You (Admin)'
                            : $selectedVendor->owner_name,
                        'message' => $message->message,
                        'timestamp' => $message->created_at,
                        'reactions' => $message->grouped_reactions ?? [],
                        'is_read' => $message->is_read,
                        'avatar' => null,
                    ];
                });

                // Mark all vendor messages as read
                HelpMessage::where('sender_type', 'vendor')
                    ->where('sender_id', $selectedVendorId)
                    ->unread()
                    ->update(['is_read' => true, 'read_at' => now()]);

                $conversation->markAsReadFor('admin');
            }
        }

        return view('admin.vendors.help', compact('messages', 'conversation', 'vendors', 'selectedVendorId', 'selectedVendor'));
    }

    /**
     * Fetch new messages (AJAX polling)
     */
    public function fetchMessages(Request $request)
    {
        $vendorId = $request->input('vendor_id');
        $lastMessageId = $request->input('last_message_id', 0);

        if (!$vendorId) {
            return response()->json([
                'success' => false,
                'message' => 'Vendor ID required',
            ], 400);
        }

        $vendor = Turf::find($vendorId);

        // Get new messages since last fetch
        $newMessages = HelpMessage::where('id', '>', $lastMessageId)
            ->where(function($query) use ($vendorId) {
                $query->where('sender_type', 'vendor')
                      ->where('sender_id', $vendorId);
            })->orWhere(function($query) use ($lastMessageId) {
                $query->where('sender_type', 'admin')
                     ->where('sender_id', $lastMessageId);
            })
            ->with('messageReactions')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) use ($vendor) {
                return [
                    'id' => $message->id,
                    'sender' => $message->sender_type === 'admin' ? 'admin' : 'vendor',
                    'sender_name' => $message->sender_type === 'admin' ? 'You (Admin)' : $vendor->owner_name,
                    'message' => $message->message,
                    'timestamp' => $message->created_at->format('c'), // ISO 8601 format
                    'time_display' => $message->created_at->format('g:ia'),
                    'date_display' => $this->getDateDisplay($message->created_at),
                    'reactions' => $message->grouped_reactions ?? [],
                    'is_read' => $message->is_read,
                ];
            });

        // Mark new vendor messages as read
        if ($newMessages->isNotEmpty()) {
            HelpMessage::where('sender_type', 'vendor')
                ->where('sender_id', $vendorId)
                ->where('id', '>', $lastMessageId)
                ->unread()
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'messages' => $newMessages,
            'has_new_messages' => $newMessages->isNotEmpty(),
        ]);
    }

    /**
     * Send a new message from admin
     */
    public function sendMessage(Request $request)
    {
        $vendorId = $request->vendor_id;

        $conversation = HelpConversation::firstOrCreate(
            ['vendor_id' => $vendorId],
            ['status' => 'active']
        );

        DB::beginTransaction();
        try {
            $helpMessage = HelpMessage::create([
                'sender_id' => $vendorId, 
                'sender_type' => 'admin',
                'message' => $request->message,
                'is_read' => false,
            ]);

            $conversation->updateAfterMessage($helpMessage);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $helpMessage->id,
                    'sender' => 'admin',
                    'sender_name' => 'You (Admin)',
                    'message' => $helpMessage->message,
                    'timestamp' => $helpMessage->created_at->format('c'),
                    'time_display' => $helpMessage->created_at->format('g:ia'),
                    'date_display' => $this->getDateDisplay($helpMessage->created_at),
                    'reactions' => [],
                    'is_read' => false,
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Add reaction to a message
     */
    public function addReaction(Request $request, $messageId)
    {
        $request->validate([
            'emoji' => 'required|string|max:10',
        ]);

        $adminId = Auth::id();

        try {
            $reaction = HelpMessageReaction::updateOrCreate(
                [
                    'help_message_id' => $messageId,
                    'user_id' => $adminId,
                    'user_type' => 'admin',
                    'emoji' => $request->emoji,
                ],
                []
            );

            $message = HelpMessage::find($messageId);

            return response()->json([
                'success' => true,
                'reactions' => $message->grouped_reactions,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add reaction',
            ], 500);
        }
    }

    /**
     * Remove reaction from a message
     */
    public function removeReaction(Request $request, $messageId)
    {
        $request->validate([
            'emoji' => 'required|string|max:10',
        ]);

        $adminId = Auth::id();

        try {
            HelpMessageReaction::where('help_message_id', $messageId)
                ->where('user_id', $adminId)
                ->where('user_type', 'admin')
                ->where('emoji', $request->emoji)
                ->delete();

            $message = HelpMessage::find($messageId);

            return response()->json([
                'success' => true,
                'reactions' => $message->grouped_reactions ?? [],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove reaction',
            ], 500);
        }
    }

    /**
     * Get display format for date
     */
    private function getDateDisplay($date)
    {
        if ($date->isToday()) {
            return 'Today';
        } elseif ($date->isYesterday()) {
            return 'Yesterday';
        } else {
            return $date->format('l, F j');
        }
    }

    /**
     * Get total unread message count across all vendors
     */
    public function getUnreadCount()
    {
        $count = HelpMessage::where('sender_type', 'vendor')
            ->unread()
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Get unread count for specific vendor
     */
    public function getVendorUnreadCount($vendorId)
    {
        $count = HelpMessage::where('sender_type', 'vendor')
            ->where('sender_id', $vendorId)
            ->unread()
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
}