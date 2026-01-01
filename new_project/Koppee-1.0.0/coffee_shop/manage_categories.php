<?php
include_once('header.php');
?>

<!-- Manage Categories Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <h2 class="mb-4" style="color: #C8A882;">Manage Categories</h2>

        <!-- Add New Category Button -->
        <div class="mb-4">
            <button class="btn btn-warning" data-toggle="modal" data-target="#addCategoryModal">
                <i class="fa fa-plus mr-2"></i>Add New Category
            </button>
        </div>

        <!-- Categories Table -->
        <div class="table-responsive bg-dark rounded p-4">
            <table class="table table-dark table-hover">
                <thead style="background-color: #C8A882; color: #000;">
                    <tr>
                        <th>ID</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="color: #fff;">
                    <?php
                    if(!empty($coffe_arr) && is_array($coffe_arr)) {
                        foreach($coffe_arr as $cat) {
                            ?>
                            <tr>
                                <td><?php echo isset($cat->id) ? htmlspecialchars($cat->id) : 'N/A'; ?></td>
                                <td><?php echo isset($cat->name) ? htmlspecialchars($cat->name) : 'N/A'; ?></td>
                                <td><?php echo isset($cat->description) ? htmlspecialchars($cat->description) : 'N/A'; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editCategory(<?php echo $cat->id; ?>)">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCategory(<?php echo $cat->id; ?>)">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No categories found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header" style="background-color: #C8A882; color: #000;">
                <h5 class="modal-title">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body" style="color: #fff;">
                    <div class="form-group">
                        <label style="color: #C8A882;">Category Name</label>
                        <input type="text" class="form-control" name="cat_name" required
                               style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                    </div>
                    <div class="form-group">
                        <label style="color: #C8A882;">Description</label>
                        <textarea class="form-control" name="cat_desc" rows="3"
                                  style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_category" class="btn btn-warning">Add Category</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Manage Categories End -->

<?php
include_once('footer.php');
?>
