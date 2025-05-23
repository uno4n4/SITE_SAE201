<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/76ad15112d.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="../CSS/profil.css">
    <script src="../JS/setting.js" defer></script>
    <title>Réglages</title>
</head>

<body>

    <?php

    include('config.php');
    session_start();

    if (!isset($_SESSION['utilisateur'])) {
        echo "Erreur : Utilisateur non connecté.";
        exit();
    }

    $tables = ['inscription_eleve', 'inscription_prof', 'inscription_admin', 'inscription_agent'];
    $tableOrigine = $_POST['tableOrigine'] ?? '';
    $roles = [
        'inscription_eleve' => 'Étudiant',
        'inscription_prof' => 'Professeur',
        'inscription_admin' => 'Admin',
        'inscription_agent' => 'Agent'
    ];

    if (isset($_GET['Pseudo'])) {
        $Pseudo = $_GET['Pseudo'];

        // Chercher l'utilisateur dans les tables
        $found = false;  // Variable pour savoir si l'utilisateur a été trouvé
        foreach ($tables as $table) {
            $stmt = $pdo->prepare("SELECT * FROM `$table` WHERE Pseudo = ?");
            $stmt->execute([$Pseudo]);
            if ($utilisateur = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $tableOrigine = $table;  // Table d'origine trouvée
                $found = true;  // Utilisateur trouvé
                break;
            }
        }

        if (!$found) {
            die("L'utilisateur n'a pas été trouvé dans la base de données.");
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Pseudo'])) {
        $Nom = $_POST['Nom'];
        $Prenom = $_POST['Prenom'];
        $Anniv = $_POST['Anniv'];
        $Email = $_POST['Email'];
        $Tel = $_POST["Tel"];
        $Adresse = $_POST['Adresse'];
        $Pseudo = $_POST['Pseudo'];
        $tableOrigine = $_POST['tableOrigine'];
        if (!in_array($tableOrigine, $tables)) {
            die("Table d'origine invalide.");
        }

        // Récupération de l'utilisateur depuis la bonne table
        $stmt = $pdo->prepare("SELECT * FROM `$tableOrigine` WHERE Pseudo = ?");
        $stmt->execute([$Pseudo]);
        $utilisateur = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$utilisateur) {
            die("Utilisateur introuvable pour mise à jour.");
        }
        $Statut = 'accepté';
        $Role = $_POST['Role'];
        $Mdp = $utilisateur['Mdp'];

        // Définir la nouvelle table en fonction du rôle
        switch ($Role) {
            case 'admin':
                $table = 'inscription_admin';
                break;
            case 'agent':
                $table = 'inscription_agent';
                break;
            case 'etudiant':
                $table = 'inscription_eleve';
                break;
            case 'prof':
                $table = 'inscription_prof';
                break;
            default:
                $table = $tableOrigine;
                break;
        }

        // Vérifier si la table d'origine est définie avant de supprimer
        if ($tableOrigine && $table !== $tableOrigine) {
            // Supprimer l'utilisateur de la table d'origine
            $stmtDelete = $pdo->prepare("DELETE FROM `$tableOrigine` WHERE Pseudo = ?");
            if (!$stmtDelete->execute([$Pseudo])) {
                die("Erreur de suppression dans la table d'origine.");
            }

            // Ajouter l'utilisateur dans la nouvelle table
            $sql = "INSERT INTO `$table` (nom, prenom, date_naissance, adresse_email, numero_tel, adresse, pseudo, mdp, statut) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmtInsert = $pdo->prepare($sql);
            if ($stmtInsert->execute([$Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Pseudo, $Mdp, $Statut])) {
                echo <<<HTML
                <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
                    <b class="mb-2 d-block">Le rôle a été mis à jour et l'utilisateur déplacé avec succès !</b>
                    <div class="text-center mt-3">
                        <a href="gest-comptes.php" class="btn btn-success">Fermer</a>
                    </div>
                </div>
            HTML;
            } else {
                echo "Erreur : " . $stmtInsert->errorInfo()[2];
            }

            $stmtDelete = null;
            $stmtInsert = null;
        } elseif ($tableOrigine && $table === $tableOrigine) {
            // Cas : rôle inchangé → mise à jour dans la même table
            $sql = "UPDATE `$tableOrigine` SET nom = ?, prenom = ?, date_naissance = ?, adresse_email = ?, numero_tel = ?, adresse = ?, statut = ? WHERE pseudo = ?";
            $stmtUpdate = $pdo->prepare($sql);
            if ($stmtUpdate->execute([$Nom, $Prenom, $Anniv, $Email, $Tel, $Adresse, $Statut, $Pseudo])) {
                echo <<<HTML
                <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
                    <b class="mb-2 d-block">Information mise à jour avec succès ! </b>
                    <div class="text-center mt-3">
                        <a href="modifier-compte.php" class="btn btn-success">Fermer</a>
                    </div>
                </div>
            HTML;
            } else {
                echo "Erreur lors de la mise à jour : " . $stmtUpdate->errorInfo()[2];
            }
            $stmtUpdate = null;
        } else {
            die("Table d'origine invalide ou non définie.");
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['supprimer_compte'])) {
            $Pseudo = $_POST['Pseudo'];
            $tableOrigine = $_POST['tableOrigine'];

            if (!in_array($tableOrigine, $tables)) {
                die("Table d'origine invalide.");
            }

            // Supprimer l'utilisateur
            $stmt = $pdo->prepare("DELETE FROM `$tableOrigine` WHERE Pseudo = ?");
            if ($stmt->execute([$Pseudo])) {
                echo <<<HTML
                <div class="container-sm-6 bg-light border border-dark rounded p-5 position-absolute top-50 start-50 translate-middle text-center align-items-center justify-content-center" style="--bs-border-opacity: .5; z-index:10; width: 500px;">
                    <b class="mb-2 d-block">Le compte a été supprimé avec succès</b>
                    <div class="text-center mt-3">
                        <a href="gest-comptes.php" class="btn btn-danger">Fermer</a>
                    </div>
                </div>
            HTML;
                exit;
            } else {
                echo "Erreur lors de la suppression du compte : " . $stmt->errorInfo()[2];
            }

            $stmt = null;
            $pdo = null;
            exit;
        }
    }
    ?>

    <header class="container-fluid px-0">
        <div class="d-flex align-items-center justify-content-between px-3 py-2 w-100">
            <div class="d-flex align-items-center ms-auto gap-2">
                <?php
                if (isset($_SESSION['utilisateur']) && isset($pdo)) {
                    $nom = $_SESSION['utilisateur']['Nom'];

                    // ADMIN
                    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM inscription_admin WHERE nom = ?");
                    $stmt->execute([$nom]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($row['total'] > 0) {
                        echo '
            <span class="rounded-circle" style="width:10px;height:10px;background-color: #2F2A85;"></span>';
                    } else {
                        // Aucun des deux trouvés
                        echo '<span class="badge d-flex align-items-center gap-2 text-dark">
                <span class="rounded-circle" style="width:10px;height:10px;background-color: gray;"></span>
            </span>';
                    }
                }
                ?>
                <h6 class="mb-0 text-nowrap text-end">
                    <?= isset($_SESSION['utilisateur']) ? strtoupper(htmlspecialchars($_SESSION['utilisateur']['Nom'])) . ' ' . ucfirst(htmlspecialchars($_SESSION['utilisateur']['Prenom'])) : 'Utilisateur non connecté' ?>
                </h6>

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
                            <a href="gest-reservation.php" class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-calendar-days"></i><span class="ms-1 d-none d-sm-inline">Gestion des réservations</span>
                            </a>
                        </li>

                        <li>
                            <a href="gest-comptes.php" class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-users"></i><span class="ms-1 d-none d-sm-inline">Gestion des comptes</span>
                            </a>
                        </li>

                        <li>
                            <a href="materiel.php" class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-camera"></i><span class="ms-1 d-none d-sm-inline">Gestion du matériel</span>
                            </a>
                        </li>

                        <li>
                            <a href="gest-reservation.php" class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-chart-simple"></i><span class="ms-1 d-none d-sm-inline">Statistiques</span>
                            </a>
                        </li>

                        <li>
                            <a href="gest-reservation.php" class="nav-link px-0 align-middle">
                                <i class="fa-solid fa-file-pen"></i><span class="ms-1 d-none d-sm-inline">Consigne de sécurité</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main content -->
            <div class="col py-3 custom-bg d-flex justify-content-lg-start">
                <form class="mx-auto" method="post" action="modifier-compte.php">
                    <input type="hidden" name="Pseudo" value="<?= $utilisateur['Pseudo'] ?>">
                    <input type="hidden" name="tableOrigine" value="<?= htmlspecialchars($tableOrigine) ?>">
                    <input type="hidden" name="Anniv" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Date_naissance']) : '' ?>">
                    <input type="hidden" name="Adresse" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Adresse']) : '' ?>">
                    <h2>Modifier Le compte</h2>
                    <div class="form-grid">
                        <div>
                            <label for="Nom">Nom *</label>
                            <input type="text" name="Nom" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Nom']) : '' ?>">
                        </div>
                        <div>
                            <label for="Prenom">Prénom *</label>
                            <input type="text" id="Prenom" name="Prenom" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Prenom']) : '' ?>">
                        </div>
                        <div>
                            <label for="Email">Email *</label>
                            <input type="text" id="Email" name="Email" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Adresse_email']) : '' ?>">
                        </div>
                        <div>
                            <label for="Tel">Numéro de téléphone *</label>
                            <input type="text" id="Tel" name="Tel" value="<?= isset($utilisateur) ? htmlspecialchars($utilisateur['Numero_tel']) : '' ?>">
                        </div>
                        <div>
                            <label for="Role" class="me-3">Rôle</label>

                            <select class="border none" name="Role">
                                <option selected><?= isset($utilisateur) && isset($roles[$tableOrigine]) ? $roles[$tableOrigine] : '' ?></option>
                                <option value="etudiant" name="Role">Étudiant</option>
                                <option value="prof" name="Role">Professeur</option>
                                <option value="agent" name="Role">Agent</option>
                                <option value="admin" name="Role">Admin</option>
                            </select>
                        </div>
                        <div class="button-container-1">
                            <button type="submit" id="submit">Enregistrer les changements</button>
                            <a href="gest-comptes.php" class="btn" id="submit2">Annuler</a>
                        </div>
                        <button class="btn btn-danger text-white justify-content-center" type="button" id="supprimer-compte">Supprimer le compte</button>
                        <div id="container-supp"></div>
                </form>

            </div>


</body>

</html>