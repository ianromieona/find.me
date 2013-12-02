<?php

/**
* 
*/
class FindController extends Controller
{
	   public function filters()
	    {
	        return array( 'accessControl' ); // perform access control for CRUD operations
	    }
	 
	    public function accessRules()
	    {
	        return array(
	            array('allow', // allow authenticated users to access all actions
	            	'actions' => array('index','add','edit','delete'),
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
		if(isset($_POST['find']['search'])){
			$params=$_POST['find'];
			if($params['searchType']=="tag"){
				$result=TagRel::searchByTag($params['searchKey']);
				// Common::pre($result,true);
			}

			else if($params['searchType']=="cat"){
				$result=CategoryRel::searchByCategory($params['searchKey']);
				// Common::pre($result,true);
			}

			else if($params['searchType']=="key"){
				$result=PostTable::searchByKey($params['searchKey']);
				// Common::pre($result['data'],true);
			}
		}
		$this->render("view",array('result' => $result));
	}

	public function actionAdd(){
	}

	public function actionEdit(){
		
	}

	public function actionDelete(){
		
	}

}

?>