<?php
session_start();

$languagesFile = 'lang.json';
if (file_exists($languagesFile)) {
    $languages = json_decode(file_get_contents($languagesFile), true);
} else {
    die('Error: File lang.json tidak ditemukan.');
}

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'en'; 
}

if (isset($_POST['language'])) {
    $_SESSION['lang'] = $_POST['language'];
}

$currentLang = $_SESSION['lang'];

if (isset($languages[$currentLang])) {
    $home = $languages[$currentLang]['home'];
    $about_us = $languages[$currentLang]['about_us'];
    $contact = $languages[$currentLang]['contact'];
    $register = $languages[$currentLang]['register'];
    $login = $languages[$currentLang]['login'];
    $copyright = $languages[$currentLang]['copyright'];
    $paragraph_1 = $languages[$currentLang]['paragraph_1'];
    $paragraph_2 = $languages[$currentLang]['paragraph_2'];
} else {
    $home = $languages['en']['home'];
    $about_us = $languages['en']['about_us'];
    $contact = $languages['en']['contact'];
    $register = $languages['en']['register'];
    $login = $languages['en']['login'];
    $copyright = $languages['en']['copyright'];
    $paragraph_1 = $languages['en']['paragraph_1'];
    $paragraph_2 = $languages['en']['paragraph_2'];
}
?>

<!DOCTYPE html>
<html lang="<?php echo $currentLang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $home; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: linear-gradient(135deg, #0066cc, #003366); 
            color: #fff; 
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
        }
        header, nav, footer {
            background-color: rgba(0, 51, 102, 0.9); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }
        header h1 {
            font-size: 2.5em;
            margin: 0;
        }
        nav {
            margin: 20px 0;
        }
        nav ul {
            list-style-type: none;
            padding: 0;
            display: flex; 
            justify-content: center; 
            align-items: center; 
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: #fff; 
            text-decoration: none;
            font-weight: 600;
            padding: 10px 20px; 
            transition: background-color 0.3s, color 0.3s;
            border-radius: 5px;
        }
        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #ffcc00;
        }
        .language-selector {
            margin-left: 30px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
        }
        .content {
            padding: 40px;
            background-color: rgba(0, 51, 102, 0.8);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 20px;
        }
        .content h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }
        .content p {
            line-height: 1.8;
            font-weight: 300;
        }
        select {
            background-color: #fff;
            color: #000;
            border: none;
            padding: 5px;
            border-radius: 5px;
            font-family: 'Poppins', sans-serif;
        }
        footer {
            padding: 15px 0;
        }
        footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1><?php echo $home; ?></h1>
        </div>
    </header>

    <nav>
        <div class="container">
            <ul>
                <li><a href="#"><?php echo $home; ?></a></li>
                <li><a href="#"><?php echo $about_us; ?></a></li>
                <li><a href="#"><?php echo $contact; ?></a></li>
                <li><a href="#"><?php echo $register; ?></a></li>
                <li><a href="#"><?php echo $login; ?></a></li>
                <li>
                    <form method="post" class="language-selector">
                        <select name="language" onchange="this.form.submit()">
                            <option value="id" <?php if ($currentLang == 'id') echo 'selected'; ?>>Bahasa Indonesia</option>
                            <option value="en" <?php if ($currentLang == 'en') echo 'selected'; ?>>English</option>
                            <option value="nl" <?php if ($currentLang == 'nl') echo 'selected'; ?>>Nederlands</option>
                        </select>
                    </form>
                </li>
            </ul>
        </div>
    </nav>

    <div class="content">
        <div class="container">
            <h2><?php echo $about_us; ?></h2>
            <p><?php echo $paragraph_1; ?></p>
            <p><?php echo $paragraph_2; ?></p>
        </div>
    </div>

    <footer>
        <div class="container">
            <p><?php echo $copyright; ?> &copy; 2024</p>
        </div>
    </footer>
</body>
</html>
