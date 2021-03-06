const rulesBtn = document.getElementById('btn-rules');
const rules = document.getElementById('rules');
const closeBtn = document.getElementById('btn-close');
const usernameInput = document.getElementById('username-input');
const levelElement = document.getElementById('level');
const canvas = document.getElementById('canvas');
const ctx = canvas.getContext('2d');

let score = 0;
let level = 1;
let animationFrameId;

// Ball properties
const BALL = {
  x: canvas.width / 2,
  y: canvas.height / 2,
  radius: 10,
  speed: 2,
  dx: 2,
  dy: -2,
};

// Paddle properties
const PADDLE = {
  x: canvas.width / 2 - 35,
  y: canvas.height - 20,
  w: 130,
  h: 8,
  speed: 6,
  dx: 0,
};

// Brick properties
const BRICK_INFO = {
  w: 140,
  h: 18,
  padding: 10,
  offsetX: 24,
  offsetY: 40,
  visible: true,
};

// The number of bricks in a row and column
const BRICK_COLUMN_NUMBER = 3;
const BRICK_ROW_NUMBER = 4;

// Create bricks
const bricks = [];
for (let i = 0; i < BRICK_ROW_NUMBER; i++) {
  bricks[i] = [];
  for (let j = 0; j < BRICK_COLUMN_NUMBER; j++) {
    const x = i * (BRICK_INFO.w + BRICK_INFO.padding) + BRICK_INFO.offsetX;
    const y = j * (BRICK_INFO.h + BRICK_INFO.padding) + BRICK_INFO.offsetY;

    bricks[i][j] = { x, y, ...BRICK_INFO };
  }
}

// Draw bricks to canvas
function drawBricks() {
  bricks.forEach((columns) => {
    columns.forEach((brick) => {
      ctx.beginPath();
      ctx.rect(brick.x, brick.y, brick.w, brick.h);
      ctx.fillStyle = brick.visible ? '#E20097' : 'transparent';
      ctx.fill();
      ctx.closePath();
    });
  });
}

// Draw ball to canvas
function drawBall() {
  ctx.beginPath();
  ctx.arc(BALL.x, BALL.y, BALL.radius, 0, Math.PI * 2);
  ctx.fillStyle = '#75AC4D';
  ctx.fill();
  ctx.stroke();
  ctx.lineWidth = '0.1';
  ctx.closePath();
}

// Draw paddle to canvas
function drawPaddle() {
  ctx.beginPath();
  ctx.rect(PADDLE.x, PADDLE.y, PADDLE.w, PADDLE.h);
  ctx.fillStyle = '#FF92DB';
  ctx.fill();
  ctx.closePath();
}

// Draw score to canvas
function drawScore() {
  ctx.font = '20px Arial';
  ctx.fillStyle = '#FF92DB';
  ctx.fillText(`Score: ${score}`, 10, 25);
}

// Main draw function (draws everything)
function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  drawBricks();
  drawBall();
  drawPaddle();
  drawScore();
}

// Move the paddle
function updatePaddle() {
  PADDLE.x += PADDLE.dx;

  // Check for paddle wall collision
  if (PADDLE.x < 0) PADDLE.x = 0;
  if (PADDLE.x + PADDLE.w > canvas.width) {
    PADDLE.x = canvas.width - PADDLE.w;
  }
}

