<?php
require 'config/database.php';

// Fetch the search query from the URL parameters
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Fetch posts from the database that match the search query
    $search_query = "SELECT * FROM posts WHERE title LIKE '%$query%' OR body LIKE '%$query%'";
    $search_result = mysqli_query($connection, $search_query);

    // Check if the query was successful
    if ($search_result && mysqli_num_rows($search_result) > 0) {
        $posts = mysqli_fetch_all($search_result, MYSQLI_ASSOC);
    } else {
        // Handle the case when no posts are found for the search query
        echo "No posts found for the search query: $query";
    }
} else {
    // Handle the case when no search query is provided in the URL
    echo "No search query specified.";
}
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

    <meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>

<nav>
        <div class="container nav__container">
            <a style="width:150px;" href="<?= ROOT_URL ?>blog.php" class="nav__logo">
            <i class="fa fa-arrow-circle-left" style="font-size:24px;">Back</i>
            </a>
        </div>
    </nav>
    <!-- Navbar End -->
<!-- Display the search results -->
<section style="margin-top: 10rem" class="posts">
    <div  class="container post__container">
        <?php if (isset($posts) && count($posts) > 0) : ?>
            <?php foreach ($posts as $post) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="./images/<?= $post['thumbnail'] ?>">
                    </div>
                    <div class="post__info">
                        <div style="margin-top: 15px" class="post__author-info">
                            <small><?= $post['date-_time'] ?></small>
                        </div>
                        <h3 class="post__title">
                            <a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p class="post__body">
                            <?= substr($post['body'], 0, 150) ?>...
                        </p>
                        <div class="post__author">
                            <!--<div class="post__author-avatar">
                                <img src="">
                            </div>-->
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No posts found for the search query: <?= $query ?></p>
        <?php endif; ?>
    </div>
</section>
</body>
</html>