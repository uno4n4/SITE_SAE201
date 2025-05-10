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
            </a>
            <li><button type="button">Supprimer</button></li>
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
