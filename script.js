const rulesBtn = document.getElementById("btn-rules");
const rules = document.getElementById("rules");
const closeBtn = document.getElementById("btn-close");
const canvas = document.getElementById("canvas");
const ctx = canvas.getContext("2d");

let score = 0;

const BALL = {
  x: canvas.width / 2,
  y: canvas.height / 2,
  radius: 10,
  speed: 4,
  dx: 4,
  dy: -4,
};

const PADDLE = {
  x: canvas.width / 2 - 35,
  y: canvas.height - 20,
  w: 75,
  h: 8,
  speed: 6,
  dx: 0,
};

const BRICK_INFO = {
  w: 65,
  h: 20,
  padding: 10,
  offsetX: 65,
  offsetY: 50,
  visbile: true,
};

const BRICK_COLUMN_NUMBER = 5;
const BRICK_ROW_NUMBER = 9;

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
      ctx.fillStyle = "#E20097";
      ctx.fill();
      ctx.closePath();
    });
  });
}

// Draw ball to canvas
function drawBall() {
  ctx.beginPath();
  ctx.arc(BALL.x, BALL.y, BALL.radius, 0, Math.PI * 2);
  ctx.fillStyle = "#75AC4D";
  ctx.fill();
  ctx.stroke();
  ctx.lineWidth = "0.1";
  ctx.closePath();
}

// Draw paddle to canvas
function drawPaddle() {
  ctx.beginPath();
  ctx.rect(PADDLE.x, PADDLE.y, PADDLE.w, PADDLE.h);
  ctx.fillStyle = "#FF92DB";
  ctx.fill();
  ctx.closePath();
}

// Draw score to canvas
function drawScore() {
  ctx.beginPath();
  ctx.font = "20px Arial";
  ctx.fillStyle = "#FF92DB";
  ctx.fillText(`Score: ${score}`, 10, 25);
  ctx.closePath();
}

// Main draw function (draws everything)
function draw() {
  ctx.clearRect(0, 0, canvas.width, canvas.height);
  drawBricks();
  drawBall();
  drawPaddle();
  drawScore();
}

// Update the paddles position
function updatePaddle() {
  PADDLE.x += PADDLE.dx;

  // Check for paddle wall collision
  if (PADDLE.x < 0) PADDLE.x = 0;
  if (PADDLE.x + PADDLE.w > canvas.width) {
    PADDLE.x = canvas.width - PADDLE.w;
  }
}

// Main update funtion
function update() {
  updatePaddle();

  console.log(PADDLE.dx);
}

// Main game loop
function main() {
  update();
  draw();

  window.requestAnimationFrame(main);
}

main();

// If arrow left or right is pressed down, give the paddle speed
function handleKeyDown(e) {
  if (e.key === "Right" || e.key === "ArrowRight") {
    PADDLE.dx = PADDLE.speed;
  } else if (e.key === "Left" || e.key === "ArrowLeft") {
    PADDLE.dx = -PADDLE.speed;
  }
}

// When arrow left or right key lifted, remove paddle's speed
function handleKeyUp(e) {
  if (
    e.key === "Right" ||
    e.key === "ArrowRight" ||
    e.key === "Left" ||
    e.key === "ArrowLeft"
  ) {
    PADDLE.dx = 0;
  }
}

// Event listeners to move paddle
document.addEventListener("keydown", handleKeyDown);
document.addEventListener("keyup", handleKeyUp);

// Rules show and close btns event listeners
rulesBtn.addEventListener("click", () => rules.classList.add("show"));
closeBtn.addEventListener("click", () => rules.classList.remove("show"));
