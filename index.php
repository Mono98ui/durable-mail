<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Accueil</title>
</head>

<body>
    <div class="banner_home">
        <?php include("header.html"); ?>
        <div class="content_home">
            <h1>Email <span style="color:chartreuse">Durable</span></h1>
            <p id="currentDateTime"></p>
            <!-- Metrics Section -->
            <div class="metrics">
                <?php
                 $file = 'emailList.txt';
                 $NombreAbonner = count(file($file, FILE_SKIP_EMPTY_LINES));
                // Extracted metrics as an associative array for better readability
                $metrics = [
                    "Nombre d'abonnés" => $NombreAbonner,
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
