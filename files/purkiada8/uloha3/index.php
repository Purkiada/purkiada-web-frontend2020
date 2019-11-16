<?php

include(__DIR__ . '/include/openTerminal.php');

$inputPrefix = $terminal->getInputPrefix();
$content = $terminal->getContentBackup();

include(__DIR__ . '/include/closeTerminal.php');

?>

<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Purkiada - Control Panel</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css" />
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/styles.css">

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.1.1.min.js"><\/script>')</script>
    <script src="js/vendor/bootstrap.min.js"></script>
    <script src="js/vendor/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/plugins.js"></script>
    <script src="js/console.js"></script>
    <script src="js/main.js"></script>
</head>
<body id="body" onclick="focusConsole()">
<div id="control-panel">
    <div id="background-wrapper">
        <img id="top-image" src="img/consoleTop.png">
        <div id="content-background-wrapper">
            <img id="left-image" src="img/consoleLeft.png">
            <img id="right-image" src="img/consoleRight.png">
        </div>
        <img id="bottom-image" src="img/consoleBottom.png">
    </div>
    <div id="console-wrapper" class="mCustomScrollbar">
        <div id="terminal-result"><?= $content ?></div>

        <div id="input-wrapper">
            <span id="input-prefix"><?= $inputPrefix ?></span>
            <input type="text" id="input" name="input" autofocus>
        </div>
        <p id="processing-request-line"><span id="processing-request">Zpracovávám... (Prosím o strpení, školní servery občas pracují <i>"pomalu"</i>.)</span>&nbsp;</p>
    </div>
</div>
</body>
</html>
