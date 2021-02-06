<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Website for saving your daliy tasks">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="format-detection" content="telephone=no">
        <title>To Do List</title>
        <?php 
        // to include all css files in css folder by using glob.
            foreach(glob($css.'*.css') as $cssFile):
                echo '<link href="'.$cssFile.'" rel="stylesheet">';
            endforeach;
        ?>
    </head>
    <body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
            <a class="navbar-brand img-brand" href="index.php">
                <img alt="Brand" src="layout/images/brand.png">
                To-Do-List
            </a>       
            </div>
            
            <!--in login page it shouldn't appear username and drop menu part-->
            <?php if(pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME)!=='login'):?>
            <div class="navbar-collapse" id="app-nav">
                <ul class="nav navbar-right">
                    <li class="">
                        <a href="#" class="" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false"><?php echo $_SESSION['username']; ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                        <li><a href="index.php?action=reset" class="confirm">Delete All Tasks</a></li>
                        <li><a href="login.php?action=logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
            <?php endif;?>
        </div>
    </nav>