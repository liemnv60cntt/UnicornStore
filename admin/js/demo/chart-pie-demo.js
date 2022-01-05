// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var vl1 = document.getElementById("pendingNum").value;
var vl2 = document.getElementById("preparingNum").value;
var vl3 = document.getElementById("deliveringNum").value;
var vl4 = document.getElementById("deliveredNum").value;
var vl5 = document.getElementById("cancelledNum").value;
var myPieChart = new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ["Chờ xác nhận", "Đang chuẩn bị hàng", "Đang giao", "Đã giao và thanh toán", "Đã hủy"],
    datasets: [{
      data: [vl1, vl2, vl3, vl4, vl5],
      backgroundColor: ['#FFD700', '#36b9cc', '#4e73df', '#1cc88a', '#DC143C'],
      hoverBackgroundColor: ['#f7e307', '#16a1f7', '#2e59d9', '#17a673', '#f51e1b'],
      hoverBorderColor: "rgba(234, 236, 244, 1)",
    }],
  },
  options: {
    maintainAspectRatio: false,
    tooltips: {
      backgroundColor: "rgb(255,255,255)",
      bodyFontColor: "#858796",
      borderColor: '#dddfeb',
      borderWidth: 1,
      xPadding: 15,
      yPadding: 15,
      displayColors: false,
      caretPadding: 10,
    },
    legend: {
      display: false
    },
    cutoutPercentage: 80,
  },
});
