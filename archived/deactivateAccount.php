<?php
session_start();
$servername = "localhost";
$username = "dyno";
$password = "Dinocloud.1995";
$dbname = "liveboard";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Setam modul de eroare PDO ca exceptie
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $userDeactivate = $_SESSION['loggedin'];
    $sqli = "DELETE FROM users WHERE id = $userDeactivate";

    // Pregatire declaratie
    $stmt = $conn->prepare($sqli);

    // Executam interogarea
    $stmt->execute();

    // Cu echo afisam un mesaj de success pentru inregistrarea planului
    echo "Your account was deactivated successfully! Goodbye";
    header( "refresh:3;url=logout.php" );
    }
catch(PDOException $e)
    {
    echo $sqli . "<br>" . $e->getMessage();
    }

$conn = null;
?>

