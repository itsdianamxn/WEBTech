
    function updateNotificationsCount() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '../controller/nrOfNoTifications.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var count = response.count;
                
                // Update the SVG or any HTML element with the count
                var countElement = document.getElementById('notificationsCount');
                if (countElement) {
                    countElement.textContent = count;
                }
            }
        };

        xhr.send();
    }

    // Call updateNotificationsCount() when page loads
    document.addEventListener('DOMContentLoaded', function () {
        updateNotificationsCount();
    });
