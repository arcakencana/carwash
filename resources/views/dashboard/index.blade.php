<x-app-layout>

  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-900 leading-tight">
      Dashboard
  </h2>
</x-slot>

<div class="py-6">
    <div class="max-w-7xl mx-auto px-4">

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="flex items-center p-5 bg-red-500 text-white rounded-xl shadow-md">
          <div class="text-4xl opacity-80">👤</div>
          <div class="ml-4">
            <p class="text-sm uppercase font-semibold opacity-90">Kuota {{ $nama }}</p>
            <h3 class="text-3xl font-bold">{{ $kuota }}</h3>
        </div>
    </div>

    <div class="flex items-center p-5 bg-blue-500 text-white rounded-xl shadow-md">
      <div class="text-4xl opacity-80">📄</div>
      <div class="ml-4">
        <p class="text-sm uppercase font-semibold opacity-90">Total Pendaftaran</p>
        <h3 class="text-3xl font-bold">{{ $total_pendaftaran }}</h3>
    </div>
</div>

<div class="flex items-center p-5 bg-green-500 text-white rounded-xl shadow-md">
  <div class="text-4xl opacity-80">✔️</div>
  <div class="ml-4">
    <p class="text-sm uppercase font-semibold opacity-90">Terverifikasi</p>
    <h3 class="text-3xl font-bold">{{ $total_terverifikasi }}</h3>
</div>
</div>

<div class="flex items-center p-5 bg-yellow-500 text-white rounded-xl shadow-md">
  <div class="text-4xl opacity-80">⏳</div>
  <div class="ml-4">
    <p class="text-sm uppercase font-semibold opacity-90">Belum Verifikasi</p>
    <h3 class="text-3xl font-bold">{{ $total_belum }}</h3>
</div>
</div>

</div>

@if(Auth::user()->kelurahan_id != 0)
<div class="mt-8 bg-white p-6 rounded-xl shadow">
    <h2 class="text-lg font-bold mb-4">Grafik Pendaftaran Harian</h2>
    <canvas id="pendaftaranChart" class="w-full" style="height:400px;"></canvas>
</div>
@else
<div class="card mt-8">
    <div class="card-body">
      <h4 class="font-bold text-center">Grafik Pendaftaran per Kelurahan</h4>
      <canvas id="chartKelurahan" class="w-full" style="height:1200px; max-height:1200px;"></canvas>
  </div>
</div>
@endif

</div>
</div>

<script>
    window.API_URL = "{{ url('/api/dashboard/harian') }}";
    window.API_URL_KELURAHAN = "{{ url('/api/dashboard/grafik-kelurahan') }}";
</script>

@if(Auth::user()->kelurahan_id == 0)
<script>
    // Pastikan chart hanya diinisialisasi sekali
    if (!window.kelurahanChartInstance) {
      (async () => {
        try {
          const response = await fetch(window.API_URL_KELURAHAN);
          const data = await response.json();

          console.log("HASIL API:", data);

          // Optional: urutkan data agar chart lebih rapi
          const sortedData = data.sort((a, b) => a.total_pendaftaran - b.total_pendaftaran);

          const labels = sortedData.map(item => item.kelurahan);
          const totals = sortedData.map(item => parseInt(item.total_pendaftaran) || 0);
          const kuota = sortedData.map(item => parseInt(item.kuota) || 0);

          const canvas = document.getElementById("chartKelurahan");
          const ctx = canvas.getContext("2d");

          window.kelurahanChartInstance = new Chart(ctx, {
            type: "bar",
            data: {
              labels,
              datasets: [
                {
                  label: "Pendaftaran",
                  data: totals,
                  backgroundColor: "rgba(54, 162, 235, 0.7)",
                  borderColor: "rgb(54, 162, 235)",
                  borderWidth: 1
              },
              {
                  label: "Kuota",
                  data: kuota,
                  backgroundColor: "rgba(255, 99, 132, 0.7)",
                  borderColor: "rgb(255, 99, 132)",
                  borderWidth: 1
              }
          ]
      },
      options: {
              indexAxis: "y", // horizontal bar
              responsive: true,
              maintainAspectRatio: false,
              layout: {
                  padding: {
                      top: 25,
                      bottom: 70
                  }
              },
              scales: {
                x: { beginAtZero: true},
                y: { 
                    beginAtZero: true,
                    ticks: {
                        autoSkip: false, 
                        maxRotation: 0, 
                        minRotation: 0  
                    }
                }
            }
        }
    });

      } catch (error) {
          console.error("Gagal load grafik kelurahan:", error);
      }
  })();
}
</script>

@else

<script>
    if (!window.pendaftaranChartInstance) {
        (async () => {
            const canvas = document.getElementById("pendaftaranChart");
            if (!canvas) return;

        // Tetapkan tinggi tetap
            canvas.height = 400;
            canvas.style.height = "400px";

            try {
                const response = await fetch(window.API_URL);
                const data = await response.json();

                const labels = data.map(item => item.tanggal);
                const totals = data.map(item => item.total);

                window.pendaftaranChartInstance = new Chart(canvas.getContext("2d"), {
                    type: "line",
                    data: { labels, datasets:[{label:"Total Pendaftaran Harian", data:totals, borderColor:"blue", borderWidth:2, tension:0.3}] },
                    options: {
                        responsive: false,
                        maintainAspectRatio: false,
                        animation: false,
                        scales: { y: { beginAtZero:true } }
                    }
                });
            } catch(err) { console.error(err); }
        })();
    }
</script>

@endif

</x-app-layout>