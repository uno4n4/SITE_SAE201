<?php

include('config.php');
session_start();

if (!isset($_SESSION['utilisateur'])) {
  echo "Erreur : Utilisateur non connecté.";
  exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $Pseudo = $_POST['Pseudo'];
  $tables = ['inscription_eleve', 'inscription_prof', 'inscription_admin', 'inscription_agent'];
  $trouve = false;

  foreach ($tables as $table) {
    $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE Pseudo = ? OR Adresse_email = ?");
    $stmt->execute([$Pseudo, $Pseudo]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
      $trouve = true;
      $email = $user['Adresse_email'];
      $Pseudo = $user['Pseudo'];
      $mdp_temporaire = bin2hex(random_bytes(4));
      $mdp_hash = password_hash($mdp_temporaire, PASSWORD_DEFAULT);

      $update = $pdo->prepare("UPDATE `$table` SET Mdp = ? WHERE Pseudo = ? OR Adresse_email = ?");
      $update->execute([$mdp_hash, $Pseudo, $email]);

      $mail = new PHPMailer(true);

      try {
          $mail->isSMTP();
          $mail->Host = 'smtp.gmail.com';  
          $mail->SMTPAuth = true;
          $mail->Username = 'materiel.iut@gmail.com'; 
          $mail->Password = 'obmv hoac gbrw ftwz'; 
          $mail->SMTPSecure = 'tls';
          $mail->Port = 587;

          $mail->setFrom('materiel.iut@gmail.com', 'IUT Support');
          $mail->addAddress($email, $Pseudo);
          $mail->addReplyTo('materiel.iut@gmail.com', 'IUT Support'); // Ajout du Reply-To

          $mail->Subject = 'Réinitialisation de votre mot de passe';
          $mail->Body = "Bonjour $Pseudo,\n\nVoici votre mot de passe temporaire : $mdp_temporaire\n\nMerci de le changer dès votre connexion.\n\nCordialement,\nL'équipe IUT";

          if(!$mail->send()) {
              echo "Erreur d'envoi : " . $mail->ErrorInfo;
          } else {
              echo <<<HTML
        <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
          <b class="mb-2 d-block">MESSAGE ENVOYÉ AVEC SUCCÈS</b>
          <div class="text-center mt-3">
            <a href="mdp-oublie.php" class="btn btn-success">Fermer</a>
          </div>
        </div>
        HTML;
          }
      } catch (Exception $e) {
          echo "Une erreur est survenue lors de l'envoi de l'email. Erreur : {$mail->ErrorInfo}";
      }

      break;
    }
  }

  if (!$trouve) {
    echo <<<HTML
        <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
          <b class="mb-2 d-block">AUCUN COMPTE N'A ÉTÉ TROUVÉ SOUS CETTE ADRESSE EMAIL / PSEUDO</b>
          <div class="text-center mt-3">
            <a href="mdp-oublie.php" class="btn btn-danger">Fermer</a>
          </div>
        </div>
        HTML;
  }
}
?>









<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <title>Mot de passe oublié</title>
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="container-fluid px-0">
        <div class="d-flex align-items-center flex-nowrap px-3 py-2">
          <div class="me-auto">
            <img src="../IMAGE/logo-iut.png" class="img-fluid float-left" id="logo-iut-head" alt="Logo IUT">
          </div>
          <div class="d-flex flex-nowrap gap-2">
            <a href="authentification.php" class="btn border rounded text-white bouton-co"><i class="fa-solid fa-user me-2"></i>Connexion</a>
            <a href="inscription.php" class="btn border rounded text-white bouton-co">Créer un compte</a>
          </div>
        </div>
    </header> 

      <main class="d-flex flex-column justify-content-center align-items-center flex-fill text-center">
      <div class="container text-center">
        <div id="form-container" style="display: block;">
            <form class="form-inline form-style" action="mdp-oublie.php" method="post">
              <div class="form-group">
                <a href="authentification.php">
                    <button type="button" class="btn btn-sm mb-3">Revenir en arrière</button>
                </a>
              <h2>Mot de passe oublié : </h2>
              <label for="Pseudo">Pseudo ou Adresse email universitaire :</label>
              <div class="input-icon-e">
                <input type="text" class="form-control" id="Pseudo" name="Pseudo" placeholder="Ex : noob1234 ou clara.domingues@edu.univ-eiffel.fr" required>
                <i class="fa-solid fa-envelope icon-inside"></i>
              </div>
      
                <button type="submit" class="btn submit">Soumettre</button>
              </div>
            </form>
        </div>
      </div>
      </main>

      <footer class="container-fluid mt-5 text-white">
        <div class="row px-5">
          <div class="col-md-2 mt-5">
            <a class="navbar-brand" href="#">
              <img src="../IMAGE/logo-iut.png" alt="logo iut" id="logo-iut-foot">
            </a>
          </div>
        </div>
      
        <div class="row px-5 mt-4">
          <div class="col-12 d-flex flex-wrap gap-5">
            <!-- Bloc Informations -->
            <div>
              <div class="fw-bold mb-2">INFORMATIONS</div>
              <a href="#" class="text-white text-decoration-none d-block mb-1">Mentions légales</a>
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
    
</body>
</html>