<?php

/**
 * This is the model class for table "post_table".
 *
 * The followings are the available columns in table 'post_table':
 * @property integer $postId
 * @property string $postType
 * @property string $postTitle
 * @property string $postContent
 * @property string $postDate
 * @property integer $userId
 *
 * The followings are the available model relations:
 * @property CategoryRel[] $categoryRels
 * @property LogsTable[] $logsTables
 * @property PostRelationship[] $postRelationships
 * @property PostRelationship[] $postRelationships1
 * @property UserTable $user
 * @property TagRel[] $tagRels
 * @property TransactionTable[] $transactionTables
 */
class PostTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'post_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('postType', 'length', 'max'=>200),
			array('postTitle, postContent, postDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('postId, postType, postTitle, status,postContent, postDate,walletType , postView, userId', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'categoryRels' => array(self::HAS_MANY, 'CategoryRel', 'postId'),
			'logsTables' => array(self::HAS_MANY, 'LogsTable', 'postId'),
			'postRelationships' => array(self::HAS_MANY, 'PostRelationship', 'postId'),
			'postRelationships1' => array(self::HAS_MANY, 'PostRelationship', 'parentId'),
			'user' => array(self::BELONGS_TO, 'UserTable', 'userId'),
			'tagRels' => array(self::HAS_MANY, 'TagRel', 'postId'),
			'transactionTables' => array(self::HAS_MANY, 'TransactionTable', 'postId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'postId' => 'Post',
			'postType' => 'Post Type',
			'postTitle' => 'Post Title',
			'postContent' => 'Post Content',
			'postDate' => 'Post Date',
			'userId' => 'User',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('postId',$this->postId);
		$criteria->compare('postType',$this->postType,true);
		$criteria->compare('postTitle',$this->postTitle,true);
		$criteria->compare('postContent',$this->postContent,true);
		$criteria->compare('postDate',$this->postDate,true);
		$criteria->compare('userId',$this->userId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PostTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function showAllThread(){
		$model = Yii::app()->db->createCommand()
			->select("*")
			->from('post_table t1')
			->leftJoin('post_meta t2','t2.post_table_postId = t1.postId')
			->leftJoin('user_table t5','t5.userId = t1.userId')
			->where('t1.postType =:type',array(':type'=>'post'))
			->order('t2.value DESC, t1.postDate DESC, t1.status ASC ');

		$countQuery = clone $model;

		$countQuery->select('count(*) as count');
		$count = $countQuery->queryScalar();
		$pages = new CPagination($count);
		// $pages->pageSize = Yii::app()->params['pageSize']; // results per page
		$pages->pageSize = 15;
		$pages->pageVar = "thread";
		$pages->params = array("tab"=>"thread");
		//$offset=$pages->getOffset();
		//$limit=$pages->getLimit();
		$model->limit($pages->getLimit(),$pages->getOffset());

		$data = $model->queryAll();

		$result = array('data'=>$data,'pages'=>$pages,"count"=>$count);

		return $result;
	}

	public static function showThread($status){
		$model = Yii::app()->db->createCommand()
			->select("*")
			->from('post_table t1')
			->leftJoin('post_meta t2','t2.post_table_postId = t1.postId')
			->leftJoin('user_table t5','t5.userId = t1.userId')
			->where('t1.status =:status',array(':status'=>$status))
			->andWhere('t1.postType =:type',array(':type'=>'post'))
			->order('t2.value DESC, t1.postDate DESC, t1.status ASC ');
			
		$countQuery = clone $model;
		$countQuery->select('count(*) as count');
		$count = $countQuery->queryScalar();
		$pages = new CPagination($count);
		// $pages->pageSize = Yii::app()->params['pageSize']; // results per page
		$pages->pageSize = 15;
		$pages->pageVar = "thread";
		$pages->params = array("tab"=>"thread");
		//$offset=$pages->getOffset();
		//$limit=$pages->getLimit();
		$model->limit($pages->getLimit(),$pages->getOffset());

		$data = $model->queryAll();

		$result = array('data'=>$data,'pages'=>$pages,"count"=>$count);

		return $result;

	}
	public static function searchByKey($params){
		$model = Yii::app()->db->createCommand()
				->select('t1.*,t4.value,t5.userName,t5.userId')
				->from('post_table t1')
				->leftJoin('tag_rel t2','t2.postId = t1.postId')
				->leftJoin('tag_table t3','t3.tagId = t2.tagId')
				->leftJoin('post_meta t4','t4.post_table_postId = t1.postId')
				->leftJoin('user_table t5','t5.userId = t1.userId')
				->where('t1.postTitle LIKE :name',array(':name'=>'%'.$params.'%'))
				->orWhere('t1.postContent LIKE :name',array(':name'=>'%'.$params.'%'))
				->orWhere('t3.tagName LIKE :name',array(':name'=>'%'.$params.'%'))
				->andWhere('t1.postType =:type',array(':type'=>'post'))
				->order('t4.value DESC, t1.postDate DESC, t1.status ASC ')
				->group('t1.postId');

		$countQuery = clone $model;
		$countQuery->select('count(*) as count');
		$count = $countQuery->queryScalar();
		$pages = new CPagination($count);
		// $pages->pageSize = Yii::app()->params['pageSize']; // results per page
		$pages->pageSize = 15;
		$pages->pageVar = "key";
		$pages->params = array("tab"=>"key");
		//$offset=$pages->getOffset();
		//$limit=$pages->getLimit();
		$model->limit($pages->getLimit(),$pages->getOffset());

		$data = $model->queryAll();

		$result = array('data'=>$data,'pages'=>$pages,"count"=>$count);

		return $result;
	}
	public static function getPostDetails($id){

		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('post_meta t2','t2.post_table_postId = t1.postId')
			->where('t1.postId=:id',array(':id'=>$id))
			->queryAll();
		if($query){
			return $query[0];
		}
		throw new Exception("Post missing", 1);
	}

	public static function getPostAuthor($id){
		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('user_table t2','t2.userId = t1.userId')
			->where('t1.postId=:id',array(':id'=>$id))
			->andWhere('t1.postType =:type',array(':type'=>'post'))
			->queryAll();
		if($query){
			return $query[0];
		}
		throw new Exception("Post missing", 1);	
	}

	public static function getPostComments($id){
		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('post_relationship t2','t2.parentId = t1.postId')
			->leftJoin('post_table t3','t3.postId = t2.postId')
			->leftJoin('user_table t4','t4.userId = t3.userId')
			->where('t2.parentId=:id',array(':id'=>$id))
			->andWhere('t1.postType =:type',array(':type'=>'post'))
			->queryAll();
		if($query){
			return $query;
		}
		return false;
	}

	public static function getFilterPost($id,$key){
		$model = Yii::app()->db->createCommand()
				->select("*,t1.postId")
				->from('post_table t1');

		if($key=="user"){
			$model 	->leftJoin('post_meta t2','t2.post_table_postId = t1.postId')
					->leftJoin('user_table t5','t5.userId = t1.userId')
					->where('t1.userId =:id',array(':id'=>$id))
					->andWhere('t1.postType =:type',array(':type'=>'post'))
					->order('t2.value DESC, t1.postDate DESC, t1.status ASC ')
					->group('t1.postId');
					
		}
		else if($key=="tag"){
			$model 	->leftJoin('tag_rel t2','t2.postId = t1.postId')
					->leftJoin('tag_table t3','t3.tagId = t2.tagId')
					->leftJoin('post_meta t4','t4.post_table_postId = t1.postId')
					->leftJoin('user_table t5','t5.userId = t1.userId')
					->where('t3.tagId =:id',array(':id'=>$id))
					->andWhere('t1.postType =:type',array(':type'=>'post'))
					->order('t4.value DESC, t1.postDate DESC, t1.status ASC ')
					->group('t1.postId');

		}
		else if($key=="status"){
			$model 	->leftJoin('tag_rel t2','t2.postId = t1.postId')
					->leftJoin('tag_table t3','t3.tagId = t2.tagId')
					->leftJoin('post_meta t4','t4.post_table_postId = t1.postId')
					->leftJoin('user_table t5','t5.userId = t1.userId')
					->where('t1.status =:id',array(':id'=>$id))
					->andWhere('t1.postType =:type',array(':type'=>'post'))
					->order('t4.value DESC, t1.postDate DESC, t1.status ASC ')
					->group('t1.postId');
		}

		$countQuery = clone $model;
		$countQuery->select('count(*) as count');
		$count = $countQuery->queryScalar();
		$pages = new CPagination($count);
		// $pages->pageSize = Yii::app()->params['pageSize']; // results per page
		$pages->pageSize = 15;
		$pages->pageVar = "thread";
		$pages->params = array("tab"=>"thread","id"=>$_GET['id']);
		//$offset=$pages->getOffset();
		//$limit=$pages->getLimit();
		$model->limit($pages->getLimit(),$pages->getOffset());

		$data = $model->queryAll();

		$result = array('data'=>$data,'pages'=>$pages,"count"=>$count);

		return $result;

	}
	public static function getAnswersPostCount($id){
		$query = Yii::app()->db->createCommand()
			->select('count(*)')
			->from('post_relationship t1')
			->where('t1.parentId=:id',array(':id'=>$id))
			->queryScalar();
		return $query;
	}
	public static function getViewsPostCount($id){
		$query = Yii::app()->db->createCommand()
			->select('t1.postView')
			->from('post_table t1')
			->where('t1.postId=:id and t1.postType="post"',array(':id'=>$id))
			->queryAll();
		return $query[0]['postView'];
	}
	public static function addViewToPost($id){
		$increment =  PostTable::model()->findByPk($id);
		$increment->postView += 1;
		$increment->save(false);
	}
	public static function getFeaturedPost(){
		$model = Yii::app()->db->createCommand()
			->select("*")
			->from('post_table t1')
			->leftJoin('post_meta t2','t2.post_table_postId = t1.postId')
			->leftJoin('user_table t5','t5.userId = t1.userId')
			->where('t1.postType =:type',array(':type'=>'post'))
			->order('t2.value DESC, t1.postDate DESC, t1.status ASC ')
			->limit(5)
			->queryAll();
		return $model;
	}
}
