<!DOCTYPE html>

<html>

    <head>

        <link href="css/bootstrap.css" rel="stylesheet"/>
        <link href="css/bootstrap-responsive.css" rel="stylesheet"/>
        <link href="css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>Harvard Activities Index: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Harvard Activities Index (HAI)</title>
        <?php endif ?>

        <script src="js/jquery-1.8.2.js"></script>
        <script src="js/bootstrap.js"></script>
        <script src="js/scripts.js"></script>

    </head>

    <body>

        <div class="container-fluid">

            <div id="top">
                <a href="index.php"><img alt="Harvard Activities Index" src="img/nyancat.gif"/></a>
            </div>

            <div id="middle">

            <ul class="nav nav-pills">
                <li><a href="index.php">Home</a></li>
                <li><a href="admin.php">Admin</a></li>
            </ul>
