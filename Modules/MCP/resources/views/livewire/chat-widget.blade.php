<div>
    <!-- Chat Toggle Button -->
    @if(!$isOpen)
        <button wire:click="toggleChat"
                class="fixed bottom-6 right-6 bg-blue-600 hover:bg-blue-700 text-white rounded-full p-4 shadow-lg z-50 transition-all duration-300 hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </button>
    @endif

    <!-- Chat Window -->
    @if($isOpen)
        <div class="fixed bottom-6 right-6 w-96 h-[600px] bg-white rounded-lg shadow-2xl z-50 flex flex-col">
            <!-- Header -->
            <div class="bg-blue-600 text-white p-4 rounded-t-lg flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                    <h3 class="font-semibold">AI Assistant</h3>
                </div>
                <button wire:click="closeChat" class="hover:bg-blue-700 rounded p-1 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Messages Container -->
            <div id="messages-container"
                 class="flex-1 overflow-y-auto p-4 space-y-4 bg-gray-50"
                 x-data
                 x-init="$el.scrollTop = $el.scrollHeight"
                 @scroll-to-bottom.window="$el.scrollTop = $el.scrollHeight">
                @foreach($messages as $message)
                    <div class="flex {{ $message['is_from_bot'] ? 'justify-start' : 'justify-end' }}">
                        <div class="max-w-[80%] {{ $message['is_from_bot'] ? 'bg-white border border-gray-200' : 'bg-blue-600 text-white' }} rounded-lg p-3 shadow">
                            @if($message['is_from_bot'])
                                <div class="flex items-start gap-2">
                                    <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z"></path>
                                        </svg>
                                    </div>
                                    <div class="text-sm text-gray-800">{!! nl2br(e($message['message'])) !!}</div>
                                </div>
                            @else
                                <div class="text-sm">{!! nl2br(e($message['message'])) !!}</div>
                            @endif
                            <div class="text-xs {{ $message['is_from_bot'] ? 'text-gray-400' : 'text-blue-100' }} mt-1">
                                {{ \Carbon\Carbon::parse($message['created_at'])->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Typing Indicator -->
                @if($isTyping)
                    <div class="flex justify-start">
                        <div class="bg-white border border-gray-200 rounded-lg p-3 shadow">
                            <div class="flex gap-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Input Area -->
            <form wire:submit.prevent="sendMessage" class="p-4 border-t border-gray-200 bg-white rounded-b-lg">
                <div class="flex gap-2">
                    <input
                        type="text"
                        wire:model="newMessage"
                        placeholder="Type your message..."
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                        {{ $isLoading ? 'disabled' : '' }}
                    >
                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        {{ $isLoading ? 'disabled' : '' }}>
                        @if($isLoading)
                            <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                        @endif
                    </button>
                </div>
                @error('newMessage')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </form>
        </div>
    @endif
</div>
