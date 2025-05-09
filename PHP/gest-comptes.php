<?php 

include 'config.php';
session_start();


$tables = ['inscription_eleve', 'inscription_prof', 'inscription_agent', 'inscription_admin'];

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
    <title>Gestion des comptes</title>
</head>
<body>

<header class="container-fluid px-0">
    <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100">
      <div>
        <img src="../IMAGE/logo-iut.png" alt="Logo IUT" style="width: auto; height: 45px;">
      </div>
      <div class="d-flex align-items-center ms-auto gap-2">
        <h6 class="mb-0 text-nowrap text-end">
          <?= isset($_SESSION['utilisateur']) ? strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) : 'Utilisateur non connecté' ?>
        </h6>
        <img class="card-img-top img-card" src="../IMAGE/logo-iut.png" alt="Image de profil carte" id="img-profil">
      </div>
    </div>
</header>


    
      <div class="container-fluid">
        <div class="row flex-nowrap">
          <!-- Sidebar -->
          <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 d-flex flex-column min-vh-100">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white flex-grow-1">
              <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start">
      
                <li class="nav-item">
                  <a href="admin.php" class="nav-link align-middle px-0">
                    <i class="fa-solid fa-house"></i><span class="ms-1 d-none d-sm-inline">Tableau de bord</span>
                  </a>
                </li>
      
                <li>
                  <a href="../HTML/reservation.html" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                    <i class="fa-solid fa-calendar-days"></i><span class="ms-1 d-none d-sm-inline">Gestion des réservations</span>
                  </a>
                </li>
      
                <li>
                  <a href="../HTML/gest-comptes.html" class="nav-link px-0 align-middle">
                    <i class="fa-solid fa-users"></i><span class="ms-1 d-none d-sm-inline">Gestion des comptes</span>
                  </a>
                </li>
      
                <li>
                  <a href="../HTML/materiel.html" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                    <i class="fa-solid fa-camera"></i><span class="ms-1 d-none d-sm-inline">Gestion du matériel</span>
                  </a>
                </li>
      
                <li>
                  <a href="../HTML/statistiques.html" data-bs-toggle="collapse" class="nav-link px-0 align-middle">
                    <i class="fa-solid fa-chart-simple"></i><span class="ms-1 d-none d-sm-inline">Statistiques</span>
                  </a>
                </li>
      
                <li>
                  <a href="../HTML/consignes.html" class="nav-link px-0 align-middle">
                    <i class="fa-solid fa-file-pen"></i><span class="ms-1 d-none d-sm-inline">Consigne de sécurité</span>
                  </a>
                </li>
              </ul>
                <div class="mt-auto w-100">
                  <a href="setting.php" class="nav-link align-middle px-0">
                    <i class="fa-solid fa-cogs"></i><span class="ms-1 d-none d-sm-inline">Réglages</span>
                  </a>
                </div>
            </div>
          </div>
          <!--APPRO-->
          <div class="container">
            <div class="row">
              <div class="col-md-9 py-3 custom-bg1">
                <div class="d-flex flex-column align-items-start gap-3">
                  <div class="d-flex flex-column gap-2 align-items-start">
                    <div class="d-flex justify-content-between align-items-center gap-5">
                      <h2>Approbation des comptes</h2>
                      <h6>
                      <?php 
                      $total = 0;
                      foreach($tables as $table){
                        $query = "SELECT COUNT(*) as count FROM `$table` WHERE statut = 'en attente'";
                        $result = $conn->query($query);
                        if($result){
                          $row = $result->fetch_assoc();
                          $total += (int)$row['count'];
                        }
                      }
                      echo $total . " compte(s) en attente";
                      ?>
<<<<<<< HEAD
=======
                      </h6>
<<<<<<< HEAD
                      <h6 id="nom-prenom"> <?= htmlspecialchars($_SESSION['nom']) . ' ' . htmlspecialchars($_SESSION['prenom']) ?><h6>
                      <img class="card-img-top img-card" src="../IMAGE/logo-iut.png" alt="Image de profil carte" id="img-profil">
