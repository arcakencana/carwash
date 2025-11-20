<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            Edit Permission
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded p-6">

                <form action="{{ route('permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1 text-sm font-medium text-gray-700">Nama Permission</label>
                        <input 
                            type="text" 
                            name="name"
                            value="{{ $permission->name }}"
                            required
                            class="border rounded w-full p-2 focus:outline-none focus:ring focus:ring-blue-200"
                        >
                    </div>

                    <button 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Update
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
