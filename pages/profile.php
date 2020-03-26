<?php
session_start();
//redirect if not logged in
if (!isset($_SESSION['loggedin'])) {
	header('Location: ../index.php');
	exit;
}
//Connect to the login database
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = $_SESSION['pass'];
$DATABASE_NAME = 'dactrlogin';
$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
//Send an error if failed
if (mysqli_connect_errno()) {
	exit('Failed to connect ' . mysqli_connect_error());
}

// Obtaining password and email from database using account ID
$stmt = $connection->prepare('SELECT password, email FROM accounts WHERE id = ?');
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$stmt->bind_result($password, $email);
$stmt->fetch();
$stmt->close();
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Dactr | My Profile</title>

    <!-- Custom style -->
    <link href="\dactr/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  </head>

  <body class="text-center">
		<div id='wrapper'>
		<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
			<!-- Header -->
			<header class="masthead">
				<div class="inner">
					<h3 class="masthead-brand">Dactr</h3>
					<nav class="nav nav-masthead justify-content-center">
						<a class="nav-link" href="home.php">Home</a>
						<a class="nav-link" href="journal.php">My Diary</a>
						<a class="nav-link active" href="profile.php">My Profile</a>
						<a class="nav-link" href="../php/logout.php">Logout</a>
					</nav>
				</div>
			</header>
			<!-- Profile information -->
			<main class="text-left">
				<h1>Profile Page</h1>
				<div class="row">
					<div class="col-6"><p>Username:</p></div>
					<div class="col-6"><p><?=$_SESSION['name']?></p></div>
				</div>
				<div class="row">
					<div class="col-6"><p>Email:</p></div>
					<div class="col-6"><p><?=$email?></p></div>
				</div>
			</main>
			<!-- Footer -->
			<footer class="mastfoot mt-auto">
        <div class="inner">
          <p>&copy; Dactr Group</p>
					<a class="btn btn-link btn-sm text-danger" href="crisis.php">Need Support Now?</a>
        </div>
      </footer>
		</div>
	</div>
	</body>

</html>
