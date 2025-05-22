<?php
$file = 'log.json';

if (!file_exists($file)) {
    file_put_contents($file, json_encode([]));
}

$data = json_decode(file_get_contents($file), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['id'])) {
        foreach ($data as &$note) {
            if ($note['id'] === $_POST['id']) {
                $note['name'] = $_POST['name'];
                $note['content'] = $_POST['content'];
                break;
            }
        }
    } else {
        $newNote = [
            'id' => uniqid(),
            'name' => $_POST['name'],
            'content' => $_POST['content'],
            'date' => date('d/m/Y')
        ];
        $data[] = $newNote;
    }
    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}

if (isset($_GET['delete'])) {
    $data = array_filter($data, fn($note) => $note['id'] !== $_GET['delete']);
    file_put_contents($file, json_encode(array_values($data), JSON_PRETTY_PRINT));
    header("Location: index.php");
    exit;
}

$editNote = ['id' => '', 'name' => '', 'content' => ''];
if (isset($_GET['edit'])) {
    foreach ($data as $note) {
        if ($note['id'] === $_GET['edit']) {
            $editNote = $note;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticeboard</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 20px; }
        .container { background: white; padding: 20px; max-width: 500px; margin: auto; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0,0,0,0.2); }
        input, textarea { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        button { padding: 10px; border: none; background: #007bff; color: white; font-size: 16px; border-radius: 5px; cursor: pointer; margin-top: 10px; }
        .box { background: #fff; margin-top: 15px; padding: 15px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); text-align: left; }
        .date { display: block; color: #777; font-size: 12px; margin-top: 5px; }
        .delete-btn { background: red; margin-top: 5px; }
        .edit-btn { background: orange; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Noticeboard</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($editNote['id']) ?>">
            <input type="text" name="name" placeholder="Title" value="<?= htmlspecialchars($editNote['name']) ?>" required><br>
            <textarea name="content" placeholder="Content" required><?= htmlspecialchars($editNote['content']) ?></textarea><br>
            <button type="submit"><?= !empty($editNote['id']) ? 'Update' : 'Save' ?></button>
        </form>
        <hr>
        <?php foreach ($data as $note): ?>
            <div class="box">
                <h3><?= htmlspecialchars($note['name']) ?></h3>
                <p><?= nl2br(htmlspecialchars($note['content'])) ?></p>
                <span class="date"><?= $note['date'] ?></span>
                <a href="index.php?edit=<?= $note['id'] ?>"><button class="edit-btn">Edit</button></a>
                <a href="index.php?delete=<?= $note['id'] ?>" onclick="return confirm('Apakah anda yakin akan menghapus data ini?')"><button class="delete-btn">Delete</button></a>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
