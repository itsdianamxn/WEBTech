document.getElementById('extract-button').addEventListener('click', function() {
    fetch('../controller/extractController.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.file) {
                // Create a download link and trigger it
                const link = document.createElement('a');
                link.href = data.path;
                link.download = data.file;
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else {
                console.error('Error:', data.error);
                document.getElementById('output').textContent = 'Error fetching data';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('output').textContent = 'Error fetching data';
        });
});

document.getElementById('import-button').addEventListener('click', function() {
    fetch('../controller/importController.php')

});
