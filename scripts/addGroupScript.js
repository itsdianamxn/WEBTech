function submitForm(event) {
    event.preventDefault();
    const form = document.getElementById('editPage');
    const formData = new FormData(form);

    fetch('../controller/addGroup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            alert(data.message);
        } else {
            window.location.href = '../view/groups.html';
        }
    })
    .catch(error => console.error('Error:', error));
}
