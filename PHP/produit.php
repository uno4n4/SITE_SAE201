<?php

include('config.php');
session_start();
// Vérifie si la connexion fonctionne
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifie si l'ID du produit est bien passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour récupérer les détails du produit
    $sql = "SELECT * FROM materiel WHERE Nom = ?";

    // Prépare la requête
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $id); // Lie l'ID à la requête
        $stmt->execute(); // Exécute la requête

        // Récupère les résultats
        $result = $stmt->get_result();
        $produit = $result->fetch_assoc(); // Récupère les informations du produit

        // Si le produit n'existe pas
        if (!$produit) {
            echo "Produit introuvable.";
            exit;
        }
    } else {
        echo "Erreur dans la préparation de la requête.";
        exit;
    }
} else {
    echo "Aucun produit sélectionné.";
    exit;
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Bonheur+Royale&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Pixelify+Sans:wght@400..700&display=swap"
        rel="stylesheet">
    <title>Produit</title>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <link rel="stylesheet" type="text/css" href="../CSS/parcours-user.css">
    <script src="../JS/redirection.js" defer></script>
</head>

<body class="overflow-x-hidden">
    <section class="container-fluid px-0">
        <nav class="navbar navbar-expand">
            <div class="container-fluid px-3 d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="../PHP/accueil.php">
                    <img src="../IMG/logo-iut.png" class="img-fluid" alt="logo iut" id="logo-iut-head">
                </a>

                <div class="d-flex align-items-center gap-2" id="navbar-nav">
                    <ul class="navbar-nav gap-2 mb-2 mb-lg-0">
                        <li class="nav-item mt-3">
                            <a class="icon-link link-dark" href="../HTML/mesemprunts.html">
                                <img src="../IMG/boite.png" alt="boite mes emprunts">
                                <span class="spantext">Mes Emprunts</span>
                            </a>
                        </li>
                        <li class="nav-item mt-3 d-flex flex-column">
                            <a class="icon-link link-dark" href="../HTML/moncompte.html">
                                <img src="../IMG/avatar-de-lutilisateur.png" alt="boite mes emprunts">
                                <span class="spantext"><?= isset($_SESSION['utilisateur']) ? strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) : 'Utilisateur non connecté' ?></span>
                            </a>
                            <?php
                            // Si l'user fait partie de la table eleve on affiche etudiant(e) + pastille couleur dédié
                            $stmt = $conn->prepare("SELECT COUNT(*) as total FROM inscription_eleve WHERE nom = ?");
                            $stmt->bind_param("s", $_SESSION['utilisateur']['Nom']);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $row = $result->fetch_assoc();

                            if ($row['total'] > 0) {
                                echo '<span class="badge d-flex align-items-center gap-2 text-dark">
                                <span class="rounded-circle" style="width:10px;height:10px;background-color: #12A19A;"></span>
                                <span class="spantext">Etudiant(e)</span>
                            </span>';
                                // Si l'user fait partie de la table enseignant on affiche enseignant(e) + pastille couleur dédié
                            } else {
                                $stmt = $conn->prepare("SELECT COUNT(*) as total FROM inscription_prof WHERE nom = ?");
                                $stmt->bind_param("s", $_SESSION['utilisateur']['Nom']);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                $row = $result->fetch_assoc();

                                if ($row['total'] > 0) {
                                    echo '<span class="badge d-flex align-items-center gap-2 text-dark">
                                <span id="roleicon" class="rounded-circle" style="background-color: #8B1E3F;"></span>
                                <span class="spantext">Enseignant(e)</span>
                            </span>';
                                }
                            }
                            ?>

                        </li>
                    </ul>

                    <a class="btn btn-primary bouton-co" id="deconnexion" href="../index.html" role="button">Se déconnecter</a>
                </div>
            </div>
        </nav>

        <div class="container-fluid text-center mt-5">
            <div class="d-flex justify-content-center">
                <div class="col-sm-1 dropdown me-5">
                    <div class="dropdown">
                        <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <a class="icon-link link-dark" href="#">
                                <img src="../IMG/filtre.png" alt="boite mes emprunts">
                                Filtres
                            </a>
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item" type="button">Action</button></li>
                            <li><button class="dropdown-item" type="button">Another action</button></li>
                            <li><button class="dropdown-item" type="button">Something else here</button></li>
                        </ul>
                    </div>
                </div>

                <form class="d-flex" role="search">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-info" type="submit">Search</button>
                </form>
            </div>

            <div class="row">
                <div class="col-sm ms-5">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../PHP/accueil.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Produit</li>
                        </ol>
                    </nav>
                </div>
            </div>
    </section>

    <div class="container-fluid ms-5 me-5 mt-5">
        <div class="row">
            <h2><?= htmlspecialchars($produit['Nom']) ?></h2>
        </div>
        <div class="row">
            <div id="carouselExampleIndicators" class="col-sm-4 carousel slide">
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                        class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                        aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                        aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../IMG/images/<?= htmlspecialchars($produit['Image_un']) ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="../IMG/images/<?= htmlspecialchars($produit['Image_deux']) ?>" class="d-block w-100" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="../IMG/images/<?= htmlspecialchars($produit['Image_trois']) ?>" class="d-block w-100" alt="...">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="col-sm-7 ms-1 me-1">
                <div class="row">
                    <h3 id="nomproduit"><?= htmlspecialchars($produit['Nom']) ?></h3>
                    <p><?= htmlspecialchars($produit['Description_materiel']) ?></p>
                </div>

                <div class="row">
                    <div class="col-sm-5">
                        <div class="row ms-2">
                            <input type="number" class="form-control text-center" value="1" min="1" id="quantite">
                        </div>
                        <div class="row mt-2">
                            <input type="button" onclick="rediriger()" class="btn btn-info ms-2" value="RESERVER"
                                role="button"><!--REDIRECTION vers reservation.php-->
                        </div>
                    </div>
                    <div class="col-sm-4 ms-3 mt-4">
                        <span class="rounded bg-light d-flex align-items-center gap-2 text-dark">
                            <?php if (htmlspecialchars($produit['disponibilite']) == 1): ?>
                                <span class="ms-3 rounded-circle bg-success disponibilite"></span>
                                Disponible
                            <?php else: ?>
                                <span class="ms-3 rounded-circle bg-danger disponibilite"></span>
                                Indisponible
                            <?php endif; ?>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 me-2 mt-3">
                        <img class="rounded" src="../IMG/drone-video.gif" alt="drone video" width="100%">
                    </div>
                    <div class="col-sm-5 mt-3">
                        <img class="rounded" src="../IMG/drone-video.gif" alt="drone video" width="100%">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-50 border border-dark mt-5 rounded consignes-eleve ms-5">
        <h6 class="text-danger text-decoration-underline text-start p-3">Les consignes de sécurité : </h6>
        <div class="text-center">
        <?php
        
            $sql = "SELECT contenu FROM consigne WHERE id = 1";
            $result = $conn->query($sql);

            if ($result && $row = $result->fetch_assoc()) {
                echo $row['contenu'];  // Affiche le HTML enregistré
            } else {
                echo "<p>Aucune consigne disponible pour le moment.</p>";
            }
        ?>
        </div>

    </div>

    <div class="container-fluid mt-5">
        <div class="row ms-5">
            <div class="col-sm-4 fs-3 mt-5">
                Commentaires
            </div>
        </div>
        <?php
        $materielcomment = $produit['Nom'];
        $result = $conn->query("SELECT Pseudo, date_comment, commentaire, reaction FROM commentaires_eleve WHERE materiel = '$materielcomment' UNION SELECT Pseudo, date_comment, commentaire, reaction FROM commentaires_prof WHERE materiel = '$materielcomment';");
        $users = $result->fetch_all(MYSQLI_ASSOC);
        ?>
        <?php foreach ($users as $user): ?>
            <div id="com1" class="row ms-5">
                <div class="col-sm-10 mt-2 ms-5 border border-secondary rounded p-3">
                    <div class="row ms-5">
                        <div class="col-sm-1"><img src="../IMG/avatar-de-lutilisateur.png" alt="boite mes emprunts"></div>
                        <div class="col-sm-4"><?= htmlspecialchars($user['Pseudo']) ?></div>
                    </div>
                    <div class="row ms-5">
                        <div class="col-sm-2"><?= htmlspecialchars($user['reaction']) ?> ☆</div>
                        <div class="col-sm-2"><?= htmlspecialchars($user['date_comment']) ?></div>
                    </div>
                    <div class="row ms-2 mt-2">
                        <div class="col-sm-10"><?= htmlspecialchars($user['commentaire']) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

        <form action="#" method="post" class="mt-5 d-flex align-items-center ms-5">
            <textarea class="form-control me-3" id="exampleFormControlTextarea1" rows="1"
                name="commentaire" placeholder="Ecrire un commentaire" style="resize: none; width: 70%;"></textarea>
            <input type="number" name="reaction" value="5" min="1" max="5" style="width: 60px; margin-right: 5px;"> ☆
            <input type="submit" name="submit" class="btn btn-info ms-2" value="ENVOYER">
        </form>
    </div>

    <?php
        if (isset($_POST["submit"])) {
            $commentaire = htmlspecialchars($_POST['commentaire']) ?? '';
            $reaction = htmlspecialchars($_POST['reaction']) ?? '';

            if (!empty($commentaire) && !empty($reaction)) {
                if ($_SESSION['utilisateur']['Td']) {
                    //Preparer la requete
                    $stmt = $conn->prepare("INSERT INTO commentaires_eleve(Pseudo, date_comment, commentaire, reaction) 
    VALUES (?,DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i'),?,?)");
                    //Verifier si la preparation a echoue
                    if ($stmt === false) {
                        die("Erreur de preparation de la requete: " . $conn->error);
                    }

                    //Lier les paramètres a la requete
                    $stmt->bind_param("ssi", $_SESSION['utilisateur']['Pseudo'], $commentaire, $reaction);

                    //Executer la requete
                    $stmt->execute();

                    //Fermer la declaration et la connexion
                    $stmt->close();
                }else {
                    //Preparer la requete
                    $stmt = $conn->prepare("INSERT INTO commentaires_prof(Pseudo, date_comment, commentaire, reaction) 
    VALUES (?,NOW(),?,?)");
                    //Verifier si la preparation a echoue
                    if ($stmt === false) {
                        die("Erreur de preparation de la requete: " . $conn->error);
                    }

                    //Lier les paramètres a la requete
                    $stmt->bind_param("sssi", $_SESSION['utilisateur']['Pseudo'], $commentaire, $reaction);

                    //Executer la requete
                    $stmt->execute();

                    //Fermer la declaration et la connexion
                    $stmt->close();
                }
            }
        }
    ?>


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
                    <a href="../PHP/contact.php" class="text-white text-decoration-none d-block mb-1">Contact</a>
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