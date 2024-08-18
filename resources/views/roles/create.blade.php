<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Roles/Create') }}
            </h2>
            <a href="{{route('roles.index')}}" class="bg-slate-700 text-sm rounded-md text-white px-3 py-2">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-6 sm:px-6 lg:px-8 space-y-6">
            <div class="p-8 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Roles Information') }}
                            </h2>
                        </header>

                        <form action="{{route('roles.store')}}" method="post" class="mt-6 space-y-6">
                            @csrf

                            <div class="max-w-xl">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" :value="old('name')" placeholder="Enter name" class="mt-1 block w-full" autofocus autocomplete="name" />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div class="grid sm:grid-cols-1 md:grid-cols-3 lg:grid-cols-4">
                                @if($permissions->isNotEmpty())
                                    @foreach($permissions as $permission)
                                        <div class="mt-3 text-gray-900 dark:text-gray-100">
                                            <input type="checkbox" id="permission-{{$permission->id}}" class="rounded" name="permission[]" value="{{$permission->name}}"/>
                                            <label for="permission-{{$permission->id}}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
