function confirmDelete(_id) {    
    if (confirm("Are you sure you want to delete your profile?\nAll your memories will be lost.")) {
        top.location.href='../controller/deleteProfile.php?ID=' +  _id;
        top.location.reload();
    }
}

function checkImageSet()
{
  if (document.getElementById('fileToUpload').value != "")
  {
    document.getElementById('submitProfilePic').click();
    return;
  }
  setTimeout(checkImageSet, 500);
}