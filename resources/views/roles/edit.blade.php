<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            Edit Role
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">

                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Role -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">
                            Nama Role
                        </label>
                        <input 
                        type="text" 
                        name="name" 
                        value="{{ $role->name }}" 
                        class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-blue-200"
                        required
                        >
                        @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Update Button -->
                    <div class="mt-6">
                        <button 
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Update
                    </button>

                    <a href="{{ route('roles.index') }}" 
                    class="ml-2 text-gray-600 hover:underline">
                    Batal
                </a>
            </div>

        </form>

    </div>

</div>
</div>
</x-app-layout>
