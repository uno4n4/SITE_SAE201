document.addEventListener("DOMContentLoaded", function () {
  const check = document.querySelectorAll(".appro-checkbox");
  const div = document.getElementById("select");
  const kebabIcon = document.getElementById("kebabs-icon");
  const contentAccept = document.getElementById("content-accept");

  function updateSelectionCount() {
    const selectedCount = Array.from(check).filter((c) => c.checked).length;
    div.textContent = `${selectedCount} compte${
      selectedCount !== 1 ? "s" : ""
    } sélectionné${selectedCount !== 1 ? "s" : ""}`;
    kebabIcon.style.display = selectedCount > 0 ? "block" : "none";

    // (optionnel) cacher le formulaire si aucune sélection
    if (selectedCount === 0) {
      contentAccept.innerHTML = "";
      contentAccept.style.display = "none";
    }
  }

  check.forEach((c) => c.addEventListener("change", updateSelectionCount));

  kebabIcon.addEventListener("click", function () {
    contentAccept.style.display = "block";
    contentAccept.innerHTML = `
      <form action="../PHP/gest-comptes.php" method="post">
        <input type="hidden" name="Nom">
        <ul class="d-flex flex-column list-unstyled m-3 gap-2">
          <li><button type="submit" class="btn btn-success text-white" name="accept">Accepter</button></li>
          <li><button type="submit" class="btn btn-danger text-white" name="refuse">Refuser</button></li>
        </ul>
      </form>
    `;
  });
});


document.addEventListener("DOMContentLoaded", function(){
  const buttonKebab = document.querySelectorAll('.icon-kebab');
  const contents = document.querySelectorAll('.kebabs-menu');

  buttonKebab.forEach((button, index) => {
    button.addEventListener("click", function(event){
      event.stopPropagation(); // Évite la fermeture immédiate

      // Fermer tous les autres menus
      contents.forEach(content => {
        content.style.display = "none";
        content.innerHTML = "";
      });

      const content = contents[index];

      content.style.display = "block";
      content.innerHTML = `
      <form action="../PHP/gest-comptes.php" method="post">
        <ul class="d-flex flex-column">
            <li><button type="submit" class="vert" name="accept">Accepter</button></li>
            <li><button type="submit" class="rouge" name="refuse">Refuser</button></li>
        </ul>
      </form>
      `;
    });
  });

  // Fermer tous les menus si on clique ailleurs
  document.addEventListener("click", function(){
    contents.forEach(content => {
      content.style.display = "none";
      content.innerHTML = "";
    });
  });

  // Ne pas fermer si on clique dans le menu
  contents.forEach(content => {
    content.addEventListener("click", function(event){
      event.stopPropagation();
    });
  });
});



/* CHECKBOX */

document.addEventListener("DOMContentLoaded", function() {
  const checkboxes = document.querySelectorAll('.compte-checkbox');  // Sélectionne toutes les checkboxes
  const display = document.getElementById('selection'); // La div où on affiche le comptage
  const kebabIcon = document.getElementById('kebab-icon');
  
  // Fonction pour mettre à jour le nombre de comptes sélectionnés
  function updateSelectionCount() {
    const selectedCount = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
    display.textContent = `${selectedCount} compte${selectedCount !== 1 ? 's' : ''} sélectionné${selectedCount !== 1 ? 's' : ''}`;
    if (selectedCount > 0) {
      kebabIcon.style.display = 'block';  // Affiche l'icône
    } else {
      kebabIcon.style.display = 'none';   // Cache l'icône si aucune case n'est cochée
    }
  }

  // Ajoute un événement sur chaque checkbox pour mettre à jour le comptage à chaque changement
  checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', updateSelectionCount);
  });
});







document.addEventListener("DOMContentLoaded", function(){
  const kebabButton = document.querySelectorAll('.kebab-icon');
  const containers = document.querySelectorAll('.kebab-menu');

  kebabButton.forEach((button, index) => {
    button.addEventListener("click", function(event){
      event.stopPropagation(); // Évite la fermeture immédiate

      // Fermer tous les autres menus
      containers.forEach(container => {
        container.style.display = "none";
        container.innerHTML = "";
      });

      const container = containers[index];
      const Pseudo = container.getAttribute('data-pseudo');

      container.style.display = "block";
      container.innerHTML = `
        <ul>
          <a href="../PHP/modifier-compte.php?Pseudo=${Pseudo}">
            <li><button type="button">Modifier</button></li>
            <li><button type="button">Supprimer</button></li>
          </a>
        </ul>
      `;
    });
  });

  // Fermer tous les menus si on clique ailleurs
  document.addEventListener("click", function(){
    containers.forEach(container => {
      container.style.display = "none";
      container.innerHTML = "";
    });
  });

  // Ne pas fermer si on clique dans le menu
  containers.forEach(container => {
    container.addEventListener("click", function(event){
      event.stopPropagation();
    });
  });
});


