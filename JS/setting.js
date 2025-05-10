/* Agent */
document.addEventListener("DOMContentLoaded", function() {
    const settingButton = document.getElementById("reglage");
    const reglages = document.getElementById("form-reglages");
    const container = document.getElementById("form-container");
    var nom = document.getElementById('form-container').getAttribute('data-nom');
    var prenom = document.getElementById('form-container').getAttribute('data-prenom');
    var email = document.getElementById('form-container').getAttribute('data-email');
    var numetu = document.getElementById('form-container').getAttribute('data-numetu');
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
            <div class="photo-container">
                <label for="photoUpload">
                    <img src="../IMAGE/logo-iut.png" alt="Photo de profil" id="photo">
                </label>
                <input type="file" id="photoUpload" hidden>
                <div class="button-container">
                    <button type="button" id="changer">Changer</button>
                    <button type="button" id="supp">Supprimer la photo</button>
                    </div>
            </div>
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
                    <label for="Numetu">Numéro étudiant *</label>
                    <input type="text" name="Numetu" value = "${numetu}" disabled>
                </div>
                <div>
                    <label for="Pseudo">Pseudo *</label>
                    <input type="text" id="Pseudo" name="Pseudo" value = "${pseudo}">
                </div>
            </div>
            <div class="button-container-1">
                <button type="submit" id="submit" name="update_pseudo">Enregistrer les changements</button>
                <button onclick="../PHP/admin.php" id="submit2">Annuler</button>
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


