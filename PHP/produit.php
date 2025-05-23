<?php

include('config.php');
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

// Vérifie si la connexion fonctionne
if (!$pdo) {
    die("Connexion échouée.");
}

// Vérifie si l'ID du produit est bien passé dans l'URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Requête pour récupérer les détails du produit
    $sql = "SELECT * FROM materiel WHERE Nom = :nom";

    // Prépare la requête
    $stmt = $pdo->prepare($sql);
    if ($stmt) {
        $stmt->execute([':nom' => $id]);

        // Récupère les résultats
        $produit = $stmt->fetch(PDO::FETCH_ASSOC);

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
                            <a class="icon-link link-dark" href="mesemprunts.php">
                                <img src="../IMG/boite.png" alt="boite mes emprunts">
                                <span class="spantext">Mes Emprunts</span>
                            </a>
                        </li>
                        <li class="nav-item mt-3 d-flex flex-column">
                            <a class="icon-link link-dark" href="moncompte.php">
                                <img src="../IMG/avatar-de-lutilisateur.png" alt="boite mes emprunts">
                                <span class="spantext"><?= isset($_SESSION['utilisateur']) ? strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) : 'Utilisateur non connecté' ?></span>
                            </a>
                            <?php
                            // Si l'user fait partie de la table eleve on affiche etudiant(e) + pastille couleur dédié
                            $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_eleve WHERE nom = :nom");
                            $stmt->execute([':nom' => $_SESSION['utilisateur']['Nom']]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($row['total'] > 0) {
                                echo '<span class="badge d-flex align-items-center gap-2 text-dark">
        <span class="rounded-circle" style="width:10px;height:10px;background-color: #12A19A;"></span>
        <span class="spantext">Etudiant(e)</span>
    </span>';
                                // Si l'user fait partie de la table enseignant on affiche enseignant(e) + pastille couleur dédié
                            } else {
                                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_prof WHERE nom = :nom");
                                $stmt->execute([':nom' => $_SESSION['utilisateur']['Nom']]);
                                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                if ($row['total'] > 0) {
                                    echo '<span class="badge d-flex align-items-center gap-2 text-dark">
            <span class="rounded-circle" style="width:10px;height:10px;background-color: #8B1E3F;"></span>
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
                                role="button"<?php if ($produit['disponibilite'] == 0) echo 'disabled'; ?>><!--REDIRECTION vers reservation.php-->
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
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                echo $row['contenu'];  // Affiche le HTML enregistré
            } else {
                echo "<p>Aucune consigne disponible pour le moment.</p>";
            }
            ?>

        </div>

    </div>

    <div class="container-fluid my-5">
        <div class="row ms-5">
            <div class="col-sm-4 fs-3 mt-5">
                Commentaires
            </div>
        </div>
        <?php
        $materielcomment = $produit['Nom'];

        // Préparation de la requête avec UNION
        $sql = "SELECT Pseudo, date_comment, commentaire, reaction FROM commentaires_eleve WHERE materiel = :materiel
        UNION 
        SELECT Pseudo, date_comment, commentaire, reaction FROM commentaires_prof WHERE materiel = :materiel";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':materiel', $materielcomment, PDO::PARAM_STR);
        $stmt->execute();

        // Récupération des résultats
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

        <form action="#" method="post" class="my-5 d-flex align-items-center ms-5">
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
                // Préparer la requête pour les élèves
                $sql = "INSERT INTO commentaires_eleve(Pseudo, date_comment, commentaire, reaction) 
                    VALUES (:pseudo, DATE_FORMAT(NOW(), '%Y-%m-%d %H:%i'), :commentaire, :reaction)";
                $stmt = $pdo->prepare($sql);

                // Vérifier si la préparation a échoué
                if ($stmt === false) {
                    die("Erreur de préparation de la requête: " . $pdo->errorInfo());
                }

                // Lier les paramètres à la requête
                $stmt->bindParam(':pseudo', $_SESSION['utilisateur']['Pseudo'], PDO::PARAM_STR);
                $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
                $stmt->bindParam(':reaction', $reaction, PDO::PARAM_STR);

                // Exécuter la requête
                $stmt->execute();
            } else {
                // Préparer la requête pour les professeurs
                $sql = "INSERT INTO commentaires_prof(Pseudo, date_comment, commentaire, reaction) 
                    VALUES (:pseudo, NOW(), :commentaire, :reaction)";
                $stmt = $pdo->prepare($sql);

                // Vérifier si la préparation a échoué
                if ($stmt === false) {
                    die("Erreur de préparation de la requête: " . $conn->errorInfo());
                }

                // Lier les paramètres à la requête
                $stmt->bindParam(':pseudo', $_SESSION['utilisateur']['Pseudo'], PDO::PARAM_STR);
                $stmt->bindParam(':commentaire', $commentaire, PDO::PARAM_STR);
                $stmt->bindParam(':reaction', $reaction, PDO::PARAM_STR);

                // Exécuter la requête
                $stmt->execute();
            }
        }
    }
    ?>




</body>

</html>