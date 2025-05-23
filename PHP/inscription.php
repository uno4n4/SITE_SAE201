<?php 

include('config.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

function pseudoExiste($pdo, $pseudo) {
    // Vérifie dans inscription_eleve
    $sql1 = "SELECT 1 FROM inscription_eleve WHERE pseudo = ?";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute([$pseudo]);
    $existeDansEleve = $stmt1->fetchColumn() !== false;

    // Vérifie dans inscription_prof
    $sql2 = "SELECT 1 FROM inscription_prof WHERE pseudo = ?";
    $stmt2 = $pdo->prepare($sql2);
    $stmt2->execute([$pseudo]);
    $existeDansProf = $stmt2->fetchColumn() !== false;

    return $existeDansEleve || $existeDansProf;
}

if (isset($_GET['Pseudo'])) {
    $pseudo = trim(strtolower($_GET['Pseudo']));

    if (pseudoExiste($pdo, $pseudo)) {
        echo "pris";
    } else {
        echo "dispo";
    }
    exit();
}

// ETUDIANT :
if (isset($_POST['Nom']) && isset($_POST['Prenom'])) {
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Anniv = $_POST['Anniv'];
    $Email = $_POST['Email'];
    $Tel = $_POST['Tel'];
    $Adresse = $_POST['Adresse'];
    $Numetu = $_POST['Numetu'];
    $Formation = $_POST['Formations'];
    $TD = $_POST['TD'];
    $TP = $_POST['TP'];
    $Pseudo = trim(strtolower($_POST['Pseudo']));
    $Mdp = password_hash($_POST['Mdp'], PASSWORD_DEFAULT);

    if (pseudoExiste($pdo, $Pseudo)) {
        exit;
    } else {
        $sql = "INSERT INTO inscription_eleve (nom, prenom, date_naissance, adresse_email, numero_tel, adresse, num_etudiant, formation, td, tp, pseudo, mdp, statut)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $Statut = "en attente";

        if ($stmt->execute([$Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Numetu, $Formation, $TD, $TP, $Pseudo, $Mdp, $Statut])) {

        $stmtUser = $pdo->prepare("SELECT * FROM inscription_eleve WHERE Nom = :Nom");
        $stmtUser->bindParam(':Nom', $Nom, PDO::PARAM_STR);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $email = $user['Adresse_email'];
            $Nom = $user['Nom'];

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
                $mail->setFrom('materiel.iut@gmail.com', 'IUT Support');
                $mail->addAddress($email, $Nom);
                $mail->addReplyTo('materiel.iut@gmail.com', 'IUT Support');

                $mail->Subject = 'Inscription réussie';
                $mail->Body = "Bonjour $Nom,\n\nNous avons bien reçu votre demande d'inscription. Merci et bienvenue ! \n Votre compte est actuellement en attente d'approbation par un administrateur. Dès qu'il sera validé, vous en serez informé et vous pourrez accéder à notre site et effectuer vos réservations librement.\nÀ très bientôt,\nL'équipe IUT";

                $mail->send();
            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
            }
        } else {
            echo "Utilisateur introuvable après mise à jour.";
        }
            echo <<<HTML
            <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
              <b class="mb-2 d-block">Inscription étudiant réussie !</b>
              <div class="text-center mt-3">
                <a href="inscription.php" class="btn btn-success">Fermer</a>
              </div>
            </div>
            HTML;
        } else {
            echo "Erreur : " . $stmt->errorInfo()[2];
        }
    }
}

// PROF :
elseif (isset($_POST['Nomprof']) && isset($_POST['Prenomprof'])) {
    $Nom = $_POST['Nomprof'];
    $Prenom = $_POST['Prenomprof'];
    $Anniv = $_POST['Annivprof'];
    $Email = $_POST['Emailprof'];
    $Tel = $_POST['Numprof'];
    $Adresse = $_POST['Adresseprof'];
    $Pseudo = trim(strtolower($_POST['Pseudoprof']));
    $Mdp = password_hash($_POST['Mdpprof'], PASSWORD_DEFAULT);

    if (pseudoExiste($pdo, $Pseudo)) {
        exit;
    } else {
        $sql = "INSERT INTO inscription_prof (nom, prenom, date_naissance, adresse_email, numero_tel, adresse, pseudo, mdp, statut)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $Statut = "en attente";

        if ($stmt->execute([$Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Pseudo, $Mdp, $Statut])) {

          $stmtUser = $pdo->prepare("SELECT * FROM inscription_prof WHERE Nom = :Nom");
        $stmtUser->bindParam(':Nom', $Nom, PDO::PARAM_STR);
        $stmtUser->execute();
        $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $email = $user['Adresse_email'];
            $Nom = $user['Nom'];

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
                $mail->setFrom('materiel.iut@gmail.com', 'IUT Support');
                $mail->addAddress($email, $Nom);
                $mail->addReplyTo('materiel.iut@gmail.com', 'IUT Support');

                $mail->Subject = 'Inscription réussie';
                $mail->Body = "Bonjour $Nom,\n\nNous avons bien reçu votre demande d'inscription. Merci et bienvenue ! \n Votre compte est actuellement en attente d'approbation par un administrateur. Dès qu'il sera validé, vous en serez informé et vous pourrez accéder à notre site et effectuer vos réservations librement.\nÀ très bientôt,\nL'équipe IUT";

                $mail->send();
            } catch (Exception $e) {
                echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
            }
        } else {
            echo "Utilisateur introuvable après mise à jour.";
        }
            echo <<<HTML
            <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
              <b class="mb-2 d-block">Inscription professeur réussie !</b>
              <div class="text-center mt-3">
                <a href="inscription.php" class="btn btn-success">Fermer</a>
              </div>
            </div>
            HTML;
        } else {
            echo "Erreur : " . $stmt->errorInfo()[2];
        }
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
    <script src="../JS/inscription.js" defer></script>
    <title>Inscription</title>
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="container-fluid px-0">
        <div class="d-flex align-items-center justify-content-between flex-nowrap px-3 py-2">
          <div class="me-auto">
            <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">
          </div>
          <div class="d-flex flex-nowrap gap-2">
            <a href="authentification.php" class="btn border rounded text-white bouton-co"><i class="fa-solid fa-user me-2"></i>Connexion</a>
          </div>
        </div>
    </header> 

    <main class="d-flex flex-column justify-content-center align-items-center flex-fill text-center">
      <div class="container-fluid">
        <h2>Choissisez votre statut : </h2>
        <button type="button" class="btn border rounded text-white bouton-choix" id="btn-etudiant">Je suis étudiant(e)</button>
        <button type="button" class="btn border rounded text-white bouton-choix" id="btn-prof">Je suis professeur(e)</button>
        <div id="form-container"></div>
      </div>
    </main>

    <footer class="container-fluid mt-5 text-white custom-bg">
      <img src="../IMAGE/logo-iut.png" id="logo-iut-foot" class="img-fluid float-left my-3" alt="logo iut">
    
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
            <a href="contact.php" class="text-white text-decoration-none d-block mb-1">Contact</a>
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