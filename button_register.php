<?php 

    require 'connect.php';
    require 'classes.php';
    session_start();

      //Dynamic Validation AJAX
      if(isset($_SESSION['validator']))
      {
        $v =  count($_SESSION['validator']->get_errors());
        if ($v == 1) {
            echo "false";
         }
        else
            echo "true";
      }
      else echo "true";
?>
