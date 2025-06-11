<?php
include("partials/header.php");
require_once '_inc/classes/Database.php';
require_once '_inc/classes/Authenticate.php';
require_once '_inc/classes/User.php';

$db = new Database();
$auth = new Authenticate($db);
$auth->requireLogin('tetris.php'); // Передаём текущую страницу как return
$user = new User($db);
$userId = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['score'])) {
    $score = (int)$_POST['score'];
    if ($user->updatePoints($userId, $score)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to save score']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="wrapper">
        <main class="main" style="padding-top: 3.4rem;">
            <div class="container">
                <div class="menu">
                    <div class="bg-primary text-white text-center py-5">
                        <h1 class="display-4">Play Tetris!</h1>
                        <p class="lead">Test your skills and earn points for the Tetris Club leaderboard.</p>
                    </div>
                </div>

                <section class="game-section mt-5">
                    <div class="container text-center">
                        <h2 class="mb-4 text-dark">Tetris Game</h2>
                        <div class="canvas-wrap">
                            <canvas id="tetris" width="320" height="640"></canvas>
                            <div id="score" class="mt-3">Score: 0</div>
                            <button id="start_game" class="btn btn-primary mt-3">Start Game</button>
                        </div>
                    </div>
                </section>

                <section class="instructions-section mt-5">
    <div class="container">
        <h3>How to Play</h3>
        <p>Use the following keys to control the game:</p>
        <ul class="list-group">
            <li class="list-group-item">← Left Arrow: Move the piece left</li>
            <li class="list-group-item">→ Right Arrow: Move the piece right</li>
            <li class="list-group-item">↓ Down Arrow: Soft drop (accelerate the fall)</li>
            <li class="list-group-item">↑ Up Arrow: Rotate the piece clockwise</li>
            <li class="list-group-item">Z: Rotate the piece counterclockwise</li>
            <li class="list-group-item">Space: Hard drop (instantly drop the piece)</li>
        </ul>
    </div>
</section>

<section class="accordion-section mt-5" style="padding-bottom: 1rem;">
    <div class="container">
        <div class="accordion" id="accordionExample2">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingDisclaimer">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDisclaimer" aria-expanded="true" aria-controls="collapseDisclaimer">
                        <strong>!!!Disclaimer!!!</strong>
                    </button>
                </h2>
                <div id="collapseDisclaimer" class="accordion-collapse collapse show" aria-labelledby="headingDisclaimer" data-bs-parent="#accordionExample2">
                    <div class="accordion-body">
                        <p><strong>Important! All content on this site is intended as a joke and is not meant to offend or insult anyone. All texts, images, and events mentioned on the Tetris Club pages are fictional and created purely for entertainment purposes. We do not intend to hurt the feelings of any individuals, organizations, or anyone else.</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

        <style>
            .canvas-wrap {
                display: block;
                margin: 0 auto;
                padding-top: 25px;
            }
            .canvas-wrap > canvas {
                display: block;
                margin: 0 auto;
                border: 1px solid #ffffff;
                background: black;
            }
            #score {
                font-size: 1.5em;
                color: #444;
            }
        </style>

        <script>
        // Tetris game logic adapted from Jake Gordon's JavaScript Tetris
        const canvas = document.getElementById('tetris');
        const context = canvas.getContext('2d');
        const scoreElement = document.getElementById('score');
        const startButton = document.getElementById('start_game');

        if (!canvas || !context || !scoreElement || !startButton) {
            console.error('Required elements not found:', { canvas, context, scoreElement, startButton });
            throw new Error('Missing required DOM elements');
        }

        context.scale(20, 20);

        // Test canvas rendering
        console.log('Testing canvas rendering...');
        context.fillStyle = '#FF0000';
        context.fillRect(0, 0, 1, 1); // Draw a red test block
        context.fillStyle = '#000';
        context.fillRect(0, 0, canvas.width / 20, canvas.height / 20);
        console.log('Canvas test rendering complete');

        const tetrisPieces = [
            [ // I-Piece
                [[0,0,0,0],[1,1,1,1],[0,0,0,0],[0,0,0,0]],
                [[0,0,1,0],[0,0,1,0],[0,0,1,0],[0,0,1,0]],
                [[0,0,0,0],[1,1,1,1],[0,0,0,0],[0,0,0,0]],
                [[0,1,0,0],[0,1,0,0],[0,1,0,0],[0,1,0,0]]
            ],
            [ // J-Piece
                [[0,1,0,0],[0,1,1,1],[0,0,0,0],[0,0,0,0]],
                [[0,0,1,0],[0,0,1,0],[0,1,1,0],[0,0,0,0]],
                [[0,0,0,0],[1,1,1,0],[0,0,1,0],[0,0,0,0]],
                [[0,1,1,0],[0,1,0,0],[0,1,0,0],[0,0,0,0]]
            ],
            [ // L-Piece
                [[0,0,1,0],[1,1,1,0],[0,0,0,0],[0,0,0,0]],
                [[0,1,0,0],[0,1,0,0],[0,1,1,0],[0,0,0,0]],
                [[0,0,0,0],[0,1,1,1],[0,1,0,0],[0,0,0,0]],
                [[0,1,1,0],[0,0,1,0],[0,0,1,0],[0,0,0,0]]
            ],
            [ // O-Piece
                [[0,1,1,0],[0,1,1,0],[0,0,0,0],[0,0,0,0]],
                [[0,1,1,0],[0,1,1,0],[0,0,0,0],[0,0,0,0]],
                [[0,1,1,0],[0,1,1,0],[0,0,0,0],[0,0,0,0]],
                [[0,1,1,0],[0,1,1,0],[0,0,0,0],[0,0,0,0]]
            ],
            [ // S-Piece
                [[0,0,1,1],[0,1,1,0],[0,0,0,0],[0,0,0,0]],
                [[0,1,0,0],[0,1,1,0],[0,0,1,0],[0,0,0,0]],
                [[0,0,0,0],[0,1,1,0],[1,1,0,0],[0,0,0,0]],
                [[0,1,0,0],[0,1,1,0],[0,0,1,0],[0,0,0,0]]
            ],
            [ // T-Piece
                [[0,1,0,0],[1,1,1,0],[0,0,0,0],[0,0,0,0]],
                [[0,1,0,0],[0,1,1,0],[0,1,0,0],[0,0,0,0]],
                [[0,0,0,0],[1,1,1,0],[0,1,0,0],[0,0,0,0]],
                [[0,1,0,0],[1,1,0,0],[0,1,0,0],[0,0,0,0]]
            ],
            [ // Z-Piece
                [[1,1,0,0],[0,1,1,0],[0,0,0,0],[0,0,0,0]],
                [[0,0,1,0],[0,1,1,0],[0,1,0,0],[0,0,0,0]],
                [[0,0,0,0],[1,1,0,0],[0,1,1,0],[0,0,0,0]],
                [[0,1,0,0],[1,1,0,0],[1,0,0,0],[0,0,0,0]]
            ]
        ];

        const colors = {
            1: '#00FFFF', // I: cyan
            2: '#0000FF', // J: blue
            3: '#FFA500', // L: orange
            4: '#FFFF00', // O: yellow
            5: '#00FF00', // S: green
            6: '#800080', // T: purple
            7: '#FF0000'  // Z: red
        };

        let score = 0;
        let board;
        let piece;
        let playing = false;
        let gameInterval;

        function createBoard() {
            console.log('Creating board...');
            const board = [];
            for (let y = 0; y < 20; y++) {
                board[y] = [];
                for (let x = 0; x < 10; x++) {
                    board[y][x] = 0;
                }
            }
            return board;
        }

        function eachblock(type, x, y, dir, fn) {
            console.log(`eachblock called for type:${type}, x:${x}, y:${y}, dir:${dir}`);
            const blocks = tetrisPieces[type][dir];
            for (let row = 0; row < 4; row++) {
                for (let col = 0; col < 4; col++) {
                    if (blocks[row][col]) {
                        console.log(`Processing block at row:${row}, col:${col}`);
                        fn(x + col, y + row);
                    }
                }
            }
        }

        function occupied(type, x, y, dir) {
            let result = false;
            eachblock(type, x, y, dir, function(x, y) {
                if ((x < 0) || (x >= 10) || (y >= 20) || (y < 0) || (board[y] && board[y][x])) {
                    result = true;
                }
            });
            return result;
        }

        function unoccupied(type, x, y, dir) {
            return !occupied(type, x, y, dir);
        }

        let bag = [];
        function randomPiece() {
            console.log('Generating random piece...');
            if (bag.length === 0) {
                for (let i = 0; i < 4; i++) {
                    for (let j = 0; j < 7; j++) {
                        bag.push(j);
                    }
                }
            }
            const index = Math.floor(Math.random() * bag.length);
            const type = bag.splice(index, 1)[0];
            return { type: type, dir: 0, x: Math.round(10 / 2 - 4 / 2), y: 0 };
        }

        function draw() {
            console.log('Drawing game state...');
            console.log('Piece:', piece);
            context.fillStyle = '#000';
            context.fillRect(0, 0, canvas.width / 20, canvas.height / 20);
            for (let y = 0; y < 20; y++) {
                for (let x = 0; x < 10; x++) {
                    if (board[y][x]) {
                        console.log(`Drawing board block at x:${x}, y:${y}, color:${colors[board[y][x]]}`);
                        context.fillStyle = colors[board[y][x]];
                        context.fillRect(x, y, 1, 1);
                    }
                }
            }
            if (piece) {
                console.log(`Drawing piece type:${piece.type}, x:${piece.x}, y:${piece.y}, dir:${piece.dir}`);
                context.fillStyle = colors[piece.type + 1];
                eachblock(piece.type, piece.x, piece.y, piece.dir, function(x, y) {
                    if (y >= 0) {
                        console.log(`Drawing piece block at x:${x}, y:${y}`);
                        context.fillRect(x, y, 1, 1);
                    }
                });
            }
        }

        function moveLeft() {
            if (unoccupied(piece.type, piece.x - 1, piece.y, piece.dir)) {
                piece.x--;
            }
        }

        function moveRight() {
            if (unoccupied(piece.type, piece.x + 1, piece.y, piece.dir)) {
                piece.x++;
            }
        }

        function softDrop() {
            if (unoccupied(piece.type, piece.x, piece.y + 1, piece.dir)) {
                piece.y++;
            } else {
                placePiece();
            }
        }

        function rotateCW() {
            const newDir = (piece.dir === 3 ? 0 : piece.dir + 1);
            if (unoccupied(piece.type, piece.x, piece.y, newDir)) {
                console.log(`Rotating CW to dir:${newDir}`);
                piece.dir = newDir;
            }
        }

        function rotateCCW() {
            const newDir = (piece.dir === 0 ? 3 : piece.dir - 1);
            if (unoccupied(piece.type, piece.x, piece.y, newDir)) {
                console.log(`Rotating CCW to dir:${newDir}`);
                piece.dir = newDir;
            }
        }

        function hardDrop() {
            while (unoccupied(piece.type, piece.x, piece.y + 1, piece.dir)) {
                piece.y++;
            }
            placePiece();
        }

        function placePiece() {
            console.log('Placing piece...');
            eachblock(piece.type, piece.x, piece.y, piece.dir, function(x, y) {
                if (y >= 0) {
                    board[y][x] = piece.type + 1;
                }
            });
            clearLines();
            piece = randomPiece();
            if (occupied(piece.type, piece.x, piece.y, piece.dir)) {
                gameOver();
            }
        }

        function clearLines() {
            console.log('Checking for lines to clear...');
            for (let y = 19; y >= 0; y--) {
                if (board[y].every(cell => cell)) {
                    board.splice(y, 1);
                    board.unshift(new Array(10).fill(0));
                    score += 100;
                    scoreElement.innerHTML = "Score: " + score;
                    console.log(`Line cleared, new score: ${score}`);
                }
            }
        }

        function gameOver() {
            console.log('Game over triggered');
            clearInterval(gameInterval);
            playing = false;
            startButton.textContent = 'Start Game';
            alert("Game Over! Your score: " + score);
            fetch('', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `score=${score}`
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    console.error('Failed to save score:', data.error);
                }
            });
        }

        function update() {
            if (!playing) {
                console.log('Update skipped: game not playing');
                return;
            }
            console.log('Updating game state...');
            softDrop();
            draw();
        }

        function startGame() {
            console.log('startGame called');
            if (playing) {
                console.log('Game already running, restarting...');
                clearInterval(gameInterval);
                playing = false;
                startButton.textContent = 'Start Game';
                return;
            }
            console.log('Initializing new game...');
            board = createBoard();
            piece = randomPiece();
            score = 0;
            playing = true;
            scoreElement.innerHTML = "Score: " + score;
            startButton.textContent = 'Restart Game';
            gameInterval = setInterval(update, 1000);
            draw();
        }

        startButton.addEventListener('click', () => {
            console.log('Start button clicked');
            startGame();
        });

        document.addEventListener('keydown', function(event) {
            if (!playing) {
                console.log('Keypress ignored: game not playing');
                return;
            }
            console.log('Key pressed:', event.key, 'KeyCode:', event.keyCode);
            if (event.keyCode === 37) { // left arrow
                event.preventDefault();
                moveLeft();
            } else if (event.keyCode === 39) { // right arrow
                event.preventDefault();
                moveRight();
            } else if (event.keyCode === 40) { // down arrow
                event.preventDefault();
                softDrop();
            } else if (event.keyCode === 38) { // up arrow
                event.preventDefault();
                rotateCW();
            } else if (event.keyCode === 90) { // Z key
                event.preventDefault();
                rotateCCW();
            } else if (event.keyCode === 32) { // spacebar
                event.preventDefault();
                hardDrop();
            }
            draw();
        });
        </script>

                <?php
  include("partials/footer.php")
?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>