<?php
	require "../db_connect.php";
	require "../message_display.php";
	require "../verify_logged_out.php";
	require "../header.php";
?>

<html>
	<head>
		<title>Librarian Login</title>
		<link rel="stylesheet" type="text/css" href="../css/global_styles.css">
		<link rel="stylesheet" type="text/css" href="../css/form_styles.css">
		<link rel="stylesheet" type="text/css" href="css/index_style.css">
	</head>
	<body>
		<form class="cd-form" method="POST" action="#">
		
		<legend>Librarian Login</legend>
		
			<div class="error-message" id="error-message">
				<p id="error"></p>
			</div>
			
			<div class="icon">
				<input class="l-user" type="text" name="l_user" placeholder="Username" required />
			</div>
			
			<div class="icon">
				<input class="l-pass" type="password" name="l_pass" placeholder="Password" required />
			</div>
			
			<input type="submit" value="Login" name="l_login"/>
			
		</form>
	</body>
	
	<?php
	
	$conn = Connect();
		if(isset($_POST['l_login']))
		{
			$username = $conn->real_escape_string($_POST['l_user']);
            $password = $conn->real_escape_string($_POST['l_pass']);
			// $query = $conn->prepare("SELECT id FROM librarian WHERE username =  '$username' AND password = '$password'");
			$query="select * from librarian where username='$username' and password='$password'";
            $result = $conn->query($query);
            // if($result->num_rows > 0){
            //     $_SESSION['login_admin']=$username;
            //     $msg="Login success";
            // }
			if($result->num_rows != 1)
				echo error_without_field("Invalid username/password combination");
			else
			{
				$_SESSION['type'] = "librarian";
				$_SESSION['id'] = mysqli_fetch_array($result)[0];
				$_SESSION['username'] = $_POST['l_user'];
				header('Location: home.php');
			}
		}
	?>
	
</html>