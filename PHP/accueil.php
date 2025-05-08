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
    <title>Recherche</title>
</head>

<body class="overflow-x-hidden">
    <section class="container-fluid px-0">
        <nav class="navbar navbar-expand">
            <div class="container-fluid px-3 d-flex justify-content-between align-items-center">
                <a class="navbar-brand" href="#">
                    <img src="../IMG/logo-iut.png" class="img-fluid" alt="logo iut" id="logo-iut-head">
                </a>

                <div class="d-flex align-items-center gap-2" id="navbar-nav">
                    <ul class="navbar-nav gap-2 mb-2 mb-lg-0">
                        <li class="nav-item mt-3">
                            <a class="icon-link link-dark" href="#">
                                <img src="../IMG/boite.png" alt="boite mes emprunts">
                                <span class="spantext">Mes Emprunts</span>
                            </a>
                        </li>
                        <li class="nav-item mt-3 d-flex flex-column">
                            <a class="icon-link link-dark" href="#">
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
                <div class="col-sm-3 ms-5">
                    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Recherche</li>
                        </ol>
                    </nav>
                </div>
            </div>
    </section>

    <section class="container-fluid ms-2">
        <div class="row mt-5 gx-2">
            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-success disponibilite"></span>
                            Disponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>

            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-success disponibilite"></span>
                            Disponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>

            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-danger disponibilite"></span>
                            Indisponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>

            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-success disponibilite"></span>
                            Disponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row mt-5 gx-2">
            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-success disponibilite"></span>
                            Disponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>

            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-danger disponibilite"></span>
                            Indisponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>

            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-success disponibilite"></span>
                            Disponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>

            <div class="col-sm col-6">
                    <div class="card card-produit position-relative">
                    <a href="../HTML/produit.html"><img src="../IMG/images/P1018442.JPG" class="card-img-top" alt="drone"></a>
                        <span
                            class="position-absolute top-0 start-10 translate-middle-y badge bg-light d-flex align-items-center gap-2 text-dark">
                            <span class="rounded-circle bg-danger disponibilite"></span>
                            Indisponible
                        </span>
                        <div class="card-body">
                            <h5 class="card-title">Drone</h5>
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                the card's content.</p>
                            <a href="../HTML/reservation.html" class="btn btn-info mt-2">Réserver</a>
                        </div>
                    </div>
            </div>
    </section>

    <footer class="container-fluid mt-5 text-white custom-bg">
        <div class="my-3">
            <img src="../IMAGE/logo-iut.png" id="logo-iut-foot" class="img-fluid float-left mt-3" alt="logo iut">
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

    <?php
    if (isset($_POST["valider"])) {
        //un msg de confirmation + mail : voir tpsession
        echo '<div id="msgConfirmation" class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
                <b class="mb-2">MERCI POUR VOTRE RÉSERVATION</b>
                <p class="mb-4">Vous pouvez la consulter dans la page Mes emprunts</p>
                <button class="btn btn-primary" onclick="fermer()" role="button">Fermer</button>
            </div>';
        //ajout de la réservation dans la bdd
    }
    ?>
</body>

</html>