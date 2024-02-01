<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Edit User') }}
                            </h2>
                    
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Edit Sistem User.") }}
                            </p>
                        </header>
                    
                        <form method="post" action="{{ route('kelolauser.update',['id' => $user->id]) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('patch')
                    
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" :value="$user->name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                    
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" :value="$user->email" type="email" class="mt-1 block w-full" required autocomplete="username" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div>
                                <x-input-label for="Password" :value="__('Password')" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                            </div>
                    
                            <div>
                                <x-input-label for="role" :value="__('Role')" />
                                <select name="role" class="mt-1 block w-full rounded-md">
                                    <option value="1" {{ $user->role == 1 ? 'selected' : '' }}>Penjual</option>
                                    <option value="2" {{ $user->role == 2 ? 'selected' : '' }}>Gudang</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>
                    
                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                    
                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="text-sm text-gray-600 dark:text-gray-400"
                                    >{{ __('Saved.') }}</p>
                                @endif
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>