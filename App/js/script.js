let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
let calendarBody = document.getElementById('calendar-body');
let calendarHeader = document.getElementById('month-year');
let fstdy;
let dym;

function generateCalendar() {
    let firstDay = new Date(currentYear, currentMonth, 1).getDay();
    let daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
    fstdy = firstDay;
    dym = daysInMonth;
    calendarBody.innerHTML = '';
    calendarHeader.innerHTML = getMonthName(currentMonth) + ' ' + currentYear;
    console.log(firstDay);
    console.log(daysInMonth);
    // console.log(calendarHeader.innerHTML);

    // Membuat permintaan AJAX menggunakan fetch()
    fetch('get_rentang_tanggal.php')
        .then((response) => response.json())
        .then((data) => {
            // Data rentang tanggal berhasil diterima
            let rentangTanggal = data;
            // Lakukan sesuatu dengan rentangTanggal di sini
            console.log(rentangTanggal);

            let date = 1;
            for (let i = 0; i < 6; i++) {
                let row = document.createElement('tr');
                for (let j = 0; j < 7; j++) {
                    if (i === 0 && j < fstdy) {
                        let cell = document.createElement('td');
                        row.appendChild(cell);
                    } else if (date > dym) {
                        break;
                    } else {
                        let cell = document.createElement('td');
                        cell.innerHTML = date;

                        // Periksa apakah tanggal saat ini berada dalam salah satu rentang tanggal
                        for (let k = 0; k < rentangTanggal.length; k++) {
                            let { tahun, bulan, tgl_mulai, tgl_selesai } =
                                rentangTanggal[k];
                            if (
                                currentYear === tahun &&
                                currentMonth === bulan &&
                                date >= tgl_mulai &&
                                date <= tgl_selesai
                            ) {
                                cell.style.background = 'lightblue';
                                break; // Hentikan perulangan jika gaya sudah diberikan
                            }
                        }

                        row.appendChild(cell);
                        date++;
                    }
                }
                calendarBody.appendChild(row);
            }
        })
        .catch((error) => {
            // Terjadi kesalahan saat memuat data
            console.error(error);
        });

    document.getElementById('showData').innerHTML =
        'Agenda bulan ' + calendarHeader.innerHTML;
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
        0: 'Januari',
        1: 'Februari',
        2: 'Maret',
        3: 'April',
        4: 'Mei',
        5: 'Juni',
        6: 'Juli',
        7: 'Agustus',
        8: 'September',
        9: 'October',
        10: 'November',
        11: 'Desember',
    };
    return monthNames[monthIndex];
}

generateCalendar();

document.getElementById('showData').addEventListener('click', function (e) {
    window.location.href =
        'index?data=' +
        encodeURIComponent(getMonthName(currentMonth)) +
        '-' +
        encodeURIComponent(currentYear);

    document.getElementById('formSearch').submit();
});

document.getElementById('hiddenData').addEventListener('click', function () {
    document.getElementByClassName('table-container')[0].innerHTML = '';
});
