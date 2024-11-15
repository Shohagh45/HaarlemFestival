let calA = new Calendar({
    id: "#calendar-a",
    theme: "basic",
    weekdayType: "long-upper",
    calendarSize: "small",
    dateChanged: (currentDate, events) => {
        var date = new Date(currentDate);
        document.getElementById("selected-date").innerHTML = formatDate(date);
        fetchEventsByDate(formatDateForApi(date));
    }
});

function formatDate(date) {
    var months = [
        "January", "February", "March", "April", "May", "June", "July",
        "August", "September", "October", "November", "December"
    ];
    var day = date.getDate();
    var monthIndex = date.getMonth();
    return day + ' ' + months[monthIndex];
}

function formatDateForApi(date) {
    var day = date.getDate().toString().padStart(2, '0');
    var month = (date.getMonth() + 1).toString().padStart(2, '0');
    var year = date.getFullYear();
    return year + '-' + month + '-' + day;
}

function fetchEventsByDate(date) {
    fetch('/events/by-date', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ date: date })
    })
    .then(response => response.json())
    .then(events => {
        displayEvents(events);
    })
    .catch(error => console.error('Error fetching events:', error));
}

function displayEvents(events) {
    let eventsTable = document.querySelector("#events-section table");
    eventsTable.innerHTML = `
        <tr>
            <th>Event Date Time</th>
            <th>Venue</th>
            <th>Locatiom</th>
            <th>One day price</th>
            <th>All day price</th>
            <th>Action</th>
        </tr>
    `;

    if (events.length === 0) {
        let row = eventsTable.insertRow();
        let cell = row.insertCell(0);
        cell.colSpan = 5;
        cell.innerText = 'No data found';
        cell.style.textAlign = 'center';
    } else {
        events.forEach(event => {
            let row = eventsTable.insertRow();
            row.insertCell(0).innerText = new Date(event.date).toLocaleString();
            row.insertCell(1).innerText = event.venueName;
            row.insertCell(2).innerText = event.location;
            row.insertCell(3).innerText = '$' + event.onedayprice;
            row.insertCell(4).innerText = '$' + event.alldayprice;
            let detailsCell = row.insertCell(5);
            let detailsLink = document.createElement('a');
            detailsLink.href = '/events/jazz-details?id=' + event.event_id;
            detailsLink.innerText = 'Details';
            detailsCell.appendChild(detailsLink);
        });
    }
}