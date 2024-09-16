 {{-- header for mobile view --}}
 <header class="sm:hidden">
    <section class="w-full bg-[#ffffff] justify-end sticky top-0 flex">
       <section class="w-full p-4 justify-start ms-2 sm:hidden items-center gap-3 flex">
           <a href="/"> <img <img src="{{asset('sys_logo/RISlogo1.svg')}}" class="object-contain sm:h-16 sm:w-16 w-16 h-16 drop-shadow-xl" alt=""></a>
       </section>
       <div class="me-5 flex gap-3 justify-center items-center">
           <button id="notif" class="rounded-full bg-white p-3 hover:drop-shadow-lg relative">
               <svg class="w-[1.2rem] h-[1.2rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.0003 21H15.0003M18.0003 8.6C18.0003 7.11479 17.3682 5.69041 16.2429 4.6402C15.1177 3.59 13.5916 3 12.0003 3C10.409 3 8.88288 3.59 7.75766 4.6402C6.63245 5.69041 6.0003 7.11479 6.0003 8.6C6.0003 11.2862 5.32411 13.1835 4.52776 14.4866C3.75646 15.7486 3.37082 16.3797 3.38515 16.5436C3.40126 16.7277 3.4376 16.7925 3.58633 16.9023C3.71872 17 4.34793 17 5.60636 17H18.3943C19.6527 17 20.2819 17 20.4143 16.9023C20.563 16.7925 20.5994 16.7277 20.6155 16.5436C20.6298 16.3797 20.2441 15.7486 19.4729 14.4866C18.6765 13.1835 18.0003 11.2862 18.0003 8.6Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
               
            {{-- notifbadge --}}
            <div class="absolute top-0 right-0 translate-x-1.5 text-white drop-shadow-lg bg-red-600 rounded-full  px-[5px] text-[12px]">
                @livewire('notification-badge')
            </div>
               
           </button>
          
           <button id="mess" class="rounded-full bg-white p-3 hover:drop-shadow-lg relative">
               <svg class="w-[1.2rem] h-[1.2rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 9H17M7 13H12M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
            {{-- notifbadge --}}
            <div class="absolute top-0 right-0 translate-x-1.5 text-white drop-shadow-lg bg-red-600 rounded-full px-[5px] text-[12px]">
            @livewire('unread-message-counter')
            </div>
           </button>
           @if(Auth::user()->userinfos && Auth::user()->userinfos->profile_pic)
                        <img id="profile" src="{{ asset(Auth::user()->userinfos->profile_pic) }}" alt="Profile Picture" alt="" class="rounded-full p-2 bg-white w-12 h-12 hover:drop-shadow-lg cursor-pointer">
                    @else
                        <img  id="profile" src="{{ asset('default-profile-pic.png') }}" alt="Default Profile Picture" alt="" class="rounded-full p-2 bg-white w-12 h-12 hover:drop-shadow-lg cursor-pointer" alt="" >
                    @endif 
            </div>
        
   </section>
  
</header>