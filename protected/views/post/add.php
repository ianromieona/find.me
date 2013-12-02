<div id="add-new">
<div class="container">
	<h2>Create "Find.me" post to get help from every Finder</h2>
	<div class="row">
	  <div class="col-lg-6">
	  	<form action="<?php echo $this->createUrl("post/save"); ?>" method="post" class="form-horizontal" id="add-new-post">
	  		<input type="hidden" name="postType" value="post">
	  		<?php if (isset($errorMessage)): ?>
	  			<div class="alert alert-warning"><?php echo $errorMessage; ?></div>
	  		<?php 
		  		$isError = false;
		  		$errorMessage = "";
		  		endif 
	  		?>
	  		<div class="form-group">
			    <label for="category" class="col-sm-3 control-label">Category</label>
			    <div class="col-sm-9">
				    <select name="category" class="form-control">
						<option value="">--- Select Category ---</option>
						<?php foreach ($categoryList as $key => $category): ?>
							<option value="<?php echo $category["catId"]; ?>"><?php echo $category["catName"]; ?></option>
						<?php endforeach ?>
					</select>
			    </div>
			</div>

		<div class="form-group">
			<label for="postTitle" class="col-sm-3 control-label">Title</label>
			<div class="col-sm-9">
				<input type="text" name="postTitle" class="form-control" id="postTitle" placeholder="Find me">
			</div>
		</div>

		<div class="form-group">
			<label for="postContent" class="col-sm-3 control-label">Description</label>
			<div class="col-sm-9">
				<textarea name="postContent" class="form-control" rows="5" placeholder="Description"></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="checkbox col-sm-8" style="margin-left:15px">
				<label class="addbountycheckbox">
				<input type="checkbox" name="hasReward" value="1">
				Add Bounty to your post 
				<a class="qmarks" href="#"><img src="<?php echo Yii::app()->request->baseUrl; ?>/dist/images/qmark.png" width="18" height="18">
	                <span>By adding bounty, your post will be on top of the search list. The higher the bounty, the higher the priority.</span>
	            </a>
				</label>
			</div>
		</div>
		<?php if (count($wallets) > 0): ?>
			<div class="form-group bounty-field">
				<label for="walletType" class="col-sm-3 control-label">Wallet Type</label>
				<div class="col-sm-9">
					<select name="walletType" class="form-control">
						<option value="">-Select-</option>
						<?php foreach ($wallets as $key => $wallet): ?>
							<option value='<?php echo $wallet->wallet_id; ?>' data-wallet='<?php echo json_encode($wallet); ?>'><?php echo $wallet->wallet_name; ?></option>
						<?php endforeach ?>
					</select>
				</div>
			</div>

			<div class="form-group bounty-field">
				<label for="amount" class="col-sm-3 control-label">Bounty</label>
				<div class="col-sm-9">
					<input type="text" name="amount" class="form-control" id="amount" placeholder="Bounty Amount">
					<p style="padding-top:10px;"><small><a href="http://tagbond.com/site/rewards" target="_blank">Click here for more information</a></small></p>
				</div>
			</div>
		<?php else: ?>
			<div class="form-group bounty-field">
				<div class="col-sm-9">
					<p style="padding-top:10px;"><small><a href="">Click here for more information</a></small></p>
				</div>
			</div>
		<?php endif ?>

		<div class="form-group">
			<label for="tokenfield" class="col-sm-3 control-label">Tag</label>
			<div class="col-sm-9">
				<input type="text" name="tag" class="form-control" id="tokenfield" placeholder="Type Something and hit Enter">
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-3 control-label"></label>
			<div class="col-sm-9">
				<button type="submit" class="btn btn-default">Submit</button>
			</div>
		</div>

		</form>
	  </div>

