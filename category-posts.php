<?php
require 'config/database.php';

// Fetch the selected category ID from the URL
if (isset($_GET['id'])) {
    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Fetch the selected category from the database based on the ID
    $category_query = "SELECT * FROM posts  WHERE category_id = $category_id";
    $category_result = mysqli_query($connection, $category_query);

    // Check if the query was successful
    if ($category_result && mysqli_num_rows($category_result) > 0) {
        $category = mysqli_fetch_assoc($category_result);

        // Fetch posts from the database for the selected category
        $posts_query = "SELECT * FROM posts WHERE category_id = $category_id ORDER BY date_time DESC";
        $posts_result = mysqli_query($connection, $posts_query);

        // Check if the query was successful
        if ($posts_result && mysqli_num_rows($posts_result) > 0) {
            $posts = mysqli_fetch_all($posts_result, MYSQLI_ASSOC);
        } else {
            // Handle the case when no posts are found for the selected category
            echo "No posts found for this category.";
        }
    } else {
        // Handle the case when no category is found for the selected ID
        echo "Invalid category ID.";
    }
} else {
    // Handle the case when no category ID is provided in the URL
    echo "No category ID specified.";
}


//fetch current user from database for a navbar
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}

// Fetch all data from the posts table from category id
$query_posts = "SELECT * FROM posts WHERE category_id = $category_id";
$result_posts = mysqli_query($connection, $query_posts);
$posts = mysqli_fetch_all($result_posts, MYSQLI_ASSOC);

// Fetch all data from the categories table
$query_categories = "SELECT * FROM categories";
$result_categories = mysqli_query($connection, $query_categories);
$categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

?>



 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Application</title>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
<nav>
        <div class="container nav__container">
            <a style="width:150px" href="<?= ROOT_URL ?>" class="nav__logo">
            Adeke<span>Insights</span>
            </a>
            <ul class="nav__items">
                <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>

                <?php if(isset($_SESSION['user-id'])) : ?>
                    <li class="nav__profile">
                        <div class="avatar">
                            <img src="<?= ROOT_URL . 'images/' . $avatar['avatar'] ?>">
                        </div>
                        <ul>
                            <li><a href="<?= ROOT_URL ?>admin/index.php">Dashboard</a></li>
                            <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                        </ul>
                    </li>
                <?php else : ?>
                <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
                <?php endif ?>
            </ul>

            <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
            <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
        </div>
    </nav>
    <!-- Navbar End -->

    <?php if (isset($category)) : ?>
    <header class="category__title">
        <h2> <?= $category['title'] ?> </h2>
    </header>

    <?php if (isset($posts) && count($posts) > 0) : ?>
    <section class="posts">
    <div class="container post__container">

        <?php foreach ($posts as $post) : ?>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>">
            </div>
            <div class="post__info">
                <a href="category-posts.php?id=<?= $post['category_id'] ?>" class="category__button"><?= $category['title'] ?></a>
                
                <div style="margin-top: 15px" class="post__author-info">
                    <small><?= $post['date-_time'] ?></small>
                </div>
                <h3 class="post__title">
                    <a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                </h3>
                <p class="post__body">
                    <?= substr($post['body'], 0, 150)?>...
                </p>
                <div class="post__author">
                    <!--<div class="post__author-avatar">
                        <img src="">
                    </div>-->

                </div>
            </div>
        </article>
        <?php endforeach; ?>


    </div>
</section>

<section class="category__buttons">
        <div class="container category__buttons-container">
        <?php foreach($categories as $category) : ?>
            <a href="category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
        <?php endforeach; ?>
        </div> 
    </section>

<?php else : ?>
            <p>No posts found for this category.</p>
        <?php endif; ?>

    <?php else : ?>
        <p>Category not found.</p>
    <?php endif; ?>



<?php
include 'partials/footer.php';
?>