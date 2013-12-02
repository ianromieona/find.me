<?php 
	class ThreadController extends Controller {
	   public function filters()
	    {
	        return array( 'accessControl' ); // perform access control for CRUD operations
	    }
	 
	    public function accessRules()
	    {
	        return array(
	            array('allow', // allow authenticated users to access all actions
	            	'actions' => array('index','user','tag','status'),
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

			if(isset($_GET['search'])){
				$params=$_GET;
				if($params['searchType']=="tag"){
					$threads=TagRel::searchByTag($params['searchKey']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="cat"){
					$threads=CategoryRel::searchByCategory($params['searchKey2']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="key"){
					$threads=PostTable::searchByKey($params['searchKey']);
					// Common::pre($result['data'],true);
				}
			}
			else{
				$threads = PostTable::showAllThread();
			}
			$cat = CategoryTable::model()->findAll();
			$this->render('index', array('threads' => $threads,'cat'=>$cat));
		}

		public function actionUser($id){
			if(isset($_GET['search'])){
				$params=$_GET;
				if($params['searchType']=="tag"){
					$threads=TagRel::searchByTag($params['searchKey']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="cat"){
					$threads=CategoryRel::searchByCategory($params['searchKey2']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="key"){
					$threads=PostTable::searchByKey($params['searchKey']);
					// Common::pre($result['data'],true);
				}
			}
			else{
				$threads = PostTable::getFilterPost($id,'user');
			}
			
			$cat = CategoryTable::model()->findAll();			
			// Common::pre($threads,true);
			$this->render('index', array('threads' => $threads, 'cat' => $cat));
		}

		public function actionTag($id){
			if(isset($_GET['search'])){
				$params=$_GET;
				if($params['searchType']=="tag"){
					$threads=TagRel::searchByTag($params['searchKey']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="cat"){
					$threads=CategoryRel::searchByCategory($params['searchKey2']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="key"){
					$threads=PostTable::searchByKey($params['searchKey']);
					// Common::pre($result['data'],true);
				}
			}
			else{
				$threads = PostTable::getFilterPost($id,'tag');
			}
			$cat = CategoryTable::model()->findAll();
			// Common::pre($threads,true);
			$this->render('index', array('threads' => $threads, 'cat' => $cat));
		}

		public function actionStatus($id){
			if(isset($_GET['search'])){
				$params=$_GET;
				if($params['searchType']=="tag"){
					$threads=TagRel::searchByTag($params['searchKey']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="cat"){
					$threads=CategoryRel::searchByCategory($params['searchKey2']);
					// Common::pre($result,true);
				}

				else if($params['searchType']=="key"){
					$threads=PostTable::searchByKey($params['searchKey']);
					// Common::pre($result['data'],true);
				}
			}
			else{
				$threads = PostTable::getFilterPost($id,'status');
			}
			
			$cat = CategoryTable::model()->findAll();
			// Common::pre($threads,true);
			$this->render('index', array('threads' => $threads, 'cat' => $cat));
		}
	}
?>