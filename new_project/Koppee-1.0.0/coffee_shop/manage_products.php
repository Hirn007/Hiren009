<?php
include_once('header.php');
?>

<!-- Manage Products Start -->
<div class="container-fluid pt-5">
    <div class="container">
        <h2 class="mb-4" style="color: #C8A882;">Manage Products</h2>

        <!-- Add New Product Button -->
        <div class="mb-4">
            <button class="btn btn-warning" data-toggle="modal" data-target="#addProductModal">
                <i class="fa fa-plus mr-2"></i>Add New Product
            </button>
        </div>

        <!-- Products Table -->
        <div class="table-responsive bg-dark rounded p-4">
            <table class="table table-dark table-hover">
                <thead style="background-color: #C8A882; color: #000;">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody style="color: #fff;">
                    <?php
                    if(!empty($prod_arr) && is_array($prod_arr)) {
                        foreach($prod_arr as $prod) {
                            ?>
                            <tr>
                                <td><?php echo isset($prod->id) ? htmlspecialchars($prod->id) : 'N/A'; ?></td>
                                <td><?php echo isset($prod->name) ? htmlspecialchars($prod->name) : 'N/A'; ?></td>
                                <td><?php echo isset($prod->category_id) ? htmlspecialchars($prod->category_id) : 'N/A'; ?></td>
                                <td>₹<?php echo isset($prod->price) ? htmlspecialchars($prod->price) : '0'; ?></td>
                                <td><?php echo isset($prod->description) ? htmlspecialchars(substr($prod->description, 0, 50)) : 'N/A'; ?>...</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="editProduct(<?php echo $prod->id; ?>)">
                                        <i class="fa fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteProduct(<?php echo $prod->id; ?>)">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No products found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-dark">
            <div class="modal-header" style="background-color: #C8A882; color: #000;">
                <h5 class="modal-title">Add New Product</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="modal-body" style="color: #fff;">
                    <div class="form-group">
                        <label style="color: #C8A882;">Product Name</label>
                        <input type="text" class="form-control" name="prod_name" required
                               style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label style="color: #C8A882;">Category</label>
                            <select class="form-control" name="category_id" required
                                    style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                                <option value="">-- Select Category --</option>
                                <!-- Categories will be populated from database -->
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label style="color: #C8A882;">Price</label>
                            <input type="number" class="form-control" name="price" step="0.01" required
                                   style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                        </div>
                    </div>
                    <div class="form-group">
                        <label style="color: #C8A882;">Description</label>
                        <textarea class="form-control" name="description" rows="3"
                                  style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;"></textarea>
                    </div>
                    <div class="form-group">
                        <label style="color: #C8A882;">Product Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*"
                               style="background-color: #1a1a1a; border: 1px solid #C8A882; color: #fff;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" name="add_product" class="btn btn-warning">Add Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Manage Products End -->

<?php
include_once('footer.php');
?>
