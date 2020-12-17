<?php 

include("dbConnect.php");



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

    <div class="game-and-leaderboard">
      <canvas id="canvas" width="700" height="600"></canvas>

      <div class="leaderboard">
        <table>
          <tr>
            <th>Place</th>
            <th>Name</th>
            <th>Points</th>
          </tr>

          <?php foreach($scores as $key=>$score): ?>
            <tr>
            <td><?php echo $key + 1 ?></td>
            <td><?php echo $score['name'] ?></td>
            <td><?php echo $score['score'] ?></td>
          </tr>
          <?php endforeach ?>
         
        </table>
      </div>
    </div>
  </body>
</html>
