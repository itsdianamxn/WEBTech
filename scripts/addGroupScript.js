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

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

function submitChildForm(event) {
    event.preventDefault(); // Prevent the default form submission

    // Function to get URL parameters
    

    // Get the group ID from the URL
    var groupId = getUrlParameter('groupId');
    console.log('Group ID:', groupId);

    // Get the form data
    const form = document.getElementById('editPage'); // Replace 'editPage' with your form ID
    const formData = new FormData(form);
    
    // Append groupId to the formData
    formData.append('groupId', groupId);

    // Fetch to add child to group
    fetch('../controller/addChildToGroup.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            alert(data.message);
        } else {
            window.location.href = '../view/groups.html'; // Redirect to groups page on success
        }
    })
    .catch(error => console.error('Error:', error));
}