=======
>>>>>>> b3b0474763c5d010e403160fac3e4820ffbd15d1
>>>>>>> ff037e5db5cb6cbd0a139902f5a5b8cbac2abc33
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-2">
                      <!-- Partie gauche : Filtrer par -->
                      <div class="d-flex align-items-center mb-3 mb-md-0">
                      <label for="filtre" class="me-3">Filtrer par :</label>
                  
                      <select class="custom-select">
                        <option selected>Profil</option>
                        <option value="Etu">Étudiant</option>
                        <option value="Prof">Professeur</option>
                      </select>
                  
                      <select class="custom-select">
                        <option selected>Classes</option>
                        <option value="MMI1">MMI 1</option>
                        <option value="MMI2">MMI 2</option>
                        <option value="MMI3">MMI 3</option>
                      </select>
                  
                      <select class="custom-select">
                        <option selected>TP</option>
                        <option value="TPA">TP A</option>
                        <option value="TPB">TP B</option>
                        <option value="TPC">TP C</option>
                      </select>
                  
                      <button type="submit" class="btn btn-custom mx-5">Confirmer</button>
                    </div>
                  
                    <div class="d-flex align-items-center">
                      <!-- Texte cwsv -->
                      <div class="selection me-3 mx-3">cwsv</div>
                    </div>
                  </div>
                  
                  <div class="d-flex flex-wrap justify-content-center gap-4">
                      <!-- Carte 1 -->
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> ff037e5db5cb6cbd0a139902f5a5b8cbac2abc33
                    <?php foreach($tables as $table): ?>
                      <?php 
                        $result = $conn->query("SELECT * FROM `$table` WHERE statut = 'en attente'");
                        while ($user = $result->fetch_assoc()):
                      ?>
                        <div class="card-wrapper">
                          <form action="gest-comptes.php" method="post">
                            <div class="card custom-card">
                              <div class="card-top">
                                <div class="input-group mx-3 mt-2">
                                  <div class="input-group-prepend">
                                    <input type="radio">
                                  </div>
                                </div>
                              </div> 
                              <img class="card-img-top img-card" src="../IMAGE/logo-iut.png" alt="Image de profil carte" id="img-profil">
                              <h6 class="text-center mt-2" id="nom-prenom"><?= strtoupper(htmlspecialchars($user['Nom'])) . '  ' . htmlspecialchars($user['Prenom']) ?></h6>
                              <p class="text-center" id="classe">
                                <?= isset($user['Formation']) ? htmlspecialchars($user['Formation']) . ' ' : '' ?>
                                <?= isset($user['Td']) ? htmlspecialchars($user['Td']) . ' ' : '' ?>
                                <?= isset($user['Tp']) ? htmlspecialchars($user['Tp']) : '' ?>
                              </p>
                              <div class="card-body">
                                <hr class="me-2">
                                <div class="d-flex justify-content-between gap-4">
                                  <input type="hidden" name="Nom"  value="<?= htmlspecialchars($user['Nom']) ?>">
                                  <button class="card-link text-light border-0 rounded btn-acces mb-2 me-2" id="accepter1" name="accepter1">
                                    <i class="fa-solid fa-circle-check"></i>
                                  </button>
                                  <?php 
                                    if (isset($_POST["accepter1"])){
                                      $Nom = $_POST["Nom"];
                                      $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'accepté' WHERE Nom = ?");
                                      $stmt->bind_param("s", $Nom);
                                      $stmt->execute();
                                    }
                                  ?>
                                  <button class="card-link text-light border-0 rounded btn-acces mb-2 me-2" id="refuser1" name="refuser1">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                  </button>
                                  <?php 
                                    if (isset($_POST["refuser1"])){
                                      $Nom = $_POST["Nom"];
                                      $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'refusé' WHERE Nom = ?");
                                      $stmt->bind_param("s", $Nom);
                                      $stmt->execute();
                                    }
                                  ?>
                                </div>
<<<<<<< HEAD
                              </div>
                            </div>
                          </form>
                        </div>
                      <?php endwhile; ?>
                    <?php endforeach; ?>
                  </div>
    
                  <div class="pagination-wrapper d-flex justify-content-end align-items-center gap-3 mt-auto w-100 custom-page">
                    <a href="#" class="button-class" id="avant-page"><i class="fa-solid fa-arrow-left"></i>Précédent</a>
                    <p id="nb-pages"></p>
                    <a href="#" class="button-class" id="autre-page">Suivant <i class="fa-solid fa-arrow-right"></i></a>
                  </div>

