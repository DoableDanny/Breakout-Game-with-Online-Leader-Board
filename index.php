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
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jackson</td>
            <td>94</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Jacksonator132ThemainDude</td>
            <td>100</td>
          </tr>
          <tr>
            <td>1</td>
            <td>Smith</td>
            <td>50</td>
          </tr>
        </table>
      </div>
    </div>
  </body>
</html>
