<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User:' . $register->name) }}
        </h2>
    </x-slot>
    <section class="mt-3 max-w-7xl mx-auto sm:px-6 lg:px-8 dark:bg-gray-800 rounded-lg py-8 my-10">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Form Information') }}
            </h2>
        </header>
        <form class="mt-6 space-y-6" method="POST" action="{{ route('admin.update-user', $register->id) }}">
            @csrf
            @method('PATCH')
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value=" $register->name "
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="$register->email "
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
        </form>
    </section>
</x-app-layout>
