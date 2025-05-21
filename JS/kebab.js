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
    // Crée un tableau des noms sélectionnés
    const selectedNames = Array.from(check)
      .filter((checkbox) => checkbox.checked)
      .map((checkbox) => checkbox.closest("form").querySelector("input[name='Nom']").value);

    if (selectedNames.length === 0) return;

    // Afficher le formulaire
    contentAccept.style.display = "block";
    contentAccept.innerHTML = `
      <form action="../PHP/gest-comptes.php" method="post">
        <input type="hidden" name="noms" value="${selectedNames.join(',')}">
        <ul class="d-flex flex-column list-unstyled m-3 gap-2">
          <li><button type="submit" class="btn btn-success text-white" name="accepter">Accepter</button></li>
          <li><button type="submit" class="btn btn-danger text-white" name="refuser">Refuser</button></li>
        </ul>
      </form>
    `;
  });

  // Initialisation du compteur au cas où des cases seraient déjà sélectionnées lors du chargement
  updateSelectionCount();
});



/* CHECKBOX */

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



