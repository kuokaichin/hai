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
            <header class="jumbotron subhead" id="overview">
                <div class="container">
                    <h1>Harvard Activities Index</h1>
                    <p class="lead">Find and rate student activities!</p>
                </div>
            </header>

            <div id="middle">

            <ul class="nav nav-pills">
                <li><a href="index.php">Home</a></li>
				<li><a href="help.php">Help</a></li>
            </ul>