=======
                              </div>
                            </div>
                          </form>
                        </div>
                      <?php endwhile; ?>
                    <?php endforeach; ?>
                  </div>
    
                  <div class="pagination-wrapper d-flex justify-content-end align-items-center gap-3 mt-auto w-100 custom-page">
                    <a href="#" class="button-class" id="avant-page"><i class="fa-solid fa-arrow-left"></i>Précédent</a>
                    <p id="nb-pages"></p>
                    <a href="#" class="button-class" id="autre-page">Suivant <i class="fa-solid fa-arrow-right"></i></a>
=======
                      <?php foreach($tables as $table): ?>
                        <?php 
                          $result = $conn->query("SELECT * FROM `$table` WHERE statut = 'en attente'");
                          while ($user = $result->fetch_assoc()):
                        ?>
                      <div class="col-12 col-md-3 mb-4 d-flex justify-content-center">
                        <form action="gest-comptes.php" method="post">
                          <div class="card custom-card">
                            <div class="card-top">
                              <div class="input-group mx-3 mt-2">
                                <div class="input-group-prepend">
                                  <input type="radio">
                                </div>
                              </div>
                            </div> 
                            <img class="card-img-top img-card" src="../IMAGE/logo-iut.png" alt="Image de profil carte" id="img-profil">
                            <h6 class="text-center mt-2" id="nom-prenom"><?= strtoupper(htmlspecialchars($user['Nom'])) . '  ' . htmlspecialchars($user['Prenom']) ?></h6>
                            <p class="text-center" id="classe">
                              <?= isset($user['Formation']) ? htmlspecialchars($user['Formation']) . ' ' : '' ?>
                              <?= isset($user['Td']) ? htmlspecialchars($user['Td']) . ' ' : '' ?>
                              <?= isset($user['Tp']) ? htmlspecialchars($user['Tp']) : '' ?>
                            </p>
                            <div class="card-body">
                              <hr class="me-2">
                              <div class="d-flex justify-content-between gap-4">
                                <input type="hidden" name="Nom"  value="<?= htmlspecialchars($user['Nom']) ?>">
                                <button class="card-link text-light border-0 rounded btn-acces mb-2 me-2" id="accepter1" name="accepter1">
                                  <i class="fa-solid fa-circle-check"></i>
                                </button>
                                <?php 
                                  if (isset($_POST["accepter1"])){
                                    $Nom = $_POST["Nom"];
                                    $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'accepté' WHERE Nom = ?");
                                    $stmt->bind_param("s", $Nom);
                                    $stmt->execute();
                                  }
                                ?>
                                <button class="card-link text-light border-0 rounded btn-acces mb-2 me-2" id="refuser1" name="refuser1">
                                  <i class="fa-solid fa-circle-xmark"></i>
                                </button>
                                <?php 
                                  if (isset($_POST["refuser1"])){
                                   $Nom = $_POST["Nom"];
                                   $stmt = $conn->prepare("UPDATE `$table` SET Statut = 'refusé' WHERE Nom = ?");
                                    $stmt->bind_param("s", $Nom);
                                    $stmt->execute();
                                  }
                                ?>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                    <?php endwhile; ?>
                  <?php endforeach; ?>
                </div>
              </div>
    
                    <div class="pagination-wrapper d-flex justify-content-end align-items-center gap-3 mt-auto w-100 custom-page">
                      <a href="#" class="button-class" id="avant-page"><i class="fa-solid fa-arrow-left"></i>Précédent</a>
                      <p id="nb-pages"></p>
                      <a href="#" class="button-class" id="autre-page">Suivant <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
>>>>>>> b3b0474763c5d010e403160fac3e4820ffbd15d1
                  </div>

<<<<<<< HEAD
>>>>>>> ff037e5db5cb6cbd0a139902f5a5b8cbac2abc33
                  <!-- GESTION DES COMPTES -->
                  <div class="mt-5 d-flex justify-content-between align-items-center gap-5">
                    <h2>Gestions des comptes</h2>
                    <h6>
                      <?php 
                        $total = 0;
                        foreach($tables as $table){
                          $query = "SELECT COUNT(*) as count FROM `$table` WHERE statut = 'accepté'";
                          $result = $conn->query($query);
                          if($result){
                            $row = $result->fetch_assoc();
                            $total += (int)$row['count'];
                          }
                        }  
                        echo $total . " comptes accepté";
                      ?>
                    </h6>
                  </div>
                  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-2">
