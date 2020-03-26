<?php

// display all errors
ini_set('display_errors', 1);
error_reporting (E_ALL); 

require_once 'config.php';
require_once 'functions.php';
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Test task for Ganymeda</title>

    <!-- Bootstrap -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap-theme.min.css" integrity="sha384-6pzBo3FDv/PJ8r2KRkGHifhEocL+1X2rVCTTkUfGk7/0pbek5mMa1upzvWbrUbOZ" crossorigin="anonymous">
	
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>

	<!-- Custom stylesheet -->
	<link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
    <nav class='navbar navbar-default'>
      <div class='container-fluid'>
        <div class='navbar-header'>
          <a class='navbar-brand' href='/'>
            Test task
          </a>
        </div>
        <div class='collapse navbar-collapse' id='bs-example-navbar-collapse-1'>
          <ul class="nav navbar-nav">
          	<li><a href='/index.php'>Home</a></li>
            <li><a href='/index.php?p=add_user'>Add User</a></li>
            <li><a href='/index.php?p=add_user_role'>Add User Role</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <?php if (isset($_GET['p']) && $_GET['p'] == 'add_user_role') : 

        // create new user role if we have form data
        if(isset($_POST['rolename'])) {
          echo user_role_create();
    	}
    ?>
        <h1>Add new user role</h1>
        <form method='post' action='' enctype=\"multipart/form-data\">
          <div class='form-group row'>
            <label for='rolename' class='col-sm-4'>User Role:</label>
            <input type='text' id='rolename' name='rolename' maxlength=20 class='col-sm-4' placeholder='enter user role'/>
          </div>
          <input type='submit' value='Create User Role' class='btn btn-primary'>
        </form>
        
    <?php elseif (isset($_GET['p']) && $_GET['p'] == 'add_user') : 

        // create new user if we have form data
        if(isset($_POST['username'])) {
            echo user_create();
        }
    ?>
        <h1>Add new user</h1>
        <form method='post' action='' enctype=\"multipart/form-data\">
          <div class='form-group row'>
            <label for='username' class='col-sm-4'>Username:</label>
            <input type='text' id='username' name='username' maxlength=20 class='col-sm-4' placeholder='enter username'/>
          </div>
 	
          <div class='form-group row'>
            <label for='role_id' class='col-sm-4'>User role:</label>
            <select name="role_id">
              <?php
                $stmt = $dbPDO->query("SELECT * FROM `user_role`");
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($rows as $row) {
                  echo "<option value='" . $row['id'] . "'>" . $row['rolename'] . "</option>";
                }
              ?>
            </select>
          </div>
          <input type='submit' value='Create User' class='btn btn-primary'>
        </form>

    <?php else : ?>
        <h1>Users</h1>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Username</th>
              <th scope="col">Role</th>
            </tr>
          </thead>
          <?php
            $stmt = $dbPDO->query("SELECT * FROM `user` LEFT JOIN `user_role` ON user.role_id = user_role.id");
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($rows as $row) {
              echo "<tr><td>". $row['username'] . "</td><td>" . $row['rolename'] . "</td></tr>";
            }
          ?>
        </table>
    <?php endif; ?>
  </body>
</html>