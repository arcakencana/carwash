<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            Atur Role Untuk: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="bg-white dark:bg-gray-100 shadow rounded p-6">
                <form action="{{ route('users.storeAssignedRole', $user) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-2 font-semibold">Pilih Role:</label>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @foreach($roles as $role)
                            <label class="flex items-center gap-2">
                                <input type="checkbox" 
                                name="roles[]" 
                                value="{{ $role->name }}"
                                {{ $user->hasRole($role->name) ? 'checked' : '' }}>
                                <span>{{ $role->name }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
