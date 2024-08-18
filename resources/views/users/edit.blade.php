<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users / Edit') }}
            </h2>
            <a href="{{route('users.index')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Users Information') }}
                            </h2>
                        </header>

                        <form action="{{route('users.update',$user->id)}}" method="post" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" :value="old('name',$user->name)" placeholder="Enter name" class="mt-1 block w-full" autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" :value="old('email',$user->email)" placeholder="Enter email" class="mt-1 block w-full" autofocus autocomplete="email" />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <div class="grid grid-cols-4">
                                @if($roles->isNotEmpty())
                                    @foreach($roles as $role)
                                        <div class="mt-3 text-gray-900 dark:text-gray-100">
                                            <input {{($hasRoles->contains($role->id)) ? 'checked' : ''}} type="checkbox" id="role-{{$role->id}}" class="rounded" name="role[]" value="{{$role->name}}"/>
                                            <label for="role-{{$role->id}}">{{ $role->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>



                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Update') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
