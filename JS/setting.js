/* Agent */
document.addEventListener("DOMContentLoaded", function() {
    const settingButton = document.getElementById("setting");
    const reglages = document.getElementById("form-reglages");
    const container = document.getElementById("form-container");
    const notif = document.getElementById("notif");
    const calendrier = document.getElementById("container-calendrier");
    const materiel = document.getElementById("mat");
    settingButton.onclick = function(){
        reglages.style.display = "block";
        container.style.display = "none";
        notif.style.display = "none";
        calendrier.style.display = "none";
        
        container.innerHTML = "";
    };

    document.getElementById("reglage").onclick = function(){
        container.style.display = "block";
        container.innerHTML = 
        container.innerHTML = 
`<form id="setting" class="form-style">
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
      <label>Nom *</label>
      <input type="text" id="Nom">
    </div>
    <div>
      <label>Prénom *</label>
      <input type="text" id="Prenom">
    </div>
    <div>
      <label>Email *</label>
      <input type="text" id="Email">
    </div>
    <div>
      <label>Numéro de téléphone *</label>
      <input type="text" id="Tel">
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

    };

    document.getElementById("verif").onclick = function(){
        container.style.display = "block";
        container.innerHTML = 
        `
        <form id="setting" class="form-style">
        <h2>Votre compte est en cours de vérification</h2>
        <img src="../IMAGE/sablier.gif" id="gif">
        </form>
        `;
    };
});


