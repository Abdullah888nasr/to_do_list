<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content="Website for saving your daliy tasks">
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
            <div class="collapse navbar-collapse" id="app-nav">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION['username']; ?><span class="caret"></span></a>
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