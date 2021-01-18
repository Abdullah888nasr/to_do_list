
<?php 
    session_start();
    // if the username session is exist then the user is alreadly login.
    if(isset($_SESSION['username'])):
        header('Location: index.php');
    endif;
    require_once 'includes/init.php';
    if(isset($_GET['action']) && $_GET['action'] == 'logout'):
        session_destroy();
    elseif(isset($_POST['login'])):
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $errors = array();
        if(empty($username)):
            $errors[]="Username is empty";
        endif;
        if(empty($password)):
            $errors[]="Password is empty";
        endif;
        if(empty($errors)):
            $query = $con->prepare("SELECT userId, Password FROM users WHERE Username=?");
            $query->execute(array($username));
            $row = $query->fetch();
            if($query->rowCount() > 0 && password_verify($password, $row['Password'])):
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $row['userId'];
                header("Location: index.php");
            else:
                $errors[] = "Username or password is not exist";
            endif;
        endif;
    elseif(isset($_POST['signup'])):
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = $_POST['password'];
        $conPassword = $_POST['ConPassword'];
        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
        $errors = array();
        if(empty($username)):
            $errors[]="Username is empty";
        endif;
        if(empty($password)):
            $errors[]="Password is empty";
        endif;
        if(empty($conPassword)):
            $errors[]="Confirm password is empty";
        endif;
        if(empty($email)):
            $errors[]="Email is empty";
        endif;
        if($password !== $conPassword):
            $errors[]="The passwords is not identical";
        endif;
        if(empty($errors)):
            $password = password_hash($password, PASSWORD_DEFAULT);
            $query = $con->prepare("SELECT userId FROM users WHERE Username=? OR Email=?");
            $query->execute(array($username, $email));
            if($query->rowCount() == 0):
                $query = $con->prepare("INSERT users SET Username = ?, Password = ?, Email = ?");
                $query->execute(array($username, $password, $email));
                $_SESSION['username'] = $username;
                $_SESSION['userId'] = $row['userId'];
                header("Location: index.php");
            else:
                $errors[]="The username or email is already exist";
            endif;
        endif;
    endif;
?>
    <div class="container">
        <div class="logForm text-center">
            <a href="#" data-class="login" class="btn btn-info log active">Login</a>
            <a href="#" data-class="signup" class="btn btn-info log">Sign up</a>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" class="loginForm">
                <input type="text" placeholder="Username" name="username" class="form-control" autocomplete="off">
                <div class="password">
                    <input type="password" placeholder="Password" name="password" class="form-control" autocomplete="new-password">
                    <i class="fa fa-eye"></i>
                </div>
                <input type="submit" name="login" value="Login" class="btn btn-info btn-lg btn-block">
            </form>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" class="signForm">
                <input type="text" placeholder="Username" name="username" class="form-control" autocomplete="off" >
                <div class="password">
                    <input type="password" placeholder="Password" name="password" class="form-control" autocomplete="new-password" >
                    <i class="fa fa-eye"></i>
                </div>
                <div class="password">
                    <input type="password" placeholder="Confirm Password" name="ConPassword" class="form-control" autocomplete="new-password" >
                    <i class="fa fa-eye"></i>
                </div>
                <input type="email" placeholder="Email" name="email" autocomplete="off" class="form-control">
                <input type="submit" name="signup" value="Sign up" class="btn btn-info btn-lg btn-block">
            </form>
        </div>
        <?php 
            if(!empty($errors)):
                echo '<div class="errors">';
                foreach($errors as $error):
                    errorMessage($error);
                endforeach;
                echo '</div>';
            endif;
        ?>
    </div>
<?php require_once $tpls.'footer.php';?>