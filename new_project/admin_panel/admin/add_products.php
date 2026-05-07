<?php
include_once('header.php');
?>
      
      
      
      
      
      
      
      
      
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Add Products</h5>
              <div class="card">
                <div class="card-body">
                  
  <form action="add_products" method="post" enctype="multipart/form-data"> 
                    <div class="mb-3">
                      <label class="form-label">Title</label>
                      <input type="text" name="product_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Price</label>
                      <input type="number" name="price" class="form-control" step="0.01" required>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Description</label>
                      <textarea name="description" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Status</label>
                      <select name="status" class="form-control" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Image</label>
                      <input type="file" name="product_image" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                  </form>
                
</div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="./assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/js/sidebarmenu.js"></script>
  <script src="./assets/js/app.min.js"></script>
  <script src="./assets/libs/simplebar/dist/simplebar.js"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>
