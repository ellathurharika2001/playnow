@extends('vendor.layouts.app.sidebar')

@section('header')
    <h1 class="text-2xl font-bold">Help Channel</h1>
@endsection

@section('content')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 100px);
        margin: 0 auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(33, 18, 18, 0.1);
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

    .chat-header h2 {
        font-size: 20px;
        font-weight: 600;
        color: #111827;
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

    .message-group.user-message {
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

    .message-group.user-message .message-content {
        align-items: flex-end;
    }

    .message-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 4px;
        font-size: 13px;
    }

    .message-group.user-message .message-header {
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

    .message-group.admin-message .message-bubble {
        background: #fff;
        color: #111827;
        border: 1px solid #e5e7eb;
        border-top-left-radius: 4px;
    }

    .message-group.user-message .message-bubble {
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .chat-container {
            height: calc(100vh - 120px);
            border-radius: 0;
        }

        .message-content {
            max-width: 85%;
        }

        .chat-messages {
            padding: 16px;
        }

        .chat-input-container {
            padding: 12px 16px;
        }

        .message-bubble {
            font-size: 14px;
        }
    }

    @media (max-width: 480px) {
        .message-content {
            max-width: 90%;
        }

        .message-avatar {
            width: 36px;
            height: 36px;
        }

        .chat-header {
            padding: 16px;
        }

        .chat-header h2 {
            font-size: 18px;
        }
    }

    /* Scrollbar Styling */
    .chat-messages::-webkit-scrollbar {
        width: 6px;
    }

    .chat-messages::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .chat-messages::-webkit-scrollbar-thumb {
        background: #d1d5db;
        border-radius: 3px;
    }

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
</style>

<div class="chat-container">
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

            <div class="message-group {{ $message['sender'] === 'user' ? 'user-message' : 'admin-message' }}" data-message-id="{{ $message['id'] }}">
                <div class="message-avatar {{ $message['sender'] === 'admin' ? 'online' : '' }}">
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
            Support Team is typing...
        </div>
    </div>

    <div class="chat-input-container">
        <form id="chatForm" class="chat-input-wrapper">
            @csrf
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatMessages = document.getElementById('chatMessages');
    const chatForm = document.getElementById('chatForm');
    const messageInput = document.getElementById('messageInput');
    const sendButton = document.getElementById('sendButton');
    let pollInterval;
    let isPageActive = true;
    let lastMessageId = {{ $messages->max('id') ?? 0 }};
    let currentDate = null;

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
        if (!message) return;

        sendButton.disabled = true;
        const originalMessage = messageInput.value;
        messageInput.value = '';
        messageInput.style.height = 'auto';
        
        try {
            const response = await fetch('{{ route('help.send') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify({ message })
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

    // Append message to chat
    function appendMessage(message) {
        // Add date divider if needed
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
            <div class="message-group ${message.sender === 'user' ? 'user-message' : 'admin-message'}" data-message-id="${message.id}">
                <div class="message-avatar ${message.sender === 'admin' ? 'online' : ''}">
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
        pollInterval = setInterval(async () => {
            if (!isPageActive) return;

            try {
                const response = await fetch(`{{ route('help.messages') }}?last_message_id=${lastMessageId}`);
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
@endsection