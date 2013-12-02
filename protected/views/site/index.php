<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>
<div class="jumbotron-index">
	<div class="container">
		<div id="intro-slides" class="carousel slide" data-ride="carousel">
			<div class="carousel-inner">

				<div class="item active">
					Search, Find and Hunt
				</div><!-- end item -->
				<?php foreach ($featured as $key => $value) { ?>
					<div class="item">
						<?php echo $value['postTitle'];?>
					</div><!-- end item -->
				<?php } ?>
			</div><!-- end .carousel-inner -->

			<!-- Indicators -->
			<ol class="carousel-indicators">
				<li data-target="#intro-slides" data-slide-to="0" class="active"></li>
				<?php for ($i=1; $i <=count($featured) ; $i++) { ?>
					<li data-target="#intro-slides" data-slide-to="<?php echo  $i;?>"></li>
				<?php } ?>
			</ol>

		</div><!-- end #intro-slides -->
	</div>
	<div class="clear"></div>
</div><!-- end .jumbotron-index -->
<div id="home-content">
	<div class="container">
		<div class="row">
			<div class="col-md-4">
				<div>
					<h3>Be a Searcher!</h3>
					<p>
						Looking for something but doesn't have time to search? Let others find it for you. </p>
						<p><b>Find.me</b> provides a community where you can meet persons who can suggest the right answer to what you need.</p>
						<p>Post. Find a finder. Be satisfied. Be a searcher!</p>
				</div>
			</div>
			<div class="col-md-4">
				<div>
					<h3>Be a Finder!</h3>
					<p>Give them the satisfaction they deserve. </p>
					<p><b>Find.me</b> helps you find friends by providing ways of helping them. Just answer a non-reward post and be chosen as the best finder to earn a step towards becoming a master finder</p>
					<p>Be famous! Be a good samaritan! Be a finder!</p>
				</div>
			</div>
			<div class="col-md-4">
				<div>
					<h3>Be a Hunter!</h3>
					<p>Give them the satisfaction they deserve and earn what you deserve. </p>
					<p><b>Find.me</b> is a good place for treasure hunters. Just answer a post with bounty, be selected as the best hunter, and get the corresponding reward.</p>
					<p>Provide satisfaction. Be satisfied. Earn.</p>
				</div>
			</div>
		</div>
	</div>
</div>