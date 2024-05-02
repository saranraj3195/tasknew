$servername = "localhost";
$username = "";
$password = "";
$dbname = "task-two";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form data
$name = $_POST['name'];
$email = $_POST['email'];
$department = $_POST['department'];

// Insert employee data into database
$sql = "INSERT INTO employees (name, email, department) VALUES ('$name', '$email', '$department')";
if ($conn->query($sql) === TRUE) {
    $employee_id = $conn->insert_id;

    // Generate token
    $token = bin2hex(random_bytes(16));
    $sql_token = "INSERT INTO tokens (employee_id, token) VALUES ('$employee_id', '$token')";
    if ($conn->query($sql_token) === TRUE) {
        echo "Employee registered successfully. Token: $token";
    } else {
        echo "Error: " . $sql_token . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>