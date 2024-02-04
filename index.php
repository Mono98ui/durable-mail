<?php
// Sample data for illustration purposes
$scheduleData = [
    ['time' => '8:00 AM', 'vehicle' => 'Compact Car'],
    ['time' => '10:00 AM', 'vehicle' => 'Full-Size Car'],
    ['time' => '1:00 PM', 'vehicle' => 'Medium Car'],
    // Add more schedule data as needed
];

// Check if the cookie is set
if (!isset($_COOKIE['midnight_update'])) {
    // If not set, update the date and set the cookie
    setcookie('midnight_update', 'updated', strtotime('tomorrow midnight'));

    // Your code to update the date in the database or perform other tasks
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css" />
    <title>Home</title>
</head>

<body>
    <div class="banner_home">
        <?php include("header.html"); ?>
        <div class="content_home">
            <h1>Dashboard</h1>
            <p id="currentDateTime"></p>
            <!-- Metrics Section -->
            <div class="metrics">
                <?php
                // Extracted metrics as an associative array for better readability
                $metrics = [
                    'Total Revenue Today' => '$5000',
                    'Customers served today' => '10',
                    // Add more metrics as needed
                ];
                // Display metrics
                foreach ($metrics as $metricTitle => $metricValue) : ?>
                    <div class="metric">
                        <h2><?php echo $metricTitle; ?></h2>
                        <p><?php echo $metricValue; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="schedule_overview">
                <h2>Today's Schedule Overview</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Vehicle Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scheduleData as $entry) : ?>
                            <tr>
                                <td><?php echo $entry['time']; ?></td>
                                <td><?php echo $entry['vehicle']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <script>
                function updateDateTime() {
                    var currentDate = new Date();
                    var options = {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        hour: 'numeric',
                        minute: 'numeric',
                        second: 'numeric',
                        timeZoneName: 'short'
                    };
                    var formattedDateTime = currentDate.toLocaleDateString('en-US', options);
                    document.getElementById('currentDateTime').textContent = formattedDateTime;
                }
                setInterval(updateDateTime, 1000);
                updateDateTime();
            </script>
        </div>
    </div>
</body>

</html>
