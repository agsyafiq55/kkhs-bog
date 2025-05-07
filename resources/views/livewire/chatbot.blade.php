<div class="fixed bottom-4 right-4 z-50">
    <!-- Chat Toggle Button -->
    <flux:modal.trigger name="chatbot-modal">
        <button
            class="bg-red-500 hover:bg-red-600 text-white rounded-full p-4 shadow-lg transition-all duration-300 flex items-center justify-center relative group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
            </svg>
            <span class="absolute -top-2 -right-2 bg-zinc-800 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center scale-0 group-hover:scale-100 transition-transform">?</span>
        </button>
    </flux:modal.trigger>

    <!-- Chat Modal -->
    <flux:modal name="chatbot-modal" variant="flyout" size="sm" class="!max-w-md !rounded-xl">
        <div class="flex flex-col h-full w-full bg-white dark:bg-zinc-800">
            <!-- Chat Header -->
            <div class="flex justify-between items-center border-b border-gray-200 dark:border-zinc-700 p-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-red-500 rounded-full w-10 h-10 flex items-center justify-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                    </div>
                    <div>
                        <flux:heading size="sm" class="!mb-0 font-bold">KKHS ChatBot</flux:heading>
                        <div class="flex items-center">
                            <span class="inline-block h-2 w-2 rounded-full bg-green-500 mr-2 animate-pulse"></span>
                            <flux:text class="text-xs text-zinc-500 dark:text-zinc-400">Online & Ready to Help</flux:text>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Suggested Questions (Initial state) -->
            @if(!$response)
            <div class="p-4 bg-gray-50 dark:bg-zinc-900 rounded-lg my-3">
                <p class="text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Try asking:</p>
                <div class="space-y-2">
                    <button wire:click="$set('userInput', 'Tell me about the events happening in KKHS')" class="w-full text-left px-3 py-2 bg-white dark:bg-zinc-800 text-sm rounded-md shadow-sm border border-gray-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors text-zinc-700 dark:text-zinc-300">
                        What events are coming up?
                    </button>
                    <button wire:click="$set('userInput', 'Who are the members of the Board of Governors?')" class="w-full text-left px-3 py-2 bg-white dark:bg-zinc-800 text-sm rounded-md shadow-sm border border-gray-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors text-zinc-700 dark:text-zinc-300">
                        Who are the members of the Board of Governors?
                    </button>
                    <button wire:click="$set('userInput', 'What are the recent cocurricular achievements?')" class="w-full text-left px-3 py-2 bg-white dark:bg-zinc-800 text-sm rounded-md shadow-sm border border-gray-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors text-zinc-700 dark:text-zinc-300">
                        What are the recent cocurricular achievements?
                    </button>
                    <button wire:click="$set('userInput', 'How do I contact the Board of Governors?')" class="w-full text-left px-3 py-2 bg-white dark:bg-zinc-800 text-sm rounded-md shadow-sm border border-gray-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors text-zinc-700 dark:text-zinc-300">
                        How do I contact the Board of Governors?
                    </button>
                    <button wire:click="$set('userInput', 'Tell me about the history of KKHS Board of Governors')" class="w-full text-left px-3 py-2 bg-white dark:bg-zinc-800 text-sm rounded-md shadow-sm border border-gray-200 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors text-zinc-700 dark:text-zinc-300">
                        Tell me about the history of KKHS Board of Governors
                    </button>
                </div>
            </div>
            @endif

            <!-- Chat Messages Container -->
            <div class="flex-1 overflow-y-auto space-y-5" id="chat-messages-container">
                <!-- Bot Welcome Message -->
                <div class="flex items-start">
                    <div class="bg-gray-100 dark:bg-zinc-700 rounded-2xl rounded-tl-none p-4 max-w-[85%] shadow-sm">
                        <p class="text-zinc-900 dark:text-white">👋 Hi! I'm your KKHS assistant. How can I help you today?</p>
                    </div>
                </div>

                <!-- User Message (if response exists) -->
                @if($response)
                <div class="flex items-start justify-end">
                    <div class="bg-red-500 rounded-2xl rounded-tr-none p-4 max-w-[85%] shadow-sm">
                        <p class="text-white">{{ $lastUserInput }}</p>
                    </div>
                </div>
                @endif

                <!-- Bot Response -->
                @if($response)
                <div class="flex items-start">
                    <div class="bg-gray-100 dark:bg-zinc-700 rounded-2xl rounded-tl-none p-4 max-w-[85%] shadow-sm overflow-auto">
                        <div class="response-content text-zinc-900 dark:text-white prose prose-sm dark:prose-invert break-words">
                            {!! $response !!}
                        </div>
                    </div>
                </div>
                @endif

                <!-- Loading Message -->
                <div wire:loading wire:target="sendMessage" class="flex items-start">
                    <div class="flex items-center space-x-2 bg-gray-100 dark:bg-zinc-700 rounded-2xl rounded-tl-none p-4 mb-3 max-w-[85%] shadow-sm">
                        <div class="flex space-x-1">
                            <div class="w-2.5 h-2.5 rounded-full bg-zinc-400 dark:bg-zinc-500 animate-bounce"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-zinc-400 dark:bg-zinc-500 animate-bounce" style="animation-delay: 150ms"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-zinc-400 dark:bg-zinc-500 animate-bounce" style="animation-delay: 300ms"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Input Area - Fixed at bottom -->
            <div class="flex items-center space-x-3">
                <flux:input
                    wire:model.defer="userInput"
                    wire:keydown.enter="sendMessage"
                    placeholder="Type your question here..." />
                <flux:button
                    wire:click="sendMessage"
                    variant="primary"
                    class="!bg-red-500 hover:!bg-red-600 !rounded-full !w-10 !h-10 !p-0 !flex !items-center !justify-center !shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </flux:button>
            </div>
            <div class="text-center mt-2">
                <a href="#" wire:click="resetChat" class="text-xs text-zinc-500 hover:text-red-500 dark:text-zinc-400 dark:hover:text-red-400 transition-colors">
                    Reset conversation
                </a>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">AI may produce inaccurate information.</p>
            </div>
        </div>
    </flux:modal>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {
            // Configure marked options
            marked.setOptions({
                gfm: true,
                breaks: true,
                headerIds: true,
                mangle: false
            });

            // Initial format of any existing responses
            formatAllResponses();

            // Listen for new responses
            Livewire.on('chatResponse', () => {
                setTimeout(formatAllResponses, 50);
                scrollToBottom();
            });

            // Handle chat reset
            Livewire.on('chatReset', () => {
                const container = document.getElementById('chat-messages-container');
                if (container) {
                    const notification = document.createElement('div');
                    notification.className = 'text-center py-2 text-xs text-zinc-500 dark:text-zinc-400';
                    notification.innerHTML = 'Chat has been reset';
                    container.appendChild(notification);
                    setTimeout(() => notification.remove(), 2000);
                }
            });

            // Format all responses in the chat
            function formatAllResponses() {
                const responses = document.querySelectorAll('.response-content');
                responses.forEach(container => {
                    if (!container.getAttribute('data-formatted')) {
                        const content = container.textContent || container.innerText;
                        if (content && content.trim()) {
                            try {
                                // Process the markdown content
                                container.innerHTML = marked.parse(content);
                                applyTailwindStyles(container);
                                container.setAttribute('data-formatted', 'true');
                            } catch (err) {
                                console.error('Markdown parsing error:', err);
                            }
                        }
                    }
                });
            }

            // Apply Tailwind styles to markdown elements
            function applyTailwindStyles(container) {
                // Headings
                container.querySelectorAll('h1').forEach(el => {
                    el.className = 'text-xl font-bold text-red-500 mt-3 mb-2 pb-1 border-b border-gray-200 dark:border-zinc-700';
                    // Ensure clean content
                    el.innerHTML = el.textContent;
                });

                container.querySelectorAll('h2').forEach(el => {
                    el.className = 'text-lg font-semibold mt-3 mb-2';
                    el.innerHTML = el.textContent;
                });

                container.querySelectorAll('h3,h4,h5,h6').forEach(el => {
                    el.className = 'font-medium mt-2 mb-1';
                    el.innerHTML = el.textContent;
                });

                // Paragraphs and lists
                container.querySelectorAll('p').forEach(el =>
                    el.className = 'mb-3 leading-relaxed');

                container.querySelectorAll('ul').forEach(el =>
                    el.className = 'list-disc ml-5 mb-3 space-y-1');

                container.querySelectorAll('ol').forEach(el =>
                    el.className = 'list-decimal ml-5 mb-3 space-y-1');

                // Inline elements
                container.querySelectorAll('a').forEach(el =>
                    el.className = 'text-red-500 underline underline-offset-2');

                container.querySelectorAll('strong').forEach(el =>
                    el.className = 'font-bold text-zinc-900 dark:text-white');

                // Code elements
                container.querySelectorAll('pre').forEach(el =>
                    el.className = 'bg-gray-100 dark:bg-zinc-800 p-3 rounded-md my-2 overflow-x-auto');

                container.querySelectorAll('code:not(pre code)').forEach(el =>
                    el.className = 'bg-gray-100 dark:bg-zinc-800 px-1 rounded font-mono text-sm');
            }

            // Scroll to bottom of chat
            function scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('chat-messages-container');
                    if (container) {
                        container.scrollTo({
                            top: container.scrollHeight,
                            behavior: 'smooth'
                        });
                    }
                }, 100);
            }
        });

        // Scroll to bottom when modal opens
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new MutationObserver(mutations => {
                mutations.forEach(mutation => {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        const container = document.getElementById('chat-messages-container');
                        if (container && container.offsetParent !== null) {
                            container.scrollTop = container.scrollHeight;
                        }
                    }
                });
            });

            const modalContent = document.querySelector('[name="chatbot-modal"]');
            if (modalContent) {
                observer.observe(modalContent, {
                    attributes: true
                });
            }
        });
    </script>
    @endpush
</div>