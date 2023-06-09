let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
let calendarBody = document.getElementById("calendar-body");
let calendarHeader = document.getElementById("month-year");
let fstdy;
let dym;

function generateCalendar() {
    let firstDay = new Date(currentYear, currentMonth, 1).getDay();
    let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    fstdy = firstDay;
    dym = daysInMonth;
    calendarBody.innerHTML = "";
    calendarHeader.innerHTML = getMonthName(currentMonth) + " " + currentYear;
    console.log(firstDay);
    console.log(daysInMonth);
    // console.log(calendarHeader.innerHTML);
    let date = 1;
    for (let i = 0; i < 6; i++) {
        let row = document.createElement("tr");
        for (let j = 0; j < 7; j++) {
            if (i === 0 && j < fstdy) {
                let cell = document.createElement("td");
                row.appendChild(cell);
            } else if (date > dym) {
                break;
            } else {
                let cell = document.createElement("td");
                cell.innerHTML = date;
                row.appendChild(cell);
                date++;
            }
        }
        calendarBody.appendChild(row);
    }
    document.getElementById("showData").innerHTML = "Agenda bulan " + calendarHeader.innerHTML;
}


function prevMonth() {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    generateCalendar();
}

function nextMonth() {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    generateCalendar();
}

function getMonthName(monthIndex) {
    let monthNames = {
        "0": "Januari",
        "1": "Februari",
        "2": "Maret",
        "3": "April",
        "4": "Mei",
        "5": "Juni",
        "6": "Juli",
        "7": "Agustus",
        "8": "September",
        "9": "October",
        "10": "November",
        "11": "Desember"
    };
    return monthNames[monthIndex];
}

generateCalendar();

document.getElementById("showData").addEventListener('click', function (e) {
    window.location.href = 'index?data=' + encodeURIComponent(getMonthName(currentMonth)) + "-" + encodeURIComponent(currentYear);

    document.getElementById("formSearch").submit();
});

document.getElementById("hiddenData").addEventListener('click', function () {
    document.getElementByClassName("table-container")[0].innerHTML = "";
});