<?php
echo "<form class='register' action='index.php?page=login' method='post'>
    <input type='text' name='first name' placeholder='first name'>
    <input type='text' name='surname' placeholder='surname'>
    <input type='text' name='address' placeholder='street address'>
    <input type='text' name='postal code' placeholder='postal code' >
    <input type='date' name='birthday' placeholder='DOB'>
    <input type='password' name='pass1' placeholder='enter password'>
    <input type='password' name='pass2' placeholder='re-enter password'>
    <input type='reset' name='reset' value='reset form'>
    <input type='submit' name='register' value='register'>
  </form>";
