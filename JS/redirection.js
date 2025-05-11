function rediriger() {
    const quantiteElement = document.getElementById("quantite");
    const quantite = quantiteElement ? quantiteElement.value : 1;
    const produit = document.getElementById("nomproduit").innerText; // à remplacer dynamiquement si besoin
    window.location.href = `../PHP/reservation.php?id=${encodeURIComponent(produit)}&quantite=${quantite}`;
  }
  