<x-layouts.app.sidebar :title="'Help & Support'">
    <flux:main>

        <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
        
        <style>
            .help-container {
                display: grid;
                grid-template-columns: 350px 1fr;
                gap: 20px;
                height: calc(100vh - 150px);
                max-height: 900px;
            }

            /* Vendor Sidebar */
            .vendor-sidebar {
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }

            .vendor-sidebar-header {
                padding: 20px;
                border-bottom: 1px solid #e5e7eb;
                background: #f9fafb;
            }

            .vendor-sidebar-header h3 {
                font-size: 18px;
                font-weight: 700;
                color: #111827;
                margin: 0 0 4px 0;
            }

            .vendor-sidebar-header p {
                font-size: 13px;
                color: #6b7280;
                margin: 0;
            }

            .vendor-search {
                padding: 12px 16px;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                font-size: 14px;
                width: 100%;
                margin-top: 12px;
            }

            .vendor-search:focus {
                outline: none;
                border-color: #4f46e5;
            }

            .vendor-list {
                flex: 1;
                overflow-y: auto;
                padding: 12px;
            }

            .vendor-item {
                padding: 14px 16px;
                border-radius: 10px;
                cursor: pointer;
                transition: all 0.2s;
                margin-bottom: 6px;
                border: 2px solid transparent;
                text-decoration: none;
                display: block;
            }

            .vendor-item:hover {
                background: #f3f4f6;
            }

            .vendor-item.active {
                background: #eef2ff;
                border-color: #4f46e5;
            }

            .vendor-item-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                margin-bottom: 4px;
            }

            .vendor-name {
                font-size: 15px;
                font-weight: 600;
                color: #111827;
                margin: 0;
            }

            .vendor-item.active .vendor-name {
                color: #4f46e5;
            }

            .vendor-badge {
                background: #ef4444;
                color: #fff;
                font-size: 11px;
                font-weight: 700;
                padding: 2px 8px;
                border-radius: 10px;
                min-width: 20px;
                text-align: center;
            }

            .vendor-turf {
                font-size: 13px;
                color: #6b7280;
                margin: 0 0 4px 0;
            }

            .vendor-last-message {
                font-size: 12px;
                color: #9ca3af;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                margin: 0;
            }

            .vendor-item.active .vendor-last-message {
                color: #6366f1;
            }

            .no-vendors {
                text-align: center;
                padding: 40px 20px;
                color: #9ca3af;
            }

            /* Chat Container */
            .chat-container {
                display: flex;
                flex-direction: column;
                height: 100%;
                background: #fff;
                border-radius: 12px;
                box-shadow: 0 2 px 8px rgba(0, 0, 0, 0.1);
                overflow: hidden;
            }

            textarea#messageInput {
                color: #000;
            }

            .chat-header {
                padding: 20px;
                border-bottom: 1px solid #e5e7eb;
                background: #f9fafb;
            }

            .chat-header-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .chat-header-avatar {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: 700;
                color: #fff;
                font-size: 20px;
            }

            .chat-header-info h2 {
                font-size: 18px;
                font-weight: 700;
                color: #111827;
                margin: 0 0 2px 0;
            }

            .chat-header-info p {
                font-size: 13px;
                color: #6b7280;
                margin: 0;
            }

            .chat-messages {
                flex: 1;
                overflow-y: auto;
                padding: 20px;
                background: #f9fafb;
                scroll-behavior: smooth;
            }

            .date-divider {
                text-align: center;
                margin: 24px 0 16px;
                position: relative;
            }

            .date-divider span {
                background: #f9fafb;
                padding: 4px 12px;
                border-radius: 16px;
                font-size: 13px;
                color: #6b7280;
                border: 1px solid #e5e7eb;
                display: inline-block;
            }

            .message-group {
                margin-bottom: 20px;
                display: flex;
                gap: 12px;
            }

            .message-group.admin-message {
                flex-direction: row-reverse;
            }

            .message-avatar {
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background: #e5e7eb;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
                font-weight: 600;
                color: #6b7280;
                position: relative;
            }

            .message-avatar.online::after {
                content: '';
                position: absolute;
                bottom: 2px;
                right: 2px;
                width: 10px;
                height: 10px;
                background: #10b981;
                border: 2px solid #fff;
                border-radius: 50%;
            }

            .message-content {
                max-width: 70%;
                display: flex;
                flex-direction: column;
            }

            .message-group.admin-message .message-content {
                align-items: flex-end;
            }

            .message-header {
                display: flex;
                align-items: center;
                gap: 8px;
                margin-bottom: 4px;
                font-size: 13px;
            }

            .message-group.admin-message .message-header {
                flex-direction: row-reverse;
            }

            .sender-name {
                font-weight: 600;
                color: #111827;
            }

            .message-time {
                color: #9ca3af;
                font-size: 12px;
            }

            .message-bubble {
                padding: 12px 16px;
                border-radius: 18px;
                font-size: 15px;
                line-height: 1.5;
                word-wrap: break-word;
                position: relative;
            }

            .message-group.vendor-message .message-bubble {
                background: #fff;
                color: #111827;
                border: 1px solid #e5e7eb;
                border-top-left-radius: 4px;
            }

            .message-group.admin-message .message-bubble {
                background: #4f46e5;
                color: #fff;
                border-top-right-radius: 4px;
            }

            .message-reactions {
                display: flex;
                gap: 4px;
                margin-top: 4px;
                flex-wrap: wrap;
            }

            .reaction {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 12px;
                padding: 2px 8px;
                font-size: 13px;
                display: flex;
                align-items: center;
                gap: 4px;
            }

            .reaction-emoji {
                font-size: 14px;
            }

            .reaction-count {
                color: #6b7280;
                font-size: 12px;
            }

            .chat-input-container {
                padding: 16px 20px;
                border-top: 1px solid #e5e7eb;
                background: #fff;
            }

            .chat-input-wrapper {
                display: flex;
                gap: 12px;
                align-items: flex-end;
            }

            .chat-input {
                flex: 1;
                padding: 12px 16px;
                border: 1px solid #d1d5db;
                border-radius: 24px;
                font-size: 15px;
                resize: none;
                max-height: 120px;
                transition: border-color 0.2s;
                font-family: inherit;
            }

            .chat-input:focus {
                outline: none;
                border-color: #4f46e5;
            }

            .send-button {
                background: #4f46e5;
                color: #fff;
                border: none;
                border-radius: 50%;
                width: 44px;
                height: 44px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: background-color 0.2s;
                flex-shrink: 0;
            }

            .send-button:hover {
                background: #4338ca;
            }

            .send-button:disabled {
                background: #d1d5db;
                cursor: not-allowed;
            }

            .send-icon {
                width: 20px;
                height: 20px;
            }

            .typing-indicator {
                display: none;
                padding: 8px 12px;
                color: #6b7280;
                font-size: 13px;
                font-style: italic;
            }

            .no-conversation {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                height: 100%;
                color: #9ca3af;
                text-align: center;
                padding: 40px;
            }

            .no-conversation-icon {
                width: 80px;
                height: 80px;
                margin-bottom: 20px;
                color: #d1d5db;
            }

            .no-conversation h3 {
                font-size: 20px;
                font-weight: 600;
                color: #6b7280;
                margin: 0 0 8px 0;
            }

            .no-conversation p {
                font-size: 14px;
                margin: 0;
            }

            /* Scrollbar Styling */
            .vendor-list::-webkit-scrollbar,
            .chat-messages::-webkit-scrollbar {
                width: 6px;
            }

            .vendor-list::-webkit-scrollbar-track,
            .chat-messages::-webkit-scrollbar-track {
                background: #f1f1f1;
            }

            .vendor-list::-webkit-scrollbar-thumb,
            .chat-messages::-webkit-scrollbar-thumb {
                background: #d1d5db;
                border-radius: 3px;
            }

            .vendor-list::-webkit-scrollbar-thumb:hover,
            .chat-messages::-webkit-scrollbar-thumb:hover {
                background: #9ca3af;
            }

            /* Animation */
            @keyframes slideUp {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .message-group {
                animation: slideUp 0.3s ease-out;
            }

            /* Responsive */
            @media (max-width: 1024px) {
                .help-container {
                    grid-template-columns: 300px 1fr;
                }
            }

            @media (max-width: 768px) {
                .help-container {
                    grid-template-columns: 1fr;
                    height: auto;
                }

                .vendor-sidebar {
                    display: none;
                }

                .chat-container {
                    height: calc(100vh - 120px);
                }

                .message-content {
                    max-width: 85%;
                }
            }
        </style>

        <div class="admin-container">
            <div class="help-container">
                <!-- Vendor Sidebar -->
                <div class="vendor-sidebar">
                    <div class="vendor-sidebar-header">
                        <h3>Conversations</h3>
                        <p>{{ $vendors->count() }} vendor{{ $vendors->count() != 1 ? 's' : '' }}</p>
                        <input 
                            type="text" 
                            class="vendor-search" 
                            placeholder="Search vendors..."
                            id="vendorSearch"
                        >
                    </div>

                    <div class="vendor-list" id="vendorList">
                        @forelse($vendors as $vendor)
                            <a 
                                href="{{ route('admin.support.help', ['vendor_id' => $vendor->id]) }}" 
                                class="vendor-item {{ $selectedVendorId == $vendor->id ? 'active' : '' }}"
                                data-vendor-name="{{ strtolower($vendor->owner_name) }}"
                                data-vendor-turf="{{ strtolower($vendor->turf_name ?? '') }}"
                            >
                                <div class="vendor-item-header">
                                    <h4 class="vendor-name">{{ $vendor->owner_name }}</h4>
                                    @if(isset($vendor->unread_help_messages_count) && $vendor->unread_help_messages_count > 0)
                                        <span class="vendor-badge">{{ $vendor->unread_help_messages_count }}</span>
                                    @endif
                                </div>
                                @if($vendor->turf_name)
                                    <p class="vendor-turf">{{ $vendor->turf_name }}</p>
                                @endif
                                @if(isset($vendor->latestHelpMessage) && $vendor->latestHelpMessage)
                                    <p class="vendor-last-message">
                                        {{ Str::limit($vendor->latestHelpMessage->message, 50) }}
                                    </p>
                                @endif
                            </a>
                        @empty
                            <div class="no-vendors">
                                <p>No conversations yet</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Chat Container -->
                @if($selectedVendor)
                    <div class="chat-container">
                        <div class="chat-header">
                            <div class="chat-header-content">
                                <div class="chat-header-avatar">
                                    {{ substr($selectedVendor->owner_name, 0, 1) }}
                                </div>
                                <div class="chat-header-info">
                                    <h2>{{ $selectedVendor->owner_name }}</h2>
                                    <p>{{ $selectedVendor->turf_name ?? $selectedVendor->email }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="chat-messages" id="chatMessages">
                            @foreach($messages as $message)
                                @if($loop->first || $messages[$loop->index - 1]['timestamp']->format('Y-m-d') !== $message['timestamp']->format('Y-m-d'))
                                    <div class="date-divider">
                                        <span>
                                            @if($message['timestamp']->isToday())
                                                Today
                                            @elseif($message['timestamp']->isYesterday())
                                                Yesterday
                                            @else
                                                {{ $message['timestamp']->format('l, F j') }}
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                <div class="message-group {{ $message['sender'] === 'admin' ? 'admin-message' : 'vendor-message' }}" data-message-id="{{ $message['id'] }}">
                                    <div class="message-avatar {{ $message['sender'] === 'vendor' ? 'online' : '' }}">
                                        {{ substr($message['sender_name'], 0, 1) }}
                                    </div>
                                    <div class="message-content">
                                        <div class="message-header">
                                            <span class="sender-name">{{ $message['sender_name'] }}</span>
                                            <span class="message-time">{{ $message['timestamp']->format('g:ia') }}</span>
                                        </div>
                                        <div class="message-bubble">
                                            {{ $message['message'] }}
                                        </div>
                                        @if(!empty($message['reactions']))
                                            <div class="message-reactions">
                                                @foreach($message['reactions'] as $emoji => $count)
                                                    <div class="reaction">
                                                        <span class="reaction-emoji">{{ $emoji }}</span>
                                                        <span class="reaction-count">{{ $count }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            <div class="typing-indicator" id="typingIndicator">
                                {{ $selectedVendor->owner_name }} is typing...
                            </div>
                        </div>

                        <div class="chat-input-container">
                            <form id="chatForm" class="chat-input-wrapper">
                                @csrf
                                <input type="hidden" name="vendor_id" value="{{ $selectedVendorId }}" id="vendorIdInput">
                                <textarea 
                                    id="messageInput" 
                                    class="chat-input" 
                                    placeholder="Type your message..." 
                                    rows="1"
                                    maxlength="2000"
                                ></textarea>
                                <button type="submit" class="send-button" id="sendButton">
                                    <svg class="send-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="chat-container">
                        <div class="no-conversation">
                            <svg class="no-conversation-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            <h3>No Conversation Selected</h3>
                            <p>Select a vendor from the sidebar to start chatting</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($selectedVendor)
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatMessages = document.getElementById('chatMessages');
            const chatForm = document.getElementById('chatForm');
            const messageInput = document.getElementById('messageInput');
            const sendButton = document.getElementById('sendButton');
            const vendorIdInput = document.getElementById('vendorIdInput');
            const vendorSearch = document.getElementById('vendorSearch');
            let pollInterval;
            let isPageActive = true;
            let lastMessageId = {{ $messages->max('id') ?? 0 }};
            let currentDate = null;

            // Vendor search functionality
            if (vendorSearch) {
                vendorSearch.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const vendorItems = document.querySelectorAll('.vendor-item');
                    
                    vendorItems.forEach(item => {
                        const vendorName = item.getAttribute('data-vendor-name') || '';
                        const vendorTurf = item.getAttribute('data-vendor-turf') || '';
                        
                        if (vendorName.includes(searchTerm) || vendorTurf.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }

            // Auto-resize textarea
            messageInput.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
                
                sendButton.disabled = !this.value.trim();
            });

            // Handle Enter key (Shift+Enter for new line)
            messageInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    chatForm.dispatchEvent(new Event('submit'));
                }
            });

            // Scroll to bottom
            function scrollToBottom(smooth = true) {
                if (smooth) {
                    chatMessages.scrollTo({
                        top: chatMessages.scrollHeight,
                        behavior: 'smooth'
                    });
                } else {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }

            // Send message
            chatForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const message = messageInput.value.trim();
                const vendorId = vendorIdInput.value;
                
                if (!message || !vendorId) return;

                sendButton.disabled = true;
                const originalMessage = messageInput.value;
                messageInput.value = '';
                messageInput.style.height = 'auto';
                
                try {
                    const response = await fetch('{{ route('admin.support.help.send') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify({ 
                            message: message,
                            vendor_id: vendorId
                        })
                    });

                    const data = await response.json();
                    
                    if (data.success) {
                        appendMessage(data.message);
                        lastMessageId = data.message.id;
                        scrollToBottom();
                    } else {
                        messageInput.value = originalMessage;
                        alert('Failed to send message. Please try again.');
                    }
                } catch (error) {
                    console.error('Error sending message:', error);
                    messageInput.value = originalMessage;
                    alert('Failed to send message. Please try again.');
                } finally {
                    sendButton.disabled = !messageInput.value.trim();
                    messageInput.focus();
                }
            });

            function appendMessage(message) {
                const messageDate = new Date(message.timestamp);
                const messageDateStr = formatDate(messageDate);
                
                if (messageDateStr !== currentDate) {
                    const dividerHTML = `
                        <div class="date-divider">
                            <span>${message.date_display}</span>
                        </div>
                    `;
                    const typingIndicator = document.getElementById('typingIndicator');
                    typingIndicator.insertAdjacentHTML('beforebegin', dividerHTML);
                    currentDate = messageDateStr;
                }

                const messageHTML = `
                    <div class="message-group ${message.sender === 'admin' ? 'admin-message' : 'vendor-message'}" data-message-id="${message.id}">
                        <div class="message-avatar ${message.sender === 'vendor' ? 'online' : ''}">
                            ${message.sender_name.charAt(0)}
                        </div>
                        <div class="message-content">
                            <div class="message-header">
                                <span class="sender-name">${escapeHtml(message.sender_name)}</span>
                                <span class="message-time">${message.time_display}</span>
                            </div>
                            <div class="message-bubble">
                                ${escapeHtml(message.message)}
                            </div>
                            ${message.reactions && Object.keys(message.reactions).length > 0 ? renderReactions(message.reactions) : ''}
                        </div>
                    </div>
                `;
                
                const typingIndicator = document.getElementById('typingIndicator');
                typingIndicator.insertAdjacentHTML('beforebegin', messageHTML);
            }

            // Render reactions
            function renderReactions(reactions) {
                let html = '<div class="message-reactions">';
                for (const [emoji, count] of Object.entries(reactions)) {
                    html += `
                        <div class="reaction">
                            <span class="reaction-emoji">${emoji}</span>
                            <span class="reaction-count">${count}</span>
                        </div>
                    `;
                }
                html += '</div>';
                return html;
            }

            // Format date for comparison
            function formatDate(date) {
                return date.toISOString().split('T')[0];
            }

            // Escape HTML to prevent XSS
            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text;
                return div.innerHTML;
            }

            // Poll for new messages every 5 seconds
            function startPolling() {
                const vendorId = vendorIdInput.value;
                if (!vendorId) return;

                pollInterval = setInterval(async () => {
                    if (!isPageActive) return;

                    try {
                        const response = await fetch(`{{ route('admin.support.help') }}?last_message_id=${lastMessageId}&vendor_id=${vendorId}`);
                        const data = await response.json();
                        
                        if (data.success && data.has_new_messages) {
                            const wasAtBottom = isScrolledToBottom();
                            
                            data.messages.forEach(message => {
                                appendMessage(message);
                                lastMessageId = Math.max(lastMessageId, message.id);
                            });
                            
                            // Auto-scroll if user was at bottom
                            if (wasAtBottom) {
                                scrollToBottom();
                            }
                        }
                    } catch (error) {
                        console.error('Error fetching messages:', error);
                    }
                }, 5000);
            }

            // Check if scrolled to bottom
            function isScrolledToBottom() {
                const threshold = 50;
                return chatMessages.scrollHeight - chatMessages.clientHeight <= chatMessages.scrollTop + threshold;
            }

            // Stop polling when page is hidden
            document.addEventListener('visibilitychange', function() {
                isPageActive = !document.hidden;
                
                if (isPageActive) {
                    if (!pollInterval) {
                        startPolling();
                    }
                } else {
                    if (pollInterval) {
                        clearInterval(pollInterval);
                        pollInterval = null;
                    }
                }
            });

            // Initialize
            scrollToBottom(false);
            startPolling();
            sendButton.disabled = true;

            // Set initial current date
            const lastMessage = chatMessages.querySelector('.message-group:last-of-type');
            if (lastMessage) {
                const messages = @json($messages);
                if (messages.length > 0) {
                    const lastMsg = messages[messages.length - 1];
                    currentDate = formatDate(new Date(lastMsg.timestamp));
                }
            }

            // Cleanup on page unload
            window.addEventListener('beforeunload', function() {
                if (pollInterval) {
                    clearInterval(pollInterval);
                }
            });

            // Focus input on load
            messageInput.focus();
        });
        </script>
        @endif

    </flux:main>
</x-layouts.app.sidebar>