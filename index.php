<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: dashboard.php");
    exit;
}
 
// Include config file
require_once "dbconfig.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter your username";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: dashboard.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid!";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later!";
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>

<DOCTYPE HTML>
<html lang="en">

	<head>
	 <meta name="Radu Goada" content="author">
	 <link rel="Shortcut Icon" href="resources/images/favicon_liveboard.ico">
	 <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	 <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	 <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	 <link href="resources/css/login.css" rel="stylesheet" media="screen">
	<head>

<body>
 <section style="height: 80vh;">
    
    <div class="wrapper">
        <b style="font-size: 65px; text-align: center; margin-top: 6%; display: block;">LiveBoard&trade;</b>
    </div>
    <section>
    
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    
        <div class="admin_login">      
        <!-- Username Group -->
         <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
         
           <div class="loginClass">Admin Login</div>  <!-- Login Window Title --> 
             <hr style="border: 1px solid #ccc;">       
             <input class="usernameClass" type="text" name="username" placeholder="Your username" value="<?php echo $username; ?>">
             <span class="help-block"><?php echo $username_err; ?></span>
           </div>  
         
         <!-- Password Group --> 
         <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <input class="usernameClass" type="password" name="password" placeholder="Your password">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
            
          <!--  <input class="butonlogin" type="submit" name="" value="Login"> -->
            
          <!-- Login Button -->
          <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
          </div>
            <span style="font-size: 16px; text-align: center; display: block; color: LightSlateGrey; font-weight: bold; margin-bottom: 34px;"><a href="http://myliveboard.tk/register.php">Register to Liveboard</a></span>
          </div>
        
    </form> <!-- Close Login Form Group -->
    
    </section><br>
    <!-- <span style="font-size: 23px; text-align: center; display: block; color: #E6E6E6;
    ">LiveBoard | Admin Login</span> -->
    <span style="font-size: 16px; text-align: center; display: block; color: #fff; font-weight: bold; margin-bottom: 15px;
    ">Powered by Raspbian Server</span>
    
    </div> <!-- Close Arkalogin DIV -->
    
 </section> <!-- Close section -->
    
<body>
    
</html>