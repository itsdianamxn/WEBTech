document.addEventListener('DOMContentLoaded', () => {
    const calendarBody = document.getElementById('calendar-body');
    const monthYear = document.getElementById('month-year');
    const prevMonthBtn = document.getElementById('prev-month');
    const nextMonthBtn = document.getElementById('next-month');
    let currentDate = new Date();

    console.log(onetimeEvents);

    function renderCalendar(date) {
        const year = date.getFullYear();
        var month = date.getMonth();
        
        const firstDay = new Date(year, month, 1).getDay();
        const lastDate = new Date(year, month + 1, 0).getDate();
        
        monthYear.textContent = date.toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
        calendarBody.innerHTML = '';
        month++;
        let row = document.createElement('tr');
        
        for (let i = 0; i < firstDay; i++) {
            let cell = document.createElement('td');
            row.appendChild(cell);
        }

        for (let day = 1; day <= lastDate; day++) {
            if ((row.children.length % 7) === 0) {
                calendarBody.appendChild(row);
                row = document.createElement('tr');
            }

            let cell = document.createElement('td');
            cell.textContent = day;
            row.appendChild(cell);

            var dss = year + "-" + (month < 10 ? ('0' + month) : month) + "-" + (day < 10 ? ('0' + day) : day);
            console.log(dss);
            if (onetimeEvents.includes(dss))
            {
                //cell.style.background = 'red';
                cell.style.border="2px solid red";
            }
        }

        calendarBody.appendChild(row);
    }

    prevMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextMonthBtn.addEventListener('click', () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
});

function deleteSchedule(_eventId, _eventType)
{
    if (confirm("Ok to delete " + _eventType + " event?"))
    {
        document.getElementById('scheduleID').value = _eventId;
        document.getElementById('deleteForm').submit();
    }
}