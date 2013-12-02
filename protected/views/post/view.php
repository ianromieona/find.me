<?php 
$searcher = array();
$searcher['blue'] = range(1,50);
$searcher['green'] = range(51,150);
$searcher['orange']= range(151,300);
$searcher['red'] = range(301,600);
$searcher['black'] = range(601, 1000);

$finder = array();
$finder['bronze'] = range(1,100);
$finder['silver'] = range(101,200);
$finder['gold'] = range(201,500);

$hunter = array();
$hunter['gray'] = range(1,50);
$hunter['silver'] = range(51,150);
$hunter['yellow'] = range(151,300);
$hunter['gold'] = range(301, 500);

if(Yii::app()->user->hasFlash('msg')): ?>
	<div class="<?php echo Yii::app()->user->getFlash('msgClass'); ?>">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<?php echo '<i class="icon-info-sign"> </i>'.Yii::app()->user->getFlash('msg') ?>
	</div>
<?php endif; ?>
<div class="container">
	<div class="row" >
		<div class="col-md-12">
			<div id="post" class="post-box"><br />
				<div class="header">
					<h4><?php echo $post['postTitle']?> <?php if($post['value'] > 0):?><span class="label label-warning"><?php echo $post['value'];?> bounty - <?php echo $walletinfo['currency'];?></span><?php endif;?></h4>
					<small class="text-muted"><?php echo date("F jS, Y H:i a", strtotime($post['postDate']));?></small>
				</div>

				<div class="row question-box">
					<div class="col-md-1 text-center">
						<p><strong><?php echo $author['userName'];?></strong></p>
						<?php if($searcher > 0):?>
			      			<?php foreach ($searcher as $skey => $svalue) { 
			      				if(in_array(UserTable::getSearcherBadge($author['userId']), $svalue)){ ?>
			      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Posts between <?php echo min($searcher[$skey]);?> to <?php echo max($searcher[$skey]);?> items"><i class="icon-eye badge-<?php echo $skey;?>"></i></a>
			      				<?php } ?>
			      			<?php } ?>
			      		<?php endif;?>
			      		<?php if($finder > 0):?>
			      			<?php foreach ($finder as $fkey => $fvalue) { 
			      				if(in_array(UserTable::getSearcherBadge($author['userId']), $fvalue)){ ?>
			      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Answers between <?php echo min($finder[$fkey]);?> to <?php echo max($finder[$fkey]);?> items"><i class="icon-bullseye badge-<?php echo $fkey;?>"></i></a>
			      				<?php } ?>
			      			<?php } ?>
			      		<?php endif;?>
			      		<?php if($hunter > 0):?>
			      			<?php foreach ($hunter as $hkey => $hvalue) { 
			      				if(in_array(UserTable::getSearcherBadge($author['userId']), $hvalue)){ ?>
			      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Bounty answers between <?php echo min($hunter[$hkey]);?> to <?php echo max($hunter[$hkey]);?> items"><i class="icon-award badge-<?php echo $hkey;?>"></i></a>
			      				<?php } ?>
			      			<?php } ?>
			      		<?php endif;?>
					</div>
					<div class="col-md-11">
						<?php echo $post['postContent']?> <!--span class="muted"><?php echo date('M d,Y H:i a', strtotime($post['postDate']));?></span--> <br />
						<?php if($tags){ ?>
							<p class="post-tags">Tags: 
								<?php foreach ($tags as $key => $value) { ?>
									<a href="<?php echo $this->createUrl('thread/tag',array('id'=>$value['tagId']));?>"><?php echo $value['tagName'];?></a>
								<?php } ?>
							</p>
						<?php } ?>
					</div>
				</div>

			</div>
			<h3 class="text-info">Answers:</h3>
			<?php if(Yii::app()->user->userId != $author['userId']){?>
				<?php if(!$post['status']){?>
					<form action="<?php echo $this->createUrl('post/comment')?>" method="post" class="form-horizontal">
						<textarea id="" class="form-control input-block-level" name="content" rows="5"></textarea>
						<input type="hidden" value="<?php echo $_GET['id'];?>" name='postId'><br />
						<button type="submit" class="btn btn-primary pull-right" name="btnComment" value="comment">Post this answer</button>
						<div class="clear"></div>
					</form>
				<?php } ?>
			<?php } ?>
			<?php if($comments){ $count = 0;?>
				<?php foreach ($comments as $key => $value) { $alt = $count%2;?>
					<div class="row comment-box comment-alt-<?php echo $alt;?>">
						<?php if($alt>0):?>
							<div class="col-md-1 text-center">
								<p><strong><?php echo $value['userName'];?></strong></p>
								<?php if($searcher > 0):?>
					      			<?php foreach ($searcher as $skey => $svalue) { 
					      				if(in_array(UserTable::getSearcherBadge($value['userId']), $svalue)){ ?>
					      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Posts between <?php echo min($searcher[$skey]);?> to <?php echo max($searcher[$skey]);?> items"><i class="icon-eye badge-<?php echo $skey;?>"></i></a>
					      				<?php } ?>
					      			<?php } ?>
					      		<?php endif;?>
					      		<?php if($finder > 0):?>
					      			<?php foreach ($finder as $fkey => $fvalue) { 
					      				if(in_array(UserTable::getSearcherBadge($value['userId']), $fvalue)){ ?>
					      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Answers between <?php echo min($finder[$fkey]);?> to <?php echo max($finder[$fkey]);?> items"><i class="icon-bullseye badge-<?php echo $fkey;?>"></i></a>
					      				<?php } ?>
					      			<?php } ?>
					      		<?php endif;?>
					      		<?php if($hunter > 0):?>
					      			<?php foreach ($hunter as $hkey => $hvalue) { 
					      				if(in_array(UserTable::getSearcherBadge($value['userId']), $hvalue)){ ?>
					      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Bounty answers between <?php echo min($hunter[$hkey]);?> to <?php echo max($hunter[$hkey]);?> items"><i class="icon-award badge-<?php echo $hkey;?>"></i></a>
					      				<?php } ?>
					      			<?php } ?>
					      		<?php endif;?>
							</div>
						<?php endif;?>
						<div class="col-md-11">
							<?php echo $value['postContent']?> <br />
							<p class="comment-date">Posted: <?php echo date('M d,Y H:i a', strtotime($value['postDate']));?></p>
						</div>
						<?php if($alt==0):?>
							<div class="col-md-1 text-center">
								<p><strong><?php echo $value['userName'];?></strong></p>
								<?php if($searcher > 0):?>
					      			<?php foreach ($searcher as $skey => $svalue) { 
					      				if(in_array(UserTable::getSearcherBadge($value['userId']), $svalue)){ ?>
					      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Posts between <?php echo min($searcher[$skey]);?> to <?php echo max($searcher[$skey]);?> items"><i class="icon-eye badge-<?php echo $skey;?>"></i></a>
					      				<?php } ?>
					      			<?php } ?>
					      		<?php endif;?>
					      		<?php if($finder > 0):?>
					      			<?php foreach ($finder as $fkey => $fvalue) { 
					      				if(in_array(UserTable::getSearcherBadge($value['userId']), $fvalue)){ ?>
					      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Answers between <?php echo min($finder[$fkey]);?> to <?php echo max($finder[$fkey]);?> items"><i class="icon-bullseye badge-<?php echo $fkey;?>"></i></a>
					      				<?php } ?>
					      			<?php } ?>
					      		<?php endif;?>
					      		<?php if($hunter > 0):?>
					      			<?php foreach ($hunter as $hkey => $hvalue) { 
					      				if(in_array(UserTable::getSearcherBadge($value['userId']), $hvalue)){ ?>
					      				<a href="#" class="has-tooltip" data-toggle="tooltip" title="Bounty answers between <?php echo min($hunter[$hkey]);?> to <?php echo max($hunter[$hkey]);?> items"><i class="icon-award badge-<?php echo $hkey;?>"></i></a>
					      				<?php } ?>
					      			<?php } ?>
					      		<?php endif;?>
							</div>
						<?php endif;?>
						<?php if(!$post['status'] ){ ?>
							<?php if(Yii::app()->user->userId == $author['userId']){?>
								<a href="<?php echo $this->createUrl('post/check',array('id'=>$value['postId'],'postId'=>$_GET['id']))?>" data-toggle="tooltip" title="Mark as correct answer" class="has-tooltip btn btn-danger pull-left answer-button" onclick="if(!confirm('Are you sure about this answer? \n There is no turning back once you confirm ')){return false;}">
									<i class="icon-star"></i>
								</a>
							<?php } ?>
						<?php }else{ ?>
								<?php if ($value['status']) { ?>
										<span class="correct-answer"><i class="icon-star"></i></span>
								<?php } ?>
						<?php } ?>

					</div>

				<?php $count++;} ?>
			<?php }else{?> <br />
				<div class="alert alert-warning fade in">
			        <strong>No comments yet...</strong> 
			      </div>
			<?php } ?>
		</div>
	</div>
</div>