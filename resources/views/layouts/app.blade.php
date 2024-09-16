<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-screen flex flex-col justify-center items-center w-full dark:bg-slate-900">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title')</title>
        {{-- x icon --}}
        <link  rel="shortcut icon" href="{{asset('sys_logo/favicon.ico')}}"type="image/x-icon">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <!-- Scripts -->
        <script src="https://kit.fontawesome.com/111c11b663.js" crossorigin="anonymous"></script>
        <script src="{{ asset('js/script.js') }}" defer></script>
        <script src="{{ asset('custom/drawer.js')}}" defer></script>
        <script src="{{ asset('custom/chatpanelHider.js')}}" defer></script>
        <script src="{{ asset('custom/sideHider.js')}}" defer></script>
        <script src="{{ asset('custom/hideNavbar.js')}}" defer></script>
        <script src="{{ asset('custom/showManagement.js')}}" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>
         @vite(['resources/css/app.css', 'resources/js/app.js'])
    
         <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/tabulator/5.1.5/css/tabulator.min.css" rel="stylesheet">
        
    </head>
<body class="h-screen flex flex-col justify-start items-center w-full">
@include('preloader')
     <div class="grow overflow-hidden bg-[#ffffff] sm:flex-row flex flex-col w-full transition-all">

        {{-- Custom swal target --}}

        {{-- <div id="swal-custom" class="h-full w-full fixed top-0 z-50"></div> --}}
       {{-- FOR NOTIFICATION AND MESSAGE PANEL --}}
        @include('layouts.drawer')
            @include('layouts.header')
            {{-- SIDEBAR --}}
                @include('layouts.aside')
                <main id="main" class="w-full grow flex flex-col overflow-y-auto">
                {{-- header section --}}
                <section class="w-full bg-[#ffffff] sm:flex justify-end p-2 sticky top-0 hidden z-10">

                     <button id="hideSidebar" class="sm:me-auto sm:block hidden px-2 py-1 drop-shadow-lg rounded-lg group text-3xl hover:text-slate-700">
                            &#11207;
                    </button>

                    <div class="me-10 flex gap-5 justify-center items-center">
                       {{-- dito par --}}
                        <button id="notif" class="rounded-full bg-white p-3 hover:drop-shadow-lg relative">
                            <svg class="w-[1.5rem] h-[1.5rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M9.0003 21H15.0003M18.0003 8.6C18.0003 7.11479 17.3682 5.69041 16.2429 4.6402C15.1177 3.59 13.5916 3 12.0003 3C10.409 3 8.88288 3.59 7.75766 4.6402C6.63245 5.69041 6.0003 7.11479 6.0003 8.6C6.0003 11.2862 5.32411 13.1835 4.52776 14.4866C3.75646 15.7486 3.37082 16.3797 3.38515 16.5436C3.40126 16.7277 3.4376 16.7925 3.58633 16.9023C3.71872 17 4.34793 17 5.60636 17H18.3943C19.6527 17 20.2819 17 20.4143 16.9023C20.563 16.7925 20.5994 16.7277 20.6155 16.5436C20.6298 16.3797 20.2441 15.7486 19.4729 14.4866C18.6765 13.1835 18.0003 11.2862 18.0003 8.6Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            <div class="absolute top-0 right-0 translate-x-1.5 text-white drop-shadow-lg bg-red-600 rounded-full  px-[6px] text-sm">
                                @livewire('notification-badge')
                            </div>
                        </button> 
                        {{--NOTIFICATION BADGE COUNTER IN DESKTOP VIEW --}}
                        
                        <button id="mess" class="rounded-full bg-white p-3 hover:drop-shadow-lg relative">
                            <svg class="w-[1.5rem] h-[1.5rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M7 9H17M7 13H12M21 20L17.6757 18.3378C17.4237 18.2118 17.2977 18.1488 17.1656 18.1044C17.0484 18.065 16.9277 18.0365 16.8052 18.0193C16.6672 18 16.5263 18 16.2446 18H6.2C5.07989 18 4.51984 18 4.09202 17.782C3.71569 17.5903 3.40973 17.2843 3.21799 16.908C3 16.4802 3 15.9201 3 14.8V7.2C3 6.07989 3 5.51984 3.21799 5.09202C3.40973 4.71569 3.71569 4.40973 4.09202 4.21799C4.51984 4 5.0799 4 6.2 4H17.8C18.9201 4 19.4802 4 19.908 4.21799C20.2843 4.40973 20.5903 4.71569 20.782 5.09202C21 5.51984 21 6.0799 21 7.2V20Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                            <div class="absolute top-0 right-0 translate-x-1.5 text-white drop-shadow-lg bg-red-600 rounded-full  px-[6px] text-sm">
                                @livewire('unread-message-counter')
                            </div>
                        </button>
                      
                        @if(Auth::user()->userinfos && Auth::user()->userinfos->profile_pic)
                        <img id="profile" src="{{ asset(Auth::user()->userinfos->profile_pic) }}" alt="Profile Picture" alt="" class="rounded-full p-2 bg-white w-12 h-12 hover:drop-shadow-lg cursor-pointer">
                    @else
                        <img  id="profile" src="{{ asset('default-profile-pic.jpg') }}" alt="Default Profile Picture" alt="" class="rounded-full p-2 bg-white w-12 h-12 hover:drop-shadow-lg cursor-pointer" alt="" >
                    @endif 
                    </div>
                </section>
                <div class="w-full grow justify-start items-start flex flex-col px-3 my-5">
                      
                    {{ $slot }}  
                </div>
            </main>
            <!-- BACK TO TOP NIGG -->
            <button onclick="topFunction()" id="backToTop" title="Go to top">
            <i class="fas fa-arrow-up"></i>
            </button>
        </div>
        <script src="{{ asset('custom/backend.js')}}" defer></script>
        
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tabulator/5.1.5/js/tabulator.min.js"></script>
    </body>
</html>
