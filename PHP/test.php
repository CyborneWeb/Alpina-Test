<?php

// --- DATABASE CREDENTIALS ---
// Replace these with your actual database details.

$servername = "127.0.0.1"; // Use 127.0.0.1 instead of "localhost" to force a TCP/IP connection, which is more reliable.
$username   = "root";
$password   = "geslo123"; // <-- IMPORTANT: Change this to your actual root password!
$dbname     = "mysql";      // Optional: specify a database to connect to. 'mysql' is a good default to test with.


// --- CONNECTION LOGIC ---

// Create connection using the MySQLi extension
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // If there was an error, stop the script and print a detailed error message.
    die("Connection failed: " . $conn->connect_error);
}

// If the script reaches this point, the connection was successful.
echo "Successfully connected to the database ($dbname) as user '$username'!" . PHP_EOL;

// Close the connection
$conn->close();

?>