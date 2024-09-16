<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-screen flex flex-col justify-start items-center overflow hoverflow-hidden font-Figtree">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>401 - Forbidden</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        {{-- x icon --}}
        <link  rel="shortcut icon" href="{{asset('sys_logo/favicon.ico')}}"type="image/x-icon">
       
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
         <script src="https://cdn.tailwindcss.com"></script>
        
    </head>
    <body class="h-screen w-full flex flex-col justify-start items-center overflow-hidden bg-[#f3f3f3] antialiased ">
         {{-- PRELOADER
         @include('preloader')    --}}
        {{-- offcanvas section --}}
        <section id="offcanvas" class="sm:hidden fixed top-0 overflow-hidden z-30 h-full flex justify-end items-start transition-all">
            <div class="absolute bg-white w-1/2 h-full z-30 flex flex-col">
                <span id="offcanvasClose" class="p-4 text-lg ms-2 cursor-pointer hover:opacity-45">&#10006;</span>
                <ul class="flex flex-col space-y-6 text-md ms-5 text-sm">
                    <li class="{{request()->is('/') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}">Home</li>
                                @guest
                    <li class="{{request()->is('login') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('login') }}">Login</a></li>
                    <li class="{{request()->is('register') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('register') }}"></a>Sign up</li>
                                @endguest
                    <li onclick="showContactUsForm()" class="{{request()->is('contact') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}">Contact</li>
                                @auth
                    <li class="{{ Route::is('admin.dashboard') ? 'underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all':'hover:underline decoration-[#1B651B] decoration-2 underline-offset-4 py-2 px-3 text-slate-700 hover:text-[#1B651B] rounded-md transition-all'}}"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                @endauth
                </ul>
            </div>
            <div id="offcanvasClose" class="absolute w-full h-full bg-black opacity-20"></div>
        </section>
           <!-- component -->
<main class="h-screen w-full flex flex-col justify-center items-center bg-[#1A2238]">
	<h1 class="text-9xl font-extrabold text-white tracking-widest">401</h1>
	<div class="bg-[#FF6A3D] px-2 text-sm rounded rotate-12 absolute">
		Forbidden
	</div>
	<button class="mt-5">
      <a  href="/"
        class="relative inline-block text-sm font-medium text-[#FF6A3D] group active:text-orange-500 focus:outline-none focus:ring"
      >
        <span
          class="absolute inset-0 transition-transform translate-x-0.5 translate-y-0.5 bg-[#1b651b] group-hover:translate-y-0 group-hover:translate-x-0"
        ></span>

        <span class="relative block px-8 py-3 bg-[#1A2238] border border-current">
          <router-link to="/">Go Home</router-link>
        </span>
      </a>
    </button>
</main>
         <script src="{{ asset('custom/offcanvas.js')}}"></script>
         <script src="{{ asset('custom/backend.js')}}" defer></script>
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </body>
</html>


