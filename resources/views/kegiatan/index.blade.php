<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Daftar Kegiatan
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

          {{-- Bar atas: Tombol Tambah + Pencarian --}}
          <div class="flex justify-between items-center mb-4">
            {{-- Tombol tambah di kiri --}}
            <a href="{{ route('kegiatan.create') }}" 
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            + Tambah Kegiatan
        </a>

        {{-- Pencarian di kanan --}}
        <form method="GET" action="{{ route('kegiatan.index') }}" class="flex items-center space-x-2">
            <input 
            type="text" 
            name="search" 
            placeholder="Cari kegiatan..." 
            value="{{ $search }}" 
            class="border rounded p-2 w-64 focus:outline-none focus:ring focus:ring-blue-200"
            >
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Cari
            </button>
        </form>
    </div>

    <div class="mt-6 bg-white shadow rounded p-4">
        <table class="w-full border border-gray-200 shadow-sm overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="py-3 px-4 text-left">Nama Kegiatan</th>
                    <th class="py-3 px-4 text-left w-1/3">Deskripsi</th>
                    <th class="py-3 px-4 text-left">Tanggal</th>
                    <th class="py-3 px-4 text-center">Kuota</th>
                    <th class="py-3 px-4 text-center">Banner</th>
                    <th class="py-2 px-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kegiatans as $kegiatan)
                <tr class="border-t hover:bg-gray-50 transition">
                    <td class="py-2 px-4 font-medium text-gray-800">
                        {{ $kegiatan->nama_kegiatan }}
                    </td>
                    <td class="py-2 px-4 text-gray-600 max-w-xs truncate" title="{{ $kegiatan->deskripsi }}">
                        {{ $kegiatan->deskripsi }}
                    </td>
                    <td class="py-2 px-4 text-gray-600">
                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y, H:i') }}
                    </td>
                    <td class="py-2 px-4 text-center text-gray-600">
                        {{ $kegiatan->kuota_peserta }}
                    </td>
                    <td class="py-2 px-4 text-center">
                        @if ($kegiatan->banner)
                        <img src="{{ asset('storage/'.$kegiatan->banner) }}" alt="" class="w-20 h-12 object-cover rounded">
                        @else
                        <span class="text-gray-400 italic text-xs">Tidak ada</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 text-center">
                        <a href="{{ route('kegiatan.pdf', encrypt($kegiatan->id)) }}" class="text-blue-600 hover:underline" target="_blank">pdf</a>
                        <span class="text-gray-400">|</span>
                        <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="text-blue-600 hover:underline">Edit</a>
                        <span class="text-gray-400">|</span>
                        <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin hapus kegiatan ini?')" class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>


        <div class="mt-4">
            {{ $kegiatans->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
</div>
</x-app-layout>
