<?php
require_once "vendor/autoload.php";
        $google_client = new Google_Client();
        $google_client->setClientId ('275386874596-ofqrkagk4vc4aqe0dna8l6ga0te5ba6f.apps.googleusercontent.com');
        $google_client->setClientSecret ('CWkNNKtil6gOxC-knanM5Oce');
        $google_client->setRedirectUri  ('http://localhost/social-media-platform-web/hello/index.php');
        $google_client->addScope('email');
        $google_client->addScope('profile');

        $google_client2 = new Google_Client();
        $google_client2->setClientId ('275386874596-ofqrkagk4vc4aqe0dna8l6ga0te5ba6f.apps.googleusercontent.com');
        $google_client2->setClientSecret ('CWkNNKtil6gOxC-knanM5Oce');
        $google_client2->setRedirectUri  ('http://localhost/social-media-platform-web/index.php');
        $google_client2->addScope('email');
        $google_client2->addScope('profile');
?>