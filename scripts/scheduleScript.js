function deleteSchedule(_eventId, _eventType)
{
    if (confirm("Ok to delete " + _eventType + " event?"))
    {
        document.getElementById('scheduleID').value = _eventId;
        document.getElementById('deleteForm').submit();
    }
}