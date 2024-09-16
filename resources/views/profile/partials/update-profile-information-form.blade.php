<section>
    <header>
    <h2 class="text-2xl font-bold m-3 uppercase  text-[#1B651B]">Profile Information</h2>
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>
    <form method="post" enctype="multipart/form-data" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div class="profile-container">
            @if(Auth::user()->userinfos && Auth::user()->userinfos->profile_pic)
                <img src="{{ asset(Auth::user()->userinfos->profile_pic) }}" alt="Profile Picture" class="profile-img">
            @else
                <img src="{{ asset('default-profile-pic.png') }}" alt="Default Profile Picture" class="profile-img">
            @endif
        
            <label for="profile_pic" class="upload-overlay">
                <span class="plus-symbol">+</span>
                <x-input-label for="profile_pic" :value="__('Upload Profile Photo')" />
                <x-text-input id="profile_pic" name="profile_pic" type="file" class="upload-input" autocomplete="profile_pic" />
            </label>
        </div>
        
        <x-input-error class="mt-2" :messages="$errors->get('profile_pic')" /> 
        <div>
            <x-input-label for="fname" :value="__('First Name')" />
            <x-text-input id="fname" name="fname" type="text" class="mt-1 block w-full" :value="old('fname', $user->fname)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div><div>
            <x-input-label for="middlename" :value="__('Middle Name')" />
            <x-text-input id="middlename" name="middlename" type="text" class="mt-1 block w-full" :value="old('name', $user->middlename)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
            <x-input-label for="lname" :value="__('Last Name')" />
            <x-text-input id="lname" name="lname" type="text" class="mt-1 block w-full" :value="old('name', $user->lname)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>
        <div>
        <x-input-label for="sex" :value="__('Sex')" />
        <select id="sex" name="sex" class="mt-1 block w-full" required autofocus autocomplete="sex">
            <option value="Male" {{ old('sex', $user->sex) === 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('sex', $user->sex) === 'Female' ? 'selected' : '' }}>Female</option>
        </select>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button type="submit">{{ __('Save Changes') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600"
                >{{ __('Saved Successfully.') }}</p>
            @endif
        </div>
    </form>
</section>
