<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-screen flex flex-col justify-start items-center overflow hoverflow-hidden font-Figtree">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', '') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        {{-- x icon --}}
        <link  rel="shortcut icon" href="{{asset('sys_logo/favicon.ico')}}"type="image/x-icon">
       <!-- Styles -->
         @vite(['resources/css/app.css', 'resources/js/app.js'])
         <script src="https://cdn.tailwindcss.com"></script>
        
    </head>
    <body class="h-screen w-full flex flex-col justify-start items-center overflow-hidden bg-[#f3f3f3] antialiased">
@include('preloader')   
        {{-- offcanvas section --}}
        <section id="offcanvas" class="sm:hidden fixed top-0 overflow-hidden z-30 h-full flex justify-end items-start transition-all">
            <div class="absolute bg-white w-1/2 h-full z-30 flex flex-col">
                <span id="offcanvasClose" class="p-4 text-lg ms-2 cursor-pointer hover:opacity-45">&#10006;</span>
                <ul class="flex flex-col space-y-6 text-md ms-5 text-sm">
                    <li class="{{request()->is('/') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="/">Home</a></li>
                                @guest
                    <li class="{{request()->is('login') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('login') }}">Login</a></li>
                    <li class="{{request()->is('sign_up') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('register') }}"></a>Sign up</li>
                                @endguest
                    <li class="{{request()->is('contact') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}" onclick="showContactUsForm()">Contact</li>
                    @auth
                    @if (auth()->user()->hasRole('admin'))
                    <li class="{{ Route::is('admin.dashboard') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    @endif
                    @endauth
                    @auth
                    @if (auth()->user()->hasRole('sub-admin'))
                    <li class="{{ Route::is('sub.dashboard') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('sub.dashboard') }}">Dashboard</a></li>
                    @endif
                    @endauth
                    @auth
                    @if (auth()->user()->hasRole('user'))
                    <li class="{{ Route::is('user.dashboard') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                    @endif
                    @endauth
                </ul>
            </div>
            <div id="offcanvasClose" class="absolute w-full h-full bg-black opacity-20"></div>
        </section>
        
                        {{--  @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                     <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-green-500 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-green-500 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Log in
                                    </a>
                                    

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                  ter
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif--}}
                            
                    <header class="w-full p-1 bg-white flex justify-start items-center shadow-md z-10">
                        {{-- logo section --}}
                        <section class="p-2 flex items-center space-x-5 sm:ms-10 me-auto">
                           <a href="/"> <img src="{{asset('sys_logo/RISlogo1.svg')}}" class="object-contain sm:h-16 sm:w-16 w-9 h-9 drop-shadow-xl" alt=""></a>
                           <a href="/"><h1 class="sm:text-xl text-md font-bold text-nowrap  text-slate-800">Research InfoSys</h1></a>   </section>

                        {{-- main navigation desktop --}}
                        <nav class="sm:ms-auto hidden sm:block">
                            <ul class="flex space-x-6 text-md ">
                                <li class="{{request()->is('/') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}">Home</li>
                                @guest
                                 <li class="{{request()->is('login') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('login') }}">Login</a></li>
                                <li class="{{request()->is('register') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('register') }}">Sign up</a></li>
                                @endguest
                                <li class="{{request()->is('contact') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="#"  onclick="showContactUsForm()"> Contact</a></li>
                                @auth
                                 @if (auth()->user()->hasRole('admin'))
                                <li class="{{Route::is('admin.dashboard')  ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                @endif
                                @endauth
                                @auth
                                 @if (auth()->user()->hasRole('sub-admin'))
                                <li class="{{Route::is('sub.dashboard')  ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('sub.dashboard') }}">Dashboard</a></li>
                                @endif
                                @endauth
                                @auth
                                 @if (auth()->user()->hasRole('user'))
                                <li class="{{Route::is('user.dashboard')  ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
                                @endif
                                @endauth
                            </ul>
                        </nav>
                        {{-- main navigation desktop mobile--}}
                        <nav class="sm:hidden ms-auto">
                            <button id="buttonOffvcanvas" class="p-2 drop-shadow-lg rounded-lg hover:bg-[#1B651B] group">
                                <svg class="w-6 h-6 fill-black group-hover:fill-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M4 5C3.44772 5 3 5.44772 3 6C3 6.55228 3.44772 7 4 7H20C20.5523 7 21 6.55228 21 6C21 5.44772 20.5523 5 20 5H4ZM7 12C7 11.4477 7.44772 11 8 11H20C20.5523 11 21 11.4477 21 12C21 12.5523 20.5523 13 20 13H8C7.44772 13 7 12.5523 7 12ZM13 18C13 17.4477 13.4477 17 14 17H20C20.5523 17 21 17.4477 21 18C21 18.5523 20.5523 19 20 19H14C13.4477 19 13 18.5523 13 18Z"></path> </g></svg>
                            </button>
                        </nav>
                    </header>
                    <main class="h-screen w-full grid grid-cols-1 place-items-center justify-center items-center overflow-y-auto">
                        <section class="w-[100%] h-[100vh] flex  justify-center items-center bg-white flex-col relative">
                            <img src="{{asset('img/layered-peaks-haikei.svg')}}" alt="" class="absolute w-full h-full object-cover rounded-lg drop-shadow-lg">
                            <div class="w-[90%] h-full flex flex-col justify-start sm:mt-[15%] mt-[50%] items-center gap-2 absolute">
                                <p class="sm:text-4xl text-2xl font-semibold text-[#1B651B] w-[80%] drop-shadow-lg text-center">
                                    Research Information System for Cavite State University Trece Martires City Campus
                                </p>
                                <p class="text-slate-500 font-thin text-sm sm:text-lg w-[60%] text-center">
                                A streamlined platform for submitting research manuscripts and reports at Cavite State University Trece Martires City Campus.
                                </p>


                                @guest
                                 <a href="/register" class="mt-5 drop-shadow-xl sm:py-3 sm:px-5 py-2 px-3 rounded-lg hover:bg-[#2b912b] bg-[#1B651B] text-white hover:text-sm text-lg traking-wide group hover:text-start transition-all delay-150 flex items-center gap-2">
                                    Get started

                                    <svg class="drop-shadow-lg sm:w-8 sm:h-8 w-4 h-4 hidden group-hover:block transition-all group-hover:forwarder animate-forwarder" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                 </a>
                                 @endguest
                                 @auth
                                 @if (auth()->user()->hasRole('admin'))
                                 <a href="{{ route('admin.dashboard') }}" class="mt-5 drop-shadow-xl sm:py-3 sm:px-5 py-2 px-3 rounded-lg hover:bg-[#2b912b] bg-[#1B651B] text-white hover:text-sm text-lg traking-wide group hover:text-start transition-all delay-150 flex items-center gap-2">
                                   Dashboard

                                    <svg class="drop-shadow-lg sm:w-8 sm:h-8 w-4 h-4 hidden group-hover:block transition-all group-hover:forwarder animate-forwarder" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                 </a>
                                @endif
                                @endauth
                                @auth
                                 @if (auth()->user()->hasRole('sub-admin'))
                                 <a href="{{ route('sub.dashboard') }}" class="mt-5 drop-shadow-xl sm:py-3 sm:px-5 py-2 px-3 rounded-lg hover:bg-[#2b912b] bg-[#1B651B] text-white hover:text-sm text-lg traking-wide group hover:text-start transition-all delay-150 flex items-center gap-2">
                                   Dashboard

                                    <svg class="drop-shadow-lg sm:w-8 sm:h-8 w-4 h-4 hidden group-hover:block transition-all group-hover:forwarder animate-forwarder" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                 </a>
                                @endif @endauth
                                 @auth
                                 @if (auth()->user()->hasRole('user'))
                                 <a href="{{ route('user.dashboard') }}" class="mt-5 drop-shadow-xl sm:py-3 sm:px-5 py-2 px-3 rounded-lg hover:bg-[#2b912b] bg-[#1B651B] text-white hover:text-sm text-lg traking-wide group hover:text-start transition-all delay-150 flex items-center gap-2">
                                   Dashboard

                                    <svg class="drop-shadow-lg sm:w-8 sm:h-8 w-4 h-4 hidden group-hover:block transition-all group-hover:forwarder animate-forwarder" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M6 12H18M18 12L13 7M18 12L13 17" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                 </a>
                                @endif @endauth
                            </div>
                             
                        </section>
                        <footer class="flex flex-col justify-between w-full items-center sm:text-base text-sm  text-white drop-shadow-lg">
                            <div class="grid sm:grid-cols-3 grid-cols-1 justify-between w-full p-3 sm:place-items-center place-items-start bg-[#303440]">
                                <div class=" rounded-lg p-3 flex flex-col justify-start items-start text-center">
                                    <img src="https://trece.cvsu.edu.ph/logo.png" class="size-[10rem] object-contain" alt="">
                                </div>
                                <div class="rounded-lg p-3 h-full text-start">
                                    <h2 class="mb-5 text-xl">Other links</h2>
                                    <ul class="text-sm">
                                        <li class="underline decoration-green-500 underline-offset-2 flex gap-5">
                                            <svg class="h-[1rem] w-[1rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M9.83824 18.4467C10.0103 18.7692 10.1826 19.0598 10.3473 19.3173C8.59745 18.9238 7.07906 17.9187 6.02838 16.5383C6.72181 16.1478 7.60995 15.743 8.67766 15.4468C8.98112 16.637 9.40924 17.6423 9.83824 18.4467ZM11.1618 17.7408C10.7891 17.0421 10.4156 16.1695 10.1465 15.1356C10.7258 15.0496 11.3442 15 12.0001 15C12.6559 15 13.2743 15.0496 13.8535 15.1355C13.5844 16.1695 13.2109 17.0421 12.8382 17.7408C12.5394 18.3011 12.2417 18.7484 12 19.0757C11.7583 18.7484 11.4606 18.3011 11.1618 17.7408ZM9.75 12C9.75 12.5841 9.7893 13.1385 9.8586 13.6619C10.5269 13.5594 11.2414 13.5 12.0001 13.5C12.7587 13.5 13.4732 13.5593 14.1414 13.6619C14.2107 13.1384 14.25 12.5841 14.25 12C14.25 11.4159 14.2107 10.8616 14.1414 10.3381C13.4732 10.4406 12.7587 10.5 12.0001 10.5C11.2414 10.5 10.5269 10.4406 9.8586 10.3381C9.7893 10.8615 9.75 11.4159 9.75 12ZM8.38688 10.0288C8.29977 10.6478 8.25 11.3054 8.25 12C8.25 12.6946 8.29977 13.3522 8.38688 13.9712C7.11338 14.3131 6.05882 14.7952 5.24324 15.2591C4.76698 14.2736 4.5 13.168 4.5 12C4.5 10.832 4.76698 9.72644 5.24323 8.74088C6.05872 9.20472 7.1133 9.68686 8.38688 10.0288ZM10.1465 8.86445C10.7258 8.95042 11.3442 9 12.0001 9C12.6559 9 13.2743 8.95043 13.8535 8.86447C13.5844 7.83055 13.2109 6.95793 12.8382 6.2592C12.5394 5.69894 12.2417 5.25156 12 4.92432C11.7583 5.25156 11.4606 5.69894 11.1618 6.25918C10.7891 6.95791 10.4156 7.83053 10.1465 8.86445ZM15.6131 10.0289C15.7002 10.6479 15.75 11.3055 15.75 12C15.75 12.6946 15.7002 13.3521 15.6131 13.9711C16.8866 14.3131 17.9412 14.7952 18.7568 15.2591C19.233 14.2735 19.5 13.1679 19.5 12C19.5 10.8321 19.233 9.72647 18.7568 8.74093C17.9413 9.20477 16.8867 9.6869 15.6131 10.0289ZM17.9716 7.46178C17.2781 7.85231 16.39 8.25705 15.3224 8.55328C15.0189 7.36304 14.5908 6.35769 14.1618 5.55332C13.9897 5.23077 13.8174 4.94025 13.6527 4.6827C15.4026 5.07623 16.921 6.08136 17.9716 7.46178ZM8.67765 8.55325C7.61001 8.25701 6.7219 7.85227 6.02839 7.46173C7.07906 6.08134 8.59745 5.07623 10.3472 4.6827C10.1826 4.94025 10.0103 5.23076 9.83823 5.5533C9.40924 6.35767 8.98112 7.36301 8.67765 8.55325ZM15.3224 15.4467C15.0189 16.637 14.5908 17.6423 14.1618 18.4467C13.9897 18.7692 13.8174 19.0598 13.6527 19.3173C15.4026 18.9238 16.921 17.9186 17.9717 16.5382C17.2782 16.1477 16.3901 15.743 15.3224 15.4467ZM12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21Z" fill="#ffffff"></path> </g></svg>
                                            <a href="https://trece.cvsu.edu.ph/">trece.cvsu.edu.ph</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class=" rounded-lg p-3 h-full text-startr">
                                    <h2 class="mb-5 text-xl">Contact us</h2>
                                    <ul class="text-sm flex flex-col gap-5">
                                        <li class="flex gap-5">
                                            <svg class="w-[1rem] h-[1rem]" fill="#ffffff" viewBox="0 0 16 16" id="telephone-16px" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path id="Path_27" data-name="Path 27" d="M35.5,16A15.517,15.517,0,0,1,20,.5a.5.5,0,0,1,.5-.5h2.845a1.849,1.849,0,0,1,1.317.546l1.962,1.961a1.5,1.5,0,0,1,0,2.122L25.2,6.048A11.907,11.907,0,0,0,29.952,10.8l1.419-1.42a1.5,1.5,0,0,1,2.121,0l1.962,1.962A1.852,1.852,0,0,1,36,12.656V15.5A.5.5,0,0,1,35.5,16ZM21.009,1A14.52,14.52,0,0,0,35,14.992V12.656a.859.859,0,0,0-.253-.611l-1.962-1.962a.5.5,0,0,0-.707,0L30.4,11.763a.5.5,0,0,1-.578.093A12.893,12.893,0,0,1,24.145,6.18a.5.5,0,0,1,.092-.579l1.68-1.679a.5.5,0,0,0,0-.708L23.955,1.253A.858.858,0,0,0,23.345,1Z" transform="translate(-20)"></path> </g></svg>
                                            <p>09xxxxxxx</p>
                                        </li>
                                        <li class="flex gap-5">
                                            <svg class="w-[1rem] h-[1rem]" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg" stroke="white"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M12 21C15.5 17.4 19 14.1764 19 10.2C19 6.22355 15.866 3 12 3C8.13401 3 5 6.22355 5 10.2C5 14.1764 8.5 17.4 12 21Z" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M12 12C13.1046 12 14 11.1046 14 10C14 8.89543 13.1046 8 12 8C10.8954 8 10 8.89543 10 10C10 11.1046 10.8954 12 12 12Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                                            <p  class="break-all w-1/2">Brgy. Gregorio, Trece Martires City, Cavite 4109</p>
                                        </li>
                                        <li class="flex gap-5">
                                            <svg class="w-[1rem] h-[1rem]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#ffffff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M3.75 5.25L3 6V18L3.75 18.75H20.25L21 18V6L20.25 5.25H3.75ZM4.5 7.6955V17.25H19.5V7.69525L11.9999 14.5136L4.5 7.6955ZM18.3099 6.75H5.68986L11.9999 12.4864L18.3099 6.75Z" fill="#ffffff"></path> </g></svg>
                                            <p  class="break-all w-1/2">Admin@cvsu.edu.ph</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="flex w-full items-center bg-[#2b2f3a]">
                                 <div class=" me-auto rounded-lg p-3 text-center text-[.80rem]"> 2024 &copy; <a href="/" class=" text-center   "> Research Information System for Cavite State University-Trece Martires City Campus</a></div>
                                 <div class="flex justify-end ms-auto p-3 gap-4">
                                    <a href="">
                                        <svg class="w-[2rem] h-[2rem]" fill="#5a7ce2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" stroke="#5a7ce2"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M22,3V21a1,1,0,0,1-1,1H15.8V14.255h2.6l.39-3.018H15.8V9.309c0-.874.242-1.469,1.5-1.469h1.6V5.14a21.311,21.311,0,0,0-2.329-.119A3.636,3.636,0,0,0,12.683,9.01v2.227H10.076v3.018h2.607V22H3a1,1,0,0,1-1-1V3A1,1,0,0,1,3,2H21A1,1,0,0,1,22,3Z"></path></g></svg>
                                    </a>
                                    <a href="">
                                        <svg class="w-[2rem] h-[2rem]" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path style="fill:#E6F3FF;" d="M512,105.739v300.522c0,27.715-22.372,50.087-50.087,50.087H50.087 C22.372,456.348,0,433.976,0,406.261V105.739c0-0.89,0-1.781,0.111-2.671c1.336-25.6,21.704-45.969,47.304-47.304 c0.89-0.111,1.781-0.111,2.671-0.111h411.826c0.89,0,1.892,0,2.783,0.111c25.489,1.336,45.857,21.704,47.193,47.193 C512,103.847,512,104.849,512,105.739z"></path> <path style="fill:#CFDBE6;" d="M464.696,55.763c-0.892-0.111-1.891-0.111-2.783-0.111H256v400.696h205.913 c27.715,0,50.087-22.372,50.087-50.087V105.739c0-0.89,0-1.892-0.111-2.783C510.553,77.468,490.184,57.099,464.696,55.763z"></path> <path style="fill:#FF4B26;" d="M511.889,102.957c-1.336-25.489-21.704-45.857-47.193-47.193 C382.89,137.569,336.951,183.509,256,264.459C225.291,233.732,77.61,85.958,47.416,55.763c-25.6,1.336-45.969,21.704-47.304,47.304 C0,103.958,0,104.849,0,105.739v300.522c0,27.715,22.372,50.087,50.087,50.087h16.696V169.739l165.621,165.51 c6.456,6.567,15.026,9.795,23.597,9.795c8.57,0,17.141-3.228,23.597-9.795l165.621-165.621v286.72h16.696 c27.715,0,50.087-22.372,50.087-50.087V105.739C512,104.849,512,103.847,511.889,102.957z"></path> <path style="fill:#D93F21;" d="M279.596,335.249l165.621-165.621v286.72h16.696c27.715,0,50.087-22.372,50.087-50.087V105.739 c0-0.89,0-1.892-0.111-2.783c-1.336-25.489-21.704-45.857-47.193-47.193C382.891,137.569,336.951,183.509,256,264.459v80.584 C264.57,345.043,273.141,341.816,279.596,335.249z"></path> </g></svg>
                                    </a>
                                 </div>
                            </div>
                           
                        </footer>
                    </main>
                  
                </div>
                 
            </div>
            
        </div>
         <script src="{{ asset('custom/offcanvas.js')}}"></script>
         <script src="{{ asset('custom/backend.js')}}" defer></script>
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>
