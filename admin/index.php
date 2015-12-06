<?php include_once 'utilities.php'; ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>DUL - administração</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/admin.css" rel="stylesheet" type="text/css"/>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha256-k2/8zcNbxVIh5mnQ52A0r3a6jAgMGxFJFE2707UxGCk= sha512-ZV9KawG2Legkwp3nAlxLIVFudTauWuBpC10uEafMHYL0Sarrz5A7G79kXh5+5+woxQ5HM559XX2UZjMJ36Wplg==" crossorigin="anonymous">
        <link href="css/stylesheet.css" rel="stylesheet" type="text/css"/>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    </head>
    <body>
        <nav>
            <a id="history" href="#history" data-type="ajax" data-target="article" data-href="pages/history.php">historial</a>
            <a id="agenda" href="#agenda" data-type="ajax" data-target="article" data-href="pages/agenda.php">agenda</a>
            <a id="media" href="#media" data-type="ajax" data-target="article" data-href="pages/media.php">media</a>
            <a id="reviews" href="#reviews" data-type="ajax" data-target="article" data-href="pages/reviews.php">testemunhos</a>
            <a id="contacts" href="#contacts" data-type="ajax" data-target="article" data-href="pages/contacts.php">contactos</a>
            <a id="settings" href="#settings" data-type="ajax" data-target="article" data-href="pages/settings.php">settings</a>
            <a id="logout" href="logout.php">logout</a>
        </nav>
        <article></article>
    </body>
    <script src="../js/jquery.min.js" type="text/javascript"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <script src="../js/scripts.js" type="text/javascript"></script>
    <script src="xing/parser_rules/advanced.js" type="text/javascript"></script>
    <script src="xing/dist/wysihtml5-0.3.0.min.js" type="text/javascript"></script>
    <script src="js/admin.js" type="text/javascript"></script>
</html>
