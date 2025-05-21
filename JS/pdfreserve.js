function telechargepdf() {
const element = document.getElementById('pdf-content');
element.style.display = 'block';

// Attendre que le DOM l'affiche avant de lancer html2pdf
setTimeout(() => {
html2pdf()
.set({
margin: 1,
filename: 'reservation.pdf',
image: { type: 'jpeg', quality: 0.98 },
html2canvas: { scale: 2 },
jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
})
.from(element)
.save()
.then(() => {
// Cacher à nouveau après génération
element.style.display = 'none';
});
}, 100);
}


function telechargepdfstat() {
const element = document.getElementById('pdf-contentstat');
const bouton = document.getElementById('telecharge')
bouton.style.display = 'none';

// Attendre que le DOM l'affiche avant de lancer html2pdf
setTimeout(() => {
html2pdf()
.set({
margin: 1,
filename: 'statistiques.pdf',
image: { type: 'jpeg', quality: 0.98 },
html2canvas: { scale: 2 },
jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
})
.from(element)
.save()
.then(() => {
// Cacher à nouveau après génération
bouton.style.display = 'block';
});
}, 100);
}