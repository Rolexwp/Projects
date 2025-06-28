// admin/js/admin.js

document.addEventListener("DOMContentLoaded", function () {
  // Check if we are on the reports page
  if (document.getElementById("reportType")) {
    initializeReportPage();
  }
  // Check if we are on the orders page
  if (document.getElementById("ordersTable")) {
    initializeOrdersPage();
  }
});

function initializeReportPage() {
  // Event listeners for report generation
  document
    .getElementById("reportType")
    .addEventListener("change", updateReportDisplay);
  document
    .getElementById("dateRange")
    .addEventListener("change", updateDateRangeInputs);
  document
    .getElementById("generateReport")
    .addEventListener("click", generateReport);

  // Initialize date inputs for custom range
  const today = new Date().toISOString().split("T")[0];
  const lastMonth = new Date();
  lastMonth.setMonth(lastMonth.getMonth() - 1);
  const lastMonthStr = lastMonth.toISOString().split("T")[0];
  document.getElementById("startDate").value = lastMonthStr;
  document.getElementById("endDate").value = today;

  // Initial report generation on load
  generateReport();
  updateReportDisplay(); // Ensure correct elements are shown/hidden
}

function initializeOrdersPage() {
  // Print order functionality
  document.querySelectorAll(".print-order-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const orderId = this.getAttribute("data-order-id");
      window.open(`print-order.php?id=${orderId}`, "_blank");
    });
  });

  // Filter orders
  document
    .getElementById("orderStatusFilter")
    .addEventListener("change", filterOrders);
  document
    .getElementById("orderDateFilter")
    .addEventListener("change", filterOrders);

  function filterOrders() {
    const status = document.getElementById("orderStatusFilter").value;
    const date = document.getElementById("orderDateFilter").value;

    document.querySelectorAll("#ordersTable tbody tr").forEach((row) => {
      // Ensure these selectors match your HTML structure
      const rowStatusElement = row.querySelector("td:nth-child(5) span"); // Assuming status is in the 5th cell with a span
      const rowDateElement = row.querySelector("td:nth-child(3)"); // Assuming date is in the 3rd cell

      if (rowStatusElement && rowDateElement) {
        const rowStatus = rowStatusElement.textContent.toLowerCase();
        const rowDate = rowDateElement.textContent;
        const formattedRowDate = new Date(rowDate).toISOString().split("T")[0];

        const statusMatch = status === "all" || rowStatus.includes(status);
        const dateMatch = !date || formattedRowDate === date;

        row.style.display = statusMatch && dateMatch ? "" : "none";
      } else {
        console.warn(
          "Could not find status or date element in table row for filtering:",
          row
        );
      }
    });
  }
}

function updateReportDisplay() {
  const reportType = document.getElementById("reportType").value;
  document.getElementById("orderStatisticsReport").style.display = "none";
  document.getElementById("salesOverviewReport").style.display = "none";
  document.getElementById("topProductsReport").style.display = "none";
  document.getElementById("customerReport").style.display = "none"; // Assuming this exists

  if (reportType === "order_statistics") {
    document.getElementById("orderStatisticsReport").style.display = "block";
  } else if (reportType === "sales_overview") {
    document.getElementById("salesOverviewReport").style.display = "block";
  } else if (reportType === "top_products") {
    document.getElementById("topProductsReport").style.display = "block";
  } else if (reportType === "customer_report") {
    document.getElementById("customerReport").style.display = "block";
  }
  // Re-generate report after changing type to ensure data is fresh for the displayed section
  generateReport();
}

function updateDateRangeInputs() {
  const dateRange = document.getElementById("dateRange").value;
  const customDateRange = document.getElementById("customDateRange");
  if (dateRange === "custom") {
    customDateRange.style.display = "flex"; // Use 'flex' for side-by-side inputs
  } else {
    customDateRange.style.display = "none";
  }
}

