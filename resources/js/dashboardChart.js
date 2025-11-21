import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", async () => {
    const ctx = document.getElementById("pendaftaranChart");
    if (!ctx) return;

    const response = await fetch('/api/dashboard/harian');
    const data = await response.json();

    const labels = data.map(item => item.tanggal);
    const totals = data.map(item => item.total);

    new Chart(ctx, {
        type: "line",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Total Pendaftaran Harian",
                    data: totals,
                    borderWidth: 2,
                    tension: 0.3
                }
            ]
        }
    });
});
