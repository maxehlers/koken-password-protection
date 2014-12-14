<form action="<?= $_SERVER['PHP_SELF']; ?>" method="POST" role="form">
		<input type="hidden" name="action" value="<?= isset($nextAction)? $nextAction: "addPassword"; ?>" />
		<input type="hidden" name="maxPw" value="<?= $_POST['maxPw']; ?>" />
		<input type="hidden" name="id" value="<?= isset($row['id'])? $row['id']: ''; ?>">
		<div class="form-group">
			<label for="albumId">Album:</label>
			<select name="albumId" id="albumId">
				<?php 
					$selectedSnipplet = ' selected="selected"';
					foreach($albums as $album){
						if($album['listed'] != "1"){
							echo '<option value="'.$album['id'].'"';
							if(isset($row['albumId']) && $row['albumId'] == $album['id']) echo $selectedSnipplet;
							echo '>'.$album['title'].'</option>';
						}
					}
				?>
			</select>
		</div>
		<div class="form-group">
			<label for="description">Description <small>(just for you)</small></label>
			<input type="text" maxlength="80" name="description" class="form-control" id="description" placeholder="Anything you want..." value="<?= isset($row['description'])? $row['description']:""; ?>">
		</div>
		<div class="form-group">
			<label for="thePw">Password</label>
			<input type="password" name="pw" class="form-control" id="thePw" placeholder="The desired password">
		</div>
		<input type="submit" class="btn btn-primary" value="Save Password" /> <small>You can edit and delete it later, too.</small>
	</form>