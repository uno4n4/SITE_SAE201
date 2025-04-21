function rediriger() {
    const quantite = document.getElementById("quantite").value;
    const produit = document.getElementById("nomproduit").innerText; // à remplacer dynamiquement si besoin
    window.location.href = `../HTML/reservation.html?produit=${encodeURIComponent(produit)}&quantite=${quantite}`;
  }
  