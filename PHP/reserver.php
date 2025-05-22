<?php

include 'config.php';
session_start();

if (!isset($_SESSION['utilisateur'])) {
    echo "Erreur : Utilisateur non connecté.";
    exit();
}

// Vérification de la connexion PDO (optionnel mais recommandé)
if ($pdo === null) {
    die("Erreur de connexion à la base de données.");
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <script src="../JS/reserve.js" defer></script>
    <script src="../JS/pdfreserve.js" defer></script>
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
                            <a class="icon-link link-dark" href="mesmeprunts.php">
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
                            $stmt->execute([$_SESSION['utilisateur']['Nom']]);
                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                            if ($row['total'] > 0) {
                                echo '<span class="badge d-flex align-items-center gap-2 text-dark">
    <span class="rounded-circle" style="width:10px;height:10px;background-color: #12A19A;"></span>
    <span class="spantext">Etudiant(e)</span>
    </span>';
                                // Si l'user fait partie de la table enseignant on affiche enseignant(e) + pastille couleur dédié
                            } else {
                                $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_prof WHERE nom = ?");
                                $stmt->execute([$_SESSION['utilisateur']['Nom']]);
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
                <div class="col-sm ms-md-5">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="../PHP/accueil.php">Accueil</a></li>
                            <li class="breadcrumb-item"><a href='produit.php?id=<?= htmlspecialchars($_POST['nom_produit']) ?>&quantite=1' type='button'><?= htmlspecialchars($_POST['nom_produit']) ?></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Réservation</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row ms-2 ms-md-5">
            <h2>MA RESERVATION</h2>
        </div>
    </section>

    <div class="container mt-5">
        <div class="stepper-container">
            <div class="stepper-line"></div>

            <div id="steps" class="d-flex justify-content-between align-items-center stepper-steps">
                <!-- Étape 1 -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    ☑️
                </div>

                <!-- Étape 2 -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    ☑️
                </div>

                <!-- Étape 3 -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    ☑️
                </div>

                <!-- Étape 4 en cours -->
                <div class="step-circle bg-primary text-white d-flex justify-content-center align-items-center">
                    4
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <div class="w-100"></div>

    <?php
    if (isset($_POST["submit_etud"])) {
        $nom = htmlspecialchars($_POST['nom'] ?? '');
        $prenom = htmlspecialchars($_POST['prenom'] ?? '');
        $numcarteetud = htmlspecialchars($_POST['numcarteetud'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $date = htmlspecialchars($_POST['date'] ?? '');
        $heureRetrait = htmlspecialchars($_POST['heureRetrait'] ?? '');
        $heureRetour = htmlspecialchars($_POST['heureRetour'] ?? '');
        $nomProjet = htmlspecialchars($_POST['nomProjet'] ?? '');
        $participants = htmlspecialchars($_POST['participants'] ?? '');
        $enseignantResponsable = htmlspecialchars($_POST['enseignantResponsable'] ?? '');
        $nom_produit = urldecode($_POST['nom_produit'] ?? '');
        $quantite = htmlspecialchars($_POST['quantite'] ?? '');
        $signature = htmlspecialchars($_POST['signature_eleve'] ?? '');

        if (!empty($nom) && !empty($prenom) && !empty($numcarteetud) && !empty($email) && !empty($date) && !empty($heureRetrait) && !empty($heureRetour) && !empty($nomProjet) && !empty($participants) && !empty($enseignantResponsable) && !empty($signature)) {
            // Formulaire de reçu redirigé vers page accueil à la validation
            echo "<section id='3'>
                <form action='../PHP/accueil.php' method='post' class='col-sm-6 float-end p-4 mb-4'>
                    <h5 class='mb-4 ms-4'>Votre Réservation</h5>
                        <div>Nom : <input type='hidden' value='$nom' name='nom'>{$nom}</div>
                        <div class='mb-4'>Prénom : <input type='hidden' value='$prenom' name='prenom'>{$prenom}</div>
                        <div>Numéro étudiant : <input type='hidden' value='$numcarteetud' name='numcarteetud'>{$numcarteetud}</div>
                        <div>Adresse email universitaire : <input type='hidden' value='$email' name='email'>{$email}</div>
                        <div class='mb-4'>Date de réservation : <input type='hidden' value='$date' name='date'>{$date}</div>
                        <div>Horaire de réservation : <input type='hidden' value='$heureRetrait' name='heureRetrait'>{$heureRetrait} - <input type='hidden' value='$heureRetour' name='heureRetour'>{$heureRetour}</div>
                        <div class='mb-4'>Nom du projet : <input type='hidden' value='$nomProjet' name='nomProjet'>{$nomProjet}</div>
                        <div>Etudiants participants : <input type='hidden' value='$participants' name='participants'>{$participants}</div> 
                        <div class='mb-4'>Enseignant responsable du projet : <input type='hidden' value='$enseignantResponsable' name='enseignantResponsable'>{$enseignantResponsable}</div>
                        <p>Matériel : <input type='hidden' value='$nom_produit' name='nom_produit'>{$nom_produit} x<input type='hidden' value='$quantite' name='quantite'>{$quantite}</p>
                        <p>Signature : <input type='hidden' value='$signature' name='signature_eleve'>{$signature}</p>
                        <div class='row mt-5'>
                            <div action='accueil.php' method='post' class='col-sm-4'>
                            <button type='button' class='btn btn-info' onclick='previousForm(event)'><img
                                    src='../IMG/fleche-gauche.png' alt='retour'>Retour</button>
                            </div>
                            <div class='col-sm-4'></div>
                            <div class='col-sm-4'>
                                <button type='submit' name='validerE' class='btn btn-info'>Valider</button>
                            </div>
                        </div>
                </form>
            </section>";
        } else {
            echo "<b id='erreur' class='text-danger col-sm-12 d-flex justify-content-center align-items-center'>Veuillez saisir tous les champs! </b>";
            echo "<div class='row mt-5 d-flex justify-content-center align-items-center'>
                            <a href='../PHP/reservation.php?id=" . htmlspecialchars($nom_produit) . "&quantite=1' type='button' class='btn btn-primary col-3'><img
                                    src='../IMG/fleche-gauche.png' alt='retour'>Retour au formulaire</a>
                        </div>
            <div class='clearfix'></div>
            <div class='w-100'></div>";
        }
    }

    if (isset($_POST["submit_prof"])) {
        $nom = htmlspecialchars($_POST['nom'] ?? '');
        $prenom = htmlspecialchars($_POST['prenom'] ?? '');
        $email = htmlspecialchars($_POST['email'] ?? '');
        $date = htmlspecialchars($_POST['date'] ?? '');
        $heureRetrait = htmlspecialchars($_POST['heureRetrait'] ?? '');
        $heureRetour = htmlspecialchars($_POST['heureRetour'] ?? '');
        $nom_produit = urldecode($_POST['nom_produit'] ?? '');
        $quantite = htmlspecialchars($_POST['quantite'] ?? '');
        $signature = htmlspecialchars($_POST['signature_prof'] ?? '');

        if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($date) && !empty($heureRetrait) && !empty($heureRetour) && !empty($nom_produit) && !empty($quantite) && !empty($signature)) {
            // Formulaire de reçu redirigé vers page accueil à la validation
            echo "<section id='3'>
            <form action='../PHP/accueil.php' method='post' class='col-sm-6 float-end p-4 mb-4'>
                <h5 class='mb-4 ms-4'>Votre Réservation</h5>
                    <div>Nom : <input type='hidden' value='$nom' name='nom'>{$nom}</div>
                    <div class='mb-4'>Prénom : <input type='hidden' value='$prenom' name='prenom'>{$prenom}</div>
                    <div>Adresse email universitaire : <input type='hidden' value='$email' name='email'>{$email}</div>
                    <div class='mb-4'>Date de réservation : <input type='hidden' value='$date' name='date'>{$date}</div>
                    <div>Horaire de réservation : <input type='hidden' value='$heureRetrait' name='heureRetrait'>{$heureRetrait} - <input type='hidden' value='$heureRetour' name='heureRetour'>{$heureRetour}</div>
                    <p>Matériel : <input type='hidden' value='$nom_produit' name='nom_produit'>{$nom_produit} x<input type='hidden' value='$quantite' name='quantite'>{$quantite}</p>
                    <p>Signature : <input type='hidden' value='$signature' name='signature_prof'>{$signature}</p>
                    <div class='row mt-5'>
                        <divclass='col-sm-4'>
                            <button type='button' class='btn btn-info' onclick='previousForm(event)'><img
                                    src='../IMG/fleche-gauche.png' alt='retour'>Retour</button>
                        </div>
                        <div class='col-sm-4'></div>
                        <div class='col-sm-4'>
                            <button type='submit' name='validerP' class='btn btn-info'>Valider</button>
                        </div>
                    </div>
            </form>
        </section>";
        } else {
            echo "<b id='erreur' class='text-danger col-sm-12 d-flex justify-content-center align-items-center'>Veuillez saisir tous les champs! </b>";
            echo "<div class='row mt-5 d-flex justify-content-center align-items-center'>
                        <a href='../PHP/reservation.php?id=" . htmlspecialchars($nom_produit) . "&quantite=1' type='button' class='btn btn-primary col-3'><img
                                src='../IMG/fleche-gauche.png' alt='retour'>Retour au formulaire</a>
                    </div>
        <div class='clearfix'></div>
        <div class='w-100'></div>";
        }
    }
    ?>

    <div class="clearfix"></div>
    <div class="w-100"></div>

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