<?php 
    session_start();
    // we add username session after login or sign up 
    // in this if statement checks if the username session is existed because if it's not exist that mean the user access this page directly without login or sign up.
    if(!isset($_SESSION['username'])):
      header('Location: login.php');
    endif;
    require_once 'includes/init.php';
    // we declare action variable and get the value of it by get method because we will use it to arrive to some cases like delete task , edit task, and reset tasks.
    $action = '';
    if(isset($_GET['action'])):
      $action=$_GET['action'];
      // $_SESSION['action'] we use it to control the alert in the bottom where it appears when happening any error or finishing any action.
      $_SESSION['action'] = $_GET['action'];
    else:
      // when the url doesn't have action variable make action value equal home to access the index page. 
      $action='home';
    endif;
    $errors = array();
    switch($action):
      case 'add':
        // add task
        if($_SERVER['REQUEST_METHOD'] === 'POST'):
          $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
          $detail = filter_var($_POST['detail'], FILTER_SANITIZE_STRING);
          if(empty($title)):
            $errors[]="Title is empty";
          endif;
          if(empty($detail)):
            $errors[]="Detail is empty";
          endif;
          if(empty($errors)):
            $query = $con->prepare("INSERT tasks SET title = ?, details = ?, userId = ?");
            $query->execute(array($title, $detail, $_SESSION['userId']));
          else:
            // $_SESSION['errors'] used to print the errors in the bottom alert after reload the page .
            $_SESSION['errors'] = $errors;
          endif;
          header("Location: index.php");
        endif;
      break;
      case 'reset':
        $query = $con->prepare("DELETE FROM tasks");
        $query->execute();
        header("Location: index.php");
      break;
      case 'delete':
        //to prevent to access to the delete case if the task id is not exist.
        // we use task id to select the right task task to delete it.
        if(isset($_GET['taskId'])):
          $query = $con->prepare("SELECT taskId FROM tasks WHERE taskId = :ztaskId");
          $query->execute(array(':ztaskId' => $_GET['taskId']));
          if($query->rowCount() > 0):
            $query = $con->prepare("DELETE FROM tasks WHERE taskId=:ztaskId");
            $query->bindParam(':ztaskId', $_GET['taskId']);
            $query->execute();
            header("Location: index.php");
          else:
            errorMessage("This task id is not exist");
          endif;
        else: 
          accessDirectly();
        endif;
      break;
      case 'edit':
        if(isset($_GET['taskId'])):
          $taskId = $_GET['taskId'];
          $query = $con->prepare("SELECT * FROM tasks WHERE taskId = ?");
          $query->execute(array($taskId));
          echo '<div class="container">';
          if($query->rowCount() > 0):
            $task = $query->fetch();
        ?>
            <h1 class="text-center">Edit Task</h1>
            <form method="POST" action="index.php?action=update&taskId=<?php echo $taskId;?>">
              <input type="text" value="<?php echo $task['title']; ?>" placeholder="Title" name="title" class="form-control" required>
              <textarea placeholder="Details" name="detail" class="form-control" required><?php echo $task['details']; ?></textarea>
              <input type="submit" value="Edit Task" class="btn btn-primary btn-block">
            </form>
          <?php 
          else: 
            errorMessage("This task id is not exist");
          endif;
        else: accessDirectly();
        ?>
          </div>
       <?php endif;
      break;
      case 'update':
        if(isset($_GET['taskId'])):
          $taskId = $_GET['taskId'];
          if($_SERVER['REQUEST_METHOD'] === 'POST'):
            $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
            $detail = filter_var($_POST['detail'], FILTER_SANITIZE_STRING);
            if(empty($title)):
              $errors[]="Title is empty";
            endif;
            if(empty($detail)):
              $errors[]="Detail is empty";
            endif;
            if(empty($errors)):
              $query = $con->prepare("UPDATE tasks SET title = ?, details = ? WHERE taskId = ?");
              $query->execute(array($title, $detail, $taskId));
              header('Location: index.php');
            endif;
          endif;
        else:
          accessDirectly();
        endif;
      break;
      case 'home':
        // to print the user's tasks
        $query = $con->prepare("SELECT * FROM tasks WHERE userId = ?");
        $query->execute(array($_SESSION['userId']));
        $tasks = $query->fetchAll();
?>
    <div class="container">
      <h1 class="text-center">To-Do-List</h1>
      <div class="row">
        <div class="col-sm-6 ">
          <form method="POST" action="index.php?action=add">
            <input type="text" placeholder="Title" name="title" class="form-control" >
            <textarea placeholder="Details" name="detail" class="form-control" ></textarea>
            <input type="submit" value="Add Task" class="btn btn-primary btn-block">
          </form>
        </div>
        <div class="col-sm-6">
          <ol class="do-list">
            <?php
              if(!empty($tasks)):
                foreach($tasks as $task):
                echo '<li>
                <a href="index.php?action=delete&taskId='.$task['taskId'].'" class="close confirm"><i class="fa fa-close"></i></a><a href="index.php?action=edit&taskId='.$task['taskId'].'" class="close"><i class="fa fa-edit"></i></a>
                      <h4>' .$task['title']. '</h4>';
                echo '<p class="detail">' .$task['details'].'</p> 
                  </li><hr>';
                endforeach;
              endif;
            ?>
          </ol>
          <?php 
            if(empty($tasks)):
              echo '<div class="alert alert-info">The list of tasks is empty</div>';
            endif;
          ?>
        </div>
      </div>
      <?php 
      // to appear the alert of errors or finished actions after reload
        if(isset($_SESSION['action'])):
          echo '<div class="errors">';
          // print the errors if the user don't write in the fields of add case.
          if(!empty($_SESSION['errors'])):
            $errors = $_SESSION['errors'];
            foreach($errors as $error):
              errorMessage($error);
            endforeach;
            echo'</div>';
            // clear the $_SESSION['errors'] until don't print the errors again after reload the page.
            $_SESSION['errors'] = array();
          endif;
          switch($_SESSION['action']):
            case 'add':
              if(empty($errors)):
                doneMessage('You add new task');
              endif;
            break;
            case 'delete':
              doneMessage('You deleted one task');
            break;
            case 'reset':
              doneMessage('You are clear your tasks list');
            break;
            case 'update':
              if(empty($errors)):
                doneMessage('One task is edit.');
              endif;
            break;
          endswitch;
          // clear the $_SESSION['action'] until don't print the done message again after reload the page.
          $_SESSION['action'] = '';  
        endif;
      break;
      default:
        accessDirectly();
      break;
    endswitch;
      ?>
    </div>
<?php require_once $tpls.'footer.php'; ?>