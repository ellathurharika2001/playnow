<?php

namespace App\Http\Controllers;

use App\Models\HelpMessage;
use App\Models\HelpConversation;
use App\Models\HelpMessageReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HelpController extends Controller
{
    /**
     * Display the help chat interface
     */
    public function help()
    {
        $vendorId = Auth::guard('vendor')->id();
        
        // Get or create conversation   
        $conversation = HelpConversation::firstOrCreate(
            ['vendor_id' => $vendorId],
            ['status' => 'active']
        );

        // Get all messages for this vendor
        $messages = HelpMessage::where(function($query) use ($vendorId) {
            $query->where('sender_type', 'vendor')
                  ->where('sender_id', $vendorId);
                  })->orWhere(function($query) use ($vendorId) {
                      $query->where('sender_type', 'admin')
                      ->where('sender_id', $vendorId);
        })
        ->with('messageReactions')
        ->orderBy('created_at', 'asc')
        ->get()
        ->map(function ($message) use ($vendorId) {
            return [
                'id' => $message->id,
                'sender' => $message->sender_type === 'vendor' ? 'user' : 'admin',
                'sender_name' => $message->sender_type === 'vendor' ? 'You' : 'Support Team',
                'message' => $message->message,
                'timestamp' => $message->created_at,
                'reactions' => $message->grouped_reactions ?? [],
                'is_read' => $message->is_read,
                'avatar' => null,
            ];
        });

        // Mark all admin messages as read
        HelpMessage::where('sender_type', 'admin')
            ->unread()
            ->update(['is_read' => true, 'read_at' => now()]);

        $conversation->markAsReadFor('vendor');

        return view('vendor.help', compact('messages', 'conversation'));
    }

    /**
     * Fetch new messages (AJAX polling)
     */
    public function fetchMessages(Request $request)
    {
        $vendorId = Auth::guard('vendor')->id();
        $lastMessageId = $request->input('last_message_id', 0);

        // Get new messages since last fetch
        $newMessages = HelpMessage::where('id', '>', $lastMessageId)
            ->where(function($query) use ($vendorId) {
                $query->where('sender_type', 'vendor')
                      ->where('sender_id', $vendorId);
                })->orWhere(function($query) use ($vendorId) {
                          $query->where('sender_type', 'admin')
                          ->where('sender_id', $vendorId);
            })
            ->with('messageReactions')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) {
                return [
                    'id' => $message->id,
                    'sender' => $message->sender_type === 'vendor' ? 'user' : 'admin',
                    'sender_name' => $message->sender_type === 'vendor' ? 'You' : 'Support Team',
                    'message' => $message->message,
                    'timestamp' => $message->created_at->format('c'), // ISO 8601 format
                    'time_display' => $message->created_at->format('g:ia'),
                    'date_display' => $this->getDateDisplay($message->created_at),
                    'reactions' => $message->grouped_reactions ?? [],
                    'is_read' => $message->is_read,
                ];
            });

        // Mark new admin messages as read
        if ($newMessages->isNotEmpty()) {
            HelpMessage::where('sender_type', 'admin')
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
     * Send a new message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $vendorId = Auth::guard('vendor')->id();

        // Get or create conversation
        $conversation = HelpConversation::firstOrCreate(
            ['vendor_id' => $vendorId],
            ['status' => 'active']
        );

        DB::beginTransaction();
        try {
            // Create the message
            $helpMessage = HelpMessage::create([
                'sender_id' => $vendorId,
                'sender_type' => 'vendor',
                'message' => $request->message,
                'is_read' => false,
            ]);

            // Update conversation
            $conversation->updateAfterMessage($helpMessage);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => [
                    'id' => $helpMessage->id,
                    'sender' => 'user',
                    'sender_name' => 'You',
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
                'message' => 'Failed to send message',
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

        $vendorId = Auth::guard('vendor')->id();

        try {
            $reaction = HelpMessageReaction::updateOrCreate(
                [
                    'help_message_id' => $messageId,
                    'user_id' => $vendorId,
                    'user_type' => 'vendor',
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

        $vendorId = Auth::guard('vendor')->id();

        try {
            HelpMessageReaction::where('help_message_id', $messageId)
                ->where('user_id', $vendorId)
                ->where('user_type', 'vendor')
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
     * Get unread message count
     */
    public function getUnreadCount()
    {
        $vendorId = Auth::guard('vendor')->id();

        $count = HelpMessage::where('sender_type', 'admin')
            ->unread()
            ->count();

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }
}