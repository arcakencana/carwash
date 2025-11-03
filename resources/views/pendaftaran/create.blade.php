<x-guest-layout>

    <div class="relative min-h-screen bg-cover bg-center bg-fixed"
    style="background-image: url('{{ asset('images/background.png') }}');
        background-position: center top 0px;
        background-size: contain;">

        <!-- Overlay transparan -->
        <div class="absolute inset-0 bg-black bg-opacity-20"></div>

        <!-- Konten utama -->
        <div class="relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-2">

            <!-- Kartu utama -->
            <div class="w-full sm:max-w-xl mt-5 mb-8 px-4 py-6 bg-white bg-opacity-80 shadow-lg overflow-hidden sm:rounded-lg backdrop-blur-sm">

             <!-- Header -->
             <div class="flex flex-col items-center mb-4">
                <div class="flex items-center space-x-3 mt-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                    <span class="text-3xl font-bold text-gray-800 dark:text-gray-900">SITEBUS MURAH</span>
                </div>
                <p class="text-gray-700 dark:text-gray-800 text-sm mt-1">
                    Dinas Perindustrian dan Perdagangan Kota Batam
                </p>
            </div>

            <!-- Banner -->
            @if($kegiatan->banner)
            <img src="{{ asset('storage/'.$kegiatan->banner) }}"
            alt="{{ $kegiatan->nama_kegiatan }}"
            class="w-full h-60 object-cover rounded-lg shadow mb-6 p-1">
            @endif

            <!-- Detail Kegiatan -->
            <div class="mb-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-3">
                    {{ $kegiatan->nama_kegiatan }}
                </h2>
                <p class="text-gray-600 text-sm mb-4 text-justify">
                    {{ $kegiatan->deskripsi }}
                </p>
                <p class="text-gray-500 text-sm"><strong>Tanggal :</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y, H:i') }}</p>
                <p class="text-gray-500 text-sm"><strong>Total Kuota :</strong> {{ number_format($kegiatan->kuota_peserta) }}</p>
            </div>

            <hr class="my-6">

            <!-- Form -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Formulir Pendaftaran</h2>

                <form id="form">
                    <input type="hidden" name="kegiatan_id" id="kegiatan_id" value="{{ $kegiatan->id }}">

                    <!-- Input fields -->
                    <div class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-1">Nomor Kartu Keluarga</label>
                            <input type="text" name="kk" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-number-16" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor KTP</label>
                            <input type="text" name="ktp" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-number-16" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nama Lengkap</label>
                            <input type="text" name="nama" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-uppercase" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor Whatsapp</label>
                            <input type="number" name="whatsapp" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-number" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Alamat</label>
                            <input type="text" name="alamat" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-uppercase" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Pilih Kecamatan</label>
                            <select name="kecamatan_id" id="kecamatan_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                <option value="">-- Pilih Kecamatan --</option>
                                @foreach($kecamatan as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                            <div id="kuota-info" class="mt-2 text-sm text-gray-700"></div>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Lansia atau Disabilitas ?</label>
                            <div class="flex items-center space-x-6">
                                <!-- Pilihan TIDAK (default) -->
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="is_lansia" value="tidak" 
                                    class="text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                    <span>Tidak</span>
                                </label>
                                <!-- Pilihan YA -->
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="is_lansia" value="ya" 
                                    class="text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span>Ya</span>
                                </label>
                            </div>
                        </div>

                       {{--  <div>
                            <label class="block font-semibold mb-1">Foto Kartu Keluarga</label>
                            <input type="file" name="foto_kk" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        </div> --}}

                        <div class="flex items-start space-x-2 mt-4">
                            <input id="terms" name="terms" type="checkbox" class="mt-1 accent-blue-600">
                            <label for="terms" class="text-sm text-gray-700">
                                Saya setuju dengan <a href="#" id="openModal" class="text-blue-600 hover:underline" target="_blank">syarat & ketentuan</a>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-all duration-200 ease-in-out">
                        Simpan
                    </button>
                </div>
            </form>

            <!-- Result -->
            <div id="result" class="mt-6 text-center"></div>
        </div>
    </div>
</div>
</div>

<div id="termsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full p-6 relative">
        <h3 class="text-lg font-semibold mb-3">Syarat & Ketentuan</h3>
        <p class="text-sm text-gray-600 leading-relaxed">
            Dengan menggunakan layanan ini, Anda setuju untuk mematuhi semua ketentuan yang berlaku. 
            Data pribadi Anda akan digunakan sesuai dengan kebijakan privasi kami. 
            Dilarang menggunakan layanan ini untuk kegiatan yang melanggar hukum.
        </p>
        <button id="closeModal" class="mt-5 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Tutup
        </button>

        <!-- Tombol close di pojok -->
        <button id="closeModalIcon" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
            e.preventDefault();

            if (!$('#terms').is(':checked')) {
                $('#result').html('<div class="p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert"><svg class="inline w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8 3a1 1 0 001-1V9a1 1 0 10-2 0v3a1 1 0 001 1zm0 2a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"></path></svg><span class="font-semibold">Gagal!</span> Silakan centang "Syarat & Ketentuan" terlebih dahulu!</div>');
                return;
            }

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('pendaftaran.store', encrypt($kegiatan->id)) }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function() {
                    $('#result').html('<div class="alert alert-info">Mengirim Data...</div>');
                },
                success: function(res) {
                    if (res.success) {

                        if (res.data === null) {

                            $('#result').html(`
                            <div class="p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
                                <svg class="inline w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8 3a1 1 0 001-1V9a1 1 0 10-2 0v3a1 1 0 001 1zm0 2a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">Gagal!</span> ${res.message}
                            </div>
                            `);

                        } else {

                            const d = res.data;

                            $('#result').html(`
                            <div class="p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50" role="alert">
                                <svg class="inline w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414L8.414 15l-4.121-4.121a1 1 0 111.414-1.414L8.414 12.172l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold">Berhasil!</span> ${res.message}
                            </div>

                            <div class="card mt-3 p-3">
                                <ul class="divide-y divide-gray-200 bg-white shadow-md rounded-lg overflow-hidden">
                                    <li class="px-4 py-3 flex justify-between">
                                        <span class="font-semibold text-gray-700">Kartu Keluarga</span>
                                        <span class="text-gray-900">${d.kk}</span>
                                    </li>
                                    <li class="px-4 py-3 flex justify-between">
                                        <span class="font-semibold text-gray-700">KTP</span>
                                        <span class="text-gray-900">${d.ktp}</span>
                                    </li>
                                    <li class="px-4 py-3 flex justify-between">
                                        <span class="font-semibold text-gray-700">Nama</span>
                                        <span class="text-gray-900">${d.nama}</span>
                                    </li>
                                    <li class="px-4 py-3 flex justify-between">
                                        <span class="font-semibold text-gray-700">WhatsApp</span>
                                        <span class="text-gray-900">${d.whatsapp}</span>
                                    </li>
                                </ul>
                            </div>
                            `);
                            $('#form')[0].reset();

                        }

                    }
                },
                error: function(err) {
                    $('#result').html('<div class="p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert"><svg class="inline w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8 3a1 1 0 001-1V9a1 1 0 10-2 0v3a1 1 0 001 1zm0 2a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" clip-rule="evenodd"></path></svg><span class="font-semibold">Gagal!</span> Terjadi kesalahan!</div>');
                }
            });
});
});
</script>

<script>
    const openModal = document.getElementById('openModal');
    const closeModal = document.getElementById('closeModal');
    const closeModalIcon = document.getElementById('closeModalIcon');
    const termsModal = document.getElementById('termsModal');

    openModal.addEventListener('click', (e) => {
      e.preventDefault();
      termsModal.classList.remove('hidden');
  });

    closeModal.addEventListener('click', () => {
      termsModal.classList.add('hidden');
  });

    closeModalIcon.addEventListener('click', () => {
      termsModal.classList.add('hidden');
  });

    // Tutup modal jika klik di luar kotak
    window.addEventListener('click', (e) => {
      if (e.target === termsModal) {
        termsModal.classList.add('hidden');
    }
});

    // === Menampilkan jumlah & sisa kuota berdasarkan kecamatan & kegiatan ===
    $(document).on('change', '#kecamatan_id', function() {
        let kecamatan_id = $(this).val();
        let kegiatan_id = $('#kegiatan_id').val();

        if (!kecamatan_id) {
            $('#kuota-info').html('');
            return;
        }

        $('#kuota-info').html('<span class="text-gray-500">Memuat data kuota...</span>');

        let url = "{{ url('/get-kuota') }}/" + kegiatan_id + "/" + kecamatan_id;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(res) {
                if (res.success) {
                    const jumlahFormatted = Number(res.jumlah).toLocaleString('id-ID');
                    const sisaFormatted = Number(res.sisa).toLocaleString('id-ID');
                    let color = res.sisa > 0 ? 'text-green-700' : 'text-red-700';
                    $('#kuota-info').html(`
                    <div class="p-2 border rounded bg-gray-50 mt-2">
                        <p><strong>Jumlah Kuota:</strong> ${jumlahFormatted}</p>
                        <p class="${color}"><strong>Sisa Kuota:</strong> ${sisaFormatted}</p>
                    </div>
                    `);
                } else {
                    $('#kuota-info').html(`<span class="text-red-600">${res.message}</span>`);
                }
            },
            error: function() {
                $('#kuota-info').html('<span class="text-red-600">Gagal memuat data kuota!</span>');
            }
        });
    });

</script>
@endpush

</x-guest-layout>
