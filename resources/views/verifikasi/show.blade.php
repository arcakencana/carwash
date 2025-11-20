<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-gray-800 leading-tight">Verifikasi Pembelian</h2>
    </x-slot>

    <div class="min-h-screen flex flex-col items-center pt-8 px-4">
        <div class="w-full sm:max-w-2xl lg:max-w-3xl bg-white shadow-lg rounded-lg border border-gray-200">

            <h2 class="text-2xl font-bold text-gray-800 p-6 pb-2">Verifikasi Pembelian</h2>

            <div class="overflow-hidden">
                <table class="min-w-full border-t border-gray-200">
                    <tbody class="divide-y divide-gray-200">

                        <tr>
                            <td class="w-1/3 px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor Kartu Keluarga
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->kk }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor KTP
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->ktp }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nama
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->nama }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Alamat
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->alamat }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor Whatsapp
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->whatsapp }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Kelurahan
                            </td>
                            <td class="px-6 py-3 text-gray-900">
                                {{ $pendaftaran->name }}
                            </td>
                        </tr>

                        <tr>
                            <td class="px-6 py-3 font-semibold text-gray-700 bg-gray-50">
                                Nomor Antrian
                            </td>
                            <td class="px-6 py-3 text-blue-700 font-bold text-xl">
                                {{ $pendaftaran->antrian }}
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            <form id="verifikasiForm" method="POST" action="{{ route('verifikasi.update', encrypt($pendaftaran->id)) }}" class="w-full sm:max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg mt-6">
                @csrf
                @method('PUT')

                <input type="hidden" name="selfie_image" id="selfie_image">
                <input type="hidden" name="latitude" id="latitude">
                <input type="hidden" name="longitude" id="longitude">
                <input type="hidden" name="captured_at" id="captured_at">

                <h2 class="text-xl font-bold text-gray-800 text-center mb-4">Verifikasi Foto</h2>

                <div class="mb-4">
                    <video id="cameraPreview" autoplay playsinline class="w-full rounded border"></video>
                    <canvas id="selfiePreview" class="w-full rounded border my-2" style="display:none;"></canvas>

                    <div class="flex flex-col items-center mt-4 space-y-2">
                        <button type="button" id="captureBtn" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                            📸 Ambil Foto
                        </button>
                        <button type="button" id="clearSelfieBtn" class="w-full px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                            Hapus Foto
                        </button>
                        <div id="cameraError" class="text-red-600 mt-2 text-center"></div>
                        <div id="locationInfo" class="text-gray-700 mt-2 text-center">📍 Mendapatkan lokasi...</div>
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('cameraPreview');
            const selfieCanvas = document.getElementById('selfiePreview');
            const captureBtn = document.getElementById('captureBtn');
            const clearSelfieBtn = document.getElementById('clearSelfieBtn');
            const locationInfo = document.getElementById('locationInfo');
            const cameraError = document.getElementById('cameraError');

            let selfieImage = null;
            let latitude = null;
            let longitude = null;

            // akses kamera
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({ video: true })
                .then(stream => { video.srcObject = stream; })
                .catch(err => { cameraError.textContent = "Tidak dapat mengakses kamera"; });
            } else {
                cameraError.textContent = "Browser tidak mendukung kamera";
            }

            // ambil foto
            captureBtn.addEventListener('click', () => {
                selfieCanvas.width = video.videoWidth;
                selfieCanvas.height = video.videoHeight;
                selfieCanvas.getContext('2d').drawImage(video, 0, 0);
                selfieImage = selfieCanvas.toDataURL('image/jpeg');
                video.style.display = 'none';
                selfieCanvas.style.display = 'block';
            });

            // hapus foto
            clearSelfieBtn.addEventListener('click', () => {
                selfieImage = null;
                selfieCanvas.style.display = 'none';
                video.style.display = 'block';
            });

            // lokasi
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(pos => {
                    latitude = pos.coords.latitude;
                    longitude = pos.coords.longitude;
                    locationInfo.textContent = `📍 Lokasi: ${latitude.toFixed(5)}, ${longitude.toFixed(5)}`;
                }, () => {
                    locationInfo.textContent = "⚠️ Gagal mendapatkan lokasi";
                });
            } else {
                locationInfo.textContent = "Geolocation tidak didukung browser.";
            }

            // submit form
            const form = document.getElementById('verifikasiForm');
            form.addEventListener('submit', function(e) {
                if (!selfieImage) {
                    e.preventDefault();
                    alert('Silahkan ambil foto terlebih dahulu!');
                    return;
                }
                document.getElementById('selfie_image').value = selfieImage;
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
                document.getElementById('captured_at').value = new Date().toISOString();
            });
        });
    </script>
    @endpush

</x-app-layout>
