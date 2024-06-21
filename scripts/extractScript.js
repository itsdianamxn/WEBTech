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
    document.getElementById('file-input').click();
});

document.getElementById('file-input').addEventListener('change', function() {
    const file = this.files[0];
    if (file.type !== 'application/json' && !file.name.endsWith('.json')) {
        document.getElementById('input').textContent = 'Please upload a valid JSON file';
        return;
    }
    if (file) {
        const formData = new FormData();
        formData.append('file', file);

        fetch('../controller/importController.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById('input').textContent = 'File uploaded successfully';
            } else {
                document.getElementById('input').textContent = 'Error: ' + data.error;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('input').textContent = 'Error uploading file';
        });
    }
});
