fetch("../../backend/penjualan_summary_api.php")
  .then(response => {
    if (!response.ok) {
      throw new Error("Network response was not ok " + response.statusText);
    }
    return response.json();
  })
  .then(data => {
    if (data.error) {
      throw new Error("Error from API: " + data.error);
    }
    const labels = data.map(item => item.kode_barang);
    const salesData = data.map(item => item.total_revenue);

    const formattedSalesData = salesData.map(amount => 
      new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(amount)
    );

    const ctx = document.getElementById("penjualan_chart").getContext("2d");
    new Chart(ctx, {
      type: "bar",
      data: {
        labels: labels,
        datasets: [
          {
            label: "Rekap Penjualan Barang",
            data: salesData, 
            borderWidth: 2,  
            backgroundColor: [
                'rgb(255, 99, 133)',
                'rgb(255, 160, 64)',
                'rgb(255, 204, 86)',
                'rgb(75, 192, 192)',
                'rgb(54, 163, 235)',
                'rgb(153, 102, 255)',
                'rgb(201, 203, 207)'
              ],
            fill: true,  
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
              }
            }
          },
        },
      },
    });

    console.log(formattedSalesData);
  })
  .catch(error => {
    console.error("There was an error fetching the data!", error);
  });
