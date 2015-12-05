<?php
    $user = filter_input(INPUT_POST, 'username');
    $pass = filter_input(INPUT_POST, 'password');
    if ($user === 'dnw' && $pass === 'dnw#2015:admin') {
        setcookie('dnw-auth', 'true');
        header('location: /admin');
    } else {
        setcookie('dnw-auth', 'false',time()-7200);
    }
?>
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
    </head>
    <body class="login">
        <form method="post">
            <h1>DNW - backoffice</h1>
            <div>
                <label for="user">user:</label>
                <input typ="text" id="user" name="username" />
            </div>
            <div>
                <label for="pass">pass:</label>
                <input typ="password" id="pass" name="password" />
            </div>
            <div>
                <input type="submit" value="entrar" />
            </div>    
        </form>
    </body>
</html>