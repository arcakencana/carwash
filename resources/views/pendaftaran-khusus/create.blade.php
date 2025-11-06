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
            <div class="w-full sm:max-w-xl lg:max-w-2xl mt-5 mb-8 px-4 py-6 bg-white bg-opacity-80 shadow-lg overflow-hidden sm:rounded-lg backdrop-blur-sm">

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
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Formulir Pendaftaran Lansia / Disabilitas</h2>

                <form id="form">
                    <input type="hidden" name="kegiatan_id" id="kegiatan_id" value="{{ $kegiatan->id }}">

                    <div class="space-y-4">
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

                        <div class="mt-4">
                            <label class="block font-semibold mb-1">Pilih Kelurahan</label>
                            <select name="kelurahan_id" id="kelurahan_id" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                                <option value="">-- Pilih Kelurahan --</option>
                            </select>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor Kartu Keluarga</label>
                            <input type="text" name="kk" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-number-16" required>
                            <div class="text-red-600 text-sm mt-1 error-message" data-error="kk"></div>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor KTP</label>
                            <input type="text" name="ktp" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-number-16" required>
                            <div class="text-red-600 text-sm mt-1 error-message" data-error="ktp"></div>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="nama" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-uppercase" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Alamat (Sesuai KTP)</label>
                            <input type="text" name="alamat" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-uppercase" required>
                        </div>

                        <div>
                            <label class="block font-semibold mb-1">Nomor Whatsapp (Nomor yang aktif sebagai penerima notifikasi undangan pengambilan paket subsidi)</label>
                            <input type="number" name="whatsapp" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none only-number" required>
                            <div class="text-red-600 text-sm mt-1 error-message" data-error="whatsapp"></div>
                        </div>

                        {{-- <div>
                            <label class="block font-semibold mb-1">Lansia atau Disabilitas ?</label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="is_lansia" value="tidak" 
                                    class="text-blue-600 focus:ring-blue-500 border-gray-300" checked>
                                    <span>Tidak</span>
                                </label>
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="is_lansia" value="ya" 
                                    class="text-blue-600 focus:ring-blue-500 border-gray-300">
                                    <span>Ya</span>
                                </label>
                            </div>
                        </div> --}}

                       {{--  <div>
                            <label class="block font-semibold mb-1">Foto Kartu Keluarga</label>
                            <input type="file" name="foto_kk" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        </div> --}}
                        <label class="block font-semibold mb-1">Disclaimer</label>
                        <div class="flex items-start space-x-2 mt-4">
                            <input id="terms1" name="terms" type="checkbox" class="mt-1 accent-blue-600">
                            <label for="terms1" class="text-sm text-gray-700">
                                Saya menyatakan diri sebagai masyarakat Kota Batam yang kurang mampu dan beresiko terhadap dampak kenaikan harga barang kebutuhan pokok, sehingga berhak untuk mendapatkan subsidi harga barang kebutuhan pokok.
                            </label>
                        </div>

                        <div class="flex items-start space-x-2 mt-4">
                            <input id="terms2" name="terms" type="checkbox" class="mt-1 accent-blue-600">
                            <label for="terms2" class="text-sm text-gray-700">
                                Saya menyatakan bahwa data dan pernyataan yang saya sampaikan ini adalah benar adanya, dan akan berdampak hukum kepada saya jika data dan pernyataan ini tidak benar.

                            </label>
                        </div>

                    </div>

                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-all duration-200 ease-in-out">
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

<!-- Modal Alert -->
<div id="alertModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg max-w-sm w-full p-6 relative text-center">
        <p id="alertMessage" class="text-gray-700 mb-4"></p>
        <button id="closeAlert" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Tutup</button>

        <!-- Tombol X di pojok -->
        <button id="closeAlertIcon" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl">&times;</button>
    </div>
</div>

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {

        $('#form').on('submit', function(e) {
            e.preventDefault();

            // ==== Fungsi buat munculin popup ====
            function showAlert(message) {
                $('#alertMessage').text(message);
                $('#alertModal').removeClass('hidden');
            }

            // ==== Tombol tutup popup ====
            $(document).on('click', '#closeAlert, #closeAlertIcon', function() {
                $('#alertModal').addClass('hidden');
            });

            // ==== Tutup modal kalau klik di luar kotak ====
            $(document).on('click', function(e) {
                if ($(e.target).is('#alertModal')) {
                    $('#alertModal').addClass('hidden');
                }
            });

            if (!$('#terms1').is(':checked')) {
                showAlert('Silakan Centang Disclaimer 1');
                return;
            }

            if (!$('#terms2').is(':checked')) {
                showAlert('Silakan Centang Disclaimer 2');
                return;
            }

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('pendaftaran-khusus.store', encrypt($kegiatan->id)) }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                beforeSend: function() {},
                success: function(res) {

                    // Bersihkan error sebelumnya
                    $('.error-message').html('');

                    if (res.success) {

                        // Jika data gagal tapi success:true dan data null (lama)
                        if (res.data === null) {
                            showAlert(res.message);
                            return;
                        }

                        // Jika berhasil
                        const d = res.data;
                        $('#result').html(`
                            <div class="p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50">
                                <span class="font-semibold">Berhasil!</span> ${res.message}
                            </div>
                        `);
                        $('#form')[0].reset();
                    } else {

                        // Kalau validasi custom gagal
                        if (res.errors) {
                            $.each(res.errors, function(field, messages) {
                                $(`[data-error="${field}"]`).html(messages[0]);
                            });
                        } else {
                            showAlert(res.message);
                        }
                    }
                },
                error: function(err) {
                    $('.error-message').html('');

                    if (err.status === 422) {

                        // Validasi Laravel
                        let errors = err.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $(`[data-error="${field}"]`).html(messages[0]);
                        });
                    } else if (err.status === 409) {
                        // Validasi duplikat data (custom)
                        let errors = err.responseJSON.errors;
                        $.each(errors, function(field, messages) {
                            $(`[data-error="${field}"]`).html(messages[0]);
                        });
                    } else {
                        showAlert('Terjadi kesalahan server.');
                    }
                }
            });
        });

        // === Menampilkan jumlah & sisa kuota berdasarkan kecamatan & kegiatan ===
        $(document).on('change', '#kecamatan_id', function() {

            let kecamatan_id = $(this).val();
            let kecamatan = $('#kecamatan_id option:selected').text();
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
                            <p class="${color}"><strong>Sisa Kuota ${kecamatan} ${sisaFormatted} dari ${jumlahFormatted}</strong></p>
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

        // === Menampilkan kelurahan berdasarkan kecamatan ===
        $(document).on('change', '#kecamatan_id', function() {

            let kecamatan_id = $(this).val();

            // kosongkan dropdown kelurahan saat ganti kecamatan
            $('#kelurahan_id').html('<option value="">-- Pilih Kelurahan --</option>');

            if (!kecamatan_id) return;

            $.ajax({
                url: "{{ url('/get-kelurahan') }}/" + kecamatan_id,
                type: "GET",
                success: function(res) {
                    if (res.success) {
                        let options = '<option value="">-- Pilih Kelurahan --</option>';
                        $.each(res.data, function(index, item) {
                            options += `<option value="${item.id}">${item.name}</option>`;
                        });
                        $('#kelurahan_id').html(options);
                    } else {
                        $('#kelurahan_id').html('<option value="">Kelurahan tidak tersedia</option>');
                    }
                },
                error: function() {
                    $('#kelurahan_id').html('<option value="">Gagal memuat kelurahan</option>');
                }
            });

        });

    });

</script>
@endpush

</x-guest-layout>
