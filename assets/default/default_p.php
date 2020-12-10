<?php 
                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");
        
        
                echo '
                                <!DOCTYPE html>
                                <html>
        
                                <head>
                                    <link rel="stylesheet" href="../main.css">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Silvaro | '.$_SESSION["user"]->get_name().'</title>
                                    <link rel="icon" href="../assets/img/icn_logo.png">
        
                                    <!--Navigation Bar-->
                                    <div id="nav">
                                        <a href="../"><img src="../assets/img/icn_logo.png" style="width: 50px; height: 95%; margin: 0 15px;"></a>
                                        <input type="text" style="width:20%; position: relative; left:5px; bottom:15px;">
                                        <div id="navbuttons">
                  
                                            <button><a href=""><img src="../assets/default/default_pp.jpg"></a></button>
                                            <button><img src="../assets/img/icn_msg.png"></button>
                                            <button><img src="../assets/img/icn_notification.png"></button>
                                            <button><a href="../assets/operation/logout.php"><img src="../assets/img/icn_settings.png"></a></button>
                                        </div> 
                                    </div>
                                    <div style="height:45px; background-color: white;"></div>
        
                                </head>
        
                                <body>'
?>



    <div id="NCP">  
            <div id="cover">
                <button id="coverBtn"><img src="../assets/img/icn_upload.png"></button>
                <img src=<?php echo $_SESSION['user']->get_cover_pic(); ?>>
            </div>
            <div id="PNB">
                <div style="display: inline-block; margin: 0 5%;">
                    <img id="pp" src=<?php echo $_SESSION['user']->get_profile_pic(); ?>>
                    <button id="ppBtn"><img src="../assets/img/icn_upload.png"></button>
                    <p><?php echo $_SESSION['user']->get_name(); ?></p>
                </div>
            </div>
    </div>




    <div id="uploadPPBox" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
            <form action="../assets/operation/upload.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="pp">
                <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
            </form>
        </div>
    </div>

    <div id="uploadCoverBox" class="modal">
        <div class="modal-content">
        <span class="close">&times;</span>
            <form action="../assets/operation/upload.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="type" value="cover">
                <input style="background-color: gray; width:70%;" type="file" name="fileToUpload" id="fileToUpload"></br></br>
                <input style="background-color: silver; width:25%;" type="submit" name="submit" value="Upload" >
            </form>
        </div>
    </div>



    <div style="width:60%; margin: 50px 20%; height: 150px; border: 4px royalblue solid;"></div>
    <div style="width:60%; margin: 50px 20%; height: 150px; border: 4px red solid;"></div>
    <div style="width:60%; margin: 50px 20%; height: 150px; border: 4px green solid;"></div>
    <div style="width:60%; margin: 50px 20%; height: 150px; border: 4px yellow solid;"></div>
    <div style="width:60%; margin: 50px 20%; height: 150px; border: 4px silver solid;"></div>
    <div style="width:60%; margin: 50px 20%; height: 150px; border: 4px blue solid;"></div>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
            var ppBox = document.getElementById("uploadPPBox");
            var ppBtn = document.getElementById("ppBtn");
            var closePP = document.getElementsByClassName("close")[0];
            ppBtn.onclick = function() {
            ppBox.style.display = "block";
            }
            closePP.onclick = function() {
            ppBox.style.display = "none";
            }

            var coverBox = document.getElementById("uploadCoverBox");
            var coverBtn = document.getElementById("coverBtn");
            var closeCover = document.getElementsByClassName("close")[1];
            coverBtn.onclick = function() {
            coverBox.style.display = "block";
            }
            closeCover.onclick = function() {
            coverBox.style.display = "none";
            }
    </script>


</body>  
</html>


















<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px royalblue solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px red solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px green solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px yellow solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px silver solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px blue solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px orange solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px purple solid;"></div>
<div style="width:70%; margin: 50px 15%; height: 150px; border: 4px orchid solid;"></div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var close = document.getElementsById("close");
btn.onclick = function() {
modal.style.display = "block";
}
close.onclick = function() {
modal.style.display = "none";
}
</script>


</body>  
</html>