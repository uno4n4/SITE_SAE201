document.getElementById("btn-etudiant").onclick = function() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les étudiants : </h2>
    <form method="post" action="./PHP/inscription.php" id="form-etudiant" class="form-style">
        <div id="etape_1">
            <h3>1. Informations Personnelles</h3>
            <label for="Nom">Nom :</label>
            <input name="Nom" id="Nom" type="text" placeholder="Ex : Domingues" required><br>
            <label for="Prenom">Prénom :</label>
            <input name="Prenom" id="Prenom" type="text" placeholder="Ex : Clara" required><br>
            <label for="Anniv">Date de naissance :</label>
            <input name="Anniv" id="Anniv" type="date" required><br>
            <div class="button-container-r">
                <button type="button" onclick="etape2()">Suivant</button>
            </div>
        </div>

        <div id=etape2" style="display:none">
            <h2>Formulaire d'inscription pour les étudiants : </h2>
            <h3>2. Informations de contact</h3>
            <div class="input-icon">
                <label for="Email">Adresse email universitaire :</label>
                <input name="Email" id="Email" type="email" placeholder="Ex : clara.domingues@edu.univ-eiffel.fr" required><i class="fa-solid fa-envelope"></i>
            </div>
            <div class="input-icon">
                <label for="Tel">Numéro de téléphone :</label>
                <input name="Tel" id="Tel" type="tel" placeholder="Ex : 0606060606" required><i class="fa-solid fa-phone"></i>
            </div>
            <div class="input-icon">
                <label for="Adresse">Adresse postale :</label>
                <input name="Adresse" id="Adresse" type="text" placeholder="Ex : 1 Rue de Paris" required><i class="fa-solid fa-house"></i>
            </div>
            <div class="button-container">
                <button type="button" onclick="etape1()">Précédent</button>
                <button type="button" onclick="etape3()">Suivant</button>
            </div>
        </div>
        
        <div id="etape3" style="display:none">
            <h2>Formulaire d'inscription pour les étudiants : </h2>
            <h3>3. Informations académiques</h3>
            <label for="Numetu">Numéro étudiant : </label>
                <input name="Numetu" id="Numetu" type="text" placeholder="Ex : 210000" required><br>
            <label for="formations">Formation :</label>
            <select name="formations" id="Formations">
                <option value="MMI1">BUT MMI 1</option>
                <option value="MMI2">BUT MMI 2</option>
                <option value="MMI3">BUT MMI 3</option>
            </select>
            <select name="TD : ">
                <option value="TD1">TD 1</option>
                <option value="TD2">TD 2</option>
                <option value="TD3">TD 3</option>
            </select>
            <select name="Groupe de TP">
                <option value="TPA">TP A</option>
                <option value="TPB">TP B</option>
                <option value="TPC">TP C</option>
                <option value="TPD">TP D</option>
                <option value="TPE">TP E</option>
                <option value="TPF">TP F</option>
            </select>
            <div class="button-container">
                <button type="button" onclick="etape2()">Précédent</button>
                <button type="button" onclick="etape4()">Suivant</button>
            </div>
        </div>

        <div id="etape4" style="display:none">
            <h2>Formulaire d'inscription pour les étudiants : </h2>
            <h3>4. Informations du compte</h3>
            <label for="Pseudo">Pseudo : </label>
                <input name="Pseudo" id="Pseudo" type="text" placeholder="Ex : noob1234" required><br>
            <label for="Mdp">Mot de passe : </label>
                <input name="Mdp" id="Mdp" type="password" required><br>
            <div class="button-container">
                <button type="button" onclick="etape3()">Précédent</button>
            </div>
    
            <button type="submit" class="submit">Soumettre</button>
        </div>
    </form>`
}


// FORMULAIRE POUR LES PROFS : 


document.getElementById("btn-prof").onclick = etape1prof;
function etape1prof() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les professeurs : </h2>
    <form method="post" action="./PHP/inscription.php" id="form-prof" class="form-style">
    <h3>1. Informations Personnelles</h3>
    <label for="Nomprof">Nom :</label>
    <input name="Nomprof" id="Nomprof" type="text" placeholder="Ex : Domingues" required><br>
    <label for="Prenomprof">Prénom :</label>
    <input name="Prenomprof" id="Prenomprof" type="text" placeholder="Ex : Clara" required><br>
    <label for="Annivprof">Date de naissance :</label>
    <input name="Annivprof" id="Annivprof" type="date" required><br>
    <div class="button-container-r">
        <button type="button" onclick="etape2prof()">Suivant</button>
    </div>
    </form>
    `;
}

function etape2prof() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les professeurs : </h2>
    <form method="post" action="./PHP/inscription.php" id="form-prof" class="form-style">
    <h3>2. Informations de contact</h3>
    <div class="input-icon">
        <label for="Emailprof">Adresse email universitaire :</label>
        <input name="Emailprof" id="Emailprof" type="email" placeholder="Ex : clara.domingues@univ-eiffel.fr" required><i class="fa-solid fa-envelope"></i>
    </div>
    <div class="input-icon">
        <label for="Numprof">Numéro de téléphone :</label>
        <input name="Numprof" id="Numprof" type="tel" placeholder="Ex : 0606060606" required><i class="fa-solid fa-phone"></i>
    </div>
    <div class="input-icon">
        <label for="Adresseprof">Adresse postale :</label>
        <input name="Adresseprof" id="Adresseprof" type="text" placeholder="Ex : 1 Rue de Paris" required><i class="fa-solid fa-house"></i>
    </div>
    <div class="button-container">
        <button type="button" onclick="etape1prof()">Précédent</button>
        <button type="button" onclick="etape3prof()">Suivant</button>
    </div>
    </form>
    `; 
}

function etape3prof() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les professeurs : </h2>
    <form method="post" action="./PHP/inscription.php" id="form-prof" class="form-style">
    <h3>3. Informations du compte</h3>
    <label for="Pseudoprof">Pseudo : </label>
    <input name="Pseudoprof" id="Pseudoprof" type="text" placeholder="Ex : noob1234" required><br>
    <label for="Mdpprof">Mot de passe : </label>
    <input name="Mdpprof" id="Mdpprof" type="password" required><br>
    <div class="button-container">
        <button type="button" onclick="etape2prof()">Précédent</button>
    </div>
    
    <button type="submit" class="submit" name>Soumettre</button>

    </form>
    `;
}


    


