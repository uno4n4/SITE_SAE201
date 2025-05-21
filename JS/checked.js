document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
    checkbox.addEventListener('change', reservationSelect);
});

function reservationSelect() {
    const checkedreserve = document.querySelectorAll('input[type="checkbox"]:checked');
    const Nbselection = document.getElementById('selection');
    Nbselection.textContent = checkedreserve.length + ' Réservations sélectionnées';
}
document.addEventListener('DOMContentLoaded', () => {
    const table = document.querySelector('table'); // ou remplace par un ID si t’as

    table.addEventListener('click', function (e) {
        if (e.target.closest('.modifier-btn')) {
            e.preventDefault();

            const btn = e.target.closest('.modifier-btn');
            const tr = btn.closest('.ligne-materiel');
            const inputs = tr.querySelectorAll('.champ-input');

            inputs.forEach(input => {
                input.disabled = false;
                $disabled = '';
            });
        }
    });
});


document.getElementById('modifier').addEventListener('click', function (e) {
    e.preventDefault(); // Pour éviter un submit si c’est dans un form

    // Récupère toutes les checkbox cochées
    const checkedBoxes = document.querySelectorAll('.reservation-checkbox:checked');
    const valid = document.getElementById('valid');
    valid.style.display = 'block';


    checkedBoxes.forEach(checkbox => {
        // Récupère la ligne <tr> parente
        const tr = checkbox.closest('tr');
        // Trouve les inputs time et date dans cette ligne
        const inputs = tr.querySelectorAll('input[type="time"], input[type="date"]');

        inputs.forEach(input => {
            input.disabled = false;
            if (input.type === 'date') {
                input.readOnly = false;
            }
        });
    });
});

document.getElementById('flexCheckChecked').addEventListener('change', function () {
    if (this.checked) {
        aujourdhui();
    } else {
        // Si on décoche, on peut tout déchecker
        const checkboxes = document.querySelectorAll('tr input[type="checkbox"]');
        checkboxes.forEach(cb => cb.checked = false);
    }
});

function aujourdhui() {
    // 1. Date du jour
    const today = new Date().toISOString().split('T')[0];

    // 2. On la met dans l'input #jour
    const jourInput = document.getElementById('jour');
    if (jourInput) {
        jourInput.value = today;
    }

    // 3. On check les checkbox des réservations qui ont cette date
    const lignes = document.querySelectorAll('tr'); // chaque tr = une réservation
    lignes.forEach(ligne => {
        const dateInput = ligne.querySelector('input[type="date"]');
        const checkbox = ligne.querySelector('input[type="checkbox"]');

        if (dateInput && checkbox && dateInput.value === today) {
            checkbox.checked = true;
        }
    });
}

updateCheckedCount(); // Initialisation