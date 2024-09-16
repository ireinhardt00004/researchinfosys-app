<div class="bg-white rounded-lg shadow-lg border border-gray-300 w-full  max-w-md mx-auto ">
    @if($messages->isEmpty())
        <div class="p-4 text-center">
            <p class="text-gray-500">No messages found</p>
        </div>
    @else
        @foreach($messages as $message)
            <div class="p-4 border-b border-gray-200 flex {{ $loop->odd ? 'bg-gray-100' : 'bg-white' }}">
                <div class="flex-1">
                <a href="/chat">
                    <p class="{{ $message['is_read'] ? 'text-gray-800' : 'font-bold text-gray-800' }}">
                        {{ $message['sender'] ?? 'Unknown' }}
                    </p>
                    <p class="{{ $message['is_read'] ? 'text-gray-600' : 'font-bold text-gray-600' }}">
                         {{ $message['message_preview'] ?? 'No content' }}{{ strlen($message['message']) > strlen($message['message_preview']) ? '...' : '' }}
                    </p>
                </a>
                </div>
            </div>
        @endforeach
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('refreshChatDrawer', () => {
                @this.call('loadMessages');
            });
        });
    </script>
</div>
