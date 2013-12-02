<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo $this->createUrl('site/index'); ?>">Find.me</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
            <?php ; ?>
                <li <?php echo (Yii::app()->controller->id=='site')?'class="active"':''; ?>><a href="<?php echo $this->createUrl('site/index'); ?>">Home</a></li>
                <?php if(Yii::app()->user->isGuest){ }else{?>
                <li <?php echo (Yii::app()->controller->id=='thread')?'class="active"':''; ?>><a href="<?php echo $this->createUrl('thread/index'); ?>">Discover</a></li>
                <?php } ?>
            </ul>
            <?php if(Yii::app()->user->isGuest){ ?>
                <span class="pull-right" ><a href="https://api.tagbond.com/oauth?client_id=<?php echo Yii::app()->params['client_id']; ?>&redirect_uri=<?php echo Yii::app()->params['redirect_uri'];?>&state=<?php echo Yii::app()->params['state']?>&response_type=code&scope=user.credits%20user.settings%20user.contacts%20user.profiles" class="loginTagbond btn btn-primary">Login with Tagbond</a></span>
            <?php }else{ ?>
                <span class="pull-right" ><a href="<?php echo $this->createUrl('site/logout') ?>" class="logoutTagbond btn btn-danger"><i class="glyphicon glyphicon-off"></i></a></span><label class="tagbondName pull-right"><a href="<?php echo $this->createUrl('user/index');?>"><?php echo Yii::app()->user->userFirstname.' '.Yii::app()->user->userLastname;?></a></label>
            <?php } ?>
        </div><!--/.nav-collapse -->
    </div>
</div>