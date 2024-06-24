document.addEventListener('DOMContentLoaded', function() {
    fetch('../controller/fetchGroups.php')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                const groupsList = document.getElementById('groupsList');

                data.groups.forEach(group => {
                    const listItem = document.createElement('li');
                    listItem.classList.add('group');
                    listItem.innerHTML = `
                        <div class="first">
                            <p class="group-name">${group.name}</p>
                            <div class="mod-button-container">
                            <button class="mod-button" onclick="deleteGroup('${group.id}')">Delete Group</button>
                            <button class="mod-button" onclick="modifyGroup('${group.id}')">Modify Group</button>
                            </div>
                            <div class="svg-style">
                                <svg aria-hidden="true" focusable="false" data-prefix="fad" data-icon="arrows-down-to-people" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 620 512" class="svg-inline--fa fa-arrows-down-to-people fa-w-7 fa-xs" width="25%" height="80%">
                                    <path fill="currentColor" d="M144 0c-13.3 0-24 10.7-24 24V142.1L97 119c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9l64 64c9.4 9.4 24.6 9.4 33.9 0l64-64c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-23 23V24c0-13.3-10.7-24-24-24zM360 200a40 40 0 1 0 -80 0 40 40 0 1 0 80 0zM184 296a40 40 0 1 0 -80 0 40 40 0 1 0 80 0zm312 40a40 40 0 1 0 0-80 40 40 0 1 0 0 80zM200 441.5l26.9 49.9c6.3 11.7 20.8 16 32.5 9.8s16-20.8 9.8-32.5l-36.3-67.5c1.7-1.7 3.2-3.6 4.3-5.8L264 345.5V400c0 17.7 14.3 32 32 32h48c17.7 0 32-14.3 32-32V345.5l26.9 49.9c1.2 2.2 2.6 4.1 4.3 5.8l-36.3 67.5c-6.3 11.7-1.9 26.2 9.8 32.5s26.2 1.9 32.5-9.8L440 441.5V480c0 17.7 14.3 32 32 32h48c17.7 0 32-14.3 32-32V441.5l26.9 49.9c6.3 11.7 20.8 16 32.5 9.8s16-20.8 9.8-32.5l-37.9-70.3c-15.3-28.5-45.1-46.3-77.5-46.3H486.2c-16.3 0-31.9 4.5-45.4 12.6l-33.6-62.3c-15.3-28.5-45.1-46.3-77.5-46.3H310.2c-32.4 0-62.1 17.8-77.5 46.3l-33.6 62.3c-13.5-8.1-29.1-12.6-45.4-12.6H134.2c-32.4 0-62.1 17.8-77.5 46.3L18.9 468.6c-6.3 11.7-1.9 26.2 9.8 32.5s26.2 1.9 32.5-9.8L88 441.5V480c0 17.7 14.3 32 32 32h48c17.7 0 32-14.3 32-32V441.5zM415 153l64 64c9.4 9.4 24.6 9.4 33.9 0l64-64c9.4-9.4 9.4-24.6 0-33.9s-24.6-9.4-33.9 0l-23 23V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V142.1l-23-23c-9.4-9.4-24.6-9.4-33.9 0s-9.4 24.6 0 33.9z" class="fa-secondary"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="children">
                        </div>`;
                    groupsList.appendChild(listItem);

                    // Add children thumbnails for each group
                    const childrenContainer = listItem.querySelector('.children');
                    const groupChildren = data.groupChildren[group.id] || [];
                    groupChildren.forEach(child => {
                        const imageUrl = '../pics/childrenProfiles/' + child.id + '.jpg'|| '../pics/childrenProfiles/0.jpg';
                        fileExists(imageUrl).then(exists => {
                            const childThumbnail = document.createElement('div');
                            childThumbnail.classList.add('child-thumbnail');
                            childThumbnail.innerHTML = `
                                <div class="nameContainer">
                                    <span class="child-name">${child.firstname}</span>
                                </div>
                                <img src="${exists ? imageUrl : '../pics/childrenProfiles/0.jpg'}" alt="Child picture">`;
                            childrenContainer.appendChild(childThumbnail);
                        });
                    });
                    const childThumbnail = document.createElement('div');
                    childThumbnail.classList.add('child-thumbnail');
                    const addChildUrl = "addChildToGroup.html?  groupId=" + group.id;
                    childThumbnail.innerHTML = `
                    <a href = "${addChildUrl}">
                        <div class="nameContainer">
                                <span class="child-name">Add Child</span>
                        </div>
                        
                        <div class="addGroup">
                            <svg class="image-preview-img">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 480" class="fa-solid fa-plus">
                            <path fill="green" d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/>
                            </svg></svg>
                        </div>
                        </a>`;
                    childrenContainer.appendChild(childThumbnail);
                });
            } else {
                console.error('Error:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
});

function fileExists(url) {
    return fetch(url, { method: 'HEAD' })
        .then(response => {
            if (response.ok) {
                return true;
            } else {
                return false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            return false;
        });
}

function deleteGroup(groupId) {
    if (confirm('Are you sure you want to delete this group?')) {
        // Perform an AJAX request to delete the group
        fetch(`../controller/deleteGroup.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ groupId: groupId })
        })
        .then(response => response.json())
        .then(data => {
            // Handle the response (e.g., show a success message)
            alert(data.message);
            // Optionally reload or redirect to update the groups list
            window.location.reload();
        })
        .catch(error => console.error('Error:', error));
    }
}


// Function to modify a group
function modifyGroup(groupId) {
    // Redirect to a page where the group can be modified, passing the groupId as a parameter
    window.location.href = `../view/modifyGroup.html?groupId=${groupId}`;
}