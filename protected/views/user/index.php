<?php
$sbadge = intval($sbadge);
$fbadge = intval($fbadge);
$hbadge = intval($hbadge);

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
?>
<div id="user-page">
	<div class="container">
		<div class="row"><br />
			<h4>Your Profile Info</h4><br />
			<div class="col-lg-12">

				<div class="panel-group" id="accordion">
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
				          Badges
				        </a>
				      </h4>
				    </div>
				    <div id="collapseOne" class="panel-collapse collapse in">
				      <div class="panel-body">
				      	<?php if(!empty($searcher) || !empty($finder) || !empty($hunter) ): ?>
				      		<?php if($searcher > 0):?>
				      			<?php foreach ($searcher as $skey => $svalue) { 
				      				if(in_array($sbadge, $svalue)){ ?>
				      					<i class="icon-eye badge-<?php echo $skey;?>"></i>
				      				<?php } ?>
				      			<?php } ?>
				      		<?php endif;?>

				      		<?php if($finder > 0):?>
				      			<?php foreach ($finder as $fkey => $fvalue) { 
				      				if(in_array($fbadge, $fvalue)){ ?>
				      					<i class="icon-bullseye badge-<?php echo $fkey;?>"></i>
				      				<?php } ?>
				      			<?php } ?>
				      		<?php endif;?>

				      		<?php if($hunter > 0):?>
				      			<?php foreach ($hunter as $hkey => $hvalue) { 
				      				if(in_array($hbadge, $hvalue)){ ?>
				      					<i class="icon-award badge-<?php echo $hkey;?>"></i>
				      				<?php } ?>
				      			<?php } ?>
				      		<?php endif;?>

				      	<?php else: ?>
				      	 You have no badges yet.
				  		<?php endif;?>
				      </div>
				    </div>
				  </div>

				<div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
				          Your Latest Searches
				        </a>
				      </h4>
				    </div>
				    <div id="collapseTwo" class="panel-collapse collapse">
				      <div class="panel-body">
				      	<?php if($posts){?>
							<?php foreach ($posts as $pkey => $pvalue) { 
								if(!empty($pvalue['postTitle'])) :?>
								<p><a href="<?php echo $this->createUrl('post/'. $pvalue['postId'])?>"><?php echo $pvalue['postTitle'];?></a> - <small class="text-muted"><?php echo date('M d,Y H:i a', strtotime($pvalue['postDate']));?></small></p>
							<?php endif; } ?>
						<?php } ?>
				      </div>
				    </div>
				  </div>

				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title">
				        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
				          Your Latest Comments
				        </a>
				      </h4>
				    </div>
				    <div id="collapseThree" class="panel-collapse collapse">
				      <div class="panel-body">
				      	<?php if($comments){?>
							<?php foreach ($comments as $key => $value) { 
								if(!empty($value['postTitle'])) :?>
								<p><a href="<?php echo $this->createUrl('post/'.$value['postId'])?>"><?php echo $value['postTitle'];?></a> - <small class="text-muted"><?php echo date('M d,Y H:i a', strtotime($value['postDate']));?></small></p>
							<?php endif; } ?>
						<?php } ?>
				      </div>
				    </div>
				  </div>

				</div>
			</div>
		</div>
	</div>
</div>