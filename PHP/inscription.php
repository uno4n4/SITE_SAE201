<?php 

$host="localhost";
$user="root";
$pass="";
$db="utilisateur";
$conn=new mysqli($host, $user, $pass, $db);

if(isset($_POST['form-container'])){
  $Nom_eleve=$_POST['Nom'];
  $Prenom_eleve=$_POST['Prenom'];
  $Date=$_POST['Anniv'];
  $Adresse_email_eleve=$_POST['Email'];
  $Num_eleve=$_POST['Tel'];
  $Adresse_postale_eleve=$_POST['Adresse'];
  $Num_etu=$_POST['Numetu'];
  $Pseudo_eleve=$_POST['Pseudo'];
  $Mdp_eleve=$_POST['Mdp'];
  
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
            <img src="../IMAGE/logo-iut.png" id="logo-iut-head" alt="Logo IUT">
          </div>
          <div class="d-flex flex-nowrap gap-2">
            <a href="./authentification.html" class="btn border rounded text-white bouton-co"><i class="fa-solid fa-user me-2"></i>Connexion</a>
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