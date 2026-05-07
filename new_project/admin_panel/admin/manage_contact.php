<?php
include_once('header.php');
?>
	  
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
           
				<div class="card-body">
				  <h5 class="card-title fw-semibold mb-4">Manage Contact Messages</h5>
				  <div class="table-responsive mt-4">
					<table class="table mb-0 text-nowrap varient-table align-middle fs-3">
					  <thead>
						<tr>
						  <th scope="col" class="px-0 text-muted">Id</th>
						  <th scope="col" class="px-0 text-muted">Name</th>
						  <th scope="col" class="px-0 text-muted">Email</th>
						  <th scope="col" class="px-0 text-muted">Phone</th>
						  <th scope="col" class="px-0 text-muted">Subject</th>
						  <th scope="col" class="px-0 text-muted">Message</th>
						  <th scope="col" class="px-0 text-muted">Date</th>
						  <th scope="col" class="px-0 text-muted">Action</th>
						</tr>
					  </thead>
					  
					  <tbody>
						<?php
						$contacts = $this->select('contact');
						foreach($contacts as $c) {
						?>
						<tr>
						  <td class="px-0"><?php echo $c['id']; ?></td>
						  <td class="px-0"><?php echo $c['name']; ?></td>
						  <td class="px-0"><?php echo $c['email']; ?></td>
						  <td class="px-0"><?php echo $c['phone']; ?></td>
						  <td class="px-0"><?php echo $c['subject']; ?></td>
						  <td class="px-0"><?php echo substr($c['message'], 0, 50) . '...'; ?></td>
						  <td class="px-0"><?php echo $c['created_at']; ?></td>
						  <td class="px-0">
							<button class="btn btn-primary" onclick="replyTo('<?php echo $c['email']; ?>', '<?php echo $c['name']; ?>')">Reply</button>
							<a href="?del_contact=<?php echo $c['id']; ?>" class="btn btn-danger">Delete</a>
						  </td>
						</tr>
						<?php } ?>
						
					  </tbody>
					</table>
				  </div>
				</div>
          </div>
        </div>
      </div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="replyModalLabel">Reply to Customer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <label for="reply_email">Email</label>
            <input type="email" class="form-control" id="reply_email" name="reply_email" readonly>
          </div>
          <div class="form-group">
            <label for="reply_subject">Subject</label>
            <input type="text" class="form-control" id="reply_subject" name="reply_subject" required>
          </div>
          <div class="form-group">
            <label for="reply_message">Message</label>
            <textarea class="form-control" id="reply_message" name="reply_message" rows="5" required></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="reply_btn" class="btn btn-primary">Send Reply</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
function replyTo(email, name) {
    document.getElementById('reply_email').value = email;
    document.getElementById('reply_subject').value = 'Re: Your message';
    $('#replyModal').modal('show');
}
</script>
	  
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