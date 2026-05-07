<?php
include_once('header.php');
?>
      
      
      
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
           
<div class="card-body">
  <h5 class="card-title fw-semibold mb-4">Manage Products</h5>
  <div class="table-responsive mt-4">
<table class="table mb-0 text-nowrap varient-table align-middle fs-3">
  <thead>
<tr>
  <th scope="col" class="px-0 text-muted">Prod Id</th>
  <th scope="col" class="px-0 text-muted">Title</th>
  <th scope="col" class="px-0 text-muted">Price</th>
  <th scope="col" class="px-0 text-muted">Description</th>
  <th scope="col" class="px-0 text-muted">Image</th>
  <th scope="col" class="px-0 text-muted">Status</th>
  <th scope="col" class="px-0 text-muted">Action</th>
</tr>
  </thead>
  
  <tbody>
  <?php
      if(!empty($product_arr)){
          foreach($product_arr as $value){
  ?>
<tr>
  <td scope="col" class="px-0"><?php echo $value->id ?></td>
  <td scope="col" class="px-0"><?php echo $value->product_name ?></td>
  <td scope="col" class="px-0"><?php echo number_format($value->price, 2) ?></td>
  <td scope="col" class="px-0"><?php echo htmlspecialchars(substr($value->description, 0, 60)) ?>...</td>
  <td scope="col" class="px-0">
<img width="100px" src="assets/images/products/<?php echo $value->product_image ?>" />
  </td>
  <td scope="col" class="px-0">
<span class="badge bg-<?php echo strtolower($value->status) === 'active' ? 'success' : 'secondary' ?>"><?php echo $value->status ?></span>
  </td>
  <td class="px-0">
<a href="edit_products?edit_product=<?php echo $value->id ?>" class="btn btn-primary">Edit</a>
<a href="delete?del_prod=<?php echo $value->id ?>" class="btn btn-danger">Delete</a>
  </td>
</tr>
  <?php
          }
      } else {
          echo '<tr><td colspan="8" class="text-center">No products found</td></tr>';
      }
  ?>
  </tbody>
</table>
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
