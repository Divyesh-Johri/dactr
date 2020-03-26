<?php
session_start();
//redirect if not logged in
if (!isset($_SESSION['loggedin'])){
  header('Location: ../index.php');
  exit;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Dactr | Crisis</title>

    <!-- Custom style -->
    <link href="\dactr/css/style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
  </head>

  <body class="text-center">
    <div id='wrapper'>
    <!-- Main container -->
    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <!-- Header -->
      <header class="masthead">
        <div class="inner">
          <h3 class="masthead-brand">Dactr</h3>
          <nav class="nav nav-masthead justify-content-center">
            <a class="nav-link active" href="home.php">Home</a>
            <a class="nav-link" href="journal.php">My Diary</a>
            <a class="nav-link" href="profile.php">My Profile</a>
            <a class="nav-link" href="../php/logout.php">Logout</a>
          </nav>
        </div>
      </header>
      <!-- Info -->
      <main>
        <h1>Need Support Now?</h1>
        <h5>Please don't hesitate to connect with these sources to receive immediate support</h5>
        <div class="m-4">
          <a class="btn btn-danger btn-lg btn-block p-3" href="https://www.crisistextline.org/" role="button">Text Line</a>
          <a class="btn btn-danger btn-lg btn-block p-3" href="https://suicidepreventionlifeline.org/chat/" role="button">Chat Line</a>
          <a class="btn btn-danger btn-lg btn-block p-3" href="tel:1-800-273-8255" role="button">Talk Line</a>
        </div>
        <h5>Remember, no crisis is too small for a chat!</h5>
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
