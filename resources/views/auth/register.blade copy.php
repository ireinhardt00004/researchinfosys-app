<x-guest-layout>
    <div class="w-full h-full flex">
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
        @csrf
        <div class="w-full  items-center flex flex-auto justify-center">
            <h2 class=" text-2xl font-bold">Sign Up</h2>
        </div>
        <!-- Student Number -->
        <div>
            <x-input-label for="studnum" :value="__('Student Number')" />
            <x-text-input id="studnum" class="block mt-1 w-full" type="text" name="studnum" :value="old('studnum')" required autofocus autocomplete="studnum" />
            <x-input-error :messages="$errors->get('studnum')" class="mt-2" />
        </div>
        <!-- Last Name -->
        <div>
            <x-input-label for="lname" :value="__('Last Name')" />
            <x-text-input id="lname" class="block mt-1 w-full" type="text" name="lname" :value="old('lname')" required autofocus autocomplete="lname" />
            <x-input-error :messages="$errors->get('lname')" class="mt-2" />
        </div>
        <!-- Middle Name -->
        <div>
            <x-input-label for="middlename" :value="__('Middle Name')" />
            <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename" :value="old('middlename')" required autofocus autocomplete="middlename" />
            <x-input-error :messages="$errors->get('middlename')" class="mt-2" />
        </div>
        <!-- First Name -->
        <div>
            <x-input-label for="fname" :value="__('First Name')" />
            <x-text-input id="fname" class="block mt-1 w-full" type="text" name="fname" :value="old('fname')" required autofocus autocomplete="fname" />
            <x-input-error :messages="$errors->get('fname')" class="mt-2" />
        </div>
        <!-- Course -->
        <div class="mt-4">
            <x-input-label for="courseID" :value="__('Name of Course')" />
            <select id="courseID" name="courseID" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option disabled selected>Choose course</option>
                <option value="BSIT">Bachelor of Science in Information Technology</option>
                <option value="BSBA">Bachelor of Science in Business Administration</option>
                <option value="BSHM">Bachelor of Science in Hospitality Management</option>
                <option value="BSP">Bachelor of Science in Psychology</option>
            </select>
        </div>
        <!-- Sex -->
        <div class="mt-4">
            <x-input-label for="sex" :value="__('Sex')" />
            <select id="sex" name="sex" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option disabled selected>Please select</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('CvSU Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <!-- Profile Picture -->
        <div class="mt-4">
            <x-input-label for="profile_pic" :value="__('Profile Picture')" />
            <input id="profile_pic" class="block mt-1 w-full" type="file" name="profile_pic" accept="image/*" />
            <x-input-error :messages="$errors->get('profile_pic')" class="mt-2" />
        </div>
        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    </div>
    
    @section('title', 'Register Account')
</x-guest-layout>