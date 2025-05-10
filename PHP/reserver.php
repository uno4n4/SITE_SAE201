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
    <title>Réserver</title>
</head>

<body class="overflow-x-hidden">
    <section class="container-fluid px-0">
        <nav class="navbar navbar-expand">
            <div class="container-fluid px-3 d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="accueil.php">
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
                                <span class="spantext">Diaba Samoura</span>
                            </a>
                            <span class="badge d-flex align-items-center gap-2 text-dark">
                                <span id="roleicon" class="rounded-circle bg-warning"></span>
                                <span class="spantext">Etudiant(e)</span>
                            </span>
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
                <div class="col-sm ms-md-5">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="../PHP/accueil.php">Recherche</a></li>
                            <li class="breadcrumb-item"><a href="../HTML/produit.html">Drone</a></li>
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
    if (isset($_POST["submit"])) {
        $nom = htmlspecialchars($_POST['nom']) ?? '';
        $prenom = htmlspecialchars($_POST['prenom']) ?? '';
        $numcarteetud = htmlspecialchars($_POST['numcarteetud']) ?? '';
        $email = htmlspecialchars($_POST['email']) ?? '';
        $date = htmlspecialchars($_POST['date']) ?? '';
        $heureRetrait = htmlspecialchars($_POST['heureRetrait']) ?? '';
        $heureRetour = htmlspecialchars($_POST['heureRetour']) ?? '';
        $nomProjet = htmlspecialchars($_POST['nomProjet']) ?? '';
        $participants = htmlspecialchars($_POST['participants']) ?? '';
        $enseignantResponsable = htmlspecialchars($_POST['enseignantResponsable']) ?? '';
        $signature = htmlspecialchars($_POST['signature']) ?? '';

        if ($role == "etudiant") {
            //Requete SQL d'insertion
            $sql = "INSERT INTO reservation_etudiant(Id, Pseudo, Nom, Prenom, Num_etudiant, Adresse_email, Date_reservation, heure_debut, heure_fin, nom_projet, participant_un, participant_deux, participant_trois, participant_quatre, materiel, quantite, signature)
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            //Preparer la requete
            $stmt = $conn->prepare($sql);
            //Verifier si la preparation a echoue
            if ($stmt === false) {
                die("Erreur de preparation de la requete: " . $conn->error);
            }

            //Lier les paramètres a la requete
            $stmt->bind_param("ssssss", $pseudo, $nom, $prenom, $numcarteetud, $email, $date, $heureRetrait, $heureRetour, $nomProjet, $participants, $materiel, $quantite, $signature);

            //Executer la requete
            if ($stmt->execute()) {
                echo "Patient ajouté avec succès. ";
            } else {
                echo "Erreur lors de l'ajout du patient: " . $stmt->error;
            }

            //Fermer la declaration et la connexion
            $stmt->close();
            $conn->close();

            if (!empty($nom) && !empty($prenom) && !empty($numcarteetud) && !empty($email) && !empty($date) && !empty($heureRetrait) && !empty($heureRetour) && !empty($nomProjet) && !empty($participants) && !empty($enseignantResponsable)) {
                $produit = $_POST['produit'];
                $quantite = $_POST['quantite'];
                // formulaire de reçu redirigé vers page accueil à la validation
                echo "<section id='3'>
                    <form action='../PHP/accueil.php' method='post' class='col-sm-6 float-end p-4 mb-4'>
                        <h5 class='mb-4 ms-4'>Votre Réservation</h5>
                        <div>Nom : {$nom}</div>
                        <div class='mb-4'>Prénom : {$prenom}</div>
                        <div>Numéro étudiant : {$numcarteetud}</div>
                        <div>Adresse email universitaire : {$email}</div>
                        <div class='mb-4'>Date de réservation : {$date}</div>
                        <div>Horaire de réservation : {$heureRetrait} - {$heureRetour}</div>
                        <div class='mb-4'>Nom du projet : {$nomProjet}</div>
                        <div>Etudiants participants : {$participants}</div> 
                        <div class='mb-4'>Enseignant responsable du projet : {$enseignantResponsable}</div>
                        <p>Matériel : {$produit} x{$quantite}</p>
                        <p>Signature : A TROUVER</p>
                        <div class='col-4 ms-auto mb-3 mb-lg-0'>
                            <div class='me-5 mt-3'>
                                <a class='icon-link link-dark' href='#'>
                                    Télécharger le PDF
                                    <img src='../IMG/google-docs.png' alt='google-docs'>
                                </a>
                            </div>
                        </div>
                        <div class='row mt-5'>
                            <div class='col-sm-4'>
                                <button type='button' class='btn btn-info' onclick='previousForm(event)'><img
                                        src='../IMG/fleche-gauche.png' alt='retour'>Retour</button>
                            </div>
                            <div class='col-sm-4'></div>
                            <div class='col-sm-4'>
                                <button type='submit' name='valider' class='btn btn-info'>Valider</button>
                            </div>
                        </div>
                    </form>
                </section>";
            } else {
                echo "<b id='erreur' class='text-danger col-sm-12 d-flex justify-content-center align-items-center'>Veuillez saisir tous les champs! </b>";
                echo "<div class='row mt-5 d-flex justify-content-center align-items-center'>
                                <a href='../HTML/reservation.html' type='button' class='btn btn-primary col-3'><img
                                        src='../IMG/fleche-gauche.png' alt='retour'>Retour au formulaire</a>
                            </div>
                <div class='clearfix'></div>
                <div class='w-100'></div>";
            }

        } else if ($role == "enseignant") {
            //Requete SQL d'insertion
            $sql = "INSERT INTO reservation_prof(Id, Nom, Prenom, Pseudo, Adresse_email, Date_reservation, heure_debut, heure_fin, materiel, quantite, signature)
    VALUES (?,?,?,?,?,?,?,?,?,?,?)";

            //Preparer la requete
            $stmt = $conn->prepare($sql);
            //Verifier si la preparation a echoue
            if ($stmt === false) {
                die("Erreur de preparation de la requete: " . $conn->error);
            }

            //Lier les paramètres a la requete
            $stmt->bind_param("ssssss", $nom, $prenom, $pseudo, $email, $date, $heureRetrait, $heureRetour, $materiel, $quantite, $signature);

            //Executer la requete
            if ($stmt->execute()) {
                echo "Patient ajouté avec succès. ";
            } else {
                echo "Erreur lors de l'ajout du patient: " . $stmt->error;
            }

            //Fermer la declaration et la connexion
            $stmt->close();
            $conn->close();
        }

        if (!empty($nom) && !empty($prenom) && !empty($email) && !empty($date) && !empty($heureRetrait) && !empty($heureRetour)) {
            $produit = $_POST['produit'];
            $quantite = $_POST['quantite'];
            // formulaire de reçu redirigé vers page accueil à la validation
            echo "<section id='3'>
                <form action='../PHP/accueil.php' method='post' class='col-sm-6 float-end p-4 mb-4'>
                    <h5 class='mb-4 ms-4'>Votre Réservation</h5>
                    <div>Nom : {$nom}</div>
                    <div class='mb-4'>Prénom : {$prenom}</div>
                    <div>Adresse email universitaire : {$email}</div>
                    <div class='mb-4'>Date de réservation : {$date}</div>
                    <div>Horaire de réservation : {$heureRetrait} - {$heureRetour}</div>
                    <p>Matériel : {$produit} x{$quantite}</p>
                    <p>Signature : A TROUVER</p>
                    <div class='col-4 ms-auto mb-3 mb-lg-0'>
                        <div class='me-5 mt-3'>
                            <a class='icon-link link-dark' href='#'>
                                Télécharger le PDF
                                <img src='../IMG/google-docs.png' alt='google-docs'>
                            </a>
                        </div>
                    </div>
                    <div class='row mt-5'>
                        <div class='col-sm-4'>
                            <button type='button' class='btn btn-info' onclick='previousForm(event)'><img
                                    src='../IMG/fleche-gauche.png' alt='retour'>Retour</button>
                        </div>
                        <div class='col-sm-4'></div>
                        <div class='col-sm-4'>
                            <button type='submit' name='valider' class='btn btn-info'>Valider</button>
                        </div>
                    </div>
                </form>
            </section>";
        } else {
            echo "<b id='erreur' class='text-danger col-sm-12 d-flex justify-content-center align-items-center'>Veuillez saisir tous les champs! </b>";
            echo "<div class='row mt-5 d-flex justify-content-center align-items-center'>
                            <a href='../HTML/reservation.html' type='button' class='btn btn-primary col-3'><img
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
                    <a href="../HTML/contact.html" class="text-white text-decoration-none d-block mb-1">Contact</a>
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