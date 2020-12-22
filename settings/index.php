<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Account Settings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="syles.css" rel="stylesheet">
    <style type="text/css">
        body {
            background: #f5f5f5;
        }

        .ui-w-80 {
            width: 80px !important;
            height: auto;
        }

        .btn-default {
            border-color: rgba(24, 28, 33, 0.1);
            background: rgba(0, 0, 0, 0);
            color: #4E5155;
        }

        label.btn {
            margin-bottom: 0;
        }

        .btn-outline-primary {
            border-color: #26B4FF;
            background: transparent;
            color: #26B4FF;
        }

        .btn {
            cursor: pointer;
        }

        .text-light {
            color: #babbbc !important;
        }

        .btn-facebook {
            border-color: rgba(0, 0, 0, 0);
            background: #3B5998;
            color: #fff;
        }

        .btn-instagram {
            border-color: rgba(0, 0, 0, 0);
            background: #000;
            color: #fff;
        }

        .card {
            background-clip: padding-box;
            box-shadow: 0 1px 4px rgba(24, 28, 33, 0.012);
        }

        .row-bordered {
            overflow: hidden;
        }

        .account-settings-fileinput {
            position: absolute;
            visibility: hidden;
            width: 1px;
            height: 1px;
            opacity: 0;
        }

        .account-settings-links .list-group-item.active {
            font-weight: bold !important;
        }

        html:not(.dark-style) .account-settings-links .list-group-item.active {
            background: transparent !important;
        }

        .account-settings-multiselect~.select2-container {
            width: 100% !important;
        }

        .light-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(24, 28, 33, 0.03) !important;
        }

        .light-style .account-settings-links .list-group-item.active {
            color: #4e5155 !important;
        }

        .material-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(24, 28, 33, 0.03) !important;
        }

        .material-style .account-settings-links .list-group-item.active {
            color: #4e5155 !important;
        }

        .dark-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(255, 255, 255, 0.03) !important;
        }

        .dark-style .account-settings-links .list-group-item.active {
            color: #fff !important;
        }

        .light-style .account-settings-links .list-group-item.active {
            color: #4E5155 !important;
        }

        .light-style .account-settings-links .list-group-item {
            padding: 0.85rem 1.5rem;
            border-color: rgba(24, 28, 33, 0.03) !important;
        }

    </style>
<?php 
                require '../assets/classes.php';
                session_start();
                if(!isset($_SESSION['user']))header("location: ../");

                //aquire the usernames
                $user_id = $_SESSION['user']->get_id();



             echo '
                    <!DOCTYPE html>
                        <html>
        
                            <head>
                                    <link rel="stylesheet" href="../profile/main.css">
                                    <meta charset="utf-8">
                                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                                    <title>Chatverse | Account Settings</title>
                                    <link rel="icon" href="../assets/img/icn_logo.png">
        
                                    <!--Navigation Bar-->
                                    <div id="nav">
                                        <a href="../"><img src="../assets/img/icn_logo.png" style="width: 30px;  margin: 5px 20px;"></a>
                                        <input type="text" style="width:20%; position: relative; left:10px; bottom:15px; border-radius:10px;">
                                        <div id="navbuttons">
                                            <button><a href="../'.$user_id.'"><img src="../'.$user_id."/".$_SESSION["user"]->get_profile_pic().'"></a></button>
                                            <button><img src="../assets/img/icn_msg.png"></button>
                                            <button><img src="../assets/img/icn_notification.png"></button>
                                            <button><a href=""><img src="../assets/img/icn_settings.png"></a></button>
                                            <button><a href="../assets/operation/logout.php"><img src="../assets/img/icn_settings.png"></a></button>
                                        </div> 
                                    </div>
                                    <div style="height:40px; background-color: white;"></div>'
?>


</head>
<body style="">


    <div class="container light-style flex-grow-1 container-p-y">

        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action" data-toggle="list" href="#account-change-password">Change password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">

                            <div class="card-body media align-items-center">
                                <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="d-block ui-w-80">
                                <div class="media-body ml-4">
                                    <label class="btn btn-outline-primary">
                                        Upload new photo
                                        <input type="file" class="account-settings-fileinput">
                                    </label> &nbsp;

                                    <div class="text-light small mt-1">Allowed JPG, GIF or PNG. Max size of 800K</div>
                                </div>
                            </div>
                            <hr class="border-light m-0">

                            <div class="card-body">
                                <form id="change" method="POST" action="../assets/operation/change_settings.php">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <input type="text" name="first_name" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" name="last_name" class="form-control" value="">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">E-mail</label>
                                        <input type="text" name="email" class="form-control mb-1" value="">
                                    </div>
                                    <input type="submit" name="update_details" value="Save Changes">
                                </form>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="account-change-password">
                            <div class="card-body pb-2">

                                <div class="form-group">
                                    <label class="form-label">Current password</label>
                                    <input type="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">New password</label>
                                    <input type="password" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Repeat new password</label>
                                    <input type="password" class="form-control">
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">

    </script>

</body>
</html>
