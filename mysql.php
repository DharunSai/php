<?php
$servername = "localhost"; // Replace with your MySQL server name
$username = "root"; // Replace with your MySQL username
$password = "admin@123"; // Replace with your MySQL password
$database = "imdb"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful
echo "Connected successfully";

$sql = "SELECT * FROM movies LIMIT 20";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Access the retrieved data
        echo "Name: " . $row["name"] . "<br>";
    }
} else {
    echo "No results found";
}
// Close the connection
$conn->close();
?>
