/* Agent */
document.addEventListener("DOMContentLoaded", function() {
    const settingButton = document.getElementById("reglage");
    const reglages = document.getElementById("form-reglages");
    const container = document.getElementById("form-container");
    var nom = document.getElementById('form-container').getAttribute('data-nom');
    var prenom = document.getElementById('form-container').getAttribute('data-prenom');
    var email = document.getElementById('form-container').getAttribute('data-email');
    var pseudo = document.getElementById('form-container').getAttribute('data-pseudo');
    function activateButton(buttonToActivate, contentToDisplay) {

        settingButton.classList.remove('active-btn');
        verifButton.classList.remove('active-btn');

        buttonToActivate.classList.add('active-btn');

        reglages.style.display = "block";
        container.style.display = "none";
        container.innerHTML = contentToDisplay;
    }

    document.getElementById("reglage").onclick = reglagesContent
    function reglagesContent() {
        container.style.display = "block";
        container.innerHTML = 
        `<form id="setting" class="form-style" method="post" action="../PHP/setting.php">
            <h2>Modifier son profil</h2>
            <div class="form-grid">
                <div>
                    <label for="Nom">Nom *</label>
                    <input type="text" name="Nom" value = "${nom}" disabled>
                </div>
                <div>
                    <label for="Prenom">Prenom *</label>
                    <input type="text" name="Prenom" value = "${prenom}" disabled>
                </div>
                <div>
                    <label for="Email">Email *</label>
                    <input type="text" name="Adresse_email" value = "${email}" disabled>
                </div>
                <div>
                    <label for="Pseudo">Pseudo *</label>
                    <input type="text" id="Pseudo" name="Pseudo" value = "${pseudo}" disabled>
                </div>
            </div>
            <hr>
            <h2>Changer son mot de passe</h2>
            <div class="form-grid1">
                <div>
                    <br><label>Ancien mot de passe</label>
                    <input type="password" name="old"><br>
                </div>
                <div>
                    <label>Nouveau mot de passe</label>
                    <input type="password" name="new"><br>
                </div>
                <div>
                    <label>Confirmer le mot de passe</label>
                    <input type="password" name="new1"><br>
                </div>
            </div>
            <div class="button-container-2">
                <button type="submit" id="confirmer" name="update_pass">Confirmer</button>
            </div>

        </form>`;

        activateButton(settingButton, reglagesContent);

    };
});


/* ADMIN */

document.addEventListener("DOMContentLoaded", function(){
    const suppButton = document.getElementById('supprimer-compte');
    const containerSupp = document.getElementById('container-supp');
    suppButton.onclick = suppContent;
    function suppContent(){
        containerSupp.style.display = "block";
        containerSupp.innerHTML = `
        <form method="post" action="../PHP/modifier-compte.php">
            <h3 class="text-center font-weight-bold">Êtes-vous sûr de votre choix ?</h3>
            <div class="d-flex justify-content-center gap-2">
                <button class="btn btn-danger" type="submit" name="supprimer_compte">Supprimer le compte</button>
                <button class="btn btn-secondary" type="button" onclick="../PHP/modifier-compte.php">Annuler</button>
            </div>
        </form>`;
    }
});