<<<<<<< HEAD
=======
=======
            <!-- GESTION DES COMPTES -->
           <div class="container">
            <div class="row mt-4">
              <div class="col-md-9 py-3 custom-bg1 d-flex justify-content-lg-start">
                <div class="d-flex flex-column flex-lg-column align-items-start gap-3">
                  <div class="d-flex flex-column gap-2 align-items-start">
                    <div class="d-flex justify-content-between align-items-center gap-5">
                      <h2>Gestions des comptes</h2>
                      <h6>
                      <?php 
                      $total = 0;
                      foreach($tables as $table){
                        $query = "SELECT COUNT(*) as count FROM `$table` WHERE statut = 'accepté'";
                        $result = $conn->query($query);
                        if($result){
                          $row = $result->fetch_assoc();
                          $total += (int)$row['count'];
                        }
                      }
                      echo $total . " comptes accepté";
                      ?>
                      </h6>
                    </div>
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-2">
>>>>>>> b3b0474763c5d010e403160fac3e4820ffbd15d1
>>>>>>> ff037e5db5cb6cbd0a139902f5a5b8cbac2abc33
                    <!-- Partie gauche : Filtrer par -->
                    <form method="get" action="gest-comptes.php">
                      <div class="d-flex align-items-center mb-3 mb-md-0">
                        <label for="filtre" class="me-3">Filtrer par :</label>
                  
                        <select class="custom-select" name="profil">
                          <option selected>Profil</option>
                          <option value="Etu">Étudiant</option>
                          <option value="Prof">Professeur</option>
                        </select>
                  
                        <select class="custom-select" name="classe">
                          <option selected>Classes</option>
                          <option value="MMI1">MMI 1</option>
                          <option value="MMI2">MMI 2</option>
                          <option value="MMI3">MMI 3</option>
                        </select>
                  
                        <select class="custom-select" name="tp">
                          <option selected>TP</option>
                          <option value="TPA">TP A</option>
                          <option value="TPB">TP B</option>
                          <option value="TPC">TP C</option>
                        </select>
                  
                        <input type="submit" class="btn btn-custom mx-5" value="Confirmer"></input>
                      </div>
                    </form>
                  
                    <!-- Partie droite : cwsv et ajouter un compte -->
                    <div class="d-flex align-items-center">
                      <!-- Texte cwsv -->
                      <div class="selection me-3 mx-3">cwsv</div>
                        <!-- Ligne verticale -->
                        <div class="ligne-verticale d-none d-md-block mx-3"></div>
                          <!-- Bouton Ajouter un compte -->
                          <a href="ajout-compte.php" id="ajouter" class="btn border rounded bg-white p-2">+ Ajouter un compte</a>
                        </div>
                      </div>
                  
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> ff037e5db5cb6cbd0a139902f5a5b8cbac2abc33
                      <div class="d-flex flex-wrap justify-content-center gap-4">
                        <?php 
                        $profil = isset($_GET['profil']) ? $_GET['profil'] : '';
                        $classe = isset($_GET['formation']) ? $_GET['formation'] : '';
                        $tp = isset($_GET['tp']) ? $_GET['tp'] : '';

                        $sql = "SELECT * FROM `$table` WHERE statut = 'accepté'";

                        $conditions = [];

                        foreach($tables as $table):

                        if ($profil != '' && in_array($profil, ['Etu', 'Prof'])){
                          $conditions[] = "profil = '$profil'";
                        } else {
                          $sql = "SELECT * FROM `$table` WHERE statut = 'accepté'";
                        }?>
                          <?php 
                            $result = $conn->query("SELECT * FROM `$table` WHERE statut = 'accepté'");
                            while ($user = $result->fetch_assoc()):
                          ?>
                            <div class="card-wrapper">
                              <form action="gest-comptes.php" method="post">
                                <div class="card custom-card">
                                  <div class="card-top">
                                    <div class="input-group mx-3 mt-2">
                                      <div class="input-group-prepend">
                                        <input type="radio">
                                      </div>
                                    </div>
                                  </div>
                                  <img class="card-img-top img-card" src="../IMAGE/logo-iut.png" alt="Image de profil carte" id="img-profil">
                                  <h6 class="text-center mt-2" id="nom-prenom"><?= strtoupper(htmlspecialchars($user['Nom'])) . '  ' . htmlspecialchars($user['Prenom']) ?></h6>
                                  <p class="text-center" id="classe">
                                    <?= isset($user['Formation']) ? htmlspecialchars($user['Formation']) . ' ' : '' ?>
                                    <?= isset($user['Td']) ? htmlspecialchars($user['Td']) . ' ' : '' ?>
                                    <?= isset($user['Tp']) ? htmlspecialchars($user['Tp']) : '' ?>
                                  </p>
                                  <div class="card-body">
                                    <div class="d-flex justify-content-between gap-4">
                                      <p id="derniere-reservation">Dernière réservation</p>
                                      <p id="date-reser">11/05/2025</p>
                                    </div>
                                    <p class="text-left card-text"> <strong>Email : </strong> <?= htmlspecialchars($user['Adresse_email']) ?></p>
                                    <p class="text-left card-text"> <strong>Numéro de téléphone : </strong> <?= htmlspecialchars($user['Numero_tel']) ?></p>
                                    <p class="text-left card-text"> <strong>Pseudo : </strong> <?= htmlspecialchars($user['Pseudo']) ?></p>
                                    <p class="text-left card-text"> 
                                      <?php if ($table === 'inscription_eleve'): ?>
                                        <strong>Numéro étudiant :</strong> <?= htmlspecialchars($user['Num_etudiant'] ?? '') ?>
                                      <?php endif; ?>
                                    </p>
                                  </div>
