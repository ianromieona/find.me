<?php 

class PostController extends Controller
{
    public function filters()
    {
        return array( 'accessControl' ); // perform access control for CRUD operations
    }
 
    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated users to access all actions
            	'actions' => array('view','add','edit','delete','comment','check','save'),
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
	public function actionView($id){
		$tags = TagTable::getPostTags($id);
		$postDetails = PostTable::getPostDetails($id);
		$getWalletinfo = Common::getWalletDetails($postDetails['walletType']);
		$postAuthor = PostTable::getPostAuthor($id);
		if($postAuthor){
			if(Yii::app()->user->userId!=$postAuthor['userId']){
				PostTable::addViewtoPost($postAuthor['postId']);
			}
		}
		$postComments = PostTable::getPostComments($id);
		$this->render("view",array('post'=>$postDetails,'author'=>$postAuthor,'comments'=>$postComments,'tags'=>$tags,'walletinfo'=>$getWalletinfo));
	}

	public function actionAdd(){
		$categoryList = CategoryTable::model()->findAll();
		

		$wallets = Common::getAllWallets();
		$this->render("add", array("categoryList" => $categoryList, "wallets" => $wallets));	
	}

	public function actionEdit(){
		
	}

	public function actionDelete(){
		
	}
	public function actionComment(){
		if($_POST['btnComment']){
			$comment = new PostTable;
			$comment->postType = "answer";
			$comment->postTitle = "";
			$comment->postContent = $_POST['content'];
			$comment->userId = Yii::app()->user->userId;
			$comment->status = 0;
			$comment->postDate = date('Y-m-d H:i:s');
			if($comment->save(false)){
				$rlsp = new PostRelationship;
				$rlsp->postId = $comment->postId;
				$rlsp->parentId = $_POST['postId'];
				$rlsp->save(false);
			}

		}
		$this->redirect(array('post/'.$_POST['postId']));
	}
	public function actionCheck($id){
		if($id){
			$check = PostTable::model()->findByPk($_GET['postId']);
			$check->status = 1;
			if($check->save(false)){
				$checkThis = PostTable::model()->findByPk($id);
				 $checkThis->status = 1;
				if($checkThis->save(false)){
					$meta = PostMeta::model()->findByAttributes(array('post_table_postId'=>$_GET['postId']));
					if($meta){
						if($meta['key']=="bounty"){
							if($checkThis->walletType!=0){
								$getUser=UserTable::model()->findByPk($checkThis->userId);
								if(Common::transfer($meta['value'],$getUser['tagbond_id'],$check->walletType)){
									Yii::app()->user->setFlash('msg', 'Transfer successful.');
									Yii::app()->user->setFlash('msgClass', 'alert alert-success');
								}else{
									Yii::app()->user->setFlash('msg', 'Transfer error.');
									Yii::app()->user->setFlash('msgClass', 'alert alert-error');
								}
							}
						}
					}
				}
			}
		}

		$this->redirect(array('post/'.$_GET['postId']));
	}
	public function actionSave(){
		$formdata = serialize($_POST);
		$formdata = unserialize($formdata);
		$formdata["category"];
		
		$post 		 = new PostTable;
		$user 		 = Yii::app()->user;

		$post->postType    = $formdata["postType"];
		$post->postTitle   = $formdata["postTitle"];
		$post->postContent = $formdata["postContent"];
		$post->postDate    = date("Y-m-d H:i:s");
		$post->userId 	   = $user->userId;
		$errorMessage	   = "";
		
		if($post->save(false)){
			
			$isError = false;
			$categoryRel = new CategoryRel;
			$categoryRel->postId = $post->postId;
			$categoryRel->catId = $formdata["category"];
			$categoryRel->save(false);
			
			$formTag = strtolower($formdata["tag"]);
			$formTag = explode(',', $formTag);
			if(!empty($formTag)){
				foreach ($formTag as $tag_key => $tag_value) {
					$tag = TagTable::model()->findByAttributes(array("tagName"=> $tag_value));
					if(!$tag){
						$tag = new TagTable;
						$tag->tagName = $tag_value;
						$tag->save(false);
					}

					$tagRel		 = new TagRel;
					$tagRel->postId = $post->postId;
					$tagRel->tagId 	= $tag->tagId;
					$tagRel->save(false);
				}
			}
			
			$postMeta = new PostMeta;
			$postMeta->post_table_postId = $post->postId;
			$postMeta->key = "bounty";
			$postMeta->value = "0";
			if(isset($formdata["hasReward"]) && isset($formdata["walletType"])){
				$wallet = Common::getWalletDetails($formdata["walletType"]);
				if($wallet["amount"] > 0 && $formdata["amount"] < $wallet["amount"]){
					
					$formPoints      = $formdata["amount"];
					$postMeta->value =  $formPoints;
					$postMeta->save();

					$post->walletType = $formdata["walletType"];
					$post->save();
				}else{
					$isError=true;
					$errorMessage = "Reward points exceeds allowable amount.";
				}
			}
			if(!$isError){
				$logs =  new LogsTable;
				$logs->logDetails = "created a post";
				$logs->dateTime   = date("Y-m-d H:i:s");
				$logs->postId 	  = $post->postId;
				$logs->userId	  = $user->userId;
				$logs->save();
				$this->redirect($this->createUrl("thread/index"));
			}else{
				$categoryList = CategoryTable::model()->findAll();
				$wallets = Common::getAllWallets();
				$this->render('add', array("categoryList" => $categoryList, "wallets" => $wallets, "isError"=>$isError, "errorMessage"=>$errorMessage));
			}

		}

	}

}

?>