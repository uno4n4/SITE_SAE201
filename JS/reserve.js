
function nextForm(e) {
    let etapes = document.getElementById("steps").children;
    let form = e.target.closest("section");
    form.style.display = 'none';
    form.nextElementSibling.style.display = 'block';
    for (let i = 0; i <= form.id; i++) {
        etapes[i].textContent = '☑️';
    }
}

function previousForm(e) {
    let etapes = document.getElementById("steps").children;
    let form = e.target.closest("section");
    form.style.display = 'none';
    form.previousElementSibling.style.display = 'block';
    etapes[parseInt(form.id) - 1].textContent = parseInt(form.id);
}

function fermer() {
    let msg = document.getElementById("msgConfirmation");
    msg.style.display = 'none';
} 