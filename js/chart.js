fetch("../../backend/penjualan_api.php")
  .then(response => {
    if (!response.ok) {
      throw new Error("Network response was not ok " + response.statusText);
    }
    return response.json();
  })
  .then(data => {
    // Map data to labels and salesData arrays
    const labels = data.map(item => item.tanggal);
    const salesData = data.map(item => item.total_jumlah_jual);

    // Initialize the Chart inside the `then` block
    const ctx = document.getElementById("myChart").getContext("2d");
    new Chart(ctx, {
      type: "line",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Total Penjualan",
            data: salesData,
            borderWidth: 2,
            borderColor: "white", // Line color
            backgroundColor: "rgba(255, 99, 133, 0.2)", // Optional fill color
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  })
  .catch(error => {
    console.error("There was an error fetching the data!", error);
  });
