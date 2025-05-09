<?php

include('config.php');
session_start();

if($_SERVER["REQUEST_METHOD"] === "POST"){
  $Pseudo = $_POST['Pseudo'];
  $Mdp = $_POST['Mdp'];
  $Mdp = $_POST['Mdp'];
  $tables = ['inscription_eleve', 'inscription_prof', 'inscription_admin', 'inscription_agent'];


  $trouve = false;

  foreach($tables as $table){
    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE pseudo = ? OR adresse_email = ?");
    $stmt->bind_param("ss", $Pseudo, $Pseudo);
    $stmt = $conn->prepare("SELECT * FROM `$table` WHERE pseudo = ? OR adresse_email = ?");
    $stmt->bind_param("ss", $Pseudo, $Pseudo);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if($user){
    if($user){
      $trouve = true;
      if($user["Statut"] === "refusé"){
        echo "Votre demande a été refusée.";
        break;
      } elseif($user["Statut"] === "en attente"){
        echo "Votre demande est en attente.";
        break;
      } elseif (!password_verify($Mdp, $user["Mdp"])){
        echo "Mot de passe incorrect.";
        break;
      } else {
        $_SESSION["utilisateur"] = $user;
        $_SESSION["table"] = $table;
        if($table === "inscription_prof"){
          header("Location: admin.php");
        } elseif($table === "inscription_eleve"){
          header("Location: admin.php");
        } elseif($table === "inscription_agent"){
          header("Location: agent.php");
        } else{
          header("Location: admin.php");
        } 
        exit();
      }
    }
    break;
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
    <title>Authentification</title>
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="container-fluid px-0">
        <div class="d-flex align-items-center justify-content-between flex-nowrap px-3 py-2">
          <div class="me-auto">
            <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">
          </div>
          <div class="d-flex flex-nowrap gap-2">
            <a href="inscription.php" class="btn border rounded text-white bouton-co">Créer un compte</a>
          </div>
        </div>
      </header>

      <main class="d-flex flex-column justify-content-center align-items-center flex-fill text-center">
      <div class="container text-center">
        <div id="form-container" style="display: block;">
            <form class="form-inline form-style" action="authentification.php" method="post">
              <div class="form-group">
              <h2>Connexion : </h2>
              <label for="Pseudo">Pseudo ou Adresse email universitaire :</label>
              <div class="input-icon-e">
                <input type="text" class="form-control" id="Pseudo" name="Pseudo" placeholder="Ex : noob1234 ou clara.domingues@edu.univ-eiffel.fr" required>
                <i class="fa-solid fa-envelope icon-inside"></i>
              </div>
              
      
                <label for="Mdp">Mot de passe :</label>
                <input type="password" id="Mdp" name="Mdp" class="form-control" required><br>
      
                <button type="submit" class="btn submit">Soumettre</button>
                <button type="button" class="btn mdp">Mot de passe oublié ?</button>
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