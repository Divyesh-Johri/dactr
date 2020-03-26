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

    <title>Dactr | My Diary</title>

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
            <a class="nav-link" href="home.php">Home</a>
            <a class="nav-link active" href="journal.php">My Diary</a>
            <a class="nav-link" href="profile.php">My Profile</a>
            <a class="nav-link" href="../php/logout.php">Logout</a>
          </nav>
        </div>
      </header>
      <!-- Journal -->
      <main>
        <h1><em>Dear Dactr,</em></h1>
        <form class="mb-4" method="post">
          <div class="form-group">
            <label for="journal"></label>
            <textarea class="form-control" name="journal" placeholder="Jot down your thoughts!" id="journal" rows="10" required></textarea>
          </div>
          <input class="btn btn-large btn-secondary" type="submit" value="Submit">
        </form>

        <?php //Recording journals in the database.
      if('POST' === $_SERVER['REQUEST_METHOD']){
        // Connect to the database dactrlogin
  			$DATABASE_HOST = 'localhost';
  			$DATABASE_USER = 'root';
  			$DATABASE_PASS = $_SESSION['pass'];
  			$DATABASE_NAME = 'dactrjournal';
  			$connection = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
  			// Stop if can't connect
  			if (mysqli_connect_errno()) {
  				exit('Failed to connect ' . mysqli_connect_error());
  			}

        //Check if form is completed
        if (!isset($_POST['journal'])) {
  			  exit();
  			}

        //Basic function to sanitize input data
        function validate($data){
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          $data = str_replace('\\', '', $data);
          $data = str_replace('/', '', $data);
          $data = str_replace("'", '', $data);
          $data = str_replace(";", '', $data);
          $data = str_replace("(", '', $data);
          $data = str_replace(")", '', $data);
          return $data;
        }

        //Enter journal info into database with appropriate username
        if ($stmt = $connection->prepare('INSERT INTO journals (username, date, journal) VALUES (?,?,?)')){
		      // Bind and assign all parameters
          $date = date('m/d/Y');
          $journal = validate($_POST['journal']);
		      $stmt->bind_param('sss', $_SESSION['name'], $date, $journal);
		      $stmt->execute();
          //Send the user to see feedback and reset date/journal
          header('location: results.php');
          $date = null;
          $journal = null;
		    } else {
		      //Exit
          echo 'Something went wrong with SQL preparation';
		    }

        $stmt->close();
        $connection->close();
      }
        ?>

        <a href="results.php">Previous Entry's Feedback</a>

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
