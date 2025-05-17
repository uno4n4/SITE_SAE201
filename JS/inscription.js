document.getElementById("btn-etudiant").onclick = function() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les étudiants : </h2>
    <form method="post" action="../PHP/inscription.php" id="form-etudiant" class="form-style" novalidate>
        <div id="etape1">
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

        <div id="etape2" style="display:none">
            <h3>2. Informations de contact</h3>
            <div class="input-icon">
                <label for="Email">Adresse email universitaire :</label>
                <input name="Email" id="Email" type="email" placeholder="Ex : clara.domingues@edu.univ-eiffe.fr" pattern=".+@edu\.univ-eiffel\.fr$" title="L'email doit finir par @edu.univ-eiffel.fr" required><i class="fa-solid fa-envelope"></i>
                <div id="emailError" style="color:red; display:none;"></div>
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
            <h3>3. Informations académiques</h3>
            <label for="Numetu">Numéro étudiant : </label>
                <input name="Numetu" id="Numetu" type="text" placeholder="Ex : 210000" required><br>
            <label for="formations">Formation :</label>
            <select name="Formations" id="Formations">
                <option value="MMI1">BUT MMI 1</option>
                <option value="MMI2">BUT MMI 2</option>
                <option value="MMI3">BUT MMI 3</option>
            </select>
            <select name="TD">
                <option value="TD1">TD 1</option>
                <option value="TD2">TD 2</option>
                <option value="TD3">TD 3</option>
            </select>
            <select name="TP">
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
            <h3>4. Informations du compte</h3>
            <label for="Pseudo">Pseudo : </label>
                <input name="Pseudo" id="Pseudo" type="text" placeholder="Ex : noob1234" required><br>
                <div id="msgPseudo" style="color:red; display:none;"></div>
            <label for="Mdp">Mot de passe : </label>
                <input name="Mdp" id="Mdp" type="password" required><br>
            <div class="button-container">
                <button type="button" onclick="etape3()">Précédent</button>
            </div>
    
            <button type="submit" class="submit">Soumettre</button>
        </div>
                <div id="formEleveError" style="color:red; display:none"></div>
    </form>`;
     const emailInput = document.getElementById('Email');
    const emailError = document.getElementById('emailError');

  emailInput.addEventListener('input', () => {
    if (emailInput.validity.valid) {
      emailError.style.display = 'none';
      emailError.textContent = '';
    } else {
      emailError.style.display = 'block';
      emailError.textContent = emailInput.validationMessage || "Format incorrect";
    }
  });

  const pseudoInput = document.getElementById('Pseudo');
const messagePseudo = document.getElementById('msgPseudo');
const form = document.querySelector('form');  // Cible le formulaire
const erreurEleve = document.getElementById("formEleveError");

// Cette variable sert à vérifier l'état du pseudo (disponible ou déjà utilisé)
let pseudoDisponible = false;

pseudoInput.addEventListener("input", function () {
    const Pseudo = pseudoInput.value.trim().toLowerCase();

    // Si le champ est vide, on cache le message d'erreur
    if (Pseudo.length === 0) {
        messagePseudo.style.display = 'none';
        messagePseudo.textContent = '';
        return;
    }

    // On fait une vérification côté serveur (ici tu pourrais utiliser une API ou une logique PHP côté serveur)
    fetch("../PHP/inscription.php?Pseudo=" + encodeURIComponent(Pseudo))
        .then(res => res.text())
        .then(data => {
            if (data === "pris") {
                messagePseudo.style.display = 'block';
                messagePseudo.textContent = "Ce pseudo est déjà utilisé.";
                messagePseudo.style.color = 'red';  // Le message en rouge pour une erreur
                pseudoDisponible = false;  // Le pseudo n'est pas disponible
            } else if (data === "dispo") {
                messagePseudo.style.display = 'block';
                messagePseudo.textContent = "Ce pseudo est disponible";
                messagePseudo.style.color = 'green';  // Le message en vert pour la disponibilité
                pseudoDisponible = true;  // Le pseudo est disponible
            } else {
                messagePseudo.style.display = 'none';  // Aucun message si l'état est indéfini
                pseudoDisponible = false;
            }
        })
        .catch(err => {
            messagePseudo.style.display = 'block';
            messagePseudo.textContent = "Erreur lors de la vérification";
            messagePseudo.style.color = 'red';  // Message d'erreur en cas de problème de réseau
            pseudoDisponible = false;
        });
});

// Empêcher la soumission du formulaire si le pseudo n'est pas disponible
form.addEventListener('submit', function (e) {
    let formValid = true;

    // Vérifie les champs required manuellement
    const requiredFields = form.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            formValid = false;
        }
    });

    if (!formValid) {
        e.preventDefault();
        erreurEleve.style.display = 'block';
        erreurEleve.textContent = "Un champ requis a été oublié.";
        erreurEleve.scrollIntoView({ behavior: 'smooth'});
        return;
    }

    // Vérifie la disponibilité du pseudo
    if (!pseudoDisponible) {
        e.preventDefault();
        messagePseudo.style.display = 'block';
        messagePseudo.textContent = "Veuillez choisir un pseudo disponible avant de soumettre le formulaire.";
        messagePseudo.style.color = 'red';

        erreurEleve.style.display = 'block';
        erreurEleve.textContent = "";  // On efface le message de champ oublié si c’est juste le pseudo
    }
});


}

// FORMULAIRE POUR LES PROFS : 


document.getElementById("btn-prof").onclick = function() {
    document.getElementById("form-container").style.display = "block";
    document.getElementById("form-container").innerHTML = 
    `<h2>Formulaire d'inscription pour les professeurs : </h2>
    <form method="post" action="../PHP/inscription.php" id="form-prof" class="form-style" novalidate>
        <div id="etape1prof">
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
        </div>
 
        <div id="etape2prof" style="display:none">
            <h3>2. Informations de contact</h3>
            <div class="input-icon">
                <label for="Emailprof">Adresse email universitaire :</label>
                <input name="Emailprof" id="Emailprof" type="email" placeholder="Ex : clara.domingues@univ-eiffel.fr" pattern=".+@univ-eiffel\.fr$" title="L'email doit finir par @univ-eiffel.fr" required><i class="fa-solid fa-envelope"></i>
                <div id="emailErrorProf" style="color:red; display:none;"></div>
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
        </div>

        <div id="etape3prof" style="display:none">
            <h3>3. Informations du compte</h3>
            <label for="Pseudoprof">Pseudo : </label>
            <input name="Pseudoprof" id="Pseudoprof" type="text" placeholder="Ex : noob1234" required><br>
            <div id="msgPseudoProf" style="color:red; display:none;"></div>
            <label for="Mdpprof">Mot de passe : </label>
            <input name="Mdpprof" id="Mdpprof" type="password" required><br>
            <div class="button-container">
                <button type="button" onclick="etape2prof()">Précédent</button>
            </div>
            <button type="submit" class="submit">Soumettre</button>
        </div>
        <div id="formProfError" style="color:red; display:none"></div>
    </form>`; 
    const emailInputProf = document.getElementById('Emailprof');
    const emailErrorProf = document.getElementById('emailErrorProf');

  emailInputProf.addEventListener('input', () => {
    if (emailInputProf.validity.valid) {
      emailErrorProf.style.display = 'none';
      emailErrorProf.textContent = '';
    } else {
      emailErrorProf.style.display = 'block';
      emailErrorProf.textContent = emailInputProf.validationMessage || "Format incorrect";
    }
  });

  
  const pseudoProf = document.getElementById('Pseudoprof');
const messageProf = document.getElementById('msgPseudoProf');
const formProf = document.getElementById('form-prof');  // Cible le formulaire
const errorBox = document.getElementById("formProfError");

// Cette variable sert à vérifier l'état du pseudo (disponible ou déjà utilisé)
let pseudoProfDisponible = false;

pseudoProf.addEventListener("input", function () {
    const Pseudo = pseudoProf.value.trim().toLowerCase();

    // Si le champ est vide, on cache le message d'erreur
    if (Pseudo.length === 0) {
        messageProf.style.display = 'none';
        messageProf.textContent = '';
        return;
    }

    // On fait une vérification côté serveur (ici tu pourrais utiliser une API ou une logique PHP côté serveur)
    fetch("../PHP/inscription.php?Pseudo=" + encodeURIComponent(Pseudo))
        .then(res => res.text())
        .then(data => {
            if (data === "pris") {
                messageProf.style.display = 'block';
                messageProf.textContent = "Ce pseudo est déjà utilisé.";
                messageProf.style.color = 'red';  // Le message en rouge pour une erreur
                pseudoProfDisponible = false;  // Le pseudo n'est pas disponible
            } else if (data === "dispo") {
                messageProf.style.display = 'block';
                messageProf.textContent = "Ce pseudo est disponible";
                messageProf.style.color = 'green';  // Le message en vert pour la disponibilité
                pseudoProfDisponible = true;  // Le pseudo est disponible
            } else {
                messageProf.style.display = 'none';  // Aucun message si l'état est indéfini
                pseudoProfDisponible = false;
            }
        })
        .catch(err => {
            messageProf.style.display = 'block';
            messageProf.textContent = "Erreur lors de la vérification";
            messageProf.style.color = 'red';  // Message d'erreur en cas de problème de réseau
            pseudoProfDisponible = false;
        });
});


formProf.addEventListener('submit', function (e) {
    let formValid = true;

    // Vérifie les champs required manuellement
    const requiredFields = formProf.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            formValid = false;
        }
    });

    if (!formValid) {
        e.preventDefault();
        errorBox.style.display = 'block';
        errorBox.textContent = "Un champ requis a été oublié.";
        errorBox.scrollIntoView({ behavior: 'smooth'});
        return;
    }

    // Vérifie la disponibilité du pseudo
    if (!pseudoProfDisponible) {
        e.preventDefault();
        messageProf.style.display = 'block';
        messageProf.textContent = "Veuillez choisir un pseudo disponible avant de soumettre le formulaire.";
        messageProf.style.color = 'red';

        errorBox.style.display = 'block';
        errorBox.textContent = "";  // On efface le message de champ oublié si c’est juste le pseudo
    }
});

}
    



    
function etape1(){
    document.getElementById("etape1").style.display = "block";
    document.getElementById("etape2").style.display = "none";
    document.getElementById("etape3").style.display = "none";
    document.getElementById("etape4").style.display = "none"; 
}

function etape2() {
    document.getElementById("etape1").style.display = "none";
    document.getElementById("etape2").style.display = "block";
    document.getElementById("etape3").style.display = "none";
    document.getElementById("etape4").style.display = "none";
}

function etape3() {
    document.getElementById("etape1").style.display = "none";
    document.getElementById("etape2").style.display = "none";
    document.getElementById("etape3").style.display = "block";
    document.getElementById("etape4").style.display = "none";
}

function etape4() {
    document.getElementById("etape1").style.display = "none";
    document.getElementById("etape2").style.display = "none";
    document.getElementById("etape3").style.display = "none";
    document.getElementById("etape4").style.display = "block";
}

//PROF :

function etape1prof(){
    document.getElementById("etape1prof").style.display = "block";
    document.getElementById("etape2prof").style.display = "none";
    document.getElementById("etape3prof").style.display = "none";
}

function etape2prof() {
    document.getElementById("etape1prof").style.display = "none";
    document.getElementById("etape2prof").style.display = "block";
    document.getElementById("etape3prof").style.display = "none";
}

function etape3prof() {
    document.getElementById("etape1prof").style.display = "none";
    document.getElementById("etape2prof").style.display = "none";
    document.getElementById("etape3prof").style.display = "block";
}