async function generateReport() {
  const reportType = document.getElementById("reportType").value;
  const dateRange = document.getElementById("dateRange").value;
  const startDate = document.getElementById("startDate").value;
  const endDate = document.getElementById("endDate").value;

  let url = "";
  let containerId = "";

  if (reportType === "order_statistics") {
    url = `api/order_stats.php?range=${dateRange}`;
    if (dateRange === "custom") {
      url += `&start=${startDate}&end=${endDate}`;
    }
    containerId = "orderStatisticsReport";
    await fetchOrderStatistics(url);
  }
  // You would add similar logic for other report types here
  // e.g., if (reportType === 'sales_overview') { url = 'api/sales_overview.php'; await fetchSalesOverview(url); }
}

async function fetchOrderStatistics(url) {
  try {
    const response = await fetch(url);
    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }
    const data = await response.json();
    console.log("Fetched Order Statistics:", data); // Log the data to console

    // Update overall stats
    document.getElementById("totalOrdersCell").textContent =
      data.overall_stats.total_orders || 0;
    document.getElementById("totalRevenueCell").textContent = data.overall_stats
      .total_revenue
      ? data.overall_stats.total_revenue.toLocaleString("en-IN", {
          style: "currency",
          currency: "INR",
        })
      : "₹0.00";
    document.getElementById("avgOrderValueCell").textContent = data
      .overall_stats.average_order_value
      ? data.overall_stats.average_order_value.toLocaleString("en-IN", {
          style: "currency",
          currency: "INR",
        })
      : "₹0.00";

    // Update status distribution table
    const statusTableBody = document.getElementById("orderStatsTableBody"); // Ensure this ID exists in your HTML
    statusTableBody.innerHTML = ""; // Clear previous rows

    if (data.status_distribution && data.status_distribution.length > 0) {
      data.status_distribution.forEach((item) => {
        const row = document.createElement("tr");
        row.innerHTML = `
                    <td>${item.status}</td>
                    <td>${item.count}</td>
                    <td>${item.total_value.toLocaleString("en-IN", {
                      style: "currency",
                      currency: "INR",
                    })}</td>
                `;
        statusTableBody.appendChild(row);
      });
    } else {
      statusTableBody.innerHTML =
        '<tr><td colspan="3">No orders found for this period.</td></tr>';
    }

    // Initialize/update sales chart (if you implement sales_overview)
    // updateSalesChart(data.sales_data);
    // Initialize/update top products chart (if you implement top_products)
    // updateProductsChart(data.top_products_data);
  } catch (error) {
    console.error("Error fetching order statistics:", error);
    // Display an error message on the page
    const container = document.getElementById("orderStatisticsReport");
    if (container) {
      container.innerHTML =
        '<p style="color: red;">Error loading report data. Please try again.</p>';
    }
  }
}

// Placeholder for chart instances if you have Chart.js canvases
let salesChartInstance;
let productsChartInstance;

// You would fill these functions with Chart.js logic based on your HTML canvases
function updateSalesChart(data) {
  // Example Chart.js update logic
  const ctx = document.getElementById("salesChart").getContext("2d");
  if (salesChartInstance) {
    salesChartInstance.destroy();
  }
  salesChartInstance = new Chart(ctx, {
    type: "line",
    data: {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"], // Example labels
      datasets: [
        {
          label: "Sales Revenue",
          data: [0, 0, 0, 0, 0, 0, 0], // Placeholder data
          borderColor: "rgb(75, 192, 192)",
          tension: 0.1,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}

function updateProductsChart(data) {
  // Example Chart.js update logic
  const ctx = document.getElementById("productsChart").getContext("2d");
  if (productsChartInstance) {
    productsChartInstance.destroy();
  }
  productsChartInstance = new Chart(ctx, {
    type: "bar",
    data: {
      labels: ["Product 1", "Product 2", "Product 3"], // Example labels
      datasets: [
        {
          label: "Units Sold",
          data: [0, 0, 0], // Placeholder data
          backgroundColor: "rgba(153, 102, 255, 0.2)",
          borderColor: "rgba(153, 102, 255, 1)",
          borderWidth: 1,
        },
      ],
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
