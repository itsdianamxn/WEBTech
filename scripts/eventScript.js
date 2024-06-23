function updateForm()
{
    switch (document.getElementById("recurrence").value)
    {
        case "Daily":
            document.getElementById("date").style.display = 'none';
            document.getElementById("dow").style.display = 'none';
            break;
        case "Weekly":
            document.getElementById("date").style.display = 'none';
            document.getElementById("dow").style.display = 'block';
            break;
        case "One-time":
        case "Monthly":
        case "Yearly":
            document.getElementById("date").style.display = 'block';
            document.getElementById("dow").style.display = 'none';
            break;
    }
}