<h2>Existing passwords</h2>
<?php
// Wir bekommen das result objekt aus der index.php
while($row = mysqli_fetch_array($passwordsResult)){
	?>
	<div class="panel panel-default">
		<div class="panel-heading"><?= $row['description']; ?></div>
		<div class="panel-body">
			<strong>Album:</strong> <?= $albums[$row['albumId']]['title']; ?>
		</div>
		<div class="panel-footer">
			<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST">
				<input type="hidden" name="maxPw" value="<?= $_POST['maxPw']; ?>" />
				<input type="hidden" name="id" value="<?= $row['id']; ?>" />
				<input type="hidden" name="action" value="deletePassword" /><button type="submit" class="btn btn-danger pull-right" name="submit">Delete</button></form>
			<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit-<?= $row['id']; ?>">
			  Edit
			</button>
		</div>
	</div>
	<div class="modal fade" id="edit-<?= $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="label-<?= $row['id']; ?>" aria-hidden="true">
		<div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
		    <h4 class="modal-title" id="label-<?= $row['id']; ?>">Edit Password</h4>
		  </div>
		  <div class="modal-body">
		    <?php
		    	$nextAction = "editPassword";
		    	include("templates/form.php");
		    ?>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
		</div>
	</div>
<?php 
}
?>