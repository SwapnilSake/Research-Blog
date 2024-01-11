<?php
require 'config/database.php';

// Function to sanitize form inputs
function sanitizeInput($input) {
  $input = trim($input);
  $input = stripslashes($input);
  $input = htmlspecialchars($input);
  return $input;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form inputs and sanitize them
  $name = sanitizeInput($_POST["name"]);
  $email = sanitizeInput($_POST["email"]);
  $contactNo = sanitizeInput($_POST["contact_no"]);
  $message = sanitizeInput($_POST["message"]);

  // Perform additional validation if necessary
  // ...

  // Insert data into the contacts table
  $sql = "INSERT INTO contacts (name, email, contact_no, message) VALUES (?, ?, ?, ?)";
  $stmt = $connection->prepare($sql);
  $stmt->bind_param("ssss", $name, $email, $contactNo, $message);
  $stmt->execute();

  // Check if the insertion was successful
  if ($stmt->affected_rows > 0) {
    // Success
    // You can redirect the user to a success page or display a success message
    echo "Thank you for contacting us!";
  } else {
    // Error
    // You can redirect the user to an error page or display an error message
    echo "Oops! Something went wrong. Please try again.";
  }

  // Close the database connection
  $stmt->close();
  $connection->close();
}
?>