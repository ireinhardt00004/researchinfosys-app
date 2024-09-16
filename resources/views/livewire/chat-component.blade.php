<div class="flex w-full flex-col flex-auto h-full sm:p-6">



    <button id="chatPanelBtn" class="self-start ms-3 sm:hidden block p-2 rounded-full bg-[#1B651B] drop-shadow-lg mb-2">
        <svg viewBox="0 0 24 24" class="w-[1.5rem] h-[1.5rem] stroke-white" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 12H20"  stroke-width="2" stroke-linecap="round"></path> <path d="M5 17H20"  stroke-width="2" stroke-linecap="round"></path> <path d="M5 7H20"  stroke-width="2" stroke-linecap="round"></path> </g></svg>
    </button>



    <div class="flex flex-col flex-auto flex-shrink-0 rounded-2xl bg-gray-100 h-full p-4">
        <!-- Header Section -->
        <div class="flex flex-row items-center bg-gray-200 p-3 rounded-t-lg shadow-md">
            <div class="flex-grow flex items-center space-x-3">
            @if(!empty($profilepic))
                <img src="{{ $profilepic }}" alt="Avatar" class="h-10 w-10 rounded-full"/>
                @else
                    <img src="{{ asset('/sys_logo/user.png') }}" alt="Avatar" class="h-10 w-10 rounded-full"/>
                @endif
                <div class="text-lg font-semibold text-gray-800">
                    {{ $recipientName ?? 'Select a user to chat' }}
                </div>
            </div>
            <div class="ml-auto flex items-center space-x-2">
                <button wire:click="deleteConversation" wire:confirm="Are you sure you want to delete this entire conversation?" class="text-red-500 hover:text-red-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6h18M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2M4 6l1 14a2 2 0 002 2h8a2 2 0 002-2l1-14H4z"></path>
                    </svg>
                </button>
                <button wire:click="toggleFavorite" wire:confirm="Mark as Favorite?" class="hover:text-yellow-400">
                    <svg class="w-6 h-6 {{ $isFavorite ? 'text-yellow-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 3.639A7.963 7.963 0 0112 4c2.462 0 4.752.95 6.383 2.564C20.162 8.31 21 10.537 21 13c0 2.226-.68 4.349-1.807 6.116L12 21.59l-7.226-8.385A8.953 8.953 0 013 13c0-2.925.745-5.667 2.121-8.36z"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Messages Section -->
        <div class="flex flex-col h-full overflow-x-auto mb-4">
            <div class="flex flex-col h-full">
                <div class="grid grid-cols-12 gap-y-2">
                   @forelse ($messages ?? [] as $message)
                        <div class="col-start-{{ $message->sender_id == auth()->id() ? '8' : '1' }} col-end-{{ $message->sender_id == auth()->id() ? '13' : '8' }} p-3 rounded-lg">
                            <div class="flex flex-row items-center {{ $message->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                                @if($message->sender_id != auth()->id())
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-green-500 flex-shrink-0">{{ $message->sender_id->lname[0] ?? 'N' }}</div>
                                @endif
                                <div class="relative ml-3 text-sm py-2 px-4 shadow rounded-xl {{ $message->sender_id == auth()->id() ? 'bg-indigo-100' : 'bg-white' }}">
                                    <div class="text-gray-700">{{ $message->message }}</div>
                                    <div class="text-gray-500 text-xs mt-1">{{ $message->created_at->diffForHumans() }}</div>
                                </div>
                                @if($message->sender_id == auth()->id())
                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-500 flex-shrink-0 text-white">{{ auth()->user()->lname[0] }}</div>
                                    @if($message->seen)
                                        <div class="text-xs text-gray-400 ml-2">Seen <i class="fas fa-check"></i></div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 col-span-12">No messages yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
        <!-- Input Section -->
        <div class="flex flex-row items-center h-16 rounded-xl bg-white w-full px-4 shadow-md">
            <div class="flex-grow ml-4">
                <div class="relative w-full">
                    <input type="text" id="newMessageInput" wire:model.defer="newMessage" class="flex w-full border rounded-xl focus:outline-none focus:border-indigo-300 pl-4 h-10"/>
                    <button wire:click="sendMessage" class="absolute flex items-center justify-center h-full w-12 right-0 top-0 text-indigo-500 hover:text-indigo-700">
                        <!-- <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg> -->
                    </button>
                </div>
            </div>
            <div class="ml-4">
                <button wire:click="sendMessage" class="flex items-center justify-center bg-green-500 hover:bg-indigo-600 rounded-xl text-white px-4 py-1 flex-shrink-0">
                    <span>Send</span>
                    <span class="ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </span>
                </button>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const messageInput = document.getElementById('newMessageInput');

    // Reset input field after sending message
    document.querySelectorAll('[wire\\:click="sendMessage"]').forEach(button => {
        button.addEventListener('click', function () {
            messageInput.value = '';
        });
    });
    // Reset input field on Enter key press
    messageInput.addEventListener('keypress', function (event) {
        if (event.key === 'Enter') {
            event.preventDefault(); 
            document.querySelector('[wire\\:click="sendMessage"]').click(); 
            messageInput.value = ''; 
        }
    });
});
</script>
</div>
