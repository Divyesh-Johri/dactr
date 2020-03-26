<!DOCTYPE html>
<html>
	<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Register for Dactr</title>

    <!-- Custom CSS -->
    <link href="\dactr/css/login.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">

	</head>

	<body>
		<div class="register">
			<h1>Register</h1>
      <!-- Registration form -->
			<form method="post" autocomplete="off">
				<label for="username">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="username" placeholder="Username" id="username" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password (5-20 Characters)" id="password" required>
				<label for="email">
					<i class="fas fa-envelope"></i>
				</label>
				<input type="email" name="email" placeholder="Email" id="email" required>
        <a href="../index.php" style="padding:5px">Go back to login</a>
				<input type="submit" value="Register">
			</form>

			<?php // Registration code
			session_start();
			// Connect to the database dactrlogin
			$DATABASE_HOST = 'localhost';
			$DATABASE_USER = 'root';
			$DATABASE_PASS = $_SESSION['pass'];
			$DATABASE_NAME = 'dactrlogin';
			$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
			// Stop if can't connect
			if (mysqli_connect_errno()) {
				exit('Failed to connect ' . mysqli_connect_error());
			}

			// Validation Time!
			// Check if form is completed
			if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
			  exit();
			}
			// Make sure the submitted registration values are not empty.
			if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
				exit();
			}
			// Email validation
			if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
				?>
				<p class = "text-danger">Email is not valid</p>
				<?php
				exit();
			}
			// Invalid characters validation
			// Valid characters: uppercase and lowercase, numbers
			if (preg_match('/[A-Za-z0-9]+/', $_POST['username']) == 0){
				?>
				<p class = "text-danger">Username is not valid</p>
				<?php
			  exit();
			}
			// Character length Validation
			if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5){
				?>
				<p class = "text-danger">Password must be between 5 and 20 characters long</p>
				<?php
				exit();
			}


			// Prepare SQL to prevent injection
			if ($stmt = $connection->prepare('SELECT id, password FROM accounts WHERE username = ?')){
			  // Bind the username
			  $stmt->bind_param('s',$_POST['username']);
			  $stmt->execute();
			  // Store result so we can see if it exists in dactrlogin
			  $stmt->store_result();

			  if ($stmt->num_rows > 0){
					?>
					<p class = "text-danger">Username exists, please choose another</p>
					<?php
			  } else { //Insert a new account
			    if ($stmt = $connection->prepare('INSERT INTO accounts (username, password, email) VALUES (?,?,?)')){
			      // Hash the password, bind and assign all parameters
			      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
			      $stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
			      $stmt->execute();
						?>
						<p style="color: black">You have successfully registered, you can now login!</p>
						<?php
			    } else {
			      //Something went wrong with the sql statement
			      echo 'Could not prepare statement during insertion';
			    }
			  }

			  $stmt->close();
			} else {
			  //Something went wrong with the sql statement
			  echo 'Could not prepare statement during account verification';
			}

			$connection->close();
			?>

		</div>
	</body>

</html>
