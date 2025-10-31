<x-guest-layout>

  <div class="relative min-h-screen bg-cover bg-center bg-fixed"
  style="background-image: url('{{ asset('images/background.png') }}');
    background-position: center top 0px;
    background-size: contain;">

    <!-- Overlay gelap transparan -->
    <div class="absolute inset-0 bg-black bg-opacity-40"></div>

    <!-- Konten utama -->
    <div class="relative py-10 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">

        <!-- Kartu utama -->
        <div class="bg-white/95 backdrop-blur-sm p-8 rounded-2xl shadow-lg border border-gray-200">
            
            <!-- Header -->
            <div class="flex flex-col items-center mb-8">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16 w-auto">
                    <span class="text-3xl font-extrabold text-gray-800 dark:text-gray-100 tracking-wide">
                        SITEBUS MURAH
                    </span>
                </div>
                <p class="text-gray-600 text-md mt-2 text-center">
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
                <p class="text-gray-600 text-sm mb-4 leading-relaxed">
                    {{ $kegiatan->deskripsi }}
                </p>
                <p class="text-gray-500 text-sm"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_kegiatan)->format('d M Y, H:i') }}</p>
                <p class="text-gray-500 text-sm"><strong>Kuota:</strong> {{ $kegiatan->kuota_peserta }}</p>
            </div>

            <hr class="my-6">

            <!-- Form -->
            <div>
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Formulir Pendaftaran</h2>

                <form id="form" enctype="multipart/form-data">
                    <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">

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
                            <input type="text" name="whatsapp" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-number" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Pilih Kecamatan</label>
                            <select name="kecamatan_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                @foreach($kecamatan as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Foto Kartu Keluarga</label>
                            <input type="file" name="foto_kk" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        </div>

                        <div class="flex items-start space-x-2 mt-4">
                            <input id="terms" name="terms" type="checkbox" class="mt-1 accent-blue-600">
                            <label for="terms" class="text-sm text-gray-700">
                                Saya setuju dengan <a href="#" class="text-blue-600 hover:underline" target="_blank">syarat & ketentuan</a>
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#form').on('submit', function(e) {
            e.preventDefault();

            if (!$('#terms').is(':checked')) {
                $('#result').html('<div class="alert alert-warning">Silakan centang "Syarat & Ketentuan" terlebih dahulu!</div>');
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
                    $('#result').html('<div class="alert alert-info">Mengupload...</div>');
                },
                success: function(res) {
                    if (res.success) {

                        const d = res.data;

                        $('#result').html(`
                            <div class="alert alert-success">${res.message}</div>
                            <div class="card mt-3 p-3">
                            <ul class="list-group">
                                <li class="list-group-item"><strong>KK:</strong> ${d.kk}</li>
                                <li class="list-group-item"><strong>KTP:</strong> ${d.ktp}</li>
                                <li class="list-group-item"><strong>Nama:</strong> ${d.nama}</li>
                                <li class="list-group-item"><strong>WhatsApp:</strong> ${d.whatsapp}</li>
                            </ul>
                        </div>
                        `);
                        $('#form')[0].reset();
                    }
                },
                error: function(err) {
                    $('#result').html('<div class="alert alert-danger">Terjadi kesalahan!</div>');
                }
            });
        });
    });
</script>
@endpush

</x-guest-layout>
