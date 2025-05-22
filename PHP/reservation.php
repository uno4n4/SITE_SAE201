<?php

include 'config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

// Vérifie si l'ID du produit est bien passé dans l'URL
if (isset($_GET['id']) && isset($_GET['quantite'])) {
    $id = $_GET['id'];
    $quantite = $_GET['quantite'];
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
    <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Bonheur+Royale&family=PT+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Pixelify+Sans:wght@400..700&display=swap"
        rel="stylesheet">
    <script src="../JS/reserve.js" defer></script>
    <script src="../JS/redirection.js" defer></script>
    <link rel="stylesheet" type="text/css" href="../CSS/style.css">
    <link rel="stylesheet" type="text/css" href="../CSS/parcours-user.css">
    <title>Réserver</title>
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
                            $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_eleve WHERE nom = ?");
                            $stmt->bindParam(1, $_SESSION['utilisateur']['Nom'], PDO::PARAM_STR);
                            $stmt->execute();
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($row['total'] > 0) {
                                echo '<span class="badge d-flex align-items-center gap-2 text-dark">
            <span class="rounded-circle" style="width:10px;height:10px;background-color: #12A19A;"></span>
            <span class="spantext">Etudiant(e)</span>
        </span>';
                                // Si l'user fait partie de la table enseignant on affiche enseignant(e) + pastille couleur dédié
                            } else {
                                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_prof WHERE nom = ?");
                                $stmt->bindParam(1, $_SESSION['utilisateur']['Nom'], PDO::PARAM_STR);
                                $stmt->execute();
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

                    <a class="btn btn-primary bouton-co" id="deconnexion" href="../PHP/logout.php" role="button">Se déconnecter</a>
                </div>
            </div>
        </nav>

        <div class="container-fluid text-center mt-5">
            <div class="row">
                <div class="col-sm ms-5">
                    <nav id="fildariane" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../PHP/accueil.php">Home</a></li>
                            <li class="breadcrumb-item"><a href='produit.php?id=<?= htmlspecialchars($id) ?>&quantite=1' type='button'><?= htmlspecialchars($id) ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Réservation</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-5 ms-2 ms-md-5">
            <h2>MA RESERVATION</h2>
        </div>
    </section>

    <div class="container-sm mt-5">
        <div class="stepper-container">
            <div class="stepper-line"></div>

            <div id="steps" class="d-flex justify-content-between align-items-center stepper-steps">
                <!-- Étape 1 -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    1
                </div>

                <!-- Étape 2 -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    2
                </div>

                <!-- Étape 3 -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    3
                </div>

                <!-- Étape 4 en cours -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    4
                </div>
            </div>
        </div>
    </div>
    <div id="formulaires-etudiant" class="container-fluid gx-3 my-5 <?= isset($_SESSION['utilisateur']['Td']) ? 'd-block' : 'd-none' ?>">
        <!-- Formulaire informations personnelles -->
        <form action="reserver.php" method="post"
            class="col-md-8 ms-2 float-start border border-secondary rounded p-4 shadow-sm mb-4">
            <ol>
                <section id="0">
                    <li class="ms-4">
                        <h5 class="mb-4">Informations Personnelles</h5>
                    </li>
                    <input type="hidden" name="nom_produit" value="<?= htmlspecialchars($_GET['id']); ?>">
                    <input type="hidden" name="quantite" value="<?php echo htmlspecialchars($_GET['quantite']); ?>">



                    <div class="mb-3 row">
                        <label for="nom" class="col-sm-2 col-form-label">Nom :</label>
                        <div class="col-sm-10">
                            <input name="nom" type="text" class="form-control" id="nom" value="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Nom'])) ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="prenom" class="col-sm-2 col-form-label">Prénom :</label>
                        <div class="col-sm-10">
                            <input name="prenom" type="text" class="form-control" id="prenom" value="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="numcarteetud" class="col-sm-2 col-form-label">Numéro étudiant :</label>
                        <div class="col-sm-10">
                            <input name="numcarteetud" type="text" class="form-control" id="numcarteetud"
                                value="<?= htmlspecialchars($_SESSION['utilisateur']['Num_etudiant']) ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Adresse email universitaire :</label>
                        <div class="col-sm-10">
                            <input name="email" type="email" class="form-control" id="email"
                                value="<?= htmlspecialchars($_SESSION['utilisateur']['Adresse_email']) ?>">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="nextForm(event)">Suivant <i class="fa-solid fa-arrow-right" style="color: #FFF;"></i></button>
                        </div>
                    </div>
                </section>

                <!-- Formulaire période de réservation -->
                <section id="1" class="formetape">
                    <li class="ms-4">
                        <h5 class="mb-4">Période de réservation</h5>
                    </li>

                    <div class="mb-3 row">
                        <label for="date" class="col-sm-12 offset-sm-1 col-form-label">Date de réservation :</label>
                        <div class="col-sm-12">
                            <input name="date" type="date" class="form-control" id="date">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="heureRetrait" class="col-sm-12 offset-sm-1 col-form-label">Heure de retrait
                            :</label>
                        <div class="col-sm-12">
                            <input name="heureRetrait" type="time" step="900" min="08:00" max="18:00" class="form-control" id="heureRetrait">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="heureRetour" class="col-sm-12 offset-sm-1 col-form-label">Heure de retour du
                            matériel
                            :</label>
                        <div class="col-sm-12">
                            <input name="heureRetour" type="time" step="900" min="08:00" max="18:00" class="form-control" id="heureRetour">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="previousForm(event)"><i class="fa-solid fa-arrow-left" style="color: #FFF;"></i> Retour</button>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="nextForm(event)">Suivant <i class="fa-solid fa-arrow-right" style="color: #FFF;"></i></button>
                        </div>
                    </div>
                </section>

                <!-- Formulaire projet en cours -->
                <section id="2" class="formetape">
                    <li class="ms-4">
                        <h5 class="mb-4">Projet en cours</h5>
                    </li>

                    <div class="mb-3 row">
                        <label for="nomProjet" class="col-sm-2 col-form-label">Nom du Projet :</label>
                        <div class="col-sm-10">
                            <input name="nomProjet" type="text" class="form-control" id="nomProjet"
                                placeholder="Ex: Cornelio">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="participants" class="col-sm-2 col-form-label">Etudiants Participants :</label>
                        <div class="col-sm-10">
                            <input name="participants" type="text" class="form-control" id="participants"
                                placeholder="Ex: Clara DeneuVille, Jean Patrick, ...">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="enseignantResponsable" class="col-sm-2 col-form-label">Enseignant responsable du
                            projet
                            :</label>
                        <div class="col-sm-10">
                            <input name="enseignantResponsable" type="text" class="form-control"
                                id="enseignantResponsable" placeholder="Ex: Thierry Caron">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="signature" class="col-sm-2 col-form-label">Signature :</label>
                        <div class="col-sm-10">
                            <input name="signature_eleve" type="text" class="form-control"
                                id="signature" value="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom']))?>">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="previousForm(event)"><i class="fa-solid fa-arrow-left" style="color: #FFF;"></i> Retour</button>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="submit" name="submit-etud" class="btn btn-info">Suivant <i class="fa-solid fa-arrow-right" style="color: #FFF;"></i></button>
                        </div>
                    </div>
                </section>
            </ol>
        </form>
    </div>


    <div id="formulaires-prof" class="container-fluid gx-3 my-5 <?= isset($_SESSION['utilisateur']['Td']) ? 'd-none' : 'd-block' ?>">
        <!-- Formulaire informations personnelles -->
        <form action="reserver.php" method="post"
            class="col-md-8 ms-2 float-start border border-secondary rounded p-4 shadow-sm mb-4">
            <ol>
                <section id="0">
                    <li class="ms-4">
                        <h5 class="mb-4">Informations Personnelles</h5>
                    </li>
                    <input type="hidden" name="nom_produit" value="<?= htmlspecialchars($_GET['id']); ?>">
                    <input type="hidden" name="quantite" value="<?php echo htmlspecialchars($_GET['quantite']); ?>">

                    <div class="mb-3 row">
                        <label for="nom" class="col-sm-2 col-form-label">Nom :</label>
                        <div class="col-sm-10">
                            <input name="nom" type="text" class="form-control" id="nom" value="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Nom'])) ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="prenom" class="col-sm-2 col-form-label">Prénom :</label>
                        <div class="col-sm-10">
                            <input name="prenom" type="text" class="form-control" id="prenom" value="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) ?>">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="email" class="col-sm-2 col-form-label">Adresse email universitaire :</label>
                        <div class="col-sm-10">
                            <input name="email" type="email" class="form-control" id="email"
                                value="<?= htmlspecialchars($_SESSION['utilisateur']['Adresse_email']) ?>">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="nextForm(event)">Suivant <i class="fa-solid fa-arrow-right" style="color: #FFF;"></i></button>
                        </div>
                    </div>
                </section>

                <!-- Formulaire période de réservation -->
                <section id="1" class="formetape">
                    <li class="ms-4">
                        <h5 class="mb-4">Période de réservation</h5>
                    </li>

                    <div class="mb-3 row">
                        <label for="date" class="col-sm-12 offset-sm-1 col-form-label">Date de réservation :</label>
                        <div class="col-sm-12">
                            <input name="date" type="date" class="form-control" id="date">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="heureRetrait" class="col-sm-12 offset-sm-1 col-form-label">Heure de retrait
                            :</label>
                        <div class="col-sm-12">
                            <input name="heureRetrait" type="time" step="900" min="08:00" max="18:00" class="form-control" id="heureRetrait">
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="heureRetour" class="col-sm-12 offset-sm-1 col-form-label">Heure de retour du
                            matériel
                            :</label>
                        <div class="col-sm-12">
                            <input name="heureRetour" type="time" step="900" min="08:00" max="18:00" class="form-control" id="heureRetour">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="previousForm(event)"><i class="fa-solid fa-arrow-left" style="color: #FFF;"></i> Retour</button>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="nextForm(event)">Suivant <i class="fa-solid fa-arrow-right" style="color: #FFF;"></i></button>
                        </div>
                    </div>
                </section>

                <!-- Formulaire projet en cours -->
                <section id="2" class="formetape">
                    <li class="ms-4">
                        <h5 class="mb-4">Signature</h5>
                    </li>

                    <div class="mb-3 row">
                        <label for="signature" class="col-sm-2 col-form-label">Signature :</label>
                        <div class="col-sm-10">
                           <input name="signature_prof" type="text" class="form-control"
                                id="signature" value="<?= ucfirst(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom']))?>">
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-sm-4">
                            <button type="button" class="btn btn-info" onclick="previousForm(event)"><i class="fa-solid fa-arrow-left" style="color: #FFF;"></i> Retour</button>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <button type="submit" name="submit-prof" class="btn btn-info">Suivant <i class="fa-solid fa-arrow-right" style="color: #FFF;"></i></button>
                        </div>
                    </div>
                </section>
            </ol>
        </form>
    </div>

    <div class="clearfix"></div>
    <div class="w-100"></div>

</body>

</html>