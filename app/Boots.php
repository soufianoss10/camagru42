<?php 
    //load config
    require_once 'configs/config.php';

    //load helpers
    require_once 'helpers/url_help.php';
    require_once 'helpers/session.php';

    //load libs
    require_once 'libraries/src.php';
    require_once 'libraries/Controller.php';
    require_once 'libraries/Database.php';
    // autoload libs
    spl_autoload_register(function($className){
        require_once 'libraries/' . $className . '.php';
        
    });
    // echo 'heey its bootstrap page';
    /*
    require_once 'libraries/src.php';
    require_once 'libraries/Controller.php';
    require_once 'libraries/Datab.php';
*/
    ?>