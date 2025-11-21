<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 leading-tight">{{ $label }}</h2>
    </x-slot>

<!-- Konten utama -->
<div class="relative flex flex-col items-center py-8 sm:py-4 mt-4">

    <div class="w-full sm:max-w-xl lg:max-w-2xl px-4 py-6 bg-white bg-opacity-80 shadow-lg overflow-hidden sm:rounded-lg backdrop-blur-sm">

        <h2 class="text-2xl font-bold text-gray-800 mb-4">Formulir Pendaftaran</h2>

        <form id="form">

            <div class="space-y-4">

                <div>
                    <label class="block font-semibold mb-1">Nomor Kartu Keluarga</label>
                    <input type="text" name="kk" class="w-full border rounded-lg p-2 only-number-16" required>
                    <div class="text-red-600 text-sm mt-1 error-message" data-error="kk"></div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Nomor KTP</label>
                    <input type="text" name="ktp" class="w-full border rounded-lg p-2 only-number-16" required>
                    <div class="text-red-600 text-sm mt-1 error-message" data-error="ktp"></div>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Nama Lengkap (Sesuai KTP)</label>
                    <input type="text" name="nama" class="w-full border rounded-lg p-2 only-uppercase" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Alamat (Sesuai KTP)</label>
                    <input type="text" name="alamat" class="w-full border rounded-lg p-2" required>
                </div>

                <div>
                    <label class="block font-semibold mb-1">Nomor Whatsapp</label>
                    <input type="number" name="whatsapp" class="w-full border rounded-lg p-2 only-number" required>
                    <div class="text-red-600 text-sm mt-1 error-message" data-error="whatsapp"></div>
                </div>

            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2.5 rounded-lg">
                    Simpan
                </button>
            </div>
        </form>

        <div id="result" class="mt-6 text-center"></div>

    </div>
</div>

@push('scripts')
<script>

    $(document).ready(function() {

        $('#form').on('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            $.ajax({
                url: "{{ route('pendaftaran.store', encrypt($kegiatan->id)) }}",
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },

                beforeSend: function () {
                    $('.error-message').html('');
                },

                success: function (res) {
                    if (res.success) {

                        if (res.data === null) {
                            showAlert(res.message);
                            return;
                        }

                        $('#result').html(`
                        <div class="p-4 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50">
                            <strong>Berhasil!</strong> ${res.message}
                            <div class="mt-6 mb-6">
                                <a href="${res.data}" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold p-2 rounded-lg block" target="_blank">
                                    Download Bukti Pendaftaran
                                </a>
                            </div>
                        </div>
                        `);

                        $('#form')[0].reset();
                        $('html, body').animate({ scrollTop: $(document).height() }, 500);

                    } else {

                        if (res.errors) {
                            $.each(res.errors, function(field, msg) {
                                $(`[data-error="${field}"]`).html(msg[0]);
                            });
                        }

                        showAlert(res.message);
                    }
                },

                error: function (err) {

                    $('.error-message').html('');

                    if (err.status === 409) {
                        let errors = err.responseJSON.errors;

                        $.each(errors, function(field, msg) {
                            $(`[data-error="${field}"]`).html(msg[0]);
                        });

                        showAlert(err.responseJSON.message);

                    } else {
                        showAlert("Terjadi kesalahan pada server. Silakan coba lagi.");
                    }
                }
            });
        });

    });

</script>
@endpush

</x-app-layout>
