<div class="fixed bottom-6 right-6 z-50 w-80 bg-white dark:bg-zinc-900 shadow-xl rounded-xl overflow-hidden border border-gray-100 dark:border-zinc-800 flex flex-col transition-all duration-300 ease-in-out" style="{{ $isCollapsed ? 'max-height: 48px;' : 'max-height: 500px;' }}">
    <div class="bg-indigo-600 dark:bg-indigo-700 text-white p-3 font-semibold flex justify-between items-center cursor-pointer" wire:click="toggleCollapse">
        <div class="flex items-center gap-2">
            <flux:icon name="sparkles" class="w-5 h-5" />
            <span>Chat Assistant</span>
        </div>
        <button class="text-white focus:outline-none transition-transform duration-300" style="{{ $isCollapsed ? '' : 'transform: rotate(180deg);' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto p-3 space-y-2 text-sm text-gray-900 dark:text-white transition-opacity duration-300 ease-in-out" 
         id="chat-messages" 
         style="{{ $isCollapsed ? 'opacity: 0; max-height: 0; padding: 0;' : 'opacity: 1; max-height: 400px;' }}">
        @foreach($messages as $msg)
            <div class="{{ $msg['from'] === 'user' ? 'text-right' : 'text-left' }}">
                <span class="inline-block px-3 py-1 rounded-lg {{ $msg['from'] === 'user' ? 'bg-indigo-100 dark:bg-indigo-900/50 text-indigo-900 dark:text-indigo-100' : 'bg-gray-100 dark:bg-zinc-800 text-gray-800 dark:text-gray-200' }}">
                    {{ $msg['text'] }}
                </span>
            </div>
        @endforeach
        
        <!-- Loading Animation -->
        @if($isLoading)
        <div class="text-left">
            <div class="inline-flex items-center px-3 py-2 rounded-lg bg-gray-100 dark:bg-zinc-800">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-indigo-500 dark:bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                    <div class="w-2 h-2 bg-indigo-500 dark:bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-indigo-500 dark:bg-indigo-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="p-2 border-t border-gray-200 dark:border-zinc-800 transition-opacity duration-300 ease-in-out"
         style="{{ $isCollapsed ? 'opacity: 0; max-height: 0; padding: 0; border: none;' : 'opacity: 1;' }}">
        <input
            wire:model="message"
            wire:keydown.enter="sendMessage"
            type="text"
            id="chatbot-input"
            placeholder="Type your message..."
            class="w-full px-3 py-2 border border-gray-100 dark:border-zinc-800 rounded-lg focus:outline-none focus:ring focus:border-indigo-300 dark:focus:border-indigo-600 bg-white dark:bg-zinc-900 text-gray-900 dark:text-white"
        />
    </div>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Clear input field when event is dispatched
        Livewire.on('clear-chatbot-input', () => {
            document.getElementById('chatbot-input').value = '';
        });
        
        // Scroll to bottom when loading starts
        Livewire.on('loading-started', () => {
            scrollChatToBottom();
        });
        
        // Auto-scroll chat to bottom when messages update
        const chatMessages = document.getElementById('chat-messages');
        const observer = new MutationObserver(scrollChatToBottom);
        observer.observe(chatMessages, { childList: true, subtree: true });
        
        function scrollChatToBottom() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }
    });
</script>