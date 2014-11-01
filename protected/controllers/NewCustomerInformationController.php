<?php

class NewCustomerInformationController extends Controller
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
            array('CrugeAccessControlFilter'), // perform access control for CRUD operations
		);
	}


	public function accessRules()
	{
		return array(

			array('allow',
				'actions'=>array('create','update','index','view','delete'),
				'users'=>array('@'),
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
			'model'=>Customers::model()->findByPk($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new NewCustomerInformation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['NewCustomerInformation']))
		{
			$model->attributes=$_POST['NewCustomerInformation'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('view','id'=>$model->id));
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
        $customer=Customers::model()->findByPk($model->customer_id);

		if(isset($_POST['NewCustomerInformation']))
		{
            $newAttributes=array(
                'alternative_email'=>$_POST['NewCustomerInformation']['alternative_email_Save'],
                'first_name'=>$_POST['NewCustomerInformation']['first_name_Save'],
                'last_name'=>$_POST['NewCustomerInformation']['last_name_Save'],
                'country'=>$_POST['NewCustomerInformation']['country_Save'],
                'state'=>$_POST['NewCustomerInformation']['state_Save'],
                'city'=>$_POST['NewCustomerInformation']['city_Save'],
                'home_phone'=>$_POST['NewCustomerInformation']['home_phone_Save'],
                'work_phone'=>$_POST['NewCustomerInformation']['work_phone_Save'],
                'cell_phone'=>$_POST['NewCustomerInformation']['cell_phone_Save'],
            );

            $customer->attributes=$newAttributes;

			if($customer->save()){
                $model->verified=1;
                $model->save();
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$customer->id));
            }

		}

		$this->render('update',array(
			'model'=>$model,
            'customer'=>$customer
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
        $model=new NewCustomerInformation('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['NewCustomerInformation']))
        $model->attributes=$_GET['NewCustomerInformation'];

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
		$model=NewCustomerInformation::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='new-customer-information-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
