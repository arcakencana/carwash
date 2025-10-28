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
        <table class="w-full rounded-lg">
            <thead>
                <tr>
                    <th class="py-2">Nama Kegiatan</th>
                    <th>Tanggal</th>
                    <th>Kuota</th>
                    <th>Banner</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kegiatans as $kegiatan)
                <tr class="border-t">
                    <td class="py-2">{{ $kegiatan->nama_kegiatan }}</td>
                    <td>
                        {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y, H:i') }}
                    </td>
                    <td>{{ $kegiatan->kuota_peserta }}</td>
                    <td>
                        @if ($kegiatan->banner)
                        <img src="{{ asset('storage/'.$kegiatan->banner) }}" alt="" class="w-24 rounded">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="text-blue-600">Edit</a> |
                        <form action="{{ route('kegiatan.destroy', $kegiatan) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Yakin hapus kegiatan ini?')" class="text-red-600">Hapus</button>
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
