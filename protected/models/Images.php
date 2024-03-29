<?php

/**
 * This is the model class for table "images".
 *
 * The followings are the available columns in table 'images':
 * @property integer $id
 * @property string $url
 * @property string $site
 * @property string $active
 * @property integer $cat_id
 * @property integer $color
 *
 * The followings are the available model relations:
 * @property 4prCategories $cat
 */
class Images extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Images the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'images';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, cat_id, color', 'numerical', 'integerOnly'=>true),
			array('url, site', 'length', 'max'=>255),
			array('active', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, url, site, active, cat_id, color', 'safe', 'on'=>'search'),
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
			'cat' => array(self::BELONGS_TO, '4prCategories', 'cat_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'url' => 'Url',
			'site' => 'Site',
			'active' => 'Active',
			'cat_id' => 'Cat',
			'color' => 'Color',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('site',$this->site,true);
		$criteria->compare('active',$this->active,true);
		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('color',$this->color);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}