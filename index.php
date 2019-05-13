<?php 
    include __DIR__ . '/helper/Auth.php';    
    $isLogged = Auth::isLogged();
?>
<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8">

    <title>Guest Book</title>
    <meta name="description" content="The HTML5 Herald">
    <meta name="author" content="SitePoint">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/styles.css">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 left-panel">
                <div class="logo-wrapper">
                    <img src="https://www.haegroup.com/img/hae-logo.svg" alt="logo" />
                </div>
                <hr class="liner"/>                
                <div class="header-title grey">
                    Guestbook
                </div>
                <div class="content grey">
                    Feel free to leave us a short message to tell us what you think to our services
                </div>
                <div class="post-control">
                    <button id="btnPostMessage" class="btn btn-primary">Post a Message</button>
                </div>                
                <div class="post-message-wrapper">
                    <div class="form-group">
                        <label for="guest_name">Name:</label>
                        <input id="txtGuestName" class="form-control" type="text" name="guest_name" placeholder="Name"/>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="txtMessage" class="form-control" name="message"></textarea>
                    </div>
                    <div class="post-control">
                        <button id="btnSubmitMessage" class="btn btn-primary">Post</button>
                        <button id="btnCancel"        class="btn btn-default">Cancel</button>
                    </div>
                </div>
                <?php if (!$isLogged) { ?>
                <div class="bottom-control">
                    <a href="#" data-toggle="modal" data-target="#login_modal">Admin login</a>
                </div>
                <?php } else { ?>
                <div class="bottom-control">
                    <a href="#" id="btnLogout">Admin logout</a>
                </div>
                <?php } ?>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-9 right-panel">
                <div class="row" id="content-wrapper">
                    
                </div>
                <div id="footer" current-page="1">                    
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="login_modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row form-wrapper">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="guest_name">Username:</label>
                                <input id="txtUsername" required class="form-control" type="text" name="username" placeholder="Username"/>
                            </div>                        
                        
                            <div class="form-group">
                                <label for="password">Password:</label>
                                <input id="txtPassword" required class="form-control" type="password" name="password" placeholder="Password"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">                    
                    <button type="button" class="btn btn-primary" id="btnLogin">Login</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        var isLogged = <?php echo ($isLogged ? 'true' : 'false') ?>
    </script>
    <script type="text/javascript" src="/assets/main.js"></script>
</body>

</html>