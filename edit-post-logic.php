<?php
require 'config/database.php';

session_start(); // Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    $category_id = $_POST['category'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;

    // Perform form data validation
    $errors = [];

    // Validate title
    if (empty($title)) {
        $errors[] = "Please enter the post title.";
    }

    // Validate body
    if (empty($body)) {
        $errors[] = "Please enter the post body.";
    }

    // Validate category ID
    if (empty($category_id)) {
        $errors[] = "Please select a category.";
    }

    // If there are no errors, update the post in the database
    if (empty($errors)) {
        // Update post in the database
        $query = "UPDATE posts SET title=?, body=?, category_id=?, is_featured=? WHERE id=?";
        $stmt = mysqli_prepare($connection, $query);
        mysqli_stmt_bind_param($stmt, "ssiii", $title, $body, $category_id, $is_featured, $id);

        // Execute the update query
        if (mysqli_stmt_execute($stmt)) {
            // Post updated successfully
            $_SESSION['success'] = "Post updated successfully.";
            header('location: ' . ROOT_URL . 'admin/');
            exit();
        } else {
            // Error updating post
            $_SESSION['error'] = "Error updating post: " . mysqli_error($connection);
        }
    } else {
        // Store the validation errors in $_SESSION['error']
        $_SESSION['error'] = $errors;
    }

    // Redirect back to the edit post page with the error messages
    header("Location: edit-post.php?id=$id");
    exit();
} else {
    // Redirect to the index page if accessed directly without submitting the form
    header('location: ' . ROOT_URL . 'admin/');
    exit();
}
?>