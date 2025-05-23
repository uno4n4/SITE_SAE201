<?php

include 'config.php';

session_start();

$materiaux = []; // on initialise

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

if (isset($_POST['search'])) {
    $motcle = '%' . $_POST['motcle'] . '%';

    $stmt = $pdo->prepare("SELECT * FROM materiel WHERE nom LIKE ? OR categorie LIKE ? OR Description_materiel LIKE ?");
    $stmt->execute([$motcle, $motcle, $motcle]);

    $materiaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->query("SELECT * FROM materiel");
    $materiaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>


<!DOCTYPE html>
<html lang="en">

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
    <script src="../JS/reserve.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <link rel="stylesheet" type="text/css" href="../CSS/parcours-user.css">
    <title>Accueil</title>
</head>

<body class="overflow-x-hidden">
    <section class="container-fluid px-0">
        <nav class="navbar navbar-expand">
            <div class="container-fluid px-3 d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="../PHP/accueil_admin.php">
                    <img src="../IMG/logo-iut.png" class="img-fluid" alt="logo iut" id="logo-iut-head">
                </a>

                <div class="d-flex align-items-center gap-2" id="navbar-nav">
                    <ul class="navbar-nav gap-2 mb-2 mb-lg-0">
                        <li class="nav-item mt-3 d-flex flex-column">
                            <a class="icon-link link-dark" href="admin.php">
                                <img src="../IMG/avatar-de-lutilisateur.png" alt="boite mes emprunts">
                                <span class="spantext"><?= isset($_SESSION['utilisateur']) ? strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) : 'Utilisateur non connecté' ?></span>
                            </a>
                            <?php
                            echo '<span class="badge d-flex align-items-center gap-2 text-dark">
        <span class="rounded-circle" style="width:10px;height:10px;background-color: #2F2A85;"></span>
        <span class="spantext">Admin</span>
    </span>';
                            ?>

                        </li>
                    </ul>

                    <a class="btn btn-primary bouton-co" id="deconnexion" href="logout.php" role="button">Se déconnecter</a>
                </div>
            </div>
        </nav>
        <img src="../IMAGE/iut-meaux.jpg" class="container-fluid img-fluid" style="max-height:400px;" alt="iut meaux">

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
                            <li><button class="dropdown-item" type="button">Matériel</button></li>
                            <li><button class="dropdown-item" type="button">Caméra</button></li>
                            <li><button class="dropdown-item" type="button">Salle</button></li>
                        </ul>
                    </div>
                </div>

                <form method="post" class="d-flex" role="search">
                    <input class="form-control me-2" type="search" name="motcle" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-info" name="search" type="submit">Search</button>
                </form>

            </div>

            <div class="row">
                <div class="col-sm-3 ms-5">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
    </section>

    <section class="container-fluid ms-2">
        <div class="row mt-5 gx-2">
            <?php foreach ($materiaux as $materiel): ?>
                <div class="col-sm-6 col-md-4 col-lg-3 my-3">
                    <div class="card card-produit position-relative">
                        <a href="../PHP/produit.php?id=<?= htmlspecialchars($materiel['Nom']) ?>"><img src="../IMG/images/<?= htmlspecialchars($materiel['Image_un']) ?>" class="card-img-top" alt="<?= htmlspecialchars($materiel['Nom']) ?>"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-success disponibilite"></span>
                            Disponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($materiel['Nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($materiel['Description_materiel']) ?></p>
                            <a href="../PHP/reservation.php?id=<?= htmlspecialchars($materiel['Nom']) ?>&quantite=1" class="btn btn-info ms-2" <?php if ($materiel['disponibilite'] == 0) echo 'disabled'; ?>>Réserver</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <?php
    if (isset($_POST["validerE"])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO reservation_etudiant (
                Pseudo, Nom, Prenom, Num_etudiant, Adresse_email,
                Date_reservation, heure_debut, heure_fin, nom_projet,
                participants, materiel, quantite, signature_eleve
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $_SESSION['utilisateur']['Pseudo'],
                $_POST['nom'],
                $_POST['prenom'],
                $_POST['numcarteetud'],
                $_POST['email'],
                $_POST['date'],
                $_POST['heureRetrait'],
                $_POST['heureRetour'],
                $_POST['nomProjet'],
                $_POST['participants'],
                $_POST['nom_produit'],
                $_POST['quantite'],
                $_POST['signature_eleve'] // à bien sécuriser selon le format
            ]);

            echo '
        <div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <b class="mb-2">MERCI POUR VOTRE RÉSERVATION</b>
            <p class="mb-4">Vous serez informé(e)s par mail lors de sa validation</p>
            <button class="btn btn-primary" onclick="fermer()" role="button">Fermer</button>
        </div>';
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion (étudiant) : " . $e->getMessage();
        }
    }

    if (isset($_POST["validerP"])) {
        try {
            $stmt = $pdo->prepare("INSERT INTO reservation_prof (
                Nom, Prenom, Pseudo, Adresse_email,
                Date_reservation, heure_debut, heure_fin,
                materiel, quantite, signature_prof
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

            $stmt->execute([
                $_POST['nom'],
                $_POST['prenom'],
                $_SESSION['utilisateur']['Pseudo'],
                $_POST['email'],
                $_POST['date'],
                $_POST['heureRetrait'],
                $_POST['heureRetour'],
                $_POST['nom_produit'],
                $_POST['quantite'],
                $_POST['signature_prof']
            ]);

            echo '
        <div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
            <b class="mb-2">MERCI POUR VOTRE RÉSERVATION</b>
            <p class="mb-4">Vous serez informé(e)s par mail lors de sa validation</p>
            <button class="btn btn-primary" onclick="fermer()" role="button">Fermer</button>
        </div>';
        } catch (PDOException $e) {
            echo "Erreur lors de l'insertion (professeur) : " . $e->getMessage();
        }
    }
    ?>

</body>

</html>