<?php
include 'partials/header.php';

//fetch category from database
$query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $query);

//get back form data if form was invalid
$title = $_SESSION['add-post-data']['title'] ?? null;
$body = $_SESSION['add-post-data']['body'] ?? null;

//delete form data session
unset($_SESSION['add-post-data']);
?>

    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Post</h2>

            <?php if(isset($_SESSION['add-post'])) : ?>
            <div class="alert__message error">
                <p>
                    <?php
                    if (is_array($_SESSION['add-post'])) {
                        // If $_SESSION['add-post'] is an array, loop through each error and display it
                        foreach ($_SESSION['add-post'] as $error) {
                            echo $error . "<br>";
                        }
                    } else {
                        // If $_SESSION['add-post'] is a string, display it as a single error message
                        echo $_SESSION['add-post'];
                    }
                    unset($_SESSION['add-post']);
                    ?>
                </p>
            </div>
            <?php endif ?>

            <form action="<?= ROOT_URL ?>admin/add-post-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="title" value="<?= $title ?>" placeholder="Title">
                <select name="category">
                    <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
                        <option value="<?= $category['id'] ?>"><?= $category['title'] ?></option>
                    <?php endwhile ?>
                </select>
                <textarea rows="10" name="body" placeholder="Body"><?= $body ?></textarea>

                <!-- IF USER IS ADMIN THEN HE POST A FEATURED POST ON WEBSITE ANOTHER NO-->
                <?php if (isset($_SESSION['user_is_admin'])) : ?>
                <div class="form__control inline">
                    <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                    <label for="is_featured" >Featured</label>
                </div>
                <?php endif ?>

                <div class="form__control">
                    <label for="thumbnail">Add Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail">
                </div>
                <button type="submit" value="submit" name="submit" class="btn">Add Post</button>
            </form>
        </div>
    </section>


<?php
include '../partials/footer.php';
?>