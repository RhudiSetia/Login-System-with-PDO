<?php
session_start();
require_once('config.php');

if(isset($_POST['submit']))
{
     if(isset($_POST['username']) || !empty($_POST['username']) && isset($_POST['email']) || !empty($_POST['email']) &&  isset($_POST['password']) || !empty($_POST['password']) ){
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);      
        $password = trim($_POST['password']);
        
        $options = array("cost"=>4);
        $hashPassword = password_hash($password,PASSWORD_BCRYPT,$options);
       

        if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
            $sql = 'select * from users where email = :email';
            $stmt = $pdo->prepare($sql);
            $p = ['email'=>$email];
            $stmt->execute($p);
            
            if($stmt->rowCount() == 0)
            {
                $sql = "insert into users (username, email, `password`) values(:uname, :email, :pass)";
            
                try{
                    $handle = $pdo->prepare($sql);
                    $params = [
                        ':uname'=>$username,
                        ':email'=>$email,
                        ':pass'=>$hashPassword
                    ];
                    
                    $handle->execute($params);
                    
                    $success = 'User has been created successfully';
                    
                }
                catch(PDOException $e){
                    $errors[] = $e->getMessage();
                }
            }
            else
            {
                $valUsername = $username;
                $valEmail = $email;
                $valPassword = $password;

                $errors[] = 'E-mail address already registered';
            }
        }
        else
        {
            $errors[] = "E-mail is not valid";
        }
    }
    else
    {
        if(!isset($_POST['username']) || empty($_POST['username']))
        {
            $errors[] = 'Username  is required';
        }
        else
        {
            $valUsername = $_POST['Username'];
        }
        if(!isset($_POST['email']) || empty($_POST['email']))
        {
            $errors[] = 'E-mail  is required';
        }
        else
        {
            $vlEmail = $_POST['email'];
        }

        if(!isset($_POST['password']) || empty($_POST['password']))
        {
            $errors[] = 'Password is required';
        }
        else
        {
            $valPassword = $_POST['password'];
        }
        
    }

}
?>


<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

</head>
<body class="bg-dark">

<div class="container h-100">
	<div class="row h-100 mt-5 justify-content-center align-items-center">
		<div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
			<h1 class="mx-auto w-25" >Register</h1>
			<?php 
				if(isset($errors) && count($errors) > 0)
				{
					foreach($errors as $error_msg)
					{
						echo '<div class="alert alert-danger">'.$error_msg.'</div>';
					}
                }
                
                if(isset($success))
                {
                    
                    echo '<div class="alert alert-success">'.$success.'</div>';
                }
			?>
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="form-group">
					<label for="email">User Name:</label>
					<input type="text" name="username" placeholder="Enter User Name" class="form-control" value="<?php echo ($valUsername??'')?>">
				</div>
				<div class="form-group">
    				<label for="email">E-mail:</label>
					<input type="text" name="email" placeholder="Enter your e-mail" class="form-control" value="<?php echo ($valEmail??'')?>">
				</div>
				<div class="form-group">
    				<label for="password">Password:</label>
					<input type="password" name="password" placeholder="Enter Password" class="form-control" value="<?php echo ($valPassword??'')?>">
				</div>

				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
				<p class="pt-2"> Back to <a href="login.php">Login</a></p>
				
			</form>
		</div>
	</div>
</div>
</body>
</html>