<?php
if(isset($_SESSION['userType'])){
  echo "You are already logged in!";
} else {
  echo "<form class='login' action='index.php' method='post'>
      <input type='text' name='userid' placeholder='username'>
      <input type='password' name='password' placeholder='type your password'>
      <input type='submit' name='login' value='login'>
    </form>";

}
