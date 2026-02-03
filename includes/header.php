<?php
$navLinks = [
    'Home' => '#home',
    'Selections' => '#selections',
    'Services' => '#services',
    'Contact' => '#contact'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elm Grove Liquor</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="top-bar" id="home">
        <div class="container">
            <div class="brand">Elm Grove Liquor</div>
            <nav class="nav-links">
                <?php foreach ($navLinks as $label => $link): ?>
                    <a href="<?php echo $link; ?>"><?php echo $label; ?></a>
                <?php endforeach; ?>
            </nav>
            <a class="btn btn-outline" href="/admin/index.php">Admin Portal</a>
        </div>
    </header>
