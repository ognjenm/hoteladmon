<?php

class ContractEmployeesController extends Controller
{

	public $layout='//layouts/column2';


	public function filters()
	{
		return array(
            array('CrugeAccessControlFilter'), // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','delete','index','view'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model=new ContractEmployees;

		if(isset($_POST['ContractEmployees']))
		{
			$model->attributes=$_POST['ContractEmployees'];
            $model->contract=Yii::app()->quoteUtil->generate_contract_employee($model->employee_id,$model->date_signing_contract);

			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

    public function actionUpdate($id)
	{
		$model=$this->loadModel($id);


		if(isset($_POST['ContractEmployees']))
		{
			$model->attributes=$_POST['ContractEmployees'];
            $model->contract=Yii::app()->quoteUtil->generate_contract_employee($model->employee_id,$model->date_signing_contract);


            if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


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

	public function actionIndex()
	{
        $model=new ContractEmployees('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ContractEmployees']))
        $model->attributes=$_GET['ContractEmployees'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}


	public function loadModel($id)
	{
		$model=ContractEmployees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contract-employees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
