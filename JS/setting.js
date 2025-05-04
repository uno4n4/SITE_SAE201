/* Agent */
document.addEventListener("DOMContentLoaded", function() {
    const settingButton = document.getElementById("reglage");
    const verifButton = document.getElementById("verif");
    const reglages = document.getElementById("form-reglages");
    const container = document.getElementById("form-container");
    const notif = document.getElementById("notif");
    const calendrier = document.getElementById("container-calendrier");
    const materiel = document.getElementById("mat");
    function activateButton(buttonToActivate, contentToDisplay) {

        settingButton.classList.remove('active-btn');
        verifButton.classList.remove('active-btn');

        buttonToActivate.classList.add('active-btn');

        reglages.style.display = "block";
        container.style.display = "none";
        notif.style.display = "none";
        calendrier.style.display = "none";
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
                    <input type="text" id="Nom" name="Nom" value="<?php echo htmlspecialchars($nom); ?>">
                </div>
                <div>
                    <label for="Prenom">Prénom *</label>
                    <input type="text" id="Prenom" name="Prenom" value="<?php echo htmlspecialchars($prenom); ?>">
                </div>
                <div>
                    <label for="Email">Email *</label>
                    <input type="text" id="Email" name="Email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div>
                    <label for="Tel">Numéro de téléphone *</label>
                    <input type="text" id="Tel" name="Tel" value="<?php echo htmlspecialchars($tel); ?>">
                </div>
                <div>
                    <label for="Pseudo">Pseudo *</label>
                    <input type="text" id="Pseudo" name="Pseudo" value="<?php echo htmlspecialchars($pseudo); ?>">
                </div>
            </div>
            <div class="button-container-1">
                <button type="submit" id="submit">Enregistrer les changements</button>
                <button onclick="../HTML/reglages.html" id="submit2">Annuler</button>
            </div>
            <hr>
            <h2>Changer son mot de passe</h2>
            <div class="form-grid1">
                <div>
                    <br><label>Ancien mot de passe</label>
                    <input type="password" id="old"><br>
                </div>
                <div>
                    <label>Nouveau mot de passe</label>
                    <input type="password" id="new"><br>
                </div>
                <div>
                    <label>Confirmer le mot de passe</label>
                    <input type="password" id="new1"><br>
                </div>
            </div>
            <div class="button-container-2">
                <button type="submit" id="confirmer">Confirmer</button>
            </div>

        </form>`;

        activateButton(settingButton, reglagesContent);

    };
});


