
<?php
$servername = "your-rds-endpoint.amazonaws.com";
$username = "your-db-username";
$password = "your-db-password";
$dbname = "your-db-name";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$action = $_POST['action'];

if ($action == 'signup') {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (username, password) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);

    if ($stmt->execute()) {
        header("Location: index.html?msg=SignupSuccess");
    } else {
        echo "Signup Failed!";
    }

} elseif ($action == 'login') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT password FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($hashed);
    
    if ($stmt->fetch() && password_verify($pass, $hashed)) {
        $_SESSION['username'] = $user;
        header("Location: dashboard.html");
    } else {
        echo "Login Failed! Incorrect credentials.";
    }

} else {
    echo "Invalid action.";
}
?>