// Move the ball
function updateBall() {
  BALL.x += BALL.dx;
  BALL.y += BALL.dy;

  // Check for wall collisions
  // top and bottom
  if (BALL.y - BALL.radius < 0 || BALL.y + BALL.radius > canvas.height) {
    BALL.dy *= -1;
    // right and left
  } else if (BALL.x + BALL.radius > canvas.width || BALL.x - BALL.radius < 0) {
    BALL.dx *= -1;
  }

  // Check for brick collision
  bricks.forEach((column) => {
    column.forEach((brick) => {
      if (brick.visible) {
        if (
          BALL.x - BALL.radius > brick.x && // Left side
          BALL.x + BALL.radius < brick.x + brick.w && // right side
          BALL.y - BALL.radius < brick.y + brick.h && // top side
          BALL.y + BALL.radius > brick.y // bottom side
        ) {
          brick.visible = false;
          BALL.dy *= -1;
          incrementScore();
        }
      }
    });
  });

  // Check for paddle collision
  if (
    BALL.x - BALL.radius > PADDLE.x &&
    BALL.x + BALL.radius < PADDLE.x + PADDLE.w &&
    BALL.y + BALL.radius > PADDLE.y
  ) {
    BALL.dy *= -1;
  }

  // Check if paddle missed the ball (hit bottom wall)
  if (BALL.y + BALL.radius > canvas.height) {
    regenerateBricks();
    sendScore();
    score = 0;
  }
}

function incrementScore() {
  score++;

  // Check if all bricks broken
  if (score % (BRICK_COLUMN_NUMBER * BRICK_ROW_NUMBER) === 0) {
    regenerateBricks();
    nextLevel();
  }
}

function regenerateBricks() {
  bricks.forEach((column) => {
    column.forEach((brick) => (brick.visible = true));
  });
}

// Increase ball speed and level number
function nextLevel() {
  if (!isNaN(level)) level++;

  switch (level) {
    case 2:
      BALL.dy = -2.5;
      break;
    case 3:
      BALL.dx = 2.5;
      BALL.dy = -2.5;
      break;
    case 4:
      BALL.dy = -3;
      break;
    case 5:
      BALL.dx = 3.5;
      BALL.dy = -3.5;
      break;
    default:
      level = 'ROAD TO DEATH 💀';
      BALL.dx += 0.5;
      BALL.dy -= 0.5;
      break;
  }

  levelElement.innerHTML = !isNaN(level)
    ? `<span class="high-score">Level: </span>${level} / 5`
    : level;
}

// Main update funtion
function update() {
  updatePaddle();
  updateBall();

  console.log(PADDLE.dx);
}

// Main game loop
function main() {
  update();
  draw();

  animationFrameId = window.requestAnimationFrame(main);
}

main();

// Send score to PHP
function sendScore() {
  const form = document.createElement('form');
  form.method = 'post';
  form.action = './';

  const hiddenField = document.createElement('input');
  hiddenField.type = 'hidden';
  hiddenField.name = 'score';
  hiddenField.value = score;

  form.appendChild(hiddenField);

  document.body.appendChild(form);

  form.submit();
}

// If arrow left or right is pressed down, give the paddle speed
function handleKeyDown(e) {
  if (e.key === 'Right' || e.key === 'ArrowRight') {
    PADDLE.dx = PADDLE.speed;
  } else if (e.key === 'Left' || e.key === 'ArrowLeft') {
    PADDLE.dx = -PADDLE.speed;
  }
}

// When arrow left or right key lifted, remove paddle's speed
function handleKeyUp(e) {
  if (
    e.key === 'Right' ||
    e.key === 'ArrowRight' ||
    e.key === 'Left' ||
    e.key === 'ArrowLeft'
  ) {
    PADDLE.dx = 0;
  }
}

// Event listeners to move paddle
document.addEventListener('keydown', handleKeyDown);
document.addEventListener('keyup', handleKeyUp);

// Rules show and close btns event listeners
rulesBtn.addEventListener('click', () => {
  rules.classList.add('show');
  window.cancelAnimationFrame(animationFrameId);
});
closeBtn.addEventListener('click', () => {
  rules.classList.remove('show');
  window.requestAnimationFrame(main);
});

// Event listeners for username input to pause game
usernameInput.addEventListener('focus', () => {
  window.cancelAnimationFrame(animationFrameId);
});
usernameInput.addEventListener('focusout', () => {
  animationFrameId = window.requestAnimationFrame(main);
});
