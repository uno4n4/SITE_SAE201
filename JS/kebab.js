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
    const pseudos = Array.from(check).filter(c => c.checked).map(c => c.getAttribute('data-pseudo'));
    contentAccept.innerHTML = `
      <form action="../PHP/gest-comptes.php" method="post">
        ${pseudos.map(pseudo => `<input type="hidden" name="choix[]" value="${pseudo}">`).join('')}
        <ul class="d-flex flex-column list-unstyled m-3 gap-2">
          <li><button type="submit" class="btn btn-success text-white" name="accept">Accepter</button></li>
          <li><button type="submit" class="btn btn-danger text-white" name="refuse">Refuser</button></li>
        </ul>
      </form>
    `;
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







document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".kebab-icon").forEach(icon => {
    icon.addEventListener("click", e => {
      e.stopPropagation();
      const menu = icon.nextElementSibling;

      // Ferme les autres menus
      document.querySelectorAll(".kebab-menu").forEach(m => {
        if (m !== menu) m.style.display = "none";
      });

      // Toggle le menu
      const isVisible = menu.style.display === "block";
      menu.style.display = isVisible ? "none" : "block";

      if (!isVisible) {
        const pseudo = menu.dataset.pseudo;

        menu.innerHTML = `
          <ul>
            <a href="../PHP/modifier-compte.php?Pseudo=${pseudo}">
              <li><button type="button">Modifier</button></li>
              <li><button type="button">Supprimer</button></li>
            </a>
          </ul>`;
      }
    });
  });

  // Clique en dehors → ferme tous les menus
  document.addEventListener("click", () => {
    document.querySelectorAll(".kebab-menu").forEach(menu => {
      menu.style.display = "none";
    });
  });
});



