<?php

require 'config/database.php';

session_start(); // Start the session

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    
    $title = $_POST['title'];
    $body = $_POST['body'];
    $category_id = $_POST['category'];
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $thumbnail = $_FILES['thumbnail'];
    
    // Retrieve the current author_id from $_SESSION['user-id']
    $author_id = $_SESSION['user-id'];

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

    // Validate thumbnail
    if (empty($thumbnail['name'])) {
        $errors[] = "Please choose a post image.";
    } elseif ($thumbnail['size'] > 2_000_000) {
        $errors[] = "File size should be less than 2MB.";
    }

    // If there are no errors, insert the post into the database
    if (empty($errors)) {
        // Generate a unique filename for the thumbnail
        $thumbnail_name = time() . '_' . $thumbnail['name'];

        // Set the destination path for the thumbnail
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // Move uploaded thumbnail to the destination path
        if (move_uploaded_file($thumbnail['tmp_name'], $thumbnail_destination_path)) {
            // Thumbnail uploaded successfully
            // Insert post into database
            $query = "INSERT INTO posts (title, body, category_id, is_featured, thumbnail, author_id) VALUES ('$title', '$body', '$category_id', '$is_featured', '$thumbnail_name', '$author_id')";
            $result = mysqli_query($connection, $query);

            if ($result) {
                // Post inserted successfully
                $_SESSION['add-post-success'] = "New post added successfully";
                header('location: ' . ROOT_URL . 'admin/');
                exit();
            } else {
                // Error inserting post
                $_SESSION['add-post'] = "Error inserting post: " . mysqli_error($connection);
                header('location: ' . ROOT_URL . 'admin/add-post.php');
                exit();
            }

            // Set is_featured of posts to 0 if is_featured for this post is 1
            if ($is_featured == 1) {
                $zero_all_is_featured_query = "UPDATE posts SET is_featured = 1";
                $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);

                if (!$zero_all_is_featured_result) {
                    $_SESSION['add-post'] = "Error updating is_featured value of other posts: " . mysqli_error($connection);
                    header('location: ' . ROOT_URL . 'admin/add-post.php');
                    exit();
                }
            }
        } else {
            // Error uploading thumbnail
            $_SESSION['add-post'] = "Error uploading thumbnail.";
            header('location: ' . ROOT_URL . 'admin/add-post.php');
            exit();
        }
    } else {
        // Store the validation errors in $_SESSION['add-post']
        $_SESSION['add-post'] = $errors;
        header('location: ' . ROOT_URL . 'admin/add-post.php');
        exit();
    }
}
?>