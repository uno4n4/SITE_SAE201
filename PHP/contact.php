<?php

include('config.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

// Vérification de la connexion utilisateur
if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

// Récupération de l'email de l'utilisateur connecté
$email_utilisateur = $_SESSION['utilisateur']['Adresse_email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation des champs
    if (empty($nom) || empty($email) || empty($message)) {
        echo "Erreur : Tous les champs sont obligatoires.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Erreur : Adresse email invalide.";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'materiel.iut@gmail.com';
        $mail->Password = 'obmv hoac gbrw ftwz';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';
        $mail->setFrom('materiel.iut@gmail.com', 'Site Réservation'); 
        $mail->addAddress('materiel.iut@gmail.com'); 
        $mail->addReplyTo($email, $nom); 

        $mail->Subject = 'Contact site réservation';
        $mail->Body = "Nom : $nom\nEmail : $email\n\nMessage :\n$message";

        if ($mail->send()) {
            $success = "Votre message a été envoyé avec succès.";
        } else {
            $error = "Erreur lors de l'envoi de votre message. Veuillez réessayer.";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Page de contact stylée avec Bootstrap">
    <title>Contact</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/parcours-user.css">
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
</head>

<body class="overflow-x-hidden">
    <section class="container-fluid px-0">
        <nav class="navbar navbar-expand">
            <div class="container-fluid px-3 d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="../PHP/accueil.php">
                    <img src="../IMG/logo-iut.png" class="img-fluid" alt="logo iut" id="logo-iut-head">
                </a>
            </div>
        </nav>
    </section>

    <a href="../index.html" class="btn border rounded text-white ms-3 mt-3 mb-3 bouton-co"><i class="fa-solid fa-arrow-left-long"></i> Retour en arrière</a>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Contactez-nous</h2>
                        <?php if (isset($error)) {
                            echo "<div class='alert alert-danger'>$error</div>";
                        } ?>
                        <?php if (isset($success)) {
                            echo "<div class='alert alert-success'>$success</div>";
                        } ?>

                        <form method="post">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" id="name" value="<?= strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Adresse email</label>
                                <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($_SESSION['utilisateur']['Adresse_email']) ?>" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea name="message" class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-info">Envoyer</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="container-fluid mt-5 text-white custom-bg">
        <div class="my-3">
            <img src="../IMAGE/logo-iut.png" id="logo-iut-foot" class="img-fluid float-left mt-3" alt="logo iut">
        </div>

        <div class="row px-5 mt-4">
            <div class="col-12 d-flex flex-wrap gap-5">
                <!-- Bloc Informations -->
                <div>
                    <div class="fw-bold mb-2">INFORMATIONS</div>
                    <a href="../HTML/mentions_legales.html" class="text-white text-decoration-none d-block mb-1">Mentions légales</a>
                </div>

                <!-- Bloc Contactez-nous -->
                <div>
                    <div class="fw-bold mb-2">CONTACTEZ-NOUS</div>
                    <a href="#" class="text-white text-decoration-none d-block mb-1">Contact</a>
                </div>
            </div>
        </div>

        <hr class="mt-5 border-white opacity-50">

        <div class="row px-5">
            <div class="col-12 text-center text-white mb-3">
                &copy; Samoura Diaba et Gilet Amel | Tous droits réservés.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>