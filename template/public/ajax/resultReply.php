<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/util/DbConnectionUtil.php';
?>
	<form class="reply-form<?php echo $idComment; ?>">
		<div class="form-group">
			<input required type="text" name="name" class="form-control" id="nameReply" placeholder="Name">
		</div>
		<div class="form-group">
			<input required type="text" name="email" class="form-control" id="emailReply" placeholder="Email">
		</div>
		<div class="form-group comment">
			<textarea required class="form-control" name="comment" id="commentReply" placeholder="Comment"></textarea>
		</div>
		<button onClick="return getReplyComment();" type="submit" name="submit" class="btn btn-submit red">Submit</button>
	</form>
	