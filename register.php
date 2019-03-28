<?php 

session_start();
	$con = mysqli_connect("localhost", "root", "", "se_socail_media");
	if(mysqli_connect_errno()){
		echo "failed to Connect:" .mysqli_connect_errno();
	}
	
	$fname = "";
	$lname = "";
	$email = "";
	$cemail = "";
	$password = "";
	$cpassword = "";
	$date = "";
	$error_array = array();

	if(isset($_POST['join'])){

		$fname = strip_tags($_POST['fname']); //remove html tags
		$fname = str_replace(' ', '', $fname); //remove spaces
		$fname = ucfirst(strtolower($fname)); //Upper case first letter
		$_SESSION['fname'] = $fname; //Store first name into session variable

		$lname = strip_tags($_POST['lname']); //remove html tags
		$lname = str_replace(' ', '', $lname); //remove spaces
		$lname = ucfirst(strtolower($lname)); //Upper case first letter
		$_SESSION['lname'] = $lname; //Store last name into session variable


		$email = strip_tags($_POST['email']); //remove html tags
		$email = str_replace(' ', '', $email); //remove spaces
		$_SESSION['email'] = $email; //Store email into session variable


		$cemail = strip_tags($_POST['cemail']); //remove html tags
		$cemail = str_replace(' ', '', $cemail); //remove spaces
		$_SESSION['cemail'] = $cemail; //Store confire email into session variable


		$password = strip_tags($_POST['password']); //remove html tags

		$cpassword = strip_tags($_POST['cpassword']); //remove html tags

		$date = date("Y-m-d"); //current date

		if(is_null($fname) || is_null($lname) || is_null($email) || is_null($cemail) || is_null($password) || is_null($cpassword)){
			array_push($error_array, "All Fields must be filled<br>");
		}
		else{
		if($email == $cemail){
			//check email format
			if(filter_var($email,FILTER_VALIDATE_EMAIL)){
				$email = filter_var($email,FILTER_VALIDATE_EMAIL);
			//chesck email already used
				$email_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");
				//count number of rows return
				$num_rows = mysqli_num_rows($email_check);

				if($num_rows > 0){
					array_push($error_array, "Email is already Used <br>");
				}
			}
			else{
				array_push($error_array, "Invalid Format <br>");
			}
		}
		else{
			array_push($error_array, "Emails are Don't Match <br>");
		}

		//check first name is in valid format
		if(strlen($fname) > 25 || strlen($fname) < 2){
			array_push($error_array, "first name should be between 2 and 25 characters <br>");
		}

		//check first name is in valid format
		if(strlen($lname) > 25 || strlen($lname) < 2){
			array_push($error_array, "last name should be between 2 and 25 characters <br>");
		}

		//check password an dconfirm password is match
		if($password != $cpassword){
			array_push($error_array, "Passwords are not matched <br>");
		}
		// else{
		// 	if(preg_match('/[^A-Za-z0-9~!@#$%^&*_-+=`|\(){}]""'), '$password');
		// 	echo "You can only contain English letters, numbers and symbols";
		// }
		if(strlen($password) > 30 || strlen($password) < 8){
			array_push($error_array, "Password must be between 8 and 30 characters <br>");
		}

		if (empty($error_array)) {
			$password = md5($password); //encrypt the password 

			//Concate the first name and last name to generete the user name
			$username = strtolower($fname . "_" .$lname);
			$check_user_name = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
			$i=0;
			//if user name is there add number too user name
			while(mysqli_num_rows($check_user_name) != 0){
				$i++;
				$username = $username.$i;
				$username = ucfirst(strtolower($username)); //Upper case first letter
				$check_user_name = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
			}

			//Set a profile picture
			$rand = rand(1,16);//random number between 1 and 16
		if($rand==1){
			$profile_pictures = "images/profile_pictures/default/head_alizarin.png";
		}
		else if($rand==2){
			$profile_pictures = "images/profile_pictures/default/head_amethyst.png";
		}
		else if($rand==3){
			$profile_pictures = "images/profile_pictures/default/head_belize_hole.png";
		}
		else if($rand==4){
			$profile_pictures = "images/profile_pictures/default/head_carrot.png";
		}
		else if($rand==5){
			$profile_pictures = "images/profile_pictures/default/head_deep_blue.png";
		}
		else if($rand==6){
			$profile_pictures = "images/profile_pictures/default/head_emerald.png";
		}
		else if($rand==7){
			$profile_pictures = "images/profile_pictures/default/head_green_sea.png";
		}
		else if($rand==8){
			$profile_pictures = "images/profile_pictures/default/head_nephritis.png";
		}
		else if($rand==9){
			$profile_pictures = "images/profile_pictures/default/head_pete_river.png";
		}
		else if($rand==10){
			$profile_pictures = "images/profile_pictures/default/head_pomegranate.png";
		}
		else if($rand==11){
			$profile_pictures = "images/profile_pictures/default/head_pumpkin.png";
		}
		else if($rand==12){
			$profile_pictures = "images/profile_pictures/default/head_red.png";
		}
		else if($rand==13){
			$profile_pictures = "images/profile_pictures/default/head_sun_flower.png";
		}
		else if($rand==14){
			$profile_pictures = "images/profile_pictures/default/head_turqoise.png";
		}
		else if($rand==15){
			$profile_pictures = "images/profile_pictures/default/head_wet_asphalt.png";
		}
		else{
			$profile_pictures = "images/profile_pictures/default/head_wisteria.png";
		}

		$query = mysqli_query($con, "INSERT INTO users VALUES ('','$fname','$lname','$username','$email','$password','$date','$profile_pictures','0','0','no',',')");
		
		array_push($error_array,"<span style='color:#14C800;'>You,re all set Go a head and loging!</span><br>");

		//clear session variables
		$_SESSION['fname'] = "";
		$_SESSION['lname'] = "";
		$_SESSION['email'] = "";
		$_SESSION['cemail'] = "";
		}

	}
}

 ?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>SE Social Media Site</title>
  
  
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.css'>
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css'>

      <link rel="stylesheet" href="css/style.css">
