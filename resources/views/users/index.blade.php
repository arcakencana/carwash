<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Manajemen User
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

          <div class="flex justify-between items-center mb-4">
            <a href="{{ route('users.create') }}" 
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Tambah User
        </a>

        <form method="GET" action="{{ route('users.index') }}" class="flex items-center space-x-2">
            <input 
            type="text" 
            name="search" 
            placeholder="Cari User..." 
            value="{{ $search }}" 
            class="border rounded p-2 w-64 focus:outline-none focus:ring focus:ring-blue-200"
            >
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Cari
            </button>
        </form>
    </div>

    <div class="mt-6 bg-white shadow rounded p-4">

        <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Nama</th>
                    <th class="py-2 px-4 text-left">Email</th>
                    <th class="py-2 px-4 text-left">Role</th>
                    <th class="py-2 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-2 px-4">{{ $user->name }}</td>
                    <td class="py-2 px-4">{{ $user->email }}</td>
                    <td class="py-2 px-4">
                        {{ $user->roles->pluck('name')->join(', ') ?: 'Tidak ada' }}
                    </td>
                    <td class="py-2 px-4 text-center">
                        <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline" onclick="return confirm('Hapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links('vendor.pagination.custom') }}
        </div>

    </div>

</div>
</div>
</x-app-layout>
