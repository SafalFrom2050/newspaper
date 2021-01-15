<?php
include 'header.php';
?>

<?php
if (isset($_POST['category'])) {
    $categoryObj = new Category();
    $categoryObj->createCategory($_POST['category']);
}

if (isset($_POST['delete_category_id'])) {
    $categoryObj = Category::withID($_POST['delete_category_id']);

    $categoryObj->deleteCategory();
}

if (isset($_POST['edit_category_id'])) {
    $categoryObj = Category::withID($_POST['edit_category_id']);

    $categoryObj->rename($_POST['edit_category_name']);

    // Refresh the page by removing GET parameters
    header("Location: /admin/categories.php");
    die();
}

?>

<article>
    <h2>
        <a href="/admin">Back</a>
        Manage Categories
    </h2>

    <div class="category-list">
        <?php
        $categoryObj = new Category();
        $categories = array();
        $categories = $categoryObj->getListOfCategories();

        foreach ($categories as $category) {
            echo '<div class="edit-category-list-item">';


            // Check if user has selected to edit this category
            if (isset($_GET['edit_category_id']) && $_GET['edit_category_id'] == $category->category_id) {
                //show edit form if yes
                echo '
                    <form class="edit-category" method="POST">
                        <input type="hidden" name="edit_category_id" value="' . $category->category_id . '" />
                        <input type="text" name="edit_category_name" value="' . $category->name . '" placeholder="Category title...">
                        <input type="submit" value="Save Changes" >
                    </form>
                    
                ';
            } else {
                //otherwise show category info
                echo '<h3>' . $category->getName() .
                    '
                    <form method="POST" onsubmit="return confirm(`Do you want to delete this category?`);">

                        <input type="hidden" name="delete_category_id" value="' . $category->category_id . '" />
                        <input type="submit" value ="Delete" />
                    </form>
                    <a href="?edit_category_id=' . $category->category_id . '">Edit</a>
                    </h3>';
            }

            echo '</div>';
        }
        ?>
    </div>
    <h3>Add New</h3>
    <form method="POST" class="add-category">
        <input type="text" name="category" placeholder="Category title...">
        <input type="submit" value="Add">
    </form>
</article>
</main>
<?php
include '../footer.php';
?>