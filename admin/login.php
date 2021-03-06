<?php
  require '../model/db.php';
  session_start();

  $msg = $msgClass = '';

  if (filter_has_var(INPUT_POST, 'submit')) {
    // Get form data
    $id = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if inputs are empty
    if (!empty($id) && !empty($password)){
      // success
      $sql = "SELECT * FROM `admin` WHERE `admin_username`='$id'";
      $result = mysqli_query($conn, $sql);
      $resultCheck = mysqli_num_rows($result);
      $row = mysqli_fetch_assoc($result);

      if ($resultCheck < 1) {
        // error, id not exist
        $msg = "Invalid Admin id or password";
        $msgClass = "red";
      } else {
        // Checking the password hash
        $pwdCheck = password_verify($_POST['password'], $row['admin_password']);

        if($pwdCheck == false) {
          $msg = "Invalid password";
          $msgClass = "red";
        } elseif ($pwdCheck == true) {
          $_SESSION['admin_uname'] = $row['admin_username'];
          $_SESSION['admin_email'] = $row['admin_email'];
          header("location: index.php");
        }
      }
    } else {
      // failed ouput an error
      $msg = "Please fill in all fields";
      $msgClass = "red";
    }

    mysqli_close($conn);
  }
?>

<style>
// Finally sticky footer! Good god have mercy
body {
  display: flex;
  min-height: 100vh;
  flex-direction: column;
}

.site-content {
  flex: 1 0 auto;

}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Skule™ Lockers Admin | Log In</title>
  <link rel="stylesheet" href="../css/materialize.min.css">
  <script src="../js/fontawesome-all.min.js"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<body>
  <!-- Admin Login Nav -->
  <nav role="navigation" class="z-depth-0">
    <div class="nav-wrapper">
      <!-- Skule Logo -->
      <a id="logo-container" href="../index.php" class="brand-logo center">
        <img class="logo-img" src="../img/skule_logo.png" alt="logo">
        <img class="logo-img-lockers" src="../img/lockers.png" alt="logo">
      </a>

    </div>
  </nav>

  <!-- Form -->
  <div class="container site-content">
    <div class="box">
      <div class="row">
        <div class="col s12 m12">
          <?php if($msg != ''): ?>
            <div id="msgBox" class="card-panel <?php echo $msgClass; ?>">
              <span class="white-text"><?php echo $msg; ?></span>
            </div>
          <?php endif ?>
          <div class="card">
            <div class="card-content" style="padding: 40px;">
              <span class="card-title center-align">Admin Login</span>
              <div class="row">
                <form class="col s12" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
                  <div class="row">
                    <div class="input-field">
                      <input type="text" id="username" placeholder="Username" name="username">
                    </div>
                  </div>
                  <div class="row">
                    <div class="input-field">
                      <input type="password" id="password" placeholder="Password" name="password">
                    </div>
                  </div>
                  <div class="center">
                    <button type="submit" class="waves-effect waves-light btn blue" name="submit">Login</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<footer class="page-footer">
  <div class="container ">
    <div class="row valign-wrapper">
      <div class="col s6">
        <img src="../img/skule_crest.png" class="footer-img"></img>
      </div>
      <div class="col s12">
        <p class="grey-text text-lighten-4">
          A service of the University of Toronto Engineering Society. For any
          questions or concerns, please contact the President at president@skule.ca.
        </p>
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <!-- TODO: Add copyright -->
  </div>
</footer>
