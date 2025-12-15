<?php
include_once('header.php');
?>
	  
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
           
				<div class="card-body">
				  <h5 class="card-title fw-semibold mb-4">Manage Customer</h5>
				  <div class="table-responsive mt-4">
					<table class="table mb-0 text-nowrap varient-table align-middle fs-3">
					  <thead>
						<tr>
						  <th scope="col" class="px-0 text-muted">Id</th>
						  <th scope="col" class="px-0 text-muted">Name</th>
						  <th scope="col" class="px-0 text-muted">email</th>
						  <th scope="col" class="px-0 text-muted">Password</th> 
						  <th scope="col" class="px-0 text-muted">Gender</th>
						  <th scope="col" class="px-0 text-muted">Hobby</th>
						  <th scope="col" class="px-0 text-muted">Country</th>
						  <th scope="col" class="px-0 text-muted">Action</th>
						</tr>
					  </thead>
					  
					  <tbody>
					  <?php
					  foreach($cust_arr as $value)
					  {
					  ?>
						<tr>
						  <td class="px-0"><?php echo $value->uid?></td>
						  <td class="px-0"><?php echo $value->name?></td>
						  <td class="px-0"><?php echo $value->email?></td>
						  <td class="px-0"><?php echo $value->password?></td>
						  <td class="px-0"><?php echo $value->gender?></td>
						  <td class="px-0"><?php echo $value->hobby?></td>
						  <td class="px-0"><?php echo $value->cid?></td>
						  <td class="px-0"><img src="../website/img/customer/<?php echo $value->image?>" width="50px"/></td>
						  <td class="px-0">
							<a href="" class="btn btn-primary">Edit</a>
							<a href="delete?del_customer=<?php echo $value->uid?>" class="btn btn-danger">Delete</a>
						  </td>
						</tr>
						<?php
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