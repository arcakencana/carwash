<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            Edit User
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto">
        <div class="bg-white p-6 rounded shadow">
         <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Nama --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Password --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Password (Opsional)</label>
                <input type="password" name="password"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                <p class="text-gray-500 text-sm mt-1">Kosongkan jika tidak ingin mengubah password.</p>
            </div>

            {{-- Konfirmasi Password --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            {{-- Role --}}
            <div>
                <label class="block text-gray-700 font-medium mb-1">Role</label>
                <select name="role" 
                class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                @foreach ($roles as $id => $name)
                <option value="{{ $name }}" {{ $userRole == $id ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('users.index') }}" 
            class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">Batal</a>
            <button type="submit" 
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Update</button>
        </div>

    </form>
</div>
</div>
</x-app-layout>