<<<<<<< HEAD
                                </div>
                              </form>
                            </div>
                          <?php endwhile; ?>
                        <?php endforeach; ?>
=======
                                </div>
                              </form>
                            </div>
                          <?php endwhile; ?>
                        <?php endforeach; ?>
=======
                    <div class="container">
                      <div class="row">
                      <?php foreach($tables as $table): ?>
                        <?php 
                          $result = $conn->query("SELECT * FROM `$table` WHERE statut = 'accepté'");
                          while ($user = $result->fetch_assoc()):
                        ?>
                        <div class="col-12 col-md-3 mb-4 d-flex justify-content-center">
                          <form action="gest-comptes.php" method="post">
                            <div class="card custom-card">
                              <div class="card-top">
                                <div class="input-group mx-3 mt-2">
                                  <div class="input-group-prepend">
                                    <input type="radio">
                                  </div>
                                </div>
                              </div>
                              <img class="card-img-top img-card" src="../IMAGE/logo-iut.png" alt="Image de profil carte" id="img-profil">
                              <h6 class="text-center mt-2" id="nom-prenom"><?= strtoupper(htmlspecialchars($user['Nom'])) . '  ' . htmlspecialchars($user['Prenom']) ?></h6>
                              <p class="text-center" id="classe">
                                <?= isset($user['Formation']) ? htmlspecialchars($user['Formation']) . ' ' : '' ?>
                                <?= isset($user['Td']) ? htmlspecialchars($user['Td']) . ' ' : '' ?>
                                <?= isset($user['Tp']) ? htmlspecialchars($user['Tp']) : '' ?>
                              </p>
                              <div class="card-body custom-body">
                                <div class="d-flex justify-content-between gap-4">
                                  <p id="derniere-reservation">Dernière réservation</p>
                                  <p id="date-reser">11/05/2025</p>
                                </div>
                                <p class="text-center" id="email"></p>
                                <p class="text-center" id="num-etudiant"></p>
                                <p class="text-center" id="num-tel"></p>
                                <p class="text-center" id="pseudo"></p>
                              </div>
                            </div>
                          </form>
                        </div>
                      <?php endwhile; ?>
                      <?php endforeach; ?>
>>>>>>> b3b0474763c5d010e403160fac3e4820ffbd15d1
>>>>>>> ff037e5db5cb6cbd0a139902f5a5b8cbac2abc33
                      </div>
    
                      <div class="pagination-wrapper d-flex justify-content-end align-items-center gap-3 mt-auto w-100 custom-page">
                        <a href="#" class="button-class" id="avant-page"><i class="fa-solid fa-arrow-left"></i>Précédent</a>
                        <p id="nb-pages"></p>
                        <a href="#" class="button-class" id="autre-page">Suivant <i class="fa-solid fa-arrow-right"></i></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

    
</body>
</html>