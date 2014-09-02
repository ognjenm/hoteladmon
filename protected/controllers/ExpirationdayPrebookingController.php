<?php

class ExpirationdayPrebookingController extends Controller
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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view','delete','editarrives','editAvailability','editDaystopay'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionEditArrives(){

        $r = Yii::app()->getRequest();
        $value=$r->getParam('value');
        $pk=$r->getParam('pk');

        $data=ExpirationdayPrebooking::model()->findByPk($pk);
        $data->arrives=$value;
        $data->save();

        Yii::app()->end();
    }

    public function actionEditAvailability(){

        $r = Yii::app()->getRequest();
        $value=$r->getParam('value');
        $pk=$r->getParam('pk');

        $data=ExpirationdayPrebooking::model()->findByPk($pk);
        $data->availability=$value;
        $data->save();

        Yii::app()->end();
    }

    public function actionEditDaystopay(){

        $r = Yii::app()->getRequest();
        $value=$r->getParam('value');
        $pk=$r->getParam('pk');

        $data=ExpirationdayPrebooking::model()->findByPk($pk);
        $data->daystopay=$value;
        $data->save();

        Yii::app()->end();
    }

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
		$model=new ExpirationdayPrebooking;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ExpirationdayPrebooking']))
		{
			$model->attributes=$_POST['ExpirationdayPrebooking'];
			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }

		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

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

		if(isset($_POST['ExpirationdayPrebooking']))
		{
			$model->attributes=$_POST['ExpirationdayPrebooking'];
			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }

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
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new ExpirationdayPrebooking('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ExpirationdayPrebooking']))
        $model->attributes=$_GET['ExpirationdayPrebooking'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}

	/**
	 * Manages all models.
	 */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ExpirationdayPrebooking::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='expirationday-prebooking-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
