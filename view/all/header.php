<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?php echo SITENAME; ?></title>
  </head>
  <body>
<header>
  <?php
  echo "<div class='navbar'><a href='index.php'>".SITENAME."</a> ";
  if (!isset($_SESSION['user']) OR (isset($_GET['logout']) && $_GET['logout'] == 'yes')) {
    echo "<a href='index.php?page=login'>Log in</a> ";
  } else if(isset($_SESSION['user'])) {
    echo "Welcome <b>". $_SESSION['user']."!</b> <a href='index.php?logout=yes'>Log out</a> ";

    if ($_SESSION['userType'] <=4) {
      echo "<a href='index.php?page=viewSwimmers'>Swimmers</a> ";
      if ($_SESSION['userType'] <=3) {
        //echo "Edit Swimmer Data ";
        if ($_SESSION['userType'] <=2) {
          echo "
          Coaching:
          <a href='index.php?page=editRace'>Races</a>
          <a href='index.php?page=addPractice'> Practices</a>
          <a href='index.php?page=addRaceResults'> Add Results </a>
          ";
          if ($_SESSION['userType'] == 1) {
            //Regisration is only available to admin
            echo " Admin: <a href='index.php?page=register'>Register a new swimmer</a> ";
          }
        }
      }
    }
  }

   ?>
 </div>

</header>
<?php
  echo $userMessage;
 ?>
