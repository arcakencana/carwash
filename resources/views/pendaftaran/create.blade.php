<x-guest-layout>

    <div class="py-6 max-w-3xl mx-auto">

        <div class="bg-white p-6 rounded shadow">

            <div class="flex flex-col items-center mb-6">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
                    <span class="text-4xl font-bold text-gray-800 dark:text-gray-900">SITEBUS MURAH</span>
                </div>
                <p class="text-1xl text-gray-600 mt-1">Dinas Perindustrian dan Perdagangan Kota Batam</p>
            </div>

            @if($kegiatan->banner)
            <img src="{{ asset('storage/'.$kegiatan->banner) }}" alt="{{ $kegiatan->nama_kegiatan }}" class="w-full object-cover">
            @endif

            <div class="p-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $kegiatan->nama_kegiatan }}</h2>

                <p class="text-gray-600 text-md mb-3">
                    {{ $kegiatan->deskripsi }}
                </p>

                <p class="text-gray-500 text-sm">
                    <strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y, H:i') }}
                </p>

                <p class="text-gray-500 text-sm">
                    <strong>Kuota :</strong> {{ $kegiatan->kuota_peserta }}
                </p>
            </div>

            <hr>

            <div class="p-4 mt-4">

                <h2 class="text-4xl items-center font-semibold text-gray-800 mb-4">Pendaftaran</h2>

                <form action="{{ route('pendaftaran.store', encrypt($kegiatan->id)) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label class="block font-semibold">Nomor Kartu Keluarga</label>
                        <input type="text" name="kk" class="w-full border rounded p-2 only-number-16" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Nomor KTP</label>
                        <input type="text" name="ktp" class="w-full border rounded p-2 only-number-16" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Nama lengkap</label>
                        <input type="text" name="nama" class="w-full border rounded p-2 only-uppercase" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Nomor Whatsapp</label>
                        <input type="text" name="wa" class="w-full border rounded p-2 only-number" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Pilih Kecamatan</label>
                        <select class="w-full border rounded p-2">
                            @foreach($kecamatan as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">Berkas</label>
                        <input type="file" name="berkas" class="w-full border rounded p-2">
                    </div>

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                </form>
            </div>

        </div>
    </div>

</x-guest-layout>
