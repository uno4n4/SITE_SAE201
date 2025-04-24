let currentYear = 2025;
let currentMonth = 3; // Avril (0 = janvier)

const monthYearElement = document.getElementById("month-year");
const calendarDaysElement = document.getElementById("calendar-days");

function generateCalendar(year, month) {
    // Obtenir le premier jour du mois
    let firstDay = new Date(year, month, 1).getDay();
    let adjustedFirstDay = (firstDay === 0) ? 6 : firstDay - 1;

    let daysInMonth = new Date(year, month + 1, 0).getDate();

    // Capitaliser le nom du mois
    const monthNameRaw = new Date(year, month).toLocaleString('default', { month: 'long' });
    const monthName = monthNameRaw.charAt(0).toUpperCase() + monthNameRaw.slice(1);
    monthYearElement.textContent = `${monthName} ${year}`;

    calendarDaysElement.innerHTML = "";
    let row = document.createElement("tr");

    // Cellules vides avant le 1er du mois
    for (let i = 0; i < adjustedFirstDay; i++) {
        let cell = document.createElement("td");
        row.appendChild(cell);
    }

    let currentColumn = adjustedFirstDay;

    for (let day = 1; day <= daysInMonth; day++) {
        let weekday = new Date(year, month, day).getDay();
        if (weekday !== 0 && weekday !== 6) { // Exclure dimanche et samedi
            if (currentColumn > 4) {
                calendarDaysElement.appendChild(row);
                row = document.createElement("tr");
                currentColumn = 0;
            }

            let cell = document.createElement("td");
            cell.textContent = day;
            row.appendChild(cell);
            currentColumn++;
        }
    }

    // Ajouter la dernière ligne si nécessaire
    if (row.childElementCount > 0) {
        calendarDaysElement.appendChild(row);
    }
}

function prevMonth() {
    if (currentMonth === 0) {
        currentMonth = 11;
        currentYear--;
    } else {
        currentMonth--;
    }
    generateCalendar(currentYear, currentMonth);
}

function nextMonth() {
    if (currentMonth === 11) {
        currentMonth = 0;
        currentYear++;
    } else {
        currentMonth++;
    }
    generateCalendar(currentYear, currentMonth);
}

document.querySelector(".prev-month").addEventListener("click", prevMonth);
document.querySelector(".after-month").addEventListener("click", nextMonth);

generateCalendar(currentYear, currentMonth);