<link rel="icon" type="image/png" href="images/download.png">
  
</head>

<body>
  <div class="signupSection">
  <div class="info">
    <h2>Software Engineering University of Kelaniya</h2>
    <img src="images/download.png" id="se-logo">
    <p>This is Our Facebook</p>
  </div>
  <form action="#" method="POST" class="signupForm" name="signupform">
    <h2>Sign Up</h2>
    <ul class="noBullet">
      <li>
        <label for="fname"></label>
        <input type="name" class="inputFields" id="fname" name="fname" placeholder="First Name" value="<?php
        	if(isset($_SESSION['fname'])){
        		echo $_SESSION['fname'];
        	}
        ?>" required/>
      </li>
      <?php
      	if(in_array("first name should be between 2 and 25 characters <br>", $error_array)){
      		echo "<b style='color:red;'>first name should be between 2 and 25 characters</b>";
      	}
      ?>
      <li>
        <label for="lname"></label>
        <input type="name" class="inputFields" id="lname" name="lname" placeholder="Last Name" value="<?php
        	if(isset($_SESSION['lname'])){
        		echo $_SESSION['lname'];
        	}
        ?>" required/>
      </li>
      <?php
      	if(in_array("last name should be between 2 and 25 characters <br>", $error_array)){
      		echo "<b style='color:red;'>last name should be between 2 and 25 characters</b>";
      	}
      ?>
      <li>
        <label for="email"></label>
        <input type="email" class="inputFields" id="email" name="email" placeholder="Email" value="<?php
        	if(isset($_SESSION['email'])){
        		echo $_SESSION['email'];
        	}
        ?>" required/>
      </li>
      <li>
        <label for="c-email"></label>
        <input type="email" class="inputFields" id="email" name="cemail" placeholder="Confirm Email" value="<?php
        	if(isset($_SESSION['cemail'])){
        		echo $_SESSION['cemail'];
        	}
        ?>" required/>
      </li>
      <?php
      	if(in_array("Email is already Used <br>", $error_array)){
      		echo "<b style='color:red;'>Email is already Used</b>";
      	}
      	if(in_array("Invalid Format <br>", $error_array)){
      		echo "<b style='color:red;'>Invalid Format</b>";
      	}
      	if(in_array("Emails are Don't Match <br>", $error_array)){
      		echo "<b style='color:red;'>*Emails are Don't Match</b>";
      	}
      ?>
      <li>
        <label for="password"></label>
        <input type="password" class="inputFields" id="password" name="password" placeholder="Password" value="" oninput="return passwordValidation(this.value)" required/>
      </li>
      <li>
        <label for="c-password"></label>
        <input type="password" class="inputFields" id="password" name="cpassword" placeholder="confirm Password" value="" oninput="return passwordValidation(this.value)" required/>
      </li>
      <?php
      	if(in_array("Passwords are not matched <br>", $error_array)){
      		echo "<b style='color:red;'>Passwords are not matched</b>";
      	}
      	if(in_array("Password must be between 8 and 30 characters <br>", $error_array)){
      		echo "<b style='color:red;'>Password must be between 8 and 30 characters</b>";
      	}
      	if(in_array("All Fields must be filled<br>", $error_array)){
      		echo "<b style='color:red;'>All Fields must be filled</b>";
      	}
      ?>
      <li id="center-btn">
        <input type="submit" id="join-btn" name="join" alt="Join" value="Join">
      </li>
      <?php 
		if(in_array("<span style='color:#14C800;'>You,re all set Go a head and loging!</span><br>", $error_array)){
      		echo "<span style='color:#14C800;'>You,re all set Go a head and loging!</span><br>";
      	}
      ?>
    </ul>
  </form>
</div>
  
    <script src="js/index.js"></script>

</body>
</html>
