document.getElementById("btn-etudiant").onclick = function() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les étudiants : </h2>
    <form id="form-etudiant" class="form-style">
    <h3>1. Informations Personnelles</h3>
    <label>Nom :</label>
    <input type="text" placeholder="Ex : Domingues" required><br>
    <label>Prénom :</label>
    <input type="text" placeholder="Ex : Clara" required><br>
    <label>Date de naissance :</label>
    <input type="date" required><br>

    <h3>2. Informations de contact</h3>
    <div class="input-icon">
        <label>Adresse email universitaire :</label>
        <input type="email" placeholder="Ex : clara.domingues@edu.univ-eiffel.fr" required><i class="fa-solid fa-envelope"></i>
    </div>
    <div class="input-icon">
        <label>Numéro de téléphone :</label>
        <input type="tel" placeholder="Ex : 0606060606" required><i class="fa-solid fa-phone"></i>
    </div>
    <div class="input-icon">
        <label>Adresse postale :</label>
        <input type="text" placeholder="Ex : 1 Rue de Paris" required><i class="fa-solid fa-house"></i>
    </div>
    
    <h3>3. Informations académiques</h3>
    <label>Numéro étudiant : </label>
    <input type="text" placeholder="Ex : 210000" required><br>
    <label for="formations">Formation :</label>
    <select name="formations">
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
    
    <h3>4. Informations du compte</h3>
    <label>Pseudo : </label>
    <input type="text" placeholder="Ex : noob1234" required><br>
    <label>Mot de passe : </label>
    <input type="password" required><br>
    
    <input type="submit" value="Soumettre" id="submit1">
    </form>`;

    //validation email étudiant : 
    document.getElementById("form-etudiant").onsubmit = function(event) {
        const email = document.getElementById("email-etudiant").value;
        const regex = /^[a-zA-Z0-9._%+-]+@edu\.univ-eiffel\.fr$/;

        if(!regex.text(email)) {
            alert("L'email doit être de la forme xxx@edu.univ-eiffel.fr");
            event.preventDefault();
        }
    };
};

document.getElementById("btn-prof").onclick = function() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les professeurs : </h2>
    <form id="form-prof" class="form-style">
    <h3>1. Informations Personnelles</h3>
    <label>Nom :</label>
    <input type="text" placeholder="Ex : Domingues" required><br>
    <label>Prénom :</label>
    <input type="text" placeholder="Ex : Clara" required><br>
    <label>Date de naissance :</label>
    <input type="date" required><br>

    <h3>2. Informations de contact</h3>
    <div class="input-icon">
        <label>Adresse email universitaire :</label>
        <input type="email" placeholder="Ex : clara.domingues@univ-eiffel.fr" required><i class="fa-solid fa-envelope"></i>
    </div>
    <div class="input-icon">
        <label>Numéro de téléphone :</label>
        <input type="tel" placeholder="Ex : 0606060606" required><i class="fa-solid fa-phone"></i>
    </div>
    <div class="input-icon">
        <label>Adresse postale :</label>
        <input type="text" placeholder="Ex : 1 Rue de Paris" required><i class="fa-solid fa-house"></i>
    </div>
    
    <h3>3. Informations du compte</h3>
    <label>Pseudo : </label>
    <input type="text" placeholder="Ex : noob1234" required><br>
    <label>Mot de passe : </label>
    <input type="password" required><br>
    
    <input type="submit" value="Soumettre" id="submit2">
    </form>`;

 //validation email prof : 
    document.getElementById("form-prof").onsubmit = function(event) {
        const email = document.getElementById("email-prof").value;
        const regex = /^[a-zA-Z0-9._%+-]+@univ-eiffel\.fr$/;

        if(!regex.text(email)) {
            alert("L'email doit être de la forme xxx@univ-eiffel.fr");
            event.preventDefault();
        }
    };
};
