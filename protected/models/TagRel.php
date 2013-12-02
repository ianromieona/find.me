<?php

/**
 * This is the model class for table "tag_rel".
 *
 * The followings are the available columns in table 'tag_rel':
 * @property integer $id
 * @property integer $tagId
 * @property integer $postId
 *
 * The followings are the available model relations:
 * @property TagTable $tag
 * @property PostTable $post
 */
class TagRel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tag_rel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tagId, postId', 'required'),
			array('tagId, postId', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tagId, postId', 'safe', 'on'=>'search'),
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
			'tag' => array(self::BELONGS_TO, 'TagTable', 'tagId'),
			'post' => array(self::BELONGS_TO, 'PostTable', 'postId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tagId' => 'Tag',
			'postId' => 'Post',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('tagId',$this->tagId);
		$criteria->compare('postId',$this->postId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TagRel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function searchByTag($params){
		$model = Yii::app()->db->createCommand()
				->select('t1.*,t4.value,t5.userName,t5.userId')				
				->from('post_table t1')
				->leftJoin('tag_rel t2','t2.postId = t1.postId')
				->leftJoin('tag_table t3','t3.tagId = t2.tagId')
				->leftJoin('post_meta t4','t4.post_table_postId = t1.postId')
				->leftJoin('user_table t5','t5.userId = t1.userId')
				->where('t3.tagName LIKE :name',array(':name'=>'%'.$params.'%'))
				->andWhere('t1.postType =:type',array(':type'=>'post'))
				->order('t4.value DESC, t1.postDate DESC, t1.status ASC ')
				->group('t1.postId');

		$countQuery = clone $model;
		$countQuery->select('count(*) as count');
		$count = $countQuery->queryScalar();
		$pages = new CPagination($count);
		// $pages->pageSize = Yii::app()->params['pageSize']; // results per page
		$pages->pageSize = 15;
		$pages->pageVar = "tags";
		$pages->params = array("tab"=>"tags");
		//$offset=$pages->getOffset();
		//$limit=$pages->getLimit();
		$model->limit($pages->getLimit(),$pages->getOffset());

		$data = $model->queryAll();

		$result = array('data'=>$data,'pages'=>$pages,"count"=>$count);

		return $result;
	}
}
