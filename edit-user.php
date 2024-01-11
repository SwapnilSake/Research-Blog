<?php
include 'partials/header.php';

//get user id in edit user page by shown which id we are edit
if (isset($_GET['id'])) {
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    //fetch user data to edit 
    $query = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($connection, $query);
    $user = mysqli_fetch_assoc($result);
}else {
    header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
}
?>


    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit User</h2>
            <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                <input type="text" name="firstname" value="<?= $user['firstname'] ?>" placeholder="First Name">
                <input type="text" name="lastname" value="<?= $user['lastname'] ?>" placeholder="Last Name">
                
                <select name="userrole">
                    <option value="0">User</option>
                    <option value="1">Admin</option>
                </select>
                <button type="submit" name="submit" class="btn">Update User</button>
            </form>
        </div>
    </section>


<?php
include '../partials/footer.php';
?>