<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Inscription</title>
</head>

<body>
    <div class="banner_home">
        <?php include("header.html");
        // Fonction pour vérifier si un e-mail est déjà dans le fichier
        function isEmailSubscribed($email, $file)
        {
            $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            return in_array($email, $emails);
        }

        // Vérifier si le formulaire d'abonnement a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["subscribe"])) {
            $email = $_POST["email"];

            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $file = 'emailList.txt';

                if (!isEmailSubscribed($email, $file)) {
                    // Ajouter l'e-mail au fichier
                    file_put_contents($file, $email . PHP_EOL, FILE_APPEND | LOCK_EX);
                    echo "<p>Merci de vous être abonné avec l'e-mail : $email</p>";
                } else {
                    echo "<p>L'adresse e-mail est déjà abonnée.</p>";
                }
            } else {
                echo "<p>L'adresse e-mail n'est pas valide.</p>";
            }
        }

        // Vérifier si le formulaire de désabonnement a été soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["unsubscribe"])) {
            $email = $_POST["email"];

            // Désabonnement
            $file = 'emailList.txt';

            if (isEmailSubscribed($email, $file)) {
                // Supprimer l'e-mail du fichier
                $emails = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $updatedEmails = array_diff($emails, [$email]);
                file_put_contents($file, implode(PHP_EOL, $updatedEmails) . PHP_EOL);

                echo "<p>Vous vous êtes désabonné avec l'e-mail : $email</p>";
            } else {
                echo "<p>L'adresse e-mail n'est pas trouvée dans la liste d'abonnés.</p>";
            }
        }
        ?>

        <!-- Formulaire d'abonnement -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Adresse e-mail :</label>
            <input type="email" name="email" required>
            <br>
            <input type="submit" name="subscribe" value="S'abonner">
        </form>

        <!-- Formulaire de désabonnement -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="email">Adresse e-mail :</label>
            <input type="email" name="email" required>
            <br>
            <input type="submit" name="unsubscribe" value="Se désabonner">
        </form>
    </div>
</body>

</html>