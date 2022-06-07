<?php
debug_backtrace() || die ("Direct access not permitted");

session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'quizc');


//Check First Run

if(!mysqli_select_db($db,'quizc')){
    echo '<script type="text/javascript">';
    echo 'alert("Setting up, Databases!");';
    echo 'window.location.href = "/assets/runOnce.php";';
    echo '</script>';
}

// REGISTER USER

//--------------------------------------------FETCH-------------------------------------------------------

if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);


//--------------------------------------------Check----------------------------------------------------
  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email

//------------------------------------------Validate----------------------------------------------------

    $stmt = $db->prepare("SELECT * FROM quizc.users WHERE email=? LIMIT 1");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = mysqli_fetch_array($result);
    if ($result->num_rows ) { // if user exists
        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }

//--------------------------------------------POST-------------------------------------------------------
  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {

      //Check for first registration
      $checkNull = $db->prepare("SELECT serial from quizc.users");
      $checkNull->execute();
      $checkNull = $checkNull->get_result()->num_rows;

      $password = md5($password_1); //encrypt the password before saving in the database
      if($checkNull > 0){
          $_SESSION['isTeacher'] = 0;//Default isTeacher Var
            //Prepared Statements
            $stmt = $db->prepare("INSERT INTO quizc.users (username, email, password) VALUES (?,?,?)");
            $stmt->bind_param("sss",$username,$email,$password);
      } else{
          $_SESSION['isTeacher'] = 1; //Make first user teacher if first user
             $stmt = $db->prepare("INSERT INTO quizc.users (username, email, password,isTeacher) VALUES (?,?,?,?)");
             $stmt->bind_param("sssi",$username,$email,$password,$isTeacher);
      }
      $stmt->execute();
      $results = $stmt->get_result();
      $_SESSION['name'] = $username;
      $_SESSION['email'] = $email;
      $_SESSION['isLoggedIn'] = 1;
      header('location: ../home.php');
  }
}

//--------------------------------------------LOGIN-------------------------------------------------------
if (isset($_POST['login_user'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $passwordL = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($passwordL)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
        $password1 = md5($passwordL);
        $stmt = $db->prepare("SELECT * FROM quizc.users WHERE email=? AND password=?;");
        $stmt->bind_param('ss',$email,$password1);
        $stmt->execute();
        $results = $stmt->get_result();
        $isTeacher = mysqli_fetch_object($results);
        if (mysqli_num_rows($results) == 1) {
            $_SESSION['name'] = $isTeacher->username;
            $_SESSION['email'] = $email;
            $_SESSION['isTeacher'] = $isTeacher->isTeacher;
            $_SESSION['isLoggedIn'] = 1;
            header('location: ../home.php');
        }else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>
