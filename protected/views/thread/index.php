<div id="thread-content">
	<div class="container">
		<div class="row">
			<form method="GET">
			  	<div class="col-lg-2">
			  		<select class="form-control" name="searchType">
				  		<option value="key" <?php echo ((isset($_GET['searchType'])?$_GET['searchType']:'')=='key')?'selected':''; ?>>Keywords</option>
				  		<option value="tag" <?php echo ((isset($_GET['searchType'])?$_GET['searchType']:'')=='tag')?'selected':''; ?>>Tags</option>
				  		<option value="cat" <?php echo ((isset($_GET['searchType'])?$_GET['searchType']:'')=='cat')?'selected':''; ?>>Categories</option>
					</select>
			  	</div>
			  	<div class="col-lg-6">
		    		<input type="text" <?php echo ((isset($_GET['searchType'])?$_GET['searchType']:'')!='cat')?'':"style='display:none'"; ?> class="form-control" name="searchKey" id="inputKey" value="<?php echo isset($_GET['searchKey'])?$_GET['searchKey']:''; ?>">
		  			<select name="searchKey2" class="form-control" id="dropKey" <?php echo ((isset($_GET['searchType'])?$_GET['searchType']:'')=='cat')?'':"style='display:none'"; ?>>
		  				<option value="">All</option>
		  				<?php foreach($cat as $val){ ?>
		  					<option <?php echo ((isset($_GET['searchKey2'])?$_GET['searchKey2']:'')==$val['catId'])?'selected':''; ?> value="<?php echo $val['catId']; ?>"><?php echo $val['catName']; ?></option>
		  				<?php } ?>
		  			</select>
			  	</div><!-- /.col-lg-12 -->
			  	<div class="col-lg-4">
			  		<input type="submit" class="btn btn-search" name="search" value="Search"> &nbsp;or&nbsp;
			  		<a href="<?php echo Yii::app()->createUrl('post/add'); ?>" type="button" class="btn" />Create a Find.me Post</a>
			  	</div>
			</form>
		</div><!-- /.row -->

		<div class="threads">
			<table class="table table-hover">
			  <!-- <thead>
			  	<tr>
			  		<td>Answers</td>
			  		<td>Views</td>
			  		<td></td>
			  	</tr>
			  </thead> -->
			  <tbody>
			  	<?php if(!empty($threads['data'])):?>
			  		<?php foreach ($threads['data'] as $key => $value) { ?>
			  			<tr>
			  				<td class="text-center"><?php echo PostTable::getAnswersPostCount($value['postId']);?><br /><small>answers</small></td>
			  				<td class="text-center"><?php echo PostTable::getViewsPostCount($value['postId']);?><br /><small>views</small></td>
			  				<td>
			  					<a href="<?php echo Yii::app()->createUrl('post/' . $value['postId']); ?>"><?php ;if($value['value'] > 0){ echo "<strong>";}?><?php echo $value['postTitle'];?></a><?php if($value['value'] > 0){ echo "</strong>";}?> <?php if($value['value'] > 0):?><span class="label label-warning"><?php echo $value['value'];?> bounty</span><?php endif;?><br />
			  					<small><?php echo $value['userName']; ?> &nbsp;<span><?php echo date('M d,Y H:i a', strtotime($value['postDate']));?></span></small>
			  				</td>
			  				<td class="text-center thread-status">
			  					<?php if($value['status']):?>
			  						<a href="<?php echo Yii::app()->createURL('/thread/status/1'); ?>" class="btn btn-default btn-xs">resolved</a>
			  					<?php else:?>
			  						<a href="<?php echo Yii::app()->createURL('/thread/status/0'); ?>" class="btn btn-primary btn-xs">active</a>
			  					<?php endif;?>
			  				</td>
			  			</tr>
			  		<?php }?>
			  	<?php endif; // end if !empty threads ?>
			  	</tbody>
			</table>
		</div>
		<?php if($threads['pages']!=" "){ ?>
		<div class="widget-content padded text-center">
	            <?php
	            	if(isset($_GET['search'])){
		            	$threads['pages']->params = array('searchType'=>isset($_GET['searchType'])?$_GET['searchType']:'',
		            		'searchKey'=>isset($_GET['searchKey'])?$_GET['searchKey']:'',
		            		'search'=>isset($_GET['search'])?$_GET['search']:'');
		            }	
	            	$this->widget('CLinkPager', array(
	                    'pages'         =>  $threads['pages'],
	                    'header'        =>  '',
	                    'nextPageLabel' =>  Yii::t('yii','Next →'),
	                    'prevPageLabel' =>  Yii::t('yii','← Prev'),
	                    'htmlOptions'=>array('class'=>'pagination'),
	                )) ?>
	        </div>
	    <?php } ?>
	</div>
</div><!-- end #thread-content -->