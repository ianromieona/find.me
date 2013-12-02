<?php
	class UserController extends Controller {
	   public function filters()
	    {
	        return array( 'accessControl' ); // perform access control for CRUD operations
	    }
	 
	    public function accessRules()
	    {
	        return array(
	            array('allow', // allow authenticated users to access all actions
	            	'actions' => array('index'),
	            ),
	            array('deny'),
	        );
	    }
	    public function beforeAction($action){
	        if(Yii::app()->user->isGuest){
	        	$this->redirect(Yii::app()->homeUrl);
	        }
	        return true;
	    }
		public function actionIndex(){
			$sbadge = UserTable::getSearcherBadge();
			$fbadge = UserTable::getFinderBadge();
			$hbadge = UserTable::getHunterBadge();
			$posts = UserTable::getAllPosts();
			$comments = UserTable::getAllComments();
			$this->render('index',array('posts'=>$posts,'comments'=>$comments,'sbadge'=>$sbadge,'fbadge'=>$fbadge,'hbadge'=>$hbadge));
		}
	}

?>