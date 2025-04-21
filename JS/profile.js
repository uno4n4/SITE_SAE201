let currentYear = 2025; // Année par défaut
let currentMonth = 3; // Mois d'Avril (Les mois commencent à 0 donc 3 = Avril)

const monthYearElement = document.getElementById("month-year"); // Titre mois et année
const calendarDaysElement = document.getElementById("calendar-days"); // Corps du tableau

// Fonction pour générer le calendrier
function generateCalendar(year, month) {
    // Obtenir le premier jour du mois
    let firstDay = new Date(year, month, 1).getDay(); // Premier jour du mois
    let daysInMonth = new Date(year, month + 1, 0).getDate(); // Nombre de jours dans le mois

    // Mettre à jour le titre avec le mois et l'année
    const monthName = new Date(year, month).toLocaleString('default', { month: 'long' });
    monthYearElement.textContent = `${monthName} ${year}`;

    // Calculer les jours sans week-end (samedi et dimanche)
    let days = [];
    for (let day = 1; day <= daysInMonth; day++) {
        let currentDay = new Date(year, month, day).getDay(); // Jour de la semaine (0 = dimanche, 6 = samedi)
        if (currentDay !== 6 && currentDay !== 0) { // Exclure samedi et dimanche
            days.push(day);
        }
    }

    // Remplir le calendrier avec les jours
    calendarDaysElement.innerHTML = ""; // Vider le calendrier avant de le remplir
    let row = document.createElement("tr");

    // Placer des espaces vides pour les jours précédents du mois (avant le premier jour)
    for (let i = 0; i < firstDay - 1; i++) {
        let cell = document.createElement("td");
        row.appendChild(cell);
    }

    // Ajouter les jours valides (sans week-end)
    days.forEach((day, index) => {
        if ((index + firstDay - 1) % 5 === 0 && index !== 0) {
            calendarDaysElement.appendChild(row); // Ajouter la ligne de jours
            row = document.createElement("tr"); // Créer une nouvelle ligne pour les jours suivants
        }

        let cell = document.createElement("td");
        cell.textContent = day;
        row.appendChild(cell);
    });

    // Ajouter la dernière ligne si nécessaire
    if (row.childElementCount > 0) {
        calendarDaysElement.appendChild(row);
    }
}

// Fonction pour naviguer au mois précédent
function prevMonth() {
    if (currentMonth === 0) {
        currentMonth = 11;
        currentYear--;
    } else {
        currentMonth--;
    }
    generateCalendar(currentYear, currentMonth);
}

// Fonction pour naviguer au mois suivant
function nextMonth() {
    if (currentMonth === 11) {
        currentMonth = 0;
        currentYear++;
    } else {
        currentMonth++;
    }
    generateCalendar(currentYear, currentMonth);
}

// Événements pour les boutons de navigation
document.querySelector(".prev-month").addEventListener("click", prevMonth);
document.querySelector(".after-month").addEventListener("click", nextMonth);

// Initialiser le calendrier
generateCalendar(currentYear, currentMonth);
