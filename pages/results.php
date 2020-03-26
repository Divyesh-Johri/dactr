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

    <title>Dactr | My Feedback</title>

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
      <!-- Results -->
      <main>
          <h1>Feedback</h1>
          <!-- Cards with journal and feedback -->
            <!-- Journal card -->
            <div class ="card" style="text-align: left">
              <div class="card-header">Your Diary Entry</div>
              <div class="card-body">
                <h5 class="card-title">Dear Dactr,</h5>

                <?php //Pull and display journal
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

                //Define journal variable for use in analysis
                $journal = '';

                //Find and display today's latest journal made by the patient
                $result = $connection->query("SELECT username, date, journal FROM journals ORDER BY id DESC LIMIT 1");
                $noName = 0;
                if ($result->num_rows > 0){
                  while($row = $result->fetch_assoc()){
                    if ($row['username'] == $_SESSION['name']){
                      echo '<p class="card-text">'.$row['journal'].'</p>';
                      echo '<p class="card-text mb-2">- <em>'.$_SESSION['name'].' '.$row['date'].'</em></p>';
                      $journal = $row['journal'];
                      $noName = 1;
                      break;
                    }
                  }
                  if ($noName == 0){
                    ?><p class="card-text"><em>You haven't written in your diary yet!</em></p><?php
                  }
                } else {
                  ?><p class="card-text"><em>You haven't written in your diary yet!</em></p><?php
                }
                ?>

              </div>
            </div>
            <!--Feedback card -->
            <div class ="card" style="text-align: left">
              <div class="card-header">Feedback from Dactr</div>
              <div class="card-body">
                <h5 class="card-title">Dear <?=$_SESSION['name']?>,</h5>

                <?php
                # Has a journal been written yet?
                if ($noName == 0){
                  ?><p class="card-text"><em>You haven't written in your diary yet!</em></p><?php
                  exit();
                }

                # Begin sentiment analysis with nlp api
                # Includes the autoloader for libraries installed with composer
                require '/home/bitnami/vendor/autoload.php';

                # Imports the Google Cloud client library
                use Google\Cloud\Language\LanguageClient;

                # Your Google Cloud Platform project ID
                $projectId = 'dactr-272020';

                # Instantiates a client
                $language = new LanguageClient(['projectId' => $projectId]);

                # Detects the sentiment of current journal and assigns it to sentimentScore
                $annotation = $language->analyzeSentiment($journal);
                $sentiment = $annotation->sentiment();
                $sentimentScore = $sentiment['score'];

                # Display appropriate output
                if($sentimentScore < -.25 )
                {
                    echo "<p class='card-text'>You addressed a lot of the negatives in your journal.
                    Make sure to avoid 'should' statements and to not make hasty conclusions or assumptions.</p>";

                    echo "<p class='card-text'>Try thinking about some of the positives! What are interactions and events that you enjoyed today?
                    Even if it's as simple as having a cookie after dinner, go over a few things you may be thankful for!
                    Also, make sure to think of ways to overcome challenges and look at conflicts optimistically! </p>";

                    echo "<p class='card-text'>Remember to take time out of your day for self-healing (i.e. exercising, taking walks, yoga).
                    Whether it be a short walk in your neighborhood or a 2 minute meditation, small actions add up to big results!</p>";

                    echo "<p class='card-text'>Also, if you need support, feel free <a class='text-primary' href='crisis.php'>to contact chat-lines for advice!</a> No crisis is too small! </p>";
                }
                else if($sentimentScore >= -.25 and $sentimentScore <= .25)
                {
                    echo "<p class='card-text'>You seem to show some conflicting thoughts. While it is important to
                    take the time to analyze and acknowledge negatives of your day, make sure to place more emphasis
                    on the positives! Think of ways to overcome challenges and look at conflicts optimistically! </p>";

                    echo "<p class='card-text'>Remember to take time out of your day for self-healing (i.e. exercising, taking walks, yoga).
                    Whether it be a short walk in your neighborhood or a 2 minute meditation, small actions add up to big results!</p>";
                }
                else
                {
                    echo "<p class='card-text'>You are on the right track! Keep up the positive energy! Remember to continue thinking of
                    ways to overcome challenges and maintain an open mindset. Logically thinking through conflicts
                    and approaching them optimistically is key to overcoming them. Continue the great work!</p>";

                    echo "<p class='card-text'>Remember to take time out of your day to continue self-healing (i.e. exercising, taking walks, yoga).
                    Whether it be a short walk in your neighborhood or a 2 minute meditation, small actions add up to big results!</p>";
                }
                /* Previous entry response system
                # Obtain previous journal
                $current = 0;
                $prevJournal = '';
                $result = $connection->query("SELECT username, date, journal FROM journals ORDER BY id DESC LIMIT 1");
                if ($result->num_rows > 0){
                  while($row = $result->fetch_assoc()){
                    if ($row['username'] == $_SESSION['name']){
                      if ($current == 1){ $prevJournal = $row['journal']; }
                      $current = 1;
                    }
                  }
                } else { exit(); }

                if ($prevJournal == ''){
                  exit();
                }
                echo '<p>'.$prevJournal.'</p>';
                # Detects the sentiment of previous journal and assigns it to prevSentimentScore
                $annotation = $language->analyzeSentiment($prevJournal);
                $sentiment = $annotation->sentiment();
                $prevSentimentScore = $sentiment['score'];
                echo '<p>'.$prevSentimentScore.'</p>';
                if($prevSentimentScore < $sentimentScore)
                {
                    echo "<p class='card-text'>I see you have made some progress since your last entry! Remember to take time out of your day for self-healing (i.e. exercising, taking walks, yoga).
                    Whether it be a short walk in your neighborhood or a 2 minute meditation, small actions add up to big results!</p>";
                }
                else
                {
                    echo "<p class='card-text'>You seem to be a bit more negative in this entry than the last. Remember to take time out of your day for self-healing (i.e. exercising, taking walks, yoga).
                    Also, if you need support, feel free <a href='crisis.php'>to contact chat-lines for advice!</a> No crisis is too small! </p>";
                }
                */
                $connection->close();
                ?>

                <p class='card-text'>Thanks for taking the time to track your feelings for the day! See you next time, <?=$_SESSION['name']?>!</p>
                <p class="card-text mb-2">- <em>Dactr</em></p>
              </div>
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
