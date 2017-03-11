<?php
require_once __DIR__ . '/inc/_bootstrap.inc.php';
?>
<!DOCTYPE html>
<html class="no-js">
<head lang="de">
    <meta charset="UTF-8">
    <title>Modular click dummy</title>
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
<div class="wrapper">
    <?php $header->render(); ?>
    <?php $heroImage->render(); ?>
    <div class="row">
        <section class="site-left-bar large-3 columns">

        </section>
        <main class="site-main medium-8 large-6 columns">
            <div class="box">
                <h2>What is modular click dummy?</h2>
                <p>Building click dummies as a prototype for enormous frameworks like Symfony or Typo3 is often a lot of
                    copy and past of markup. It is not just wasted time to copy your code. The big trouble comes with
                    working in a team or if you must make changes.<br>
                    So it's better to write the markup of a module just one time an include it at the points where it's
                    needed. This little system should help you the build click dummies easier. </p>
            </div>
        </main>
        <section class="site-right-bar medium-4 large-3 columns">

        </section>
    </div>
    <?php $footer->render(); ?>
</div>
</body>
</html>