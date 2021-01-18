
<?php 
    /*
        accessDirectly function: constant alert appears in different cases when the user try to access to undirected pages.
    */
  function accessDirectly(){
    echo '<div class="errors"><div class="alert alert-danger msg-success"><i class="fa fa-close"></i>You cannot access this page directly</div></div>';
    $_SESSION['action']='';
    header("refresh:3;url=login.php");
  }

  /*
      doneMessage function: done alert appears when the user done specific action with specific message.
  */
  function doneMessage($msg){
    echo "<div class='alert alert-success msg-success'><i class='fa fa-check'></i>$msg</div>";
  }

  /*
      errorMessage function: error alert appears when the user fault in specific field or don't fill.
  */
  function errorMessage($msg){
    echo "<div class='alert alert-danger msg-success'><i class='fa fa-close'></i>$msg</div>";
  }