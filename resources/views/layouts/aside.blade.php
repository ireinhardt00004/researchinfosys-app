<!-- Page Content -->
<aside id="sidebar" class="sm:w-[25%] flex sm:flex-col flex-row gap-5">
    {{-- logo & title section --}}
    <section class="w-full p-2 justify-start sm:flex items-center gap-3 hidden">
       <a href="/" title="Back to Homepage">
        <img src="{{asset('sys_logo/logo.png')}}" alt="" class="w-[7rem] h-[7rem] object-cover">
       </a>
        <h1 id="hideSideElem" class="sm:text-lg text-md font-bold text-nowrap text-[#1b651b] uppercase">{{ ucwords(auth()->user()->roles) }}</h1>
    </section>

    <section class="w-full h-full flex sm:flex-col flex-row sm:justify-normal sm:items-center items-center justify-center relative transition-all sm:overflow-y-auto sm:overflow-x-hidden">
        <nav id="navMob" class="w-full sm:p-5 px-2 py-3 sm:ms-2 sm:mt-5 sm:flex sm:flex-col flex-row sm:justify-normal sm:items-center items-center justify-center ">
            <ul  class="flex sm:flex-col flex-row overflow-x-auto sm:overflow-hidden sm:space-y-6 w-full items-center sm:justify-start sm:items-start sm:*:text-base text-[13px] sm:text-wrap text-nowrap p-2 sm:gap-0 gap-2 sm:border-none border-b-2">
                <li class="hover:drop-shadow-lg w-full">
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}"
                               class="{{ Route::is('admin.dashboard') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 w-full items-center font-medium group p-2 rounded-lg transition-all">
                                <svg class="{{ Route::is('admin.dashboard') ? 'sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-white drop-shadow-lg' : 'sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white drop-shadow-lg' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                    <g id="SVGRepo_iconCarrier">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M4.18753 11.3788C4.03002 11.759 4 11.9533 4 12V20.0018C4 20.5529 4.44652 21 5 21H8V15C8 13.8954 8.89543 13 10 13H14C15.1046 13 16 13.8954 16 15V21H19C19.5535 21 20 20.5529 20 20.0018V12C20 11.9533 19.97 11.759 19.8125 11.3788C19.6662 11.0256 19.4443 10.5926 19.1547 10.1025C18.5764 9.1238 17.765 7.97999 16.8568 6.89018C15.9465 5.79788 14.9639 4.78969 14.0502 4.06454C13.5935 3.70204 13.1736 3.42608 12.8055 3.2444C12.429 3.05862 12.1641 3 12 3C11.8359 3 11.571 3.05862 11.1945 3.2444C10.8264 3.42608 10.4065 3.70204 9.94978 4.06454C9.03609 4.78969 8.05348 5.79788 7.14322 6.89018C6.23505 7.97999 5.42361 9.1238 4.8453 10.1025C4.55568 10.5926 4.33385 11.0256 4.18753 11.3788ZM10.3094 1.45091C10.8353 1.19138 11.4141 1 12 1C12.5859 1 13.1647 1.19138 13.6906 1.45091C14.2248 1.71454 14.7659 2.07921 15.2935 2.49796C16.3486 3.33531 17.4285 4.45212 18.3932 5.60982C19.3601 6.77001 20.2361 8.0012 20.8766 9.08502C21.1963 9.62614 21.4667 10.1462 21.6602 10.6134C21.8425 11.0535 22 11.5467 22 12V20.0018C22 21.6599 20.6557 23 19 23H16C14.8954 23 14 22.1046 14 21V15H10V21C10 22.1046 9.10457 23 8 23H5C3.34434 23 2 21.6599 2 20.0018V12C2 11.5467 2.15748 11.0535 2.33982 10.6134C2.53334 10.1462 2.80369 9.62614 3.12345 9.08502C3.76389 8.0012 4.63995 6.77001 5.60678 5.60982C6.57152 4.45212 7.65141 3.33531 8.70647 2.49796C9.2341 2.07921 9.77521 1.71454 10.3094 1.45091Z"></path>
                                    </g>
                                </svg>
                                <p id="hideSideElem">
                                    Admin Dashboard
                                </p>  
                            </a>
                        @endif
                    @endauth

                    {{-- subadmin dashboard --}}
                    @auth
                    @if (auth()->user()->hasRole('sub-admin'))
                        <a href="{{ route('sub.dashboard') }}"
                           class="{{ Route::is('sub.dashboard') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 w-full items-center font-medium group p-2 rounded-lg transition-all">
                            <svg class="{{ Route::is('sub.dashboard') ? 'sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-white drop-shadow-lg' : 'sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white drop-shadow-lg' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M4.18753 11.3788C4.03002 11.759 4 11.9533 4 12V20.0018C4 20.5529 4.44652 21 5 21H8V15C8 13.8954 8.89543 13 10 13H14C15.1046 13 16 13.8954 16 15V21H19C19.5535 21 20 20.5529 20 20.0018V12C20 11.9533 19.97 11.759 19.8125 11.3788C19.6662 11.0256 19.4443 10.5926 19.1547 10.1025C18.5764 9.1238 17.765 7.97999 16.8568 6.89018C15.9465 5.79788 14.9639 4.78969 14.0502 4.06454C13.5935 3.70204 13.1736 3.42608 12.8055 3.2444C12.429 3.05862 12.1641 3 12 3C11.8359 3 11.571 3.05862 11.1945 3.2444C10.8264 3.42608 10.4065 3.70204 9.94978 4.06454C9.03609 4.78969 8.05348 5.79788 7.14322 6.89018C6.23505 7.97999 5.42361 9.1238 4.8453 10.1025C4.55568 10.5926 4.33385 11.0256 4.18753 11.3788ZM10.3094 1.45091C10.8353 1.19138 11.4141 1 12 1C12.5859 1 13.1647 1.19138 13.6906 1.45091C14.2248 1.71454 14.7659 2.07921 15.2935 2.49796C16.3486 3.33531 17.4285 4.45212 18.3932 5.60982C19.3601 6.77001 20.2361 8.0012 20.8766 9.08502C21.1963 9.62614 21.4667 10.1462 21.6602 10.6134C21.8425 11.0535 22 11.5467 22 12V20.0018C22 21.6599 20.6557 23 19 23H16C14.8954 23 14 22.1046 14 21V15H10V21C10 22.1046 9.10457 23 8 23H5C3.34434 23 2 21.6599 2 20.0018V12C2 11.5467 2.15748 11.0535 2.33982 10.6134C2.53334 10.1462 2.80369 9.62614 3.12345 9.08502C3.76389 8.0012 4.63995 6.77001 5.60678 5.60982C6.57152 4.45212 7.65141 3.33531 8.70647 2.49796C9.2341 2.07921 9.77521 1.71454 10.3094 1.45091Z"></path>
                                </g>
                            </svg>
                            <p id="hideSideElem">
                                 Dashboard
                            </p>  
                        </a>
                    @endif
                @endauth
                {{-- user dashboard --}}
                @auth
                @if (auth()->user()->hasRole('user'))
                    <a href="{{ route('user.dashboard') }}"
                       class="{{ Route::is('user.dashboard') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 w-full items-center font-medium group p-2 rounded-lg transition-all">
                        <svg class="{{ Route::is('user.dashboard') ? 'sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-white drop-shadow-lg' : 'sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white drop-shadow-lg' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M4.18753 11.3788C4.03002 11.759 4 11.9533 4 12V20.0018C4 20.5529 4.44652 21 5 21H8V15C8 13.8954 8.89543 13 10 13H14C15.1046 13 16 13.8954 16 15V21H19C19.5535 21 20 20.5529 20 20.0018V12C20 11.9533 19.97 11.759 19.8125 11.3788C19.6662 11.0256 19.4443 10.5926 19.1547 10.1025C18.5764 9.1238 17.765 7.97999 16.8568 6.89018C15.9465 5.79788 14.9639 4.78969 14.0502 4.06454C13.5935 3.70204 13.1736 3.42608 12.8055 3.2444C12.429 3.05862 12.1641 3 12 3C11.8359 3 11.571 3.05862 11.1945 3.2444C10.8264 3.42608 10.4065 3.70204 9.94978 4.06454C9.03609 4.78969 8.05348 5.79788 7.14322 6.89018C6.23505 7.97999 5.42361 9.1238 4.8453 10.1025C4.55568 10.5926 4.33385 11.0256 4.18753 11.3788ZM10.3094 1.45091C10.8353 1.19138 11.4141 1 12 1C12.5859 1 13.1647 1.19138 13.6906 1.45091C14.2248 1.71454 14.7659 2.07921 15.2935 2.49796C16.3486 3.33531 17.4285 4.45212 18.3932 5.60982C19.3601 6.77001 20.2361 8.0012 20.8766 9.08502C21.1963 9.62614 21.4667 10.1462 21.6602 10.6134C21.8425 11.0535 22 11.5467 22 12V20.0018C22 21.6599 20.6557 23 19 23H16C14.8954 23 14 22.1046 14 21V15H10V21C10 22.1046 9.10457 23 8 23H5C3.34434 23 2 21.6599 2 20.0018V12C2 11.5467 2.15748 11.0535 2.33982 10.6134C2.53334 10.1462 2.80369 9.62614 3.12345 9.08502C3.76389 8.0012 4.63995 6.77001 5.60678 5.60982C6.57152 4.45212 7.65141 3.33531 8.70647 2.49796C9.2341 2.07921 9.77521 1.71454 10.3094 1.45091Z"></path>
                            </g>
                        </svg>
                        <p id="hideSideElem">
                            Dashboard
                        </p>  
                    </a>
                @endif
            @endauth
                </li>                
                <li class="hover:drop-shadow-lg w-full">
                    <a href="{{ route('chats.index') }}" 
                       class="{{ Route::is('chats.index') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 w-full items-center font-medium group p-2 rounded-lg transition-all">
                        <svg viewBox="0 0 24 24" class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] group-hover:fill-white {{ Route::is('chats.index') ? 'fill-white' : 'fill-none' }} drop-shadow-lg stroke-[#1B651B]" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 13.5997 2.37562 15.1116 3.04346 16.4525C3.22094 16.8088 3.28001 17.2161 3.17712 17.6006L2.58151 19.8267C2.32295 20.793 3.20701 21.677 4.17335 21.4185L6.39939 20.8229C6.78393 20.72 7.19121 20.7791 7.54753 20.9565C8.88837 21.6244 10.4003 22 12 22Z" stroke-width="1.5"></path>
                                <path d="M8 10.5H16" stroke-width="1.5" stroke-linecap="round"></path>
                                <path d="M8 14H13.5" stroke-width="1.5" stroke-linecap="round"></path>
                            </g>
                        </svg>
                        <p id="hideSideElem">Chat</p>
                        
                    </a>
                </li>
              
                    <li class="hover:drop-shadow-lg w-full">
                        <a href="{{ route('admin.event-calendar') }}" class="flex gap-4 font-medium items-center p-2 group rounded-lg transition-all {{ Route::is('admin.event-calendar') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }}">
                            <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('admin.event-calendar') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19 3h-1V2a1 1 0 0 0-2 0v1H8V2a1 1 0 0 0-2 0v1H5c-1.1 0-1.99.9-1.99 2L3 21a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5c0-1.1-.9-2-2-2zM5 8V6h14v2H5zm0 2h14v11H5V10zm7 5h2v2h-2v-2z"/>
                            </svg>
                            <p id="hideSideElem">
                                Calendar
                            </p>
                        </a>
                    </li>
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                        <li class="hover:drop-shadow-lg w-full">
                            <a href="{{ route('manuscriptall-lists') }}" class="flex gap-4 group items-center font-medium p-2 rounded-lg transition-all {{ Route::is('manuscriptall-lists') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white group' }}">
                                <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('manuscriptall-lists') ? 'fill-white' : 'group-hover:fill-white' }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path fill-rule="evenodd" d="M12 2a2 2 0 00-2 2v16a2 2 0 002 2h6a2 2 0 002-2V8.828a2 2 0 00-.586-1.414l-4.828-4.828A2 2 0 0014.828 2H12zm5.586 6H14a2 2 0 01-2-2V4.414l3.586 3.586zM10 4a2 2 0 00-2 2v12H7a2 2 0 00-2 2v2h8v-2a2 2 0 00-2-2H10V4z" clip-rule="evenodd"></path>
                                </svg>
                                <p id="hideSideElem">List of Researchers</p>
                            </a>
                        </li>
                        @endif 
                    @endauth

                    @auth
                    @if (auth()->user()->hasRole('user'))
                    <li class="hover:drop-shadow-lg w-full">
                        <a href="{{ route('manuscript.index') }}" class="flex gap-4 group items-center font-medium p-2 rounded-lg transition-all {{ Route::is('manuscript.index') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white group' }}">
                            <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('manuscript.index') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 6C3.25 4.45831 4.48029 3.26447 6.00774 2.50075C7.58004 1.7146 9.69967 1.25 12 1.25C14.3003 1.25 16.42 1.7146 17.9923 2.50075C19.5197 3.26447 20.75 4.45831 20.75 6V18C20.75 19.5417 19.5197 20.7355 17.9923 21.4992C16.42 22.2854 14.3003 22.75 12 22.75C9.69967 22.75 7.58004 22.2854 6.00774 21.4992C4.48029 20.7355 3.25 19.5417 3.25 18V6ZM4.75 6C4.75 5.33255 5.31057 4.52639 6.67856 3.84239C8.00168 3.18083 9.88205 2.75 12 2.75C14.118 2.75 15.9983 3.18083 17.3214 3.84239C18.6894 4.52639 19.25 5.33255 19.25 6C19.25 6.66745 18.6894 7.47361 17.3214 8.15761C15.9983 8.81917 14.118 9.25 12 9.25C9.88205 9.25 8.00168 8.81917 6.67856 8.15761C5.31057 7.47361 4.75 6.66745 4.75 6ZM4.75 18C4.75 18.6674 5.31057 19.4736 6.67856 20.1576C8.00168 20.8192 9.88205 21.25 12 21.25C14.118 21.25 15.9983 20.8192 17.3214 20.1576C18.6894 19.4736 19.25 18.6674 19.25 18V14.7072C18.8733 15.0077 18.4459 15.2724 17.9923 15.4992C16.42 16.2854 14.3003 16.75 12 16.75C9.69967 16.75 7.58004 16.2854 6.00774 15.4992C5.55414 15.2724 5.12675 15.0077 4.75 14.7072V18ZM19.25 8.70722V12C19.25 12.6674 18.6894 13.4736 17.3214 14.1576C15.9983 14.8192 14.118 15.25 12 15.25C9.88205 15.25 8.00168 14.8192 6.67856 14.1576C5.31057 13.4736 4.75 12.6674 4.75 12V8.70722C5.12675 9.00772 5.55414 9.27245 6.00774 9.49925C7.58004 10.2854 9.69967 10.75 12 10.75C14.3003 10.75 16.42 10.2854 17.9923 9.49925C18.4459 9.27245 18.8733 9.00772 19.25 8.70722Z"></path>
                                </g>
                            </svg>
                            <p id="hideSideElem">Manuscript Management</p>
                        </a>
                    </li>
                    @endif 
                    @endauth

                    @auth
                @if (auth()->user()->hasRole('admin'))
                <li class="hover:drop-shadow-lg w-full">
                    <a href="{{ route('reports.admin-index') }}" 
                       class="{{ Route::is('reports.admin-index') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 font-medium items-center p-2 group rounded-lg transition-all">
                        <svg viewBox="0 0 24 24" class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] group-hover:fill-white {{ Route::is('reports.admin-index') ? 'fill-white' : 'fill-[#1B651B]' }} drop-shadow-lg" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M4 1C3.44772 1 3 1.44772 3 2V22C3 22.5523 3.44772 23 4 23C4.55228 23 5 22.5523 5 22V13.5983C5.46602 13.3663 6.20273 13.0429 6.99251 12.8455C8.40911 12.4914 9.54598 12.6221 10.168 13.555C11.329 15.2964 13.5462 15.4498 15.2526 15.2798C17.0533 15.1004 18.8348 14.5107 19.7354 14.1776C20.5267 13.885 21 13.1336 21 12.3408V5.72337C21 4.17197 19.3578 3.26624 18.0489 3.85981C16.9875 4.34118 15.5774 4.87875 14.3031 5.0563C12.9699 5.24207 12.1956 4.9907 11.832 4.44544C10.5201 2.47763 8.27558 2.24466 6.66694 2.37871C6.0494 2.43018 5.47559 2.53816 5 2.65249V2C5 1.44772 4.55228 1 4 1ZM5 4.72107V11.4047C5.44083 11.2247 5.95616 11.043 6.50747 10.9052C8.09087 10.5094 10.454 10.3787 11.832 12.4455C12.3106 13.1634 13.4135 13.4531 15.0543 13.2897C16.5758 13.1381 18.1422 12.6321 19 12.3172V5.72337C19 5.67794 18.9081 5.66623 18.875 5.68126C17.7575 6.18804 16.1396 6.81972 14.5791 7.03716C13.0776 7.24639 11.2104 7.1185 10.168 5.55488C9.47989 4.52284 8.2244 4.25586 6.83304 4.3718C6.12405 4.43089 5.46427 4.58626 5 4.72107Z" ></path> </g></svg>
                        
                        <p id="hideSideElem">
                            Coordinator's Report
                        </p>
                    </a>
                    </li>
                    <li class="hover:drop-shadow-lg w-full">
                    <a href="{{ route('admin-kraindex') }}" 
                        class="{{ Route::is('admin-kraindex') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 font-medium items-center p-2 group rounded-lg transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] group-hover:fill-white {{ Route::is('admin-kraindex') ? 'fill-white' : 'fill-[#1B651B]' }} drop-shadow-lg" viewBox="0 0 24 24" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V6l-6-4H6zM4 4a2 2 0 012-2h7.172a2 2 0 011.414.586l4.828 4.828a2 2 0 01.586 1.414V20a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm4 7a1 1 0 100 2h8a1 1 0 100-2H8zm-1-3a1 1 0 011-1h6a1 1 0 110 2H8a1 1 0 01-1-1zm1 7a1 1 0 100 2h8a1 1 0 100-2H8z" clip-rule="evenodd"/>
                        </svg>
                        
                        <p id="hideSideElem">
                        MFO / KRA Report
                        </p>
                    </a>
                    </li>
                    @endif 
                    @endauth
                    
                    @auth
                @if (auth()->user()->hasRole('sub-admin'))

                <li class="hover:drop-shadow-lg w-full">
                    <a href="{{ route('reports.index') }}" 
                       class="{{ Route::is('reports.index') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 font-medium items-center p-2 group rounded-lg transition-all">
                        <svg viewBox="0 0 24 24" class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] group-hover:fill-white {{ Route::is('reports.index') ? 'fill-white' : 'fill-[#1B651B]' }} drop-shadow-lg" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M4 1C3.44772 1 3 1.44772 3 2V22C3 22.5523 3.44772 23 4 23C4.55228 23 5 22.5523 5 22V13.5983C5.46602 13.3663 6.20273 13.0429 6.99251 12.8455C8.40911 12.4914 9.54598 12.6221 10.168 13.555C11.329 15.2964 13.5462 15.4498 15.2526 15.2798C17.0533 15.1004 18.8348 14.5107 19.7354 14.1776C20.5267 13.885 21 13.1336 21 12.3408V5.72337C21 4.17197 19.3578 3.26624 18.0489 3.85981C16.9875 4.34118 15.5774 4.87875 14.3031 5.0563C12.9699 5.24207 12.1956 4.9907 11.832 4.44544C10.5201 2.47763 8.27558 2.24466 6.66694 2.37871C6.0494 2.43018 5.47559 2.53816 5 2.65249V2C5 1.44772 4.55228 1 4 1ZM5 4.72107V11.4047C5.44083 11.2247 5.95616 11.043 6.50747 10.9052C8.09087 10.5094 10.454 10.3787 11.832 12.4455C12.3106 13.1634 13.4135 13.4531 15.0543 13.2897C16.5758 13.1381 18.1422 12.6321 19 12.3172V5.72337C19 5.67794 18.9081 5.66623 18.875 5.68126C17.7575 6.18804 16.1396 6.81972 14.5791 7.03716C13.0776 7.24639 11.2104 7.1185 10.168 5.55488C9.47989 4.52284 8.2244 4.25586 6.83304 4.3718C6.12405 4.43089 5.46427 4.58626 5 4.72107Z" ></path> </g></svg>
                        
                        <p id="hideSideElem">
                           MFO / KRA Report
                        </p>
                    </a>
                    </li>
                    <li class="hover:drop-shadow-lg w-full">
                    <a href="{{ route('dropbox.index') }}" 
                    class="{{ Route::is('dropbox.index') ? 'active bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }} flex gap-4 font-medium items-center p-2 group rounded-lg transition-all">
                        <svg viewBox="0 0 24 24" class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] group-hover:fill-white {{ Route::is('dropbox.index') ? 'fill-white' : 'fill-[#1B651B]' }} drop-shadow-lg" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L3 7v10l9 5 9-5V7l-9-5zM4.64 8.79L12 4.07l7.36 4.72v9.42L12 19.93 4.64 18.21V8.79z"/>
                            <path d="M12 14.1l-4.5-2.6L12 9.9l4.5 2.6L12 14.1z"/>
                        </svg>
                        
                        <p id="hideSideElem">
                        Drop Box
                        </p>
                    </a>
                </li>
                    @endif 
                    @endauth
                    
                    @auth
                    @if (auth()->user()->hasRole('admin')) 
                    <li class="hover:drop-shadow-lg w-full">
                        <a href="{{ route('newsfeed.index') }}" class="flex gap-4 font-medium items-center p-2 group rounded-lg transition-all {{ Route::is('newsfeed.index') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }}">
                            <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] group-hover:fill-white fill-[#1B651B] drop-shadow-lg {{ Route::is('newsfeed.index') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 1000 1000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)">
                                            <path d="M8385.3,4982.2c-341.1-83.7-694.4-430.9-753.6-741.4c-8.2-44.9-28.6-77.6-57.2-89.9c-22.5-10.2-1109-355.4-2412-765.9c-1303-410.5-2659.1-837.3-3012.4-949.7c-353.3-112.3-706.6-232.8-786.3-271.6C1055.4,2016.7,749,1706.3,567.2,1355C336.5,905.7,311.9,401.3,501.9-52.1C636.7-380.9,963.4-769,1247.3-940.5c69.4-42.9,302.3-130.7,571.9-220.6l453.4-149.1v-1296.9c0-1427.6,0-1419.4,126.6-1658.4c120.5-226.7,406.4-449.3,651.5-504.5c200.1-47,439.1-10.2,639.2,96c132.8,69.5,355.4,292.1,424.8,424.8c114.4,214.5,118.4,255.3,118.4,1329.6c0,543.3,4.1,986.4,10.2,986.4c12.3,0,2934.8-921.1,3218.7-1013c153.2-49,157.3-53.1,171.6-126.6c8.2-40.8,36.8-120.5,65.4-177.7c234.9-473.8,757.7-708.7,1221.3-551.4c236.9,79.7,494.2,308.4,604.5,537.1C9629-3052.3,9625-3215.7,9625,579c0,3880.4,6.1,3655.8-118.5,3888.6c-30.6,57.2-114.4,163.4-187.9,236.9C9061.3,4963.8,8722.2,5063.9,8385.3,4982.2z M8883.6,4345c30.6-22.5,73.5-73.5,91.9-112.3c34.7-65.3,36.8-279.8,36.8-3643.5c0-3496.5-2-3576.1-40.8-3661.9c-53.1-116.4-159.3-167.5-357.4-167.5c-198.1,0-304.3,51.1-357.4,167.5c-38.8,85.8-40.8,165.4-40.8,3661.9c0,3420.9,2,3578.2,36.8,3645.6c22.5,44.9,71.5,89.9,128.7,118.5c77.6,40.8,114.4,47,267.6,40.8C8789.6,4389.9,8836.6,4379.7,8883.6,4345z M7603,589.2c0-1823.8-8.2-2930.7-18.4-2930.7c-26.5,0-5755.3,1805.4-5900.3,1858.5c-316.6,116.4-580,412.6-667.8,745.4c-38.8,149.1-40.8,494.2-2,633.1c75.6,283.9,292.1,561.6,539.2,690.3c85.8,44.9,704.6,249.2,1668.6,553.5c843.5,265.5,2166.9,682.1,2941,929.3c776.1,245.1,1415.3,447.3,1425.5,449.3C7596.9,3517.9,7603,2200.5,7603,589.2z M3283.5-1626.8c177.7-55.1,326.8-102.1,330.9-102.1c4.1,0,6.1-498.3,6.1-1106.9c0-1015-4.1-1115.1-36.8-1178.4c-63.3-126.6-126.6-155.2-330.9-155.2s-267.5,28.6-330.9,155.2c-34.7,63.3-36.8,167.5-36.8,1290.8c0,1153.9,2,1221.3,36.8,1211.1C2940.4-1518.5,3103.8-1569.6,3283.5-1626.8z"></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <p id="hideSideElem">
                                News and Announcement Publisher
                            </p>
                        </a>
                    </li> 
                    @endif @endauth

                    @auth
                    @if (auth()->user()->hasRole('sub-admin')) 
                    <li class="hover:drop-shadow-lg w-full">
                        <a href="{{ route('newsfeed.index') }}" class="flex gap-4 font-medium items-center p-2 group rounded-lg transition-all {{ Route::is('newsfeed.index') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }}">
                            <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] group-hover:fill-white fill-[#1B651B] drop-shadow-lg {{ Route::is('newsfeed.index') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 1000 1000" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 1000 1000" xml:space="preserve">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <g>
                                        <g transform="translate(0.000000,511.000000) scale(0.100000,-0.100000)">
                                            <path d="M8385.3,4982.2c-341.1-83.7-694.4-430.9-753.6-741.4c-8.2-44.9-28.6-77.6-57.2-89.9c-22.5-10.2-1109-355.4-2412-765.9c-1303-410.5-2659.1-837.3-3012.4-949.7c-353.3-112.3-706.6-232.8-786.3-271.6C1055.4,2016.7,749,1706.3,567.2,1355C336.5,905.7,311.9,401.3,501.9-52.1C636.7-380.9,963.4-769,1247.3-940.5c69.4-42.9,302.3-130.7,571.9-220.6l453.4-149.1v-1296.9c0-1427.6,0-1419.4,126.6-1658.4c120.5-226.7,406.4-449.3,651.5-504.5c200.1-47,439.1-10.2,639.2,96c132.8,69.5,355.4,292.1,424.8,424.8c114.4,214.5,118.4,255.3,118.4,1329.6c0,543.3,4.1,986.4,10.2,986.4c12.3,0,2934.8-921.1,3218.7-1013c153.2-49,157.3-53.1,171.6-126.6c8.2-40.8,36.8-120.5,65.4-177.7c234.9-473.8,757.7-708.7,1221.3-551.4c236.9,79.7,494.2,308.4,604.5,537.1C9629-3052.3,9625-3215.7,9625,579c0,3880.4,6.1,3655.8-118.5,3888.6c-30.6,57.2-114.4,163.4-187.9,236.9C9061.3,4963.8,8722.2,5063.9,8385.3,4982.2z M8883.6,4345c30.6-22.5,73.5-73.5,91.9-112.3c34.7-65.3,36.8-279.8,36.8-3643.5c0-3496.5-2-3576.1-40.8-3661.9c-53.1-116.4-159.3-167.5-357.4-167.5c-198.1,0-304.3,51.1-357.4,167.5c-38.8,85.8-40.8,165.4-40.8,3661.9c0,3420.9,2,3578.2,36.8,3645.6c22.5,44.9,71.5,89.9,128.7,118.5c77.6,40.8,114.4,47,267.6,40.8C8789.6,4389.9,8836.6,4379.7,8883.6,4345z M7603,589.2c0-1823.8-8.2-2930.7-18.4-2930.7c-26.5,0-5755.3,1805.4-5900.3,1858.5c-316.6,116.4-580,412.6-667.8,745.4c-38.8,149.1-40.8,494.2-2,633.1c75.6,283.9,292.1,561.6,539.2,690.3c85.8,44.9,704.6,249.2,1668.6,553.5c843.5,265.5,2166.9,682.1,2941,929.3c776.1,245.1,1415.3,447.3,1425.5,449.3C7596.9,3517.9,7603,2200.5,7603,589.2z M3283.5-1626.8c177.7-55.1,326.8-102.1,330.9-102.1c4.1,0,6.1-498.3,6.1-1106.9c0-1015-4.1-1115.1-36.8-1178.4c-63.3-126.6-126.6-155.2-330.9-155.2s-267.5,28.6-330.9,155.2c-34.7,63.3-36.8,167.5-36.8,1290.8c0,1153.9,2,1221.3,36.8,1211.1C2940.4-1518.5,3103.8-1569.6,3283.5-1626.8z"></path>
                                        </g>
                                    </g>
                                </g>
                            </svg>
                            <p id="hideSideElem">
                                News and Announcement Publisher
                            </p>
                        </a>
                    </li> 
                    @endif @endauth


                    @auth
        @if (auth()->user()->hasRole('admin')) 
    <li class="hover:drop-shadow-lg sm:overflow-hidden transition-all flex sm:block">
        <a id="showManagement" href="#" class="flex gap-4 font-medium items-center p-2 group rounded-lg transition-all hover:bg-[#1B651B] hover:text-white {{-- Route::is('accountmng.index') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' --}}">
            <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{-- Route::is('accountmng.index') ? 'fill-white' : 'group-hover:fill-white' --}}" viewBox="0 0 297 297" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 297 297">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M225.656,77.674c21.414,0,38.837-17.422,38.837-38.837S247.07,0,225.656,0S186.82,17.422,186.82,38.837S204.244,77.674,225.656,77.674z M225.656,17.64c11.646,0,21.127,9.481,21.127,21.127s-9.481,21.127-21.127,21.127s-21.127-9.481-21.127-21.127S214.01,17.64,225.656,17.64z M225.656,110.285c-28.606,0-51.953,23.347-51.953,51.953s23.347,51.953,51.953,51.953s51.953-23.347,51.953-51.953S254.262,110.285,225.656,110.285z M225.656,161.951c-19.603,0-35.522-15.919-35.522-35.522s15.919-35.522,35.522-35.522s35.522,15.919,35.522,35.522S245.26,161.951,225.656,161.951z M225.656,205.863c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-28.894-23.569-52.463-52.463-52.463s-52.463,23.569-52.463,52.463v2.18c-15.683-8.462-33.219-13.517-51.953-13.517c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-43.83,35.641-79.471,79.471-79.471c21.142,0,40.401,8.535,54.962,22.338c14.56-13.803,33.819-22.338,54.962-22.338c43.83,0,79.471,35.641,79.471,79.471v2.18C261.926,210.918,244.389,205.863,225.656,205.863z"></path>
                </g>
            </svg>
            <p id="hideSideElem">
                Account Management
            </p>
        </a>
<div id="managementNav" class="hidden sm:bg-white bg-amber-500 rounded-lg sm:mt-2 ms-2">
    <ul   class="sm:ml-8 w-full sm:block flex">
        <li class="hover:drop-shadow-lg w-full">
            <a href="{{ route('accountmng.userlist') }}" class="flex gap-4 font-medium items-center p-2 group rounded-lg transition-all {{ Route::is('accountmng.userlist') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }}">
                <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('accountmng.userlist') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 297 297" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 297 297">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M225.656,77.674c21.414,0,38.837-17.422,38.837-38.837S247.07,0,225.656,0S186.82,17.422,186.82,38.837S204.244,77.674,225.656,77.674z M225.656,17.64c11.646,0,21.127,9.481,21.127,21.127s-9.481,21.127-21.127,21.127s-21.127-9.481-21.127-21.127S214.01,17.64,225.656,17.64z M225.656,110.285c-28.606,0-51.953,23.347-51.953,51.953s23.347,51.953,51.953,51.953s51.953-23.347,51.953-51.953S254.262,110.285,225.656,110.285z M225.656,161.951c-19.603,0-35.522-15.919-35.522-35.522s15.919-35.522,35.522-35.522s35.522,15.919,35.522,35.522S245.26,161.951,225.656,161.951z M225.656,205.863c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-28.894-23.569-52.463-52.463-52.463s-52.463,23.569-52.463,52.463v2.18c-15.683-8.462-33.219-13.517-51.953-13.517c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-43.83,35.641-79.471,79.471-79.471c21.142,0,40.401,8.535,54.962,22.338c14.56-13.803,33.819-22.338,54.962-22.338c43.83,0,79.471,35.641,79.471,79.471v2.18C261.926,210.918,244.389,205.863,225.656,205.863z"></path>
                    </g>
                </svg>
                <p id="hideSideElem">
                   User List
                </p>
            </a>
        </li>
        <li class="hover:drop-shadow-lg w-full">
            <a href="{{ route('accountmng.index') }}" class="flex gap-4 font-medium items-center p-2 group rounded-lg transition-all {{ Route::is('accountmng.index') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }}">
                <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('accountmng.index') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 297 297" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 297 297">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M225.656,77.674c21.414,0,38.837-17.422,38.837-38.837S247.07,0,225.656,0S186.82,17.422,186.82,38.837S204.244,77.674,225.656,77.674z M225.656,17.64c11.646,0,21.127,9.481,21.127,21.127s-9.481,21.127-21.127,21.127s-21.127-9.481-21.127-21.127S214.01,17.64,225.656,17.64z M225.656,110.285c-28.606,0-51.953,23.347-51.953,51.953s23.347,51.953,51.953,51.953s51.953-23.347,51.953-51.953S254.262,110.285,225.656,110.285z M225.656,161.951c-19.603,0-35.522-15.919-35.522-35.522s15.919-35.522,35.522-35.522s35.522,15.919,35.522,35.522S245.26,161.951,225.656,161.951z M225.656,205.863c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-28.894-23.569-52.463-52.463-52.463s-52.463,23.569-52.463,52.463v2.18c-15.683-8.462-33.219-13.517-51.953-13.517c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-43.83,35.641-79.471,79.471-79.471c21.142,0,40.401,8.535,54.962,22.338c14.56-13.803,33.819-22.338,54.962-22.338c43.83,0,79.471,35.641,79.471,79.471v2.18C261.926,210.918,244.389,205.863,225.656,205.863z"></path>
                    </g>
                </svg>
                <p id="hideSideElem">
                    Validate Account
                </p>
            </a>
        </li>
        <li class="hover:drop-shadow-lg w-full">
            <a href="{{ route('accountmng.permissions') }}" class="flex gap-4 font-medium items-center p-2 group rounded-lg transition-all hover:bg-[#1B651B] hover:text-white {{ Route::is('accountmng.permissions') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white' }}">
                <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('accountmng.permissions') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 297 297" xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 297 297">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M225.656,77.674c21.414,0,38.837-17.422,38.837-38.837S247.07,0,225.656,0S186.82,17.422,186.82,38.837S204.244,77.674,225.656,77.674z M225.656,17.64c11.646,0,21.127,9.481,21.127,21.127s-9.481,21.127-21.127,21.127s-21.127-9.481-21.127-21.127S214.01,17.64,225.656,17.64z M225.656,110.285c-28.606,0-51.953,23.347-51.953,51.953s23.347,51.953,51.953,51.953s51.953-23.347,51.953-51.953S254.262,110.285,225.656,110.285z M225.656,161.951c-19.603,0-35.522-15.919-35.522-35.522s15.919-35.522,35.522-35.522s35.522,15.919,35.522,35.522S245.26,161.951,225.656,161.951z M225.656,205.863c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-28.894-23.569-52.463-52.463-52.463s-52.463,23.569-52.463,52.463v2.18c-15.683-8.462-33.219-13.517-51.953-13.517c-18.733,0-36.27,5.055-51.953,13.517v-2.18c0-43.83,35.641-79.471,79.471-79.471c21.142,0,40.401,8.535,54.962,22.338c14.56-13.803,33.819-22.338,54.962-22.338c43.83,0,79.471,35.641,79.471,79.471v2.18C261.926,210.918,244.389,205.863,225.656,205.863z"></path>
                    </g>
                </svg>
                <p id="hideSideElem">
                    Permissions
                </p>
            </a>
        </li>
    </ul>
</div>
    
</li> 
    @endif
         @endauth

                    @auth
                    @if (auth()->user()->hasRole('admin'))
                    <li class="hover:drop-shadow-lg w-full">
                        <a href="{{ route('datamng.index') }}" class="flex gap-4 group items-center font-medium p-2 rounded-lg transition-all {{ Route::is('datamng.index') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white group' }}">
                            <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('datamng.index') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.25 6C3.25 4.45831 4.48029 3.26447 6.00774 2.50075C7.58004 1.7146 9.69967 1.25 12 1.25C14.3003 1.25 16.42 1.7146 17.9923 2.50075C19.5197 3.26447 20.75 4.45831 20.75 6V18C20.75 19.5417 19.5197 20.7355 17.9923 21.4992C16.42 22.2854 14.3003 22.75 12 22.75C9.69967 22.75 7.58004 22.2854 6.00774 21.4992C4.48029 20.7355 3.25 19.5417 3.25 18V6ZM4.75 6C4.75 5.33255 5.31057 4.52639 6.67856 3.84239C8.00168 3.18083 9.88205 2.75 12 2.75C14.118 2.75 15.9983 3.18083 17.3214 3.84239C18.6894 4.52639 19.25 5.33255 19.25 6C19.25 6.66745 18.6894 7.47361 17.3214 8.15761C15.9983 8.81917 14.118 9.25 12 9.25C9.88205 9.25 8.00168 8.81917 6.67856 8.15761C5.31057 7.47361 4.75 6.66745 4.75 6ZM4.75 18C4.75 18.6674 5.31057 19.4736 6.67856 20.1576C8.00168 20.8192 9.88205 21.25 12 21.25C14.118 21.25 15.9983 20.8192 17.3214 20.1576C18.6894 19.4736 19.25 18.6674 19.25 18V14.7072C18.8733 15.0077 18.4459 15.2724 17.9923 15.4992C16.42 16.2854 14.3003 16.75 12 16.75C9.69967 16.75 7.58004 16.2854 6.00774 15.4992C5.55414 15.2724 5.12675 15.0077 4.75 14.7072V18ZM19.25 8.70722V12C19.25 12.6674 18.6894 13.4736 17.3214 14.1576C15.9983 14.8192 14.118 15.25 12 15.25C9.88205 15.25 8.00168 14.8192 6.67856 14.1576C5.31057 13.4736 4.75 12.6674 4.75 12V8.70722C5.12675 9.00772 5.55414 9.27245 6.00774 9.49925C7.58004 10.2854 9.69967 10.75 12 10.75C14.3003 10.75 16.42 10.2854 17.9923 9.49925C18.4459 9.27245 18.8733 9.00772 19.25 8.70722Z"></path>
                                </g>
                            </svg>
                            <p id="hideSideElem">Data Management</p>
                        </a>
                    </li>

                    <li class="hover:drop-shadow-lg w-full">
                    <a href="{{ route('contact.index') }}" class="flex gap-4 group items-center font-medium p-2 rounded-lg transition-all {{ Route::is('contact.index') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white group' }}">
                        <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('contact.index') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M4 2C4 1.44772 4.44772 1 5 1H19C19.5523 1 20 1.44772 20 2V22C20 22.5523 19.5523 23 19 23H5C4.44772 23 4 22.5523 4 22V2ZM5 3H19V21H5V3ZM12 17L7 12H10V9H14V12H17L12 17ZM11 7H13V10H11V7Z" />
                        </svg>
                        <p id="hideSideElem">Contact Us</p>
                    </a>
                </li>
                    <li class="hover:drop-shadow-lg w-full">
                        <a href="{{ route('activity.logsadmin') }}" class="flex group gap-4 items-center font-medium p-2 rounded-lg transition-all {{ Route::is('activity.logsadmin') ? 'bg-[#1B651B] text-white' : 'hover:bg-[#1B651B] hover:text-white group' }}">
                            <svg class="sm:h-[2rem] sm:w-[2rem] w-[1.5rem] h-[1.5rem] fill-[#1B651B] group-hover:fill-white {{ Route::is('activity.logsadmin') ? 'fill-white' : 'group-hover:fill-white' }}" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                                <g id="SVGRepo_iconCarrier">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12 1C5.925 1 1 5.925 1 12s4.925 11 11 11 11-4.925 11-11S18.075 1 12 1zm-1 16h2v-2h-2v2zm0-4h2V7h-2v6z"></path>
                                </g>
                            </svg>
                            <p id="hideSideElem">All Logs</p>
                        </a>
                    </li>                    
                    @endif
                    @endauth
                </ul>
        </nav>
        <button id="navMobBtn" class="absolute bottom-0   sm:hidden rounded-full w-[2.5rem] text-white bg-orange-500 z-20 p-0 text-sm font-bold drop-shadow-lg">
            &#11205;
    </button>
    </section>
</aside>