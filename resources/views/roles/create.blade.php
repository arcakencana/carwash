<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            Tambah Role
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded p-6">
                
                <form action="{{ route('roles.store') }}" method="POST">
                    @csrf

                    <!-- Nama Role -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">
                            Nama Role
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            class="w-full border rounded p-2 focus:outline-none focus:ring focus:ring-blue-200"
                            placeholder="Contoh: admin, staff, operator"
                            required
                        >
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Simpan -->
                    <div class="mt-6">
                        <button 
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                            Simpan
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
