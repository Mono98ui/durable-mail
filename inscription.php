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
        <?php include("header.html"); ?>
        <div class="content_home">
            <?php
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
                        echo "<h3 class='success-message'>Merci de vous être abonné avec l'e-mail : $email</h3>";
                    } else {
                        echo "<h3 class='error-message'>L'adresse e-mail est déjà abonnée.</h3>";
                    }
                } else {
                    echo "<h3 class='error-message'>L'adresse e-mail n'est pas valide.</h3>";
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

                    echo "<h3 class='success-message'>Vous vous êtes désabonné avec l'e-mail : $email</h3>";
                } else {
                    echo "<h3 class='error-message'>L'adresse e-mail n'est pas trouvée dans la liste d'abonnés.</h3>";
                }
            }
            ?>

            <div class="form-messages">
                <!-- Messages ici -->
            </div>

            <div class="content_home">
                <!-- Formulaire d'abonnement -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="email">Tenez-vous au courant et sauvez le monde :</label>
                    <input type="email"  placeholder="Adresse e-mail" name="email" required>
                    <br>
                    <input type="submit" name="subscribe" value="S'abonner">
                </form>

                <!-- Formulaire de désabonnement -->
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <label for="email">Détruire notre planète verte:</label>
                    <input type="email" placeholder="Adresse e-mail" name="email" required>
                    <br>
                    <input type="submit" name="unsubscribe" value="Se désabonner">
                </form>
            </div>
        </div>
    </div>
</body>

</html>
