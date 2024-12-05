<?php
//database credentials
$dsn ="mysql:host=localhost;dbname=evaluation";
$dbusername ="root";
$dbpassword ="";

try {
    // Establishing a connection using PDO
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $student_name = $_POST['studentname'];
        $program = $_POST['program'];
        $year_level = $_POST['yearlevel'];
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Sanitize input data
        $student_name = htmlspecialchars(strip_tags($student_name));
        $program = htmlspecialchars(strip_tags($program));
        $year_level = htmlspecialchars(strip_tags($year_level));
        $username = htmlspecialchars(strip_tags($username));
        $password = htmlspecialchars(strip_tags($password)); // In a real application, hash this!

        // SQL query to insert data into the "students" table
        $sql = "INSERT INTO students (student_name, program, year_level, username, password) 
                VALUES (:student_name, :program, :year_level, :username, :password)";
        
        // Prepare the query
        $stmt = $pdo->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':student_name', $student_name, PDO::PARAM_STR);
        $stmt->bindParam(':program', $program, PDO::PARAM_STR);
        $stmt->bindParam(':yearlevel', $year_level, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR); // Hash this in production

        // Execute the query
        $stmt->execute();

        // Success message
        echo "<h1>Registration Successful!</h1>";
        echo "<p><strong>Student Name:</strong> $student_name</p>";
        echo "<p><strong>Program:</strong> $program</p>";
        echo "<p><strong>Year Level:</strong> $yearlevel</p>";
        echo "<p><strong>Username:</strong> $username</p>";
        echo "<p><strong>Password:</strong> (hidden for security)</p>";
    } else {
        echo "<h1>Error: Invalid request method.</h1>";
    }
} catch (PDOException $e) {
    // Error handling
    echo "<h1>Database Connection Failed:</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
