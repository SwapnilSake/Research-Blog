<?php
require 'config/database.php';

//fetch current user from database 
if (isset($_SESSION['user-id'])) {
    $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT avatar FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $avatar = mysqli_fetch_assoc($result);
}


// Fetch all data from the posts table
$query_posts = "SELECT * FROM posts";
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


    <section class="search__bar">
        <form class="container search__bar-container" method="GET" action="search.php">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="query" placeholder="Search">
            </div>
            <button type="submit" class="btn">Go</button>
        </form>
   </section>
    

    <section class="posts">
        <div class="container post__container">
        <?php foreach ($posts as $post) : ?>
            <?php
                // Fetch the category title for the current post
                $category_id = $post['category_id'];
                $query_category = "SELECT title FROM categories WHERE id=$category_id";
                $result_category = mysqli_query($connection, $query_category);
                $category = mysqli_fetch_assoc($result_category);
                $category_title = $category['title'];
            ?>
            <article class="post">
            <div class="post__thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>">
            </div>
            <div class="post__info">
                <a href="category-posts.php?id=<?= $post['id'] ?>" class="category__button"><?= $category_title ?></a>

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
    

    <?php
include 'partials/footer.php';
?>