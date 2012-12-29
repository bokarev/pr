<?php

class ImagesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','addpics'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Images;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Images']))
		{
/* 			
					var_dump($_POST);
		die();

 */		$model->attributes=$_POST['Images'];
		if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionAddpics()
	{  
		self::img_draw($_POST['site']);
		$sql = "INSERT INTO images (id, url, site, active, cat_id, color)
				VALUES(:id, :url, :site, :active, :cat_id, :color)";
		$parameters = array(":id"=>null,
							":url"=>$_POST['url'],
							":site"=>$_POST['site'],
							":active"=>$_POST['active'],
							":cat_id"=>$_POST['cat_id'],
							":color"=>$_POST['color']);
		
		Yii::app()->db->createCommand($sql)->execute($parameters);	
	}
	////////////
	
	
	
   protected function img_draw($filename)
	{ 
				 $id = rand(5, 1005);
				 $img_fields = array('pic_size'=>"1",'color'=>'color');
				 $path = IMAGE_PATH;
				 $src_img = imagecreatefromjpeg($filename);
	             if($img_fields['pic_size']=="1"){			     
			     $new_h = imagesy($src_img);
			     $new_w = imagesx($src_img);			     
			     $dst_img = imagecreatetruecolor($new_w,$new_h);
			     imagecopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img));
			     $dir = $path . $img_fields['color']; 
			     $im = $dir . $id . "1.jpg";
			     if(!is_dir($dir)){
			      mkdir($dir, 0777);  
			     }
				 
			     imagejpeg($dst_img, $im, 90);   
			     echo "original size: " . $new_w . "x" . $new_h . "<br /><img src='../images/clubmusic/" . $img_fields['color'] . $id . "1.jpg?rand=" . rand(5, 1005) . "' /><br />";  
			 
			     if ($new_w>$new_h){
			        $new_w = $new_h;
			        $dst_img = imagecreatetruecolor($new_h, $new_h);		    
			     }
			     if ($new_w<$new_h){
			        $new_h = $new_w;
			        $dst_img = imagecreatetruecolor($new_w, $new_w);
			      
			     }
			     
			    imagecopyresized($dst_img, $src_img, 0, 0,round((max($new_w,$new_h)-min($new_w,$new_h))/2),0, $new_w, $new_w, min($new_w,$new_h), min($new_w,$new_h));	
	            $dir = $path . $img_fields['color'];
	            $im = $dir . $id . "7.jpg";
	            if(!is_dir($dir)){
			       mkdir($dir, 0777);  
			     }

		      //  self :: _record_img($id);
	            if(imagejpeg($dst_img, $im, 90)){
			        echo "square: " . $new_h . "<br /><img src='../images/clubmusic/" . $img_fields['color'] . $id . "7.jpg?rand=" . rand(5, 1005) . "' /><br />";  
			    }
		   
			  } 
			  // *************
			  
			  	 if($img_fields["rss_pic_width"]!=""){		//	     

			     $new_w = $img_fields["rss_pic_width"];
			     $const = imagesx($src_img)/$new_w;	
			     $new_h = imagesy($src_img)/$const;
			     		     
			     $dst_img = imagecreatetruecolor($new_w,$new_h);
			     imagecopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img));
			  	 $dir = $path . $img_fields['rss_path'];
			     $im = $dir . $id . "2.jpg";
			  	 if(!is_dir($dir)){
			       mkdir($dir, 0777);  
			     }
			     if(imagejpeg($dst_img, $im, 90)){
			        echo "width: " . $img_fields["rss_pic_width"] . " <br /><img src='../images/clubmusic/" . $id . "2.jpg?rand=" . rand(5, 1005) . "' /><br />";  
			     }
			  } 
			  
			  if($img_fields["rss_pic_height"]!=""){			     
			     
			     $new_h = $img_fields["rss_pic_height"];
			     $const = imagesy($src_img)/$new_h;	
			     $new_w = imagesx($src_img)/$const;
			     		     
			     $dst_img = imagecreatetruecolor($new_w,$new_h);
			     imagecopyresized($dst_img,$src_img,0,0,0,0,$new_w,$new_h,imagesx($src_img),imagesy($src_img));
			     $dir = $path . $img_fields['rss_path'];
			     $im = $dir . $id . "3.jpg";
			  	 if(!is_dir($dir)){
			       mkdir($dir, 0777);  
			     }
			     imagejpeg($dst_img, $im, 90);   
			     echo "height: " . $img_fields["rss_pic_height"] . "<br /><img src='../images/clubmusic/" . $img_fields['rss_path'] . $id . "3.jpg?rand=" . rand(5, 1005) . "' /><br />";  
			     
			  } 
			  
		
			  
			  
			 if($img_fields["rss_pic_kvad"]!=""){			     
			    $w_src = imagesx($src_img);
			    $h_src = imagesy($src_img);
			    $dst_img = imagecreatetruecolor($img_fields["rss_pic_kvad"], $img_fields["rss_pic_kvad"]);
		       
			    if ($w_src>$h_src or $w_src==$h_src ){
			       imagecopyresized($dst_img, $src_img, 0, 0,round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $img_fields["rss_pic_kvad"], $img_fields["rss_pic_kvad"], min($w_src,$h_src), min($w_src,$h_src));	
			    }	
			    if ($w_src<$h_src){
			       imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $img_fields["rss_pic_kvad"], $img_fields["rss_pic_kvad"], min($w_src,$h_src), min($w_src,$h_src)); 
			    }
			     $dir = $path . $img_fields['rss_path'];
			     $im = $dir . $id . "4.jpg";
			  	 if(!is_dir($dir)){
			       mkdir($dir, 0777);  
			     }
			     imagejpeg($dst_img, $im, 90);   
			     echo "square: " . $img_fields["rss_pic_height"] . "<br /><img src='../images/clubmusic/" . $img_fields['rss_path'] . $id . "4.jpg?rand=" . rand(5, 1005) . "' /><br />";  
			     
			  } 
			  
			  
  			  if($img_fields["rss_pic_kvad2"]!=""){
			    
			    $w_src = imagesx($src_img);
			    $h_src = imagesy($src_img);
			    $dst_img = imagecreatetruecolor($img_fields["rss_pic_kvad2"], $img_fields["rss_pic_kvad2"]);
			    
			    if ($w_src>$h_src or $w_src==$h_src){
			       imagecopyresized($dst_img, $src_img, 0, 0,round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $img_fields["rss_pic_kvad2"], $img_fields["rss_pic_kvad2"], min($w_src,$h_src), min($w_src,$h_src));	
			    }	
			    if ($w_src<$h_src){
			       imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $img_fields["rss_pic_kvad2"], $img_fields["rss_pic_kvad2"], min($w_src,$h_src), min($w_src,$h_src)); 
			    }

  			  	$dir = $path . $img_fields['rss_path'];
			    $im = $dir . $id . "5.jpg";
			  	if(!is_dir($dir)){
			       mkdir($dir, 0777);  
			    }
			    imagejpeg($dst_img, $im, 90);
			    echo "square: " . $img_fields["rss_pic_kvad2"] . "<br /><img src='../images/clubmusic/" . $img_fields['rss_path']  . "" . $id . "5.jpg?rand=" . rand(5, 1005) . "' /><br />";  
			    
			  }
			  
  			  if($img_fields["rss_pic_kvad3"]!=""){
			    
			    $w_src = imagesx($src_img);
			    $h_src = imagesy($src_img);
			    $dst_img = imagecreatetruecolor($img_fields["rss_pic_kvad3"], $img_fields["rss_pic_kvad3"]);
			    
			    if ($w_src>$h_src or $w_src==$h_src ){
			       imagecopyresized($dst_img, $src_img, 0, 0,round((max($w_src,$h_src)-min($w_src,$h_src))/2),0, $img_fields["rss_pic_kvad3"], $img_fields["rss_pic_kvad3"], min($w_src,$h_src), min($w_src,$h_src));	
			    }	
			    if ($w_src<$h_src){
			       imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $img_fields["rss_pic_kvad3"], $img_fields["rss_pic_kvad3"], min($w_src,$h_src), min($w_src,$h_src)); 
			    }

			    $dir = $path . $img_fields['rss_path'];
			    $im = $dir . $id . "6.jpg";
			  	if(!is_dir($dir)){
			       mkdir($dir, 0777);  
			    }
			    imagejpeg($dst_img, $im, 90);
			    echo "square: " . $img_fields["rss_pic_kvad3"] . "<br /><img src='../images/clubmusic/" . $img_fields['rss_path'] . $id . "6.jpg?rand=" . rand(5, 1005) . "' /><br />";  
			    
			  }	  
			  
			  
			       	
	}
	
	
	
	
	
	
	//////////
	
	
	
	
	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Images']))
		{
			$model->attributes=$_POST['Images'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Images');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Images('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Images']))
			$model->attributes=$_GET['Images'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Images::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='images-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
