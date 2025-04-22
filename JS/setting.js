//REGLAGES :

document.getElementById("reglage").onclick = function() {
    console.log("bouton cliqué");
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<form id="setting" class="form-style">
    <label for="photoUpload">
        <img src="../IMAGE/logo-iut.png" alt="Photo de profil" id="photo">
    </label>
    <input type="file" id="photoUpload" hidden>
    <button type="button" id="changer">Changer</button>
    <button type="button" id="supp">Supprimer la photo</button>
    <br><label>Nom *</label>
    <input type="text" id="Nom"><br>
    <label>Prénom *</label>
    <input type="text" id="Prenom"><br>
    <label>Email *</label>
    <input type="text" id="Email"><br>
    <label>Numéro de téléphone *</label>
    <input type="text" id="Tel"><br>
    <button type="submit" id="submit">Enregistrer les changements</button>
    </form>
    `;
};