<?php
//Load Models
include_once "model/Database.class.php";
include_once "model/Swim.class.php";

//Variable used for repopulating forms and showing details for user
$repopulateFields = '';
//New Swim model called and can be invoked when needed
$swim = new Swim();
$allLocations = $swim->getAllLocations();

//Control intensifies -- this will only execute if post is called
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //Burn it with fire
  $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  //This will handle all post and get actions for the edit race
  if ($_GET['page']=="editRace") {
    //Perform actions based on what is posted to the edit race
    if (isset($_POST['addRace'])) {
      //combine the date and time
      $date = New DateTime(trim($_POST['date']));
      $time = New DateTime(trim($_POST['time']));
      $dateTime = new DateTime($date->format('Y-m-d').''.$time->format('H:i:s'));
      // associate and sanitize input data
      $addRace = [
        'date-time' => $dateTime->format('Y-m-d H:i:s'),
        'name' => trim($_POST['name']),
        'locID' => trim($_POST['locations'])
      ];
      //Input to DB

      if ($swim->addRace($addRace['date-time'],$addRace['name'],$addRace['locID']) == true) {
        $userMessage = "Race Added";
        $raceInfo = $swim->getRace($addRace['name'],$addRace['date-time'],$addRace['locID']);
      } else {
        $userMessage = "<font color = 'red'> Unable to Add Race";
        $repopulateFields = $_POST;
      }
    } elseif (isset($_POST['updateRace'])) {
      $date = New DateTime(trim($_POST['date']));
      $time = New DateTime(trim($_POST['time']));
      $dateTime = new DateTime($date->format('Y-m-d').''.$time->format('H:i:s'));

      $updateThisRace=$swim->editRace($dateTime->format('Y-m-d H:i:s'),trim($_POST['name']),trim($_POST['location']),trim($_POST['raceID']));
      if ($updateThisRace!= false) {
        $userMessage = "Successfully Updated! Will Refresh in a moment";
        echo "<script>
             setTimeout(function(){
                window.location.href = 'http://localhost/WAP-Swimmer-Club-App/index.php?page=editRace';
             }, 5000);
          </script>";

      }
    }
  }
  if ($_GET['page'] == "addRaceResults") {
    if (isset($_POST['addUserRaceResults'])) {
      $updateSwimmerRaceResults = $swim->addRaceResults(trim($_GET['raceID']),trim($_POST['swimmerID']),trim($_POST['lap1']),trim($_POST['lap2']),trim($_POST['lap3']),trim($_POST['lap4']),trim($_POST['lap5']),trim($_POST['lap6']),trim($_POST['lap7']),trim($_POST['lap8']),trim($_POST['lap9']),trim($_POST['lap10']));
      if ($updateSwimmerRaceResults !=false) {
        $userMessage ="Successfully Updated Swimmers Stats!";
      } else {
        echo "Internal error please contact system administrator";
      }
    } elseif (isset($_POST['addUserPracticeResults'])) {
      $updateSwimmerRaceResults = $swim->addPracticeResults(trim($_POST['practiceID']),trim($_POST['swimmerID']),trim($_POST['lap1']),trim($_POST['lap2']),trim($_POST['lap3']),trim($_POST['lap4']),trim($_POST['lap5']),trim($_POST['lap6']),trim($_POST['lap7']),trim($_POST['lap8']),trim($_POST['lap9']),trim($_POST['lap10']));
      if ($updateSwimmerRaceResults !=false) {
        $userMessage ="Successfully Updated Swimmers Stats!";
      } else {
        echo "Internal error please contact system administrator";
    }
  }
}
  if (isset($_POST['addPractice'])) {
    $addPractice = $swim->addPractice(trim($_POST['practiceDate']),trim($_POST['location']));
    if ($addPractice != false) {
      $userMessage = "Practice Successfully Added!";
    } else {
      $userMessage = "Something has gone wrong please contact the system administrator";
    }
    $grabNewPracticeID = $swim->getPracticeByDate(trim($_POST['practiceDate']));
    foreach ($_POST['swimmers'] as $newSwimmer) {
      $addSwimmerToPractice = $swim->addSwimmerToPractice(trim($newSwimmer),$grabNewPracticeID->praID);
      if ($addSwimmerToPractice == false) {
        $userMessage.= " Swimmer unable to add to race. Please contact system administrator";
      }
    }
    $userMessage.=" Will redirect to practice form shortly...";
    $dateToUse = $_POST['practiceDate'];
    echo "<script>
         setTimeout(function(){
            window.location.href = 'http://localhost/WAP-Swimmer-Club-App/index.php?page=addRaceResults&type=practice&date=$dateToUse';
         }, 5000);
      </script>";
  }
  if (isset($_POST['updateUserInfo'])) {
    $updatedData = [
      'fname' => trim($_POST['firstName']),
      'sname' => trim($_POST['surname']),
      'address' => trim($_POST['address']),
      'post' => trim($_POST['postalCode']),
      'email' => trim($_POST['email']),
      'phone' => trim($_POST['phone']),
      'userID' => trim($_POST['userID'])
    ];
    $regex=$swim->regexInput($updatedData['fname'],$updatedData['sname'],$updatedData['email'],$updatedData['address'],$updatedData['post'],$updatedData['phone']);
    if ($regex == true) {
      $updateUser = $swim->updateSwimmerInfo($updatedData['userID'],$updatedData['fname'],$updatedData['sname'],$updatedData['address'],$updatedData['post'],$updatedData['email'],$updatedData['phone']);
      if ($updateUser == true) {
        $userMessage = "Information Successfully Updated";
      } else {
        $userMessage = "Unable to udpate user, please contact administrator";
      }
    } else {
      $userMessage = $regex;
    }
  }
}
