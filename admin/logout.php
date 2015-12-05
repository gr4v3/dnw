<?php
    setcookie('dnw-auth', 'false',time()-7200);
    header('location: /admin');