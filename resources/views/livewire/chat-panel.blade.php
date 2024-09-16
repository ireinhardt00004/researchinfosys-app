<div id="chatPanel" class="sm:flex flex-col sm:py-8 sm:pl-6 sm:pr-2 sm:w-64 w-[60%] drop-shadow-2xl h-full shadow-lg bg-white left-0 flex-shrink-0 z-10 sm:z-0 sm:static absolute hidden rounded-lg" >
    <!-- Header -->
    <div class="flex flex-row items-center justify-center h-12 w-full my-2">
        <div class="flex items-center justify-center rounded-2xl text-indigo-700 bg-indigo-100 h-10 w-10 ms-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
            </svg>
        </div>
        <div class="ml-2 font-bold sm:text-2xl text-lg text-[#1B651B]">Chat</div>


        <button id="chatPanelBtn" class="ms-auto me-3 sm:hidden block p-2 rounded-full bg-[#1B651B] drop-shadow-lg">
            <svg viewBox="0 0 24 24" class="w-[1.5rem] h-[1.5rem] stroke-white" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M5 12H20"  stroke-width="2" stroke-linecap="round"></path> <path d="M5 17H20"  stroke-width="2" stroke-linecap="round"></path> <path d="M5 7H20"  stroke-width="2" stroke-linecap="round"></path> </g></svg>
        </button>


    </div>
    <!-- Search Input -->
    <div>
        <input type="search" name="query" placeholder="Search Name..." wire:model.live.debounce.300ms="search" class="border rounded-xl w-full h-[2rem] sm:h-10 sm:px-4 p-2 sm:placeholder:text-base placeholder:text-[10px]"/>
    </div>
   <!-- Search Results -->
    @if($search && $hasResults)
        <div class="mt-4 bg-indigo-100 border border-gray-200 py-4 px-2 rounded-lg flex flex-col items-center 
            sm:h-auto h-[30vh] sm:overflow-auto overflow-y-auto">
            <div class="sm:text-sm text-[10px] font-bold mb-2">Search Results</div>
            @foreach($searchResults as $user)
                <button wire:click="selectUser({{ $user->id }})" class="flex flex-col sm:flex-row items-center justify-center hover:bg-gray-100 rounded-xl p-2">
                    <div class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full">{{ $user->name[0] ?? 'N' }}</div>
                    <div class="ml-2 sm:text-sm text-[10px] font-semibold">{{ $user->lname ?? 'No Name' }}</div>
                </button>
            @endforeach
        </div>
    @endif
    <!-- User Display -->
    <div class="flex flex-col items-center bg-indigo-100 border border-gray-200 mt-4 w-full sm:py-6 sm:px-4 sm:h-auto rounded-lg ">
        @if($currentChatUserId)
            @php
                $currentUser = \App\Models\User::find($currentChatUserId);
            @endphp
            @if($currentUser)
                <div class="sm:h-20 sm:w-20 w-[5rem] h-[5rem] sm:p-0 p-2 rounded-full border overflow-hidden">
                @if(!empty($currentUser->userinfos->profile_pic))
                    <img src="{{ $currentUser->userinfos->profile_pic }}" alt="Avatar" class="h-full w-full"/>
                @else
                    <img src="{{ asset('sys_logo/user.png') }}" alt="Avatar" class="h-full w-full"/>
                @endif

                </div>
                <div class="sm:text-xl sm:p-0 p-2 text-[10px] break-all text-center font-semibold mt-2">{{ $currentUser->fname ?? 'No Name' }} {{ $currentUser->middlename ?? '' }} {{ $currentUser->lname ?? '' }}</div>
                <div class="sm:text-m text-[12px] font-bold text-black">{{ $currentUser->roles ?? 'No title' }}</div>
                <div class="flex flex-row items-center sm:mt-3 my-3">
                <!--    
                <div class="flex flex-col justify-center h-4 w-8 bg-indigo-500 rounded-full">
                        <div class="h-3 w-3 bg-white rounded-full self-end mr-1"></div>
                     </div>
                    <div class="leading-none ml-1 text-xs">Active</div> -->
                </div>
            @else
                <div class="text-sm font-semibold mt-2">No user selected</div>
            @endif
        @else
            <div class="text-sm font-semibold mt-2">No user selected</div>
        @endif
    </div>
    <!-- Active Conversations -->
    <div class="flex flex-col mt-8">
        <div class="flex flex-row items-center justify-between text-xs">
            <span class="font-bold p-2">Active Conversations</span>
            <span class="flex items-center justify-center bg-gray-300 h-4 w-4 rounded-full">{{ $chatUsers->count() }}</span>
        </div>
        <div class="flex flex-col p-3 space-y-1 mt-4 -mx-2 h-48 overflow-y-auto">
            @foreach($chatUsers as $user)
                <button wire:click="selectUser({{ $user->id }})" class="flex flex-row items-center hover:bg-gray-100 rounded-xl p-2">
                    <div class="flex items-center justify-center h-8 w-8 bg-indigo-200 rounded-full relative">
                        {{ $user->lname[0] ?? 'N' }}
                        @if($user->unreadMessagesCount > 0)
                        <div class="absolute top-0 right-0 translate-x-1 -translate-y-2 outline   ml-auto bg-red-500 text-white sm:text-xs text-[10px] rounded-full px-1.5 py-0.5">{{ $user->unreadMessagesCount }}</div>
                    @endif
                    </div>
                    <div class="ml-2 sm:text-sm text-[12px] font-semibold {{ $user->unreadMessagesCount > 0 ? 'font-bold' : '' }}">{{ $user->lname ?? 'No Name' }}</div>
                    
                    @if($user->recentMessage)
                        <div class="ml-auto text-gray-500 sm:text-xs text-[10px]">{{ $user->recentMessage->created_at->diffForHumans() }}</div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</div>
