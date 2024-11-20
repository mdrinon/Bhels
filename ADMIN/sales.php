<?php include('partials/header.php'); ?>
<?php include('partials/topbar.php'); ?>
<?php include('partials/sidebar.php'); ?>
<?php include('../dbconnect.php'); ?>

<link rel="stylesheet" href="partials/sales.css">

<section class="main-content">
    <div class="navigation">
        <div class="menu-tab"><h6><b>Sales Report</b></h6></div>
        <div class="nav-label"><h2>Sales Report</h2></div>
        <button id="exportButton" class="export-button">Export to Excel</button>
    </div>

    <div class="sales-report-container">
        <?php
        try {
            // Fetch total sales, total orders, and total users
            $ordersCollection = $db->orders;
            $usersCollection = $db->accounts;

            $totalSales = $ordersCollection->aggregate([
                ['$group' => ['_id' => null, 'total' => ['$sum' => '$total_amount']]]
            ])->toArray()[0]['total'];

            $totalOrders = $ordersCollection->count();
            $totalUsers = $usersCollection->count();

            // Fetch top-selling cake designs
            $topSellingCakes = $ordersCollection->aggregate([
                ['$unwind' => '$items'],
                ['$group' => ['_id' => '$items.cake_id', 'totalSold' => ['$sum' => '$items.quantity']]],
                ['$sort' => ['totalSold' => -1]],
                ['$limit' => 5]
            ])->toArray();

            // Fetch cake design details
            $cakeDesignsCollection = $db->cake_designs;
            $topCakesDetails = [];
            foreach ($topSellingCakes as $cake) {
                $cakeDetails = $cakeDesignsCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($cake['_id'])]);
                $topCakesDetails[] = [
                    'name' => $cakeDetails['name'],
                    'totalSold' => $cake['totalSold']
                ];
            }

            // Fetch monthly sales data
            $monthlySales = $ordersCollection->aggregate([
                ['$group' => ['_id' => ['month' => ['$month' => '$order_date'], 'year' => ['$year' => '$order_date']], 'total' => ['$sum' => '$total_amount']]],
                ['$sort' => ['_id.year' => 1, '_id.month' => 1]]
            ])->toArray();

            // Fetch top customers
            $topCustomers = $ordersCollection->aggregate([
                ['$group' => ['_id' => '$customer_id', 'totalSpent' => ['$sum' => '$total_amount']]],
                ['$sort' => ['totalSpent' => -1]],
                ['$limit' => 5]
            ])->toArray();

            // Calculate average order value
            $averageOrderValue = $totalSales / $totalOrders;

        } catch (Exception $e) {
            echo "Unable to fetch sales data: ", $e->getMessage();
            exit();
        }
        ?>

        <div class="sales-summary">
            <div class="summary-item">
                <h3>Total Sales</h3>
                <p>₱<?php echo number_format($totalSales, 2); ?></p>
            </div>
            <div class="summary-item">
                <h3>Total Orders</h3>
                <p><?php echo $totalOrders; ?></p>
            </div>
            <div class="summary-item">
                <h3>Total Users</h3>
                <p><?php echo $totalUsers; ?></p>
            </div>
        </div>

        <div>
          <div class="top-selling-cakes">
              <h3>Top Selling Cakes</h3>
              <ul>
                  <?php foreach ($topCakesDetails as $cake): ?>
                      <li><?php echo htmlspecialchars($cake['name']); ?> - <?php echo $cake['totalSold']; ?> sold</li>
                  <?php endforeach; ?>
              </ul>
          </div>
          <div class="top-customers">
              <h3>Top Customers</h3>
              <ul>
                  <?php foreach ($topCustomers as $customer): ?>
                      <li>Customer ID: <?php echo $customer['_id']; ?> - ₱<?php echo number_format($customer['totalSpent'], 2); ?></li>
                  <?php endforeach; ?>
              </ul>
          </div>
          <div class="average-order-value">
              <h3>Average Order Value</h3>
              <p>₱<?php echo number_format($averageOrderValue, 2); ?></p>
          </div>
        </div>

        <div class="monthly-sales">
            <h3>Monthly Sales</h3>
            <canvas id="monthlySalesChart"></canvas>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.getElementById('exportButton').addEventListener('click', function() {
    var wb = XLSX.utils.book_new();
    wb.Props = {
        Title: "Sales Report",
        Subject: "Sales",
        Author: "Your Company",
        CreatedDate: new Date()
    };

    // Sales Summary
    var salesSummaryData = [
        ["Total Sales", "Total Orders", "Total Users"],
        ["₱" + <?php echo number_format($totalSales, 2); ?>, <?php echo $totalOrders; ?>, <?php echo $totalUsers; ?>]
    ];
    var wsSalesSummary = XLSX.utils.aoa_to_sheet(salesSummaryData);
    XLSX.utils.book_append_sheet(wb, wsSalesSummary, "Sales Summary");

    // Top Selling Cakes
    var topSellingCakesData = [
        ["Cake Name", "Total Sold"]
    ];
    <?php foreach ($topCakesDetails as $cake): ?>
        topSellingCakesData.push(["<?php echo htmlspecialchars($cake['name']); ?>", <?php echo $cake['totalSold']; ?>]);
    <?php endforeach; ?>
    var wsTopSellingCakes = XLSX.utils.aoa_to_sheet(topSellingCakesData);
    XLSX.utils.book_append_sheet(wb, wsTopSellingCakes, "Top Selling Cakes");

    // Monthly Sales
    var monthlySalesData = [
        ["Month/Year", "Total Sales"]
    ];
    <?php foreach ($monthlySales as $month): ?>
        monthlySalesData.push(["<?php echo $month['_id']['month'] . '/' . $month['_id']['year']; ?>", "₱<?php echo number_format($month['total'], 2); ?>"]);
    <?php endforeach; ?>
    var wsMonthlySales = XLSX.utils.aoa_to_sheet(monthlySalesData);
    XLSX.utils.book_append_sheet(wb, wsMonthlySales, "Monthly Sales");

    // Top Customers
    var topCustomersData = [
        ["Customer ID", "Total Spent"]
    ];
    <?php foreach ($topCustomers as $customer): ?>
        topCustomersData.push(["<?php echo $customer['_id']; ?>", "₱<?php echo number_format($customer['totalSpent'], 2); ?>"]);
    <?php endforeach; ?>
    var wsTopCustomers = XLSX.utils.aoa_to_sheet(topCustomersData);
    XLSX.utils.book_append_sheet(wb, wsTopCustomers, "Top Customers");

    // Average Order Value
    var averageOrderValueData = [
        ["Average Order Value"],
        ["₱<?php echo number_format($averageOrderValue, 2); ?>"]
    ];
    var wsAverageOrderValue = XLSX.utils.aoa_to_sheet(averageOrderValueData);
    XLSX.utils.book_append_sheet(wb, wsAverageOrderValue, "Average Order Value");

    XLSX.writeFile(wb, 'Sales_Report.xlsx');
});

// Chart.js configurations
const monthlySalesCtx = document.getElementById('monthlySalesChart').getContext('2d');

const monthlySalesData = {
    labels: <?php echo json_encode(array_map(function($month) { return $month['_id']['month'] . '/' . $month['_id']['year']; }, $monthlySales)); ?>,
    datasets: [{
        label: 'Monthly Sales',
        data: <?php echo json_encode(array_map(function($month) { return $month['total']; }, $monthlySales)); ?>,
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1
    }]
};

new Chart(monthlySalesCtx, {
    type: 'line',
    data: monthlySalesData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

<?php include('partials/footer.php'); ?>
