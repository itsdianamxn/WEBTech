function deleteSchedule(_eventId)
        {
            if (confirm("Ok to delete <?php echo $type; ?> event?"))
            {
                document.getElementById('scheduleID').value = _eventId;
                document.getElementById('deleteForm').submit();
            }
        }