<?php

/**
 * This is the model class for table "user_table".
 *
 * The followings are the available columns in table 'user_table':
 * @property integer $userId
 * @property string $userName
 * @property string $userEmail
 * @property string $userVerification
 * @property string $userRegDate
 *
 * The followings are the available model relations:
 * @property PointsTable[] $pointsTables
 * @property PostTable[] $postTables
 * @property TransactionTable[] $transactionTables
 * @property TransactionTable[] $transactionTables1
 * @property UserMeta[] $userMetas
 */
class UserTable extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user_table';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userName, userVerification, userRegDate', 'required'),
			array('userName, userEmail', 'length', 'max'=>100),
			array('userVerification', 'length', 'max'=>25),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('userId, tagbond_id, userName, userEmail, userVerification, userRegDate', 'safe', 'on'=>'search'),
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
			'pointsTables' => array(self::HAS_MANY, 'PointsTable', 'userId'),
			'postTables' => array(self::HAS_MANY, 'PostTable', 'userId'),
			'transactionTables' => array(self::HAS_MANY, 'TransactionTable', 'transactionFrom'),
			'transactionTables1' => array(self::HAS_MANY, 'TransactionTable', 'transactionTo'),
			'userMetas' => array(self::HAS_MANY, 'UserMeta', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userId' => 'User',
			'userName' => 'User Name',
			'tagbond_id' => 'Tagbond ID',
			'userEmail' => 'User Email',
			'userVerification' => 'User Verification',
			'userRegDate' => 'User Reg Date',
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

		$criteria->compare('userId',$this->userId);
		$criteria->compare('tagbond_id',$this->tagbond_id,true);
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('userEmail',$this->userEmail,true);
		$criteria->compare('userVerification',$this->userVerification,true);
		$criteria->compare('userRegDate',$this->userRegDate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserTable the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function checkIfUserExist($id){
		$checkUser = UserTable::model()->findByAttributes(array('tagbond_id'=>$id));
		if($checkUser){
			return true;
		}
		return false;

	}

	public static function getAllPosts(){
		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('user_table t2','t2.userId = t1.userId')
			->where("t1.userId=:id and t1.postType='post'",array(':id'=> Yii::app()->user->userId ))
			->order('t1.postDate DESC')
			->limit(5)
			->queryAll();
		return $query;
	}
	public static function getAllComments(){
		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('user_table t2','t2.userId = t1.userId')
			->where("t1.userId = :id and t1.postType='answer'",array(':id'=>Yii::app()->user->userId))
			->order('t1.postDate DESC')
			->limit(5)
			->queryAll();
		return $query;
	}
	public static function getSearcherBadge($id=false){
		if(!$id){
			$id = Yii::app()->user->userId;
		}
		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('user_table t2','t2.userId = t1.userId')
			->where("t1.userId=:id and t1.postType='post'",array(':id'=>Yii::app()->user->userId))
			->queryScalar();
		return $query;
	}
	public static function getFinderBadge($id=false){
		if(!$id){
			$id = Yii::app()->user->userId;
		}
		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('user_table t2','t2.userId = t1.userId')
			->where('t1.userId=:id and t1.postType="answer" and t1.status=1',array(':id'=>$id))
			->queryAll();
		return count($query);
	}
	public static function getHunterBadge($id=false){
		if(!$id){
			$id = Yii::app()->user->userId;
		}
		$query = Yii::app()->db->createCommand()
			->select('*')
			->from('post_table t1')
			->leftJoin('user_table t2','t2.userId = t1.userId')
			->leftJoin('transaction_table t3','t3.transactionTo=t1.userId')
			->where('t1.userId=:id and t1.postType="answer" and t1.status=1 and t3.transactionTo=t2.userId ',array(':id'=>$id))
			->queryAll();
		return count($query);

	}
}
