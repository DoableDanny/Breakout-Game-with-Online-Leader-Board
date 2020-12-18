<?php 

include("dbConnect.php");

$username = "";
$score = 0;

session_start();

// Check if submitted username
if(isset($_POST['username'])) {
  $username = $_POST['username'];
  $_SESSION['username'] = $username;
}

// If no session score, then set one. If have session score, check if new high score.
if(isset($_POST['score']) && $username !== "") {
  $score = $_POST['score'];
  if(!isset($_SESSION['high-score'])) {
    $_SESSION['high-score'] = $score;
  } else if($score > $_SESSION['high-score']) {
    $_SESSION['high-score'] = $score;
  }
}

// Get names and scores from db
$sql = 'SELECT name, score FROM leaderboard ORDER BY score DESC';
$result = mysqli_query($conn, $sql);
$scores = mysqli_fetch_all($result, MYSQLI_ASSOC);

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
  <p>High Score:
    <?php echo isset($_SESSION['high-score']) ? $_SESSION['high-score'] : "Please sign in to save your score" ?>
  </p>
  <button class="btn btn-rules" id="btn-rules">Rules</button>
  <div class="rules" id="rules">
    <h3>Rules</h3>
    <p>
      Use your right and left keys to move the paddle to bounce the ball up
      and break the blocks.
    </p>
    <p>If you miss the ball, your score and the blocks will reset.</p>
    <button class="btn btn-close" id="btn-close">Close Rules</button>
  </div>

  <div class="game-leaderboard-container">
    <canvas id="canvas" width="700" height="600"></canvas>

    <div class="form-leaderboard-container">
      <p>
        <?php echo isset($_SESSION['username']) ? "Enter you twitter username to take part!" : "Hi {$_SESSION['username']}" ?>
      </p>
      <form action="./" method="POST">
        <input type="text" name="username" value="@" required>
        <input type="submit" value="Submit" class="btn">
      </form>
      <div class="leaderboard">
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