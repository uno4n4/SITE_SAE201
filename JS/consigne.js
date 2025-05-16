document.getElementById('gras').addEventListener('click', () => {
  document.execCommand('bold');
});

document.getElementById('italic').addEventListener('click', () => {
  document.execCommand('italic');
});

document.getElementById('link').addEventListener('click', () => {
  let url = prompt("Entrez l'URL");
  if (url) {
    document.execCommand('createLink', false, url);
  }
});

// Alignements :
document.getElementById('gauche').addEventListener('click', () => {
  document.execCommand('justifyLeft');
});
document.getElementById('centre').addEventListener('click', () => {
  document.execCommand('justifyCenter');
});
document.getElementById('droite').addEventListener('click', () => {
  document.execCommand('justifyRight');
});
document.getElementById('aligner').addEventListener('click', () => {
  document.execCommand('justifyFull');
});
document.getElementById('cote-droite').addEventListener('click', () => {
  document.execCommand('outdent');
});
document.getElementById('cote-gauche').addEventListener('click', () => {
  document.execCommand('indent');
});

document.getElementById('voir').addEventListener('click', () => {
  alert(document.getElementById('ecrire').innerHTML);
});

document.getElementById('enregistrer').addEventListener('click', function(e) {
    e.preventDefault();  // empêche le rechargement

    const contenu = document.getElementById('zone-ecriture').innerHTML;

    fetch('../PHP/gest-reservation.php', {  // ta page PHP pour sauvegarder
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'contenu=' + encodeURIComponent(contenu)
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById('message').textContent = data;  // affiche message de confirmation ou erreur
    })
    .catch(error => {
        document.getElementById('message').textContent = 'Erreur : ' + error;
    });
});