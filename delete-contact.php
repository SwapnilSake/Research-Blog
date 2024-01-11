<?php
require 'config/database.php';

if (isset($_GET['id'])) {
    $contactId = $_GET['id'];

    // Delete the contact from the database
    $query = "DELETE FROM contacts WHERE id = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $contactId);
    $stmt->execute();

    // Redirect back to the contacts page
    header("Location: contacts.php");
    exit();
} else {
    // Redirect back to the contacts page if contact id is not provided
    header("Location: contacts.php");
    exit();
}
?>