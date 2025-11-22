<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 leading-tight">Formulir Pendaftaran Khusus</h2>
    </x-slot>

<!-- Konten utama -->
<div class="relative flex flex-col items-center py-8 sm:py-4 mt-4">

    <div class="w-full sm:max-w-xl lg:max-w-2xl px-4 py-6 bg-white bg-opacity-80 shadow-lg overflow-hidden sm:rounded-lg backdrop-blur-sm">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Formulir Pendaftaran Khusus</h2>

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

            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition-all duration-200 ease-in-out">
                    Simpan
                </button>
            </div>
        </form>

        <div id="result" class="mt-6 text-center"></div>

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

                            <div class="mt-6 mb-6">
                                <a href="${d}" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold p-2 rounded-lg transition-all duration-200 ease-in-out" target="_blank">Download Bukti Pendaftaran
                                </a>
                            </div>

                            </div>
                        `);

                        $('#form')[0].reset();

                        // ✅ Scroll ke paling bawah
                        $('html, body').animate({
                            scrollTop: $(document).height()
                        }, 500);
                        
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

</x-app-layout>