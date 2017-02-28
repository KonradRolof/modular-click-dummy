<?php
require_once 'bootstrap.inc.php';
?>
<!DOCTYPE html>
<html class="no-js">
<head lang="de">
    <meta charset="UTF-8">
    <title>TITLE</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link rel="stylesheet" href="./css/app.css"/>
</head>
<body>
<div class="wrapper">
    <header class="site-header">
        <a href="/" class="logo medium-3 columns">
            Branding
        </a>
    </header>
    <main class="site-main">
        <section class="row" data-equalizer>
            <div class="columns">
                <h2>Beispiel Foundation Equalizer</h2>
            </div>
            <div class="medium-6 columns">
                <div class="test-equalizer" data-equalizer-watch>
                    <p>Das ist Container 1.</p>
                </div>
            </div>
            <div class="medium-6 columns">
                <div class="test-equalizer" data-equalizer-watch>
                    <p>Und das ist:</p>
                    <p>Container 2</p>
                </div>
            </div>
        </section>
    </main>
    <footer class="site-footer">

    </footer>
</div>
<script src="./js/app.js"></script>
</body>
</html>