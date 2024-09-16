   {{-- messages drawer --}}
   <div id="drawerMess" class="hidden fixed w-full h-full z-30">
    <section class="fixed sm:right-[8%] right-[15%] z-40 bg-white top-[6.5%] rounded-lg sm:w-[15%] overflow-y-auto h-[30%] p-2">
            <h3 class="text-lg font-semibold">Messages</h3>
            @livewire('chat-drawer')
            <div class="flex items-center bottom-0 justify-center font-bold"><a href="/chat">View  All Chats</a></div> 
        </section>
        
    <div id="mess" class="fixed bg-black opacity-40 w-full h-full z-30">  
    </div>
</div>
    {{-- messages drawer end --}}

   @livewire('notification-panel')
    {{-- notification drawer end--}}

    {{-- profile drawer --}}
 <div id="drawerProf" class="hidden fixed w-full h-full z-30">
        <section class="fixed sm:right-[4%] right-[3%] z-40 bg-white top-[6.5%] rounded-lg sm:w-[15%]">
            <ul class="w-full p-2 transition-all space-y-3 sm:text-base text-sm">
                <li class="font-bold"><h3 class="flex items-center justify-center">{{ Auth::user()->fname }} {{ Auth::user()->lname }}</h3></li>    
                <li>
                    <a href="{{route('profile.edit')}}" class="flex p-2 gap-4  transition-all hover:bg-[#1B651B] group hover:text-white rounded-md">
                        <svg class="w-6 h-6 stroke-[#1B651B] stroke-4 group-hover:stroke-white" viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" stroke-width="3" stroke="#000000" fill="none"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><circle cx="32" cy="18.14" r="11.14"></circle><path d="M54.55,56.85A22.55,22.55,0,0,0,32,34.3h0A22.55,22.55,0,0,0,9.45,56.85Z"></path></g></svg>
                        Profile settings
                    </a>
                </li>
                <li>
                <a href="{{ route('activity.logsindex') }}" class="flex p-2 gap-4 transition-all hover:bg-[#1B651B] group hover:text-white rounded-md">
                        <svg class="w-6 h-6 stroke-[#1B651B] stroke-4 group-hover:stroke-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Activity Logs
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                
                        <a href="{{ route('logout') }}" 
                           class="flex p-2 gap-4 transition-all hover:bg-[#1B651B] group hover:text-white rounded-md"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            <svg class="w-6 h-6 stroke-[#1B651B] group-hover:stroke-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12h-9.5m7.5 3l3-3-3-3m-5-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2h5a2 2 0 002-2v-1"></path>
                                </g>
                            </svg>
                            {{ __('Log Out') }}
                        </a>
                    </form>
                </li>                        
            </ul>
        </section>
        <div id="profile" class="fixed bg-black opacity-40 w-full h-full z-30"></div>
    </div>
    {{-- profile drawer end --}}