<?php 

include('config.php');

//ETUDIANT : 

if(isset($_POST['Nom']) && isset($_POST['Prenom'])){
  $Nom=$_POST['Nom'];
  $Prenom=$_POST['Prenom'];
  $Anniv=$_POST['Anniv'];
  $Email=$_POST['Email'];
  $Tel=$_POST['Tel'];
  $Adresse=$_POST['Adresse'];
  $Numetu=$_POST['Numetu'];
  $Formation =$_POST['Formations'];
  $TD=$_POST['TD'];
  $TP=$_POST['TP'];
  $Pseudo=$_POST['Pseudo'];
  $Mdp=password_hash($_POST['Mdp'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO inscription_eleve (nom, prenom, date_naissance, adresse_email, numero_tel, adresse, num_etudiant, formation, td, tp, pseudo, mdp, statut)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $Statut = "en attente";
  $stmt->bind_param("sssssssssssss", $Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Numetu, $Formation, $TD, $TP, $Pseudo, $Mdp, $Statut);

  if($stmt->execute()){
    echo "Inscription étudiant réussie !";
  } else {
    echo "Erreur : " . $stmt->error;
  }
  $stmt->close();
}

//PROF : 

elseif(isset($_POST['Nomprof']) && isset($_POST['Prenomprof'])) {
  $Nom=$_POST['Nomprof'];
  $Prenom=$_POST['Prenomprof'];
  $Anniv=$_POST['Annivprof'];
  $Email=$_POST['Emailprof'];
  $Tel=$_POST['Numprof'];
  $Adresse=$_POST['Adresseprof'];
  $Pseudo=$_POST['Pseudoprof'];
  $Mdp = password_hash($_POST['Mdpprof'], PASSWORD_DEFAULT);

  $sql = "INSERT INTO inscription_prof (nom, prenom, date_naissance, adresse_email, numero_tel, adresse, pseudo, mdp, statut)
          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $conn->prepare($sql);
  $Statut = "en attente";
  $stmt->bind_param("sssssssss", $Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Pseudo, $Mdp, $Statut);

  if ($stmt->execute()){
    echo "Inscription professeur réussie !";
  } else {
    echo "Erreur :" . $stmt->error;
  }
  $stmt->close();
} else {
  echo "Aucun formulaire valide soumis.";
}

$conn->close();

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