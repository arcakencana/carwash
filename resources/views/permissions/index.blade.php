<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
            Manajemen Permission
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <a href="{{ route('permissions.create') }}" 
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition text-center sm:text-left w-full sm:w-auto">
                + Tambah Permission
            </a>

            <form method="GET" action="{{ route('permissions.index') }}" 
            class="flex flex-col sm:flex-row sm:items-center gap-2 w-full sm:w-auto">
            <input 
            type="text" 
            name="search" 
            placeholder="Cari Permission..." 
            value="{{ $search ?? '' }}" 
            class="border rounded p-2 w-full sm:w-64 focus:outline-none focus:ring focus:ring-blue-200">
            <button type="submit" 
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Cari
        </button>
    </form>
</div>

<div class="mt-6 bg-white shadow rounded p-4">
    <div class="overflow-x-auto">
        <table class="w-full border border-gray-200 rounded-lg shadow-sm text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-2 px-4 text-left">Nama Permission</th>
                    <th class="py-2 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                <tr class="border-t hover:bg-gray-50">
                    <td class="py-2 px-4">{{ $permission->name }}</td>

                    <td class="py-2 px-4 text-center">
                        <a href="{{ route('permissions.edit', $permission) }}" 
                        class="text-blue-600 hover:underline">
                        Edit
                    </a>

                    <form action="{{ route('permissions.destroy', $permission) }}" 
                    method="POST" 
                    class="inline">
                    @csrf @method('DELETE')
                    <button class="text-red-600 hover:underline"
                    onclick="return confirm('Hapus permission ini?')">
                    Hapus
                </button>
            </form>
        </td>

    </tr>
    @endforeach
</tbody>
</table>
</div>

</div>

</div>
</div>
</x-app-layout>
