<?php
// Include config file
require_once "dbconfig.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    $username_err = "This username is already taken!";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters!";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password!";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // echo "Registration Successfull!";
                // Redirect to login page
                header("location: index.php");
            } else{
                echo "Something went wrong! Please try again later..";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    // Close connection
    $mysqli->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">

	<head>
	<meta name="Radu Goada" content="author">
     <link rel="Shortcut Icon" href="resources/images/favicon_liveboard.ico">
	 <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	 <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	 <link href="resources/css/register.css" rel="stylesheet" media="screen">
	<head>

<body>

 <section style="height: 80vh;">
   
    <div class="wrapper">
        <b style="font-size: 65px; text-align: center; margin-top: 6%; display: block;">LiveBoard&trade;</b>
    </div>
    <section>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    
        <div class="admin_register">
            
        <!-- Username Group -->
         <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
         
            <div class="registerClass">Register</div>   <!-- Register Window Title -->   
           	 <hr style="border: 1px solid #ccc;">       
             <input class="usernameClass" type="text" name="username" placeholder="Your username" value="<?php echo $username; ?>">
             <span class="help-block"><?php echo $username_err; ?></span>
            </div>  
         
         <!-- Password Group --> 
         <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <input class="usernameClass" type="password" name="password" placeholder="Your password">
            <span class="help-block"><?php echo $password_err; ?></span>
         </div>
            
          <!-- Confirm Password Group --> 
         <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
           <input class="usernameClass" type="password" name="confirm_password" placeholder="Re-type password">
           <span class="help-block"><?php echo $confirm_password_err; ?></span>
         </div>
            
          <!-- Register Button -->
          <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register">
          </div>
          <span style="font-size: 16px; text-align: center; display: block; color: DodgerBlue; font-weight: bold; margin-bottom: 34px;"><a href="http://myliveboard.tk/index.php">Back to Login</a></span>
            
         </div> <!-- END OF USERNAME CLASS GROUP -->
        
     </form> <!-- Close Register Form Group -->
 
  </section><br>
   
 </div> <!-- Close Arkalogin DIV -->
    
 </section> <!-- Close section -->
    
        
</body>

</html>