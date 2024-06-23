function updateForm()
{
    switch (document.getElementById("recurrence").value)
    {
        case "Daily":
            document.getElementById("date").style.display = 'none';
            document.getElementById("dow").style.display = 'none';
            document.getElementById("expiration").style.display = 'block';
            break;
        case "Weekly":
            document.getElementById("date").style.display = 'none';
            document.getElementById("dow").style.display = 'block';
            document.getElementById("expiration").style.display = 'block';
            break;
        case "One-time":
            document.getElementById("expiration").style.display = 'none';
            document.getElementById("date").style.display = 'block';
            document.getElementById("dow").style.display = 'none';
            break;
        case "Monthly":
        case "Yearly":
            document.getElementById("expiration").style.display = 'block';
            document.getElementById("date").style.display = 'block';
            document.getElementById("dow").style.display = 'none';
            break;
    }
}