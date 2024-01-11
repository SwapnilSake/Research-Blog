<?php
include 'partials/header.php';

// Fetch featured posts with category information from the database
$query = "SELECT p.*, c.title AS category_title
          FROM posts p 
          INNER JOIN categories c ON p.category_id = c.id
          WHERE p.is_featured = 1";
$result = mysqli_query($connection, $query);
$featured_posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Fetch all data from the posts table
$query_posts = "SELECT * FROM posts";
$result_posts = mysqli_query($connection, $query_posts);
$posts = mysqli_fetch_all($result_posts, MYSQLI_ASSOC);

// Fetch all data from the categories table
$query_categories = "SELECT * FROM categories";
$result_categories = mysqli_query($connection, $query_categories);
$categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

//fetch post form database is id is set
if(isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id=$id";
    $result_posts = mysqli_query($connection, $query);
    $posts = mysqli_fetch_all($result_posts, MYSQLI_ASSOC);

    // Fetch category information for the post
    if (!empty($posts)) {
        $post = $posts[0]; // Assuming only one post is fetched
        $category_id = $post['category_id'];

        $query_category = "SELECT title FROM categories WHERE id=$category_id";
        $result_category = mysqli_query($connection, $query_category);
        $category = mysqli_fetch_assoc($result_category);
        $category_title = $category['title'];
    }
} 



?>





    <!-- News With Sidebar Start -->
    <div class="container-fluid py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- News Detail Start -->
                    <?php foreach ($posts as $post) : ?>
                    <div class="position-relative mb-3">
                        <img class="img-fluid w-100" src="./images/<?= $post['thumbnail'] ?>" style="object-fit: cover;">
                        <div class="overlay position-relative bg-light">
                            <div class="mb-3">
                                <a href=""><?= $category_title ?></a>
                                <span class="px-1">/</span>
                                <span><?= $post['date-_time'] ?></span>
                            </div>
                            <div>
                                <h3 class="mb-3"><?= $post['title'] ?></h3>
                                <p><?= $post['body'] ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <!-- News Detail End -->  
                </div>

                <div class="col-lg-4 pt-3 pt-lg-0">

                    <!-- Popular News Start -->
                    <?php if(count($featured_posts) > 0) : ?>
                    <div class="pb-3">
                        <div class="bg-light py-2 px-4 mb-3">
                            <h3 class="m-0">Other</h3>
                        </div>
                        <?php foreach($featured_posts as $featured) : ?>
                        <div class="d-flex mb-3">
                            <img src="./images/<?= $featured['thumbnail'] ?>" style="width: 100px; height: 100px; object-fit: cover;">
                            <div class="w-100 d-flex flex-column justify-content-center bg-light px-3" style="height: 100px;">
                                <div class="mb-1" style="font-size: 13px;">
                                    <a href=""><?= $featured['category_title'] ?></a>
                                    <span class="px-1">/</span>
                                    <span><?= $featured['date-_time'] ?></span>
                                </div>
                                <a class="h6 m-0" href="post.php?id=<?= $featured['id'] ?>"><?= $featured['title'] ?></a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif ?>
                    <!-- Popular News End -->

                    <!-- Tags Start -->
                    <div class="pb-3">
                        <div class="bg-light py-2 px-4 mb-3">
                            <h3 class="m-0">Categories</h3>
                        </div>
                        <?php foreach($categories as $category) : ?>
                        <div class="d-flex flex-wrap m-n1">
                            <a href="category-posts.php?id=<?= $category['id'] ?>" class="btn btn-sm btn-outline-secondary m-1"><?= $category['title'] ?></a>
                        </div>
                        <?php endforeach?>
                    </div>
                    <!-- Tags End -->
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- News With Sidebar End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-light pt-5 px-sm-3 px-md-5">
        <div class="row">
            <div class="col-lg-3 col-md-6 mb-5">
                <a href="index.html" class="navbar-brand">
                    <h1 style="font-size:2rem" class="mb-2 mt-n2 display-5 text-uppercase"><span class="text-primary">Adeke</span>Insights</h1>
                </a>
                <p>“There is a great difference between knowing and understanding: you can know a lot about something and not really understand it.”</p>
                <div class="d-flex justify-content-start mt-4">
                    <a class="btn btn-outline-secondary text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-secondary text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-secondary text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn btn-outline-secondary text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-secondary text-center mr-2 px-0" style="width: 38px; height: 38px;" href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="font-weight-bold mb-4">Categories</h4>
                <?php foreach($categories as $category) : ?>
                <div class="d-flex flex-wrap m-n1">
                    <a href="category-posts.php?id=<?= $category['id'] ?>" class="btn btn-sm btn-outline-secondary m-1"><?= $category['title'] ?></a>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="font-weight-bold mb-4">Trending</h4>
                <?php
                    $counter = 0;
                        foreach ($categories as $index => $category) :
                        if ($counter >= 4) {
                            break; // Break the loop when the desired limit is reached
                        }
                ?>
                <div class="d-flex flex-wrap m-n1">
                    <a href="category-posts.php?id=<?= $category['id'] ?>" class="btn btn-sm btn-outline-secondary m-1"><?= $category['title'] ?></a>
                </div>
                <?php
                    $counter++; // Increment the counter after displaying a category
                    endforeach;
                ?>
            </div>
            <div class="col-lg-3 col-md-6 mb-5">
                <h4 class="font-weight-bold mb-4">Quick Links</h4>
                <div class="d-flex flex-column justify-content-start">
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-dark mr-2"></i>About</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-dark mr-2"></i>Advertise</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-dark mr-2"></i>Privacy & policy</a>
                    <a class="text-secondary mb-2" href="#"><i class="fa fa-angle-right text-dark mr-2"></i>Terms & conditions</a>
                    <a class="text-secondary" href="#"><i class="fa fa-angle-right text-dark mr-2"></i>Contact</a>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid py-4 px-sm-3 px-md-5">
        <p class="m-0 text-center">
            &copy; <a class="font-weight-bold" href="#">Your Site Name</a>. All Rights Reserved. 
			
			
			Designed by <a class="font-weight-bold" href="https://freewebsitecode.com">Free Website Code</a>
        </p>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-dark back-to-top"><i class="fa fa-angle-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="mail/jqBootstrapValidation.min.js"></script>
    <script src="mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>