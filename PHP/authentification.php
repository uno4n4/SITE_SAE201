<?php
session_start();

$host="localhost";
$user="root";
$pass="";
$db="utilisateur";
$conn=new mysqli($host, $user, $pass, $db);

if ($conn->connect_error){
  die("Echec de la connexon :" . $conn->connect_error);
}

if($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['Pseudo'], $_POST['Mdp'])){
  $Pseudo = $_POST['Pseudo'];
  $Mdp = $_POST['Mdp'];

  $utilisateurs = [
    'inscription_admin' => 'admin.php',
    'inscription_agent' => 'agent.html',
    'inscription_prof' => 'accueil.php',
    'inscription_eleve' => 'accueil.php',
  ];

foreach($utilisateurs as $table => $redirect){
  $sql = "SELECT * FROM $table WHERE (adresse_email = ? OR pseudo = ?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("ss", $Pseudo, $Pseudo);
  $stmt->execute();
  $result = $stmt->get_result();

  if($result && $result->num_rows > 0){
    $user = $result->fetch_assoc();
    if(password_verify($Mdp, $user['Mdp'])){
      $_SESSION['user'] = $user;
      header("Location: $redirect");
      exit();
    } else {
      echo "Identifiants incorrects.";
      exit();
    }
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
    <title>Authentification</title>
</head>
<body class="d-flex flex-column min-vh-100">

    <header class="container-fluid px-0">
        <div class="d-flex align-items-center justify-content-between flex-nowrap px-3 py-2">
          <div class="me-auto">
            <img src="../IMAGE/logo-iut.png" id="logo-iut-head" alt="Logo IUT">
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
              <label for="Pseudo">Adresse email universitaire ou pseudo :</label>
              <div class="input-icon-e">
                <input type="text" class="form-control" id="Pseudo" name="Pseudo" placeholder="Ex : clara.domingues@edu.univ-eiffel.fr ou noob1234" required>
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