<?php
include_once('header.php');
?>
	  
	  
	  
	  
	  
	  
	  
	  
	  
	  
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Edit Categories</h5>
              <div class="card">
                <div class="card-body">
                  
				  <form action="edit_categories" method="post" enctype="multipart/form-data"> 
                    <input type="hidden" name="id" value="<?php echo $category_arr[0]->id ?>">
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Categories Name</label>
                      <input type="text" name="category_name" class="form-control" value="<?php echo $category_arr[0]->category_name ?>" required>
                    </div>
					
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Categories Image</label>
                      <input type="file" name="image" class="form-control">
                      <img src="assets/images/categories/<?php echo $category_arr[0]->image ?>" width="100px">
                    </div>
                   
                    <button type="submit" name="update" class="btn btn-primary">Update</button>
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