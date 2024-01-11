<?php
require 'config/database.php';

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Perform the delete operation
    $query = "DELETE FROM posts WHERE id=?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Execute the delete query
    if (mysqli_stmt_execute($stmt)) {
        // Post deleted successfully
        $_SESSION['success'] = "Post deleted successfully.";
        header('location: ' . ROOT_URL . 'admin/');
    } else {
        // Error deleting post
        $_SESSION['error'] = "Error deleting post: " . mysqli_error($connection);
    }

    // Redirect to the admin page or index.php
    header('location: ' . ROOT_URL . 'admin/'); // or header('Location: index.php');
    exit();
} else {
    // Redirect to the admin page or index.php if accessed directly or without the post ID
    header('location: ' . ROOT_URL . 'admin/'); // or header('Location: index.php');
    exit();
}
?>