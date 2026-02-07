<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pengeluaran Harian
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Tombol tambah pengeluaran -->
            <div class="mb-4 flex flex-col sm:flex-row sm:justify-end gap-2">
                <a href="{{ route('pengeluaran.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 transition-colors text-center">
                + Pengeluaran Baru
            </a>
        </div>

        <!-- Tabel -->
        <div class="bg-white shadow rounded p-4 overflow-x-auto">
            <table class="w-full min-w-[700px] border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 text-left">Tanggal</th>
                        <th class="p-2 text-left">Keterangan</th>
                        <th class="p-2 text-left">Nominal</th>
                        <th class="p-2 text-left">User</th>
                        <th class="p-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($data as $row)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="p-2 font-semibold">
                            {{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}
                        </td>
                        <td class="p-2">
                            {{ $row->keterangan }}
                        </td>
                        <td class="p-2 text-left font-semibold text-red-600">
                            Rp {{ number_format($row->nominal,0,',','.') }}
                        </td>
                        <td class="p-2">
                            {{ $row->user->name ?? '-' }}
                        </td>
                        <td class="p-2">
                            <a href="{{ route('pengeluaran.edit', $row->id) }}"
                                class="text-blue-600 hover:underline">
                                Edit
                            </a>

                            <span class="text-gray-400 mx-1">|</span>

                            <form action="{{ route('pengeluaran.destroy', $row->id) }}"
                                method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                onclick="return confirm('Yakin hapus pengeluaran ini?')"
                                class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">
                        Belum ada pengeluaran hari ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Total -->
        <div class="flex justify-end mt-4">
            <div class="text-right font-bold text-lg">
                Total Pengeluaran :
                <span class="text-red-600">
                    Rp {{ number_format($total,0,',','.') }}
                </span>
            </div>
        </div>

    </div>

</div>
</div>
</x-app-layout>
