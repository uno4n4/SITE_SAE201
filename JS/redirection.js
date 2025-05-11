function rediriger() {
    const quantite = document.getElementById("quantite").value;
    const produit = document.getElementById("nomproduit").innerText; // à remplacer dynamiquement si besoin
    window.location.href = `../HTML/reservation.php?id=${encodeURIComponent(produit)}&quantite=${quantite}`;
  }
  function rediriger2() {
    const quantite = document.getElementById("quantite").value;
    const produit = document.getElementById("nomproduit").innerText; // à remplacer dynamiquement si besoin
    window.location.href = `../HTML/reserver.php?id=${encodeURIComponent(produit)}&quantite=${quantite}`;
  }
  