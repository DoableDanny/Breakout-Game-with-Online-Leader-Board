<?php 

include("dbFunctions.php");

$score = 0;
$username = "";
$invalidNameError = "";

session_start();

// Check if submitted username
if(isset($_POST['username'])) {
  if(!preg_match("/^@?(\w){1,15}$/", $_POST['username'])) {
    $invalidNameError = $_POST['username'] . ' is not a valid twitter username';
  } else {
    $username = $_POST['username'];
    $_SESSION['username'] = $username;
    // Get users score from db. If exists, save score to SESSION.
    $user =  getUser($username);
    if(isset($user['score'])) {
      $_SESSION['high-score'] = $user['score'];
    } else {
      unset($_SESSION['high-score']);
    }
  }
}


// If no session score, then set one. If have session score, check if new high score.
if(isset($_POST['score']) && isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $score = $_POST['score'];
  if(!isset($_SESSION['high-score'])) {
    $_SESSION['high-score'] = $score;
    // insert new high score record to db
    saveScore($username, $score);
  } else if($score > $_SESSION['high-score']) {
    $_SESSION['high-score'] = $score;
    // update high score in db
    updateScore($username, $score);
  }
}

// Get all names and scores from db
$scores = getAllScores();

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="style.css" />
  <script src="script.js" defer></script>
  <title>Breakout!</title>
</head>

<body>
  <h1>DEV_OUT!</h1>
  <div class="level-and-score-wrapper">
    <p id="level"><span class="high-score">Level: </span>1 / 5</p>
    <p><span class="high-score">High Score:</span>
      <?php echo isset($_SESSION['high-score']) ? htmlspecialchars($_SESSION['high-score']) : "Please sign in to save your score" ?>
    </p>
  </div>

  <button class="btn btn-rules" id="btn-rules">Rules</button>
  <div class="rules" id="rules">
    <h3>Rules</h3>
    <p>
      Use your right and left keys to move the paddle to bounce the ball up
      and break the blocks.
    </p>
    <p>If you miss the ball, your score and the blocks will reset.</p>
    <p>Game gets harder between levels 😈</p>
    <button class="btn btn-close" id="btn-close">Close Rules</button>
  </div>

  <div class="game-leaderboard-container">
    <canvas id="canvas" width="650" height="550"></canvas>

    <div class="form-leaderboard-container">
      <p>
        <?php echo isset($_SESSION['username']) ? "Hi " . htmlspecialchars($_SESSION['username']) : "Enter you twitter username to take part!" ?>
      </p>
      <form action="./" method="POST">
        <input type="text" name="username" value="@" id="username-input" required>
        <p class="invalid-name-error"><?php echo $invalidNameError ?></p>
        <input type="submit" value="Submit" class="btn">
      </form>
      <div class="leaderboard-container">
        <table>
          <tr>
            <th>Place</th>
            <th>Name</th>
            <th>Score</th>
          </tr>
          <?php foreach($scores as $key=>$score) : ?>
          <tr>
            <td><?php echo $key + 1 ?></td>
            <td><?php echo $score['name'] ?></td>
            <td><?php echo $score['score'] ?></td>
          </tr>
          <?php endforeach ?>
        </table>
      </div>
    </div>

  </div>
</body>

</html>