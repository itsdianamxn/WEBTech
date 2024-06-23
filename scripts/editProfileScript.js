function confirmDelete() {    
    if (confirm("Are you sure you want to delete your profile?\nAll your memories will be lost2.")) {
      document.getElementById('deleteUserBtn').click();
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