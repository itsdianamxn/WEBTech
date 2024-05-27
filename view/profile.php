<?php
    session_start();
    if (!(array_key_exists('id', $_SESSION)))
    {
        header("Location: ../view/login.html");
        exit();
    }
    $userId = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="-1">
  <meta http-equiv="CACHE-CONTROL" content="NO-CACHE">
  <title>ParentProfile</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../css/profileStyle.css">
</head>

<body>
  <div class="container">
    <img src="../pics/profiles/<?php 
          if (file_exists('../pics/profiles/'.$_SESSION['id'].'.jpg'))
              echo $_SESSION['id'];
          else echo '0';
    ?>.jpg" style="width:10%" alt="Profile Picture" class="profile-picture">

    <form action="../controller/updateProfileImage.php"  method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Change Profile Image" name="submit">
    </form>

    <table>
      <tr>
        <td>
          Parent name:
        </td>
        <td class = "info">
          <strong><?php echo  $_SESSION['firstname'] . ' ' . $_SESSION['lastname']; ?></strong>
        </td>
      </tr>
      <tr>
        <td>
          Email:
        </td>
        <td class = "info">
          <strong><?php echo  $_SESSION['email']; ?></strong>
        </td>
      </tr>
      <tr>
        <td>
          Phone number:
        </td>
        <td class = "info">
          <strong><?php echo  $_SESSION['phone']; ?></strong>
        </td>
      </tr>
      <tr>
        <td colspan=2 class="buttons">
          <input type="button" value="Edit Your Profile" onclick="location.href='editProfile.php'">
        </td>
      </tr>
      <tr>
        <td colspan=2 class="buttons">
          <input type="button" value="Manage children" onclick="location.href='manageChildren.php'">
        </td>
      </tr>
      <tr>
        <td colspan=2 class="buttons">
          <input type="button" value="Import">
        </td>
      </tr>
      <tr>
        <td colspan=2 class="buttons">
          <input type="button" value="Export">
        </td>
      </tr>
    </table>
  </div>
</body>

</html>