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

    <title>Dactr | Home</title>

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
      <!-- Dactr image -->
      <div class="text-center" style="margin-bottom:5rem">
        <img src="\dactr/images/dactr.png" class="img-fluid">
      </div>
      <!-- Welcome and Diary button -->
      <main role="main" class="inner cover">
        <h1 class="cover-heading" style="margin-bottom: 2rem">Hello, <?=$_SESSION['name']?>!</h1>
        <p class="lead">Write your diary for Dactr today, if you haven't already!</p>
        <p class="lead">
          <a href="journal.php" class="btn btn-lg btn-secondary">My Diary</a>
        </p>
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
