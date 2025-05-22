<?php
session_start();

if (!isset($_SESSION['first_player'])) {
    $_SESSION['first_player'] = rand(0, 1) ? 'X' : 'O';
}

if (!isset($_SESSION['board'])) {
    resetGame();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['reset'])) {
        resetGame();
    } elseif (isset($_POST['cell']) && empty($_SESSION['winner'])) {
        list($row, $col) = explode(',', $_POST['cell']);
        $row = (int) $row;
        $col = (int) $col;
        
        if ($_SESSION['board'][$row][$col] === '') {
            $_SESSION['board'][$row][$col] = $_SESSION['turn'];
            if ($winning_cells = checkWinner($_SESSION['board'], $_SESSION['turn'])) {
                $_SESSION['winner'] = $_SESSION['turn'];
                $_SESSION['winning_cells'] = $winning_cells;
                $_SESSION['first_player'] = $_SESSION['turn'] === 'X' ? 'O' : 'X';
            } else {
                $_SESSION['turn'] = $_SESSION['turn'] === 'X' ? 'O' : 'X';
            }
        }
    }
}

function resetGame() {
    $_SESSION['board'] = [['', '', ''], ['', '', ''], ['', '', '']];
    $_SESSION['turn'] = $_SESSION['first_player'];
    $_SESSION['winner'] = null;
    $_SESSION['winning_cells'] = [];
}

function checkWinner($board, $player) {
    $winning_patterns = [
        [[0, 0], [0, 1], [0, 2]], [[1, 0], [1, 1], [1, 2]], [[2, 0], [2, 1], [2, 2]], // Rows
        [[0, 0], [1, 0], [2, 0]], [[0, 1], [1, 1], [2, 1]], [[0, 2], [1, 2], [2, 2]], // Columns
        [[0, 0], [1, 1], [2, 2]], [[0, 2], [1, 1], [2, 0]] 
    ];
    
    foreach ($winning_patterns as $pattern) {
        if ($board[$pattern[0][0]][$pattern[0][1]] === $player &&
            $board[$pattern[1][0]][$pattern[1][1]] === $player &&
            $board[$pattern[2][0]][$pattern[2][1]] === $player) {
            return $pattern;
        }
    }
    return false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tic Tac Toe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
            margin: 0;
            text-align: center;
        }
        .game-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
        }
        h1 {
            font-size: 2rem;
            color: #333;
        }
        .message {
            font-size: 1.2rem;
            color: #28a745;
        }
        table {
            border-collapse: collapse;
            margin: 20px auto;
            width: 100%;
        }
        td {
            width: 33.3%;
            height: 80px;
            border: 2px solid #ccc;
            text-align: center;
            font-size: 2rem;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        td.winner {
            background-color: #28a745;
            color: white;
        }
        td:hover {
            background-color: #f0f0f0;
        }
        button {
            padding: 10px 15px;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function makeMove(row, col) {
            document.getElementById('cell').value = row + ',' + col;
            document.getElementById('gameForm').submit();
        }
    </script>
</head>
<body>
    <div class="game-container">
        <h1>Tic Tac Toe</h1>
        <h3>Giliran: <?= $_SESSION['turn'] ?></h3>
        
        <?php if ($_SESSION['winner']): ?>
            <div class="message">
                <h2>Pemenang: <?= $_SESSION['winner'] ?></h2>
            </div>
        <?php elseif (!in_array('', array_merge(...$_SESSION['board']), true)): ?>
            <div class="message">
                <h2>Seri! Tidak ada pemenang.</h2>
            </div>
        <?php endif; ?>
        
        <form id="gameForm" method="post">
            <input type="hidden" id="cell" name="cell">
            <table>
                <?php for ($i = 0; $i < 3; $i++): ?>
                    <tr>
                        <?php for ($j = 0; $j < 3; $j++): ?>
                            <td onclick="makeMove(<?= $i ?>, <?= $j ?>)" 
                                class="<?= in_array([$i, $j], $_SESSION['winning_cells']) ? 'winner' : '' ?>">
                                <?= $_SESSION['board'][$i][$j] ?>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
            <button type="submit" name="reset">Reset</button>
        </form>
    </div>
</body>
</html>
