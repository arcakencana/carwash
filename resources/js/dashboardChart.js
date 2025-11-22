import Chart from "chart.js/auto";

document.addEventListener("DOMContentLoaded", async () => {
    const canvas = document.getElementById("pendaftaranChart");
    if (!canvas) return;

    try {
        const response = await fetch(window.API_URL);
        const data = await response.json();

        const labels = data.map(item => item.tanggal);
        const totals = data.map(item => item.total);

        new Chart(canvas.getContext("2d"), {
            type: "line",
            data: {
                labels,
                datasets: [{
                    label: "Total Pendaftaran Harian",
                    data: totals,
                    borderWidth: 2,
                    borderColor: "blue", // opsional
                    tension: 0.3
                }]
            }
        });

    } catch (err) {
        console.error("Gagal load chart:", err);
    }
});
