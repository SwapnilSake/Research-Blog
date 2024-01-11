<?php
include 'partials/header.php';

// Fetch contacts from the database
$query = "SELECT * FROM contacts";
$contacts = mysqli_query($connection, $query);
?>




<section class="dashboard">
    <?php if(isset($_SESSION['add-category-success'])) : //shows if edit category successful?> 
        <div class="alert__message success container">
                <p>
                    <?= $_SESSION['add-category-success'];
                    unset($_SESSION['add-category-success']);
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['add-category-success'])) : //shows if edit category was not successful?> 
        <div class="alert__message error container">
                <p>
                    <?= $_SESSION['add-category'];
                    unset($_SESSION['add-category']);
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit-category'])) : //shows if edit category was not successful?> 
        <div class="alert__message error container">
                <p>
                    <?= $_SESSION['edit-category'];
                    unset($_SESSION['edit-category']);
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['edit-category-success'])) : //shows if edit category was successful?> 
        <div class="alert__message success container">
                <p>
                    <?= $_SESSION['edit-category-success'];
                    unset($_SESSION['edit-category-success']);
                    ?>
                </p>
        </div>
    <?php elseif(isset($_SESSION['delete-category-success'])) : //shows if delete category was successful?> 
        <div class="alert__message success container">
                <p>
                    <?= $_SESSION['delete-category-success'];
                    unset($_SESSION['delete-category-success']);
                    ?>
                </p>
        </div>
    <?php endif ?>
    <div class="container dashboard__container">
        <button id="show__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-right-b"></i></button>
        <button id="hide__sidebar-btn" class="sidebar__toggle"><i class="uil uil-angle-left-b"></i></button>
        <aside>
            <ul>
                <li>
                    <a href="contacts.php" class="active"><i class="fa fa-comments-o" style="font-size:15px"></i>
                    <h5>Contacts</h5>
                    </a>
                </li>
                <li>
                    <a href="add-post.php"><i class="uil uil-pen"></i>
                    <h5>Add Post</h5>
                    </a>
                </li>
                <li>
                    <a href="index.php"><i class="uil uil-postcard"></i>
                    <h5>Manage Posts</h5>
                    </a>
                </li>

                <!--user dont see and edit this -->
                <?php if(isset($_SESSION['user_is_admin'])) : ?>

                <li>
                    <a href="add-user.php"><i class="uil uil-user-plus"></i>
                    <h5>Add User</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-users.php"><i class="uil uil-users-alt"></i>
                    <h5>Manage User</h5>
                    </a>
                </li>
                <li>
                    <a href="add-category.php"><i class="uil uil-edit"></i>
                    <h5>Add Category</h5>
                    </a>
                </li>
                <li>
                    <a href="manage-categories.php" ><i class="uil uil-list-ul"></i>
                    <h5>Manage Categories</h5>
                    </a>
                </li>

                <?php endif ?>

            </ul>
        </aside>
        <main>
            <h2>Manage Contacts</h2>
            <?php if (mysqli_num_rows($contacts) > 0) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th>Message</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($contact = mysqli_fetch_assoc($contacts)) : ?>
                        <tr>
                            <td><?= $contact['name'] ?></td>
                            <td><?= $contact['email'] ?></td>
                            <td><?= $contact['contact_no'] ?></td>
                            <td><?= $contact['message'] ?></td>
                            <td><a href="<?= ROOT_URL ?>admin/delete-contact.php?id=<?= $contact['id'] ?>" class="btn sm danger">Delete</a></td>
                        </tr>
                    <?php endwhile ?>
                </tbody>
            </table>
            <?php else : ?>
                <div class="alert__message error"><?= "No Contacts Found" ?></div>
            <?php endif ?>
        </main>
    </div>
</section>


<?php
include '../partials/footer.php';
?>