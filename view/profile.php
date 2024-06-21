  <?php
      session_start();
      if (!(array_key_exists('id', $_SESSION)))
      {
          header("Location: ../view/login.html");
          exit();
      }
      $userId = $_SESSION['id'];

      require_once '../model/User.php';
      $u = new User();
      $u->load($userId);
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
    <script src="../controller/extractScript.js"></script>
    <script src="../controller/editProfileScript.js"></script>



  </head>

  <body>
    <div class="container">
      <img src="../pics/profiles/<?php 
            if (file_exists('../pics/profiles/' . $u->getID() . '.jpg'))
                echo $u->getID();
            else echo '0';
      ?>.jpg" style="width:10%" alt="Profile Picture" class="profile-picture">

      <form action="../controller/updateProfileImage.php"  method="post" enctype="multipart/form-data">
          <input type="file" name="fileToUpload" id="fileToUpload">
          <input type="submit" value="Change Profile Image" name="submit">
      </form>

    <table>
      <tr>
        <td class = "name">
          Your name:
        </td>
        <td class = "info">
          <strong><?php echo $u->getFirstname() . ' ' . $u->getLastname(); ?></strong>
        </td>
      </tr>
      <tr>
      <td class = "name">
      Email:
        </td>
        <td class = "info">
          <strong><?php echo $u->getEmail(); ?></strong>
        </td>
      </tr>
      <tr>
      <td class = "name">
      Taking care of:
        </td>
        <td class = "info">
        <?php
        $number = count($u->getChildren());
        echo "<strong>" . $number . "</strong>";
        if ($number == 1)
        {
          echo " child";
        }
        else echo "&nbsp;children" ?>
        </td>
      </tr>
      </table>
    </div>

    <table>
      <tr>
        <td class="buttons">
          <input type="button" value="Edit Your Profile" onclick="location.href='editProfile.php'">
        </td>
      </tr>
      <tr>
        <td class="buttons">
          <input type="button" value="Manage children" onclick="location.href='manageChildren.php'">
        </td>
      </tr>
      
      <tr>
        <td class="buttons">
          <input onclick="confirmDelete($u->getID())" type="button" id="delete" value="Delete">
        </td>
      </tr>
      <tr>
      <td class="buttons">
          <input type="button" id="extract-button" value="Export">
          <pre id="output"></pre>
          </td>
      </tr>
      <tr>
          <td class="buttons">
            <input type="button" id="import-button" value="Import">
            <input type="file" id="file-input">
            <pre id="input"></pre>
          </td>
      </tr>
    </table>
          
  </body>

  </html>