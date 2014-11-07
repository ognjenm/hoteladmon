<?php

class BdgtReservationController extends Controller
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
				'actions'=>array('create','update','index','view','delete','budgetWithDiscount'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}



	public function actionBudgetWithDiscount(){

        $res=array('ok'=>false);

        if(Yii::app()->request->isAjaxRequest){

            if (isset($_POST['BdgtReservation'])){

                $tope=count($_POST['BdgtReservation']['bdgt_group_id']);
                $model=array();
                $tabla=array();

                for($i=0;$i<$tope;$i++){

                    $data=array();

                    foreach ($_POST['BdgtReservation'] as $id=>$values){
                        $anexo=array($id=>$values[$i]);
                        $data=array_merge($data,$anexo);
                    }

                    $model[]=$data;
                }

                foreach($model as $item){

                    $subtotal=BdgtConcepts::getSubtotal($item['bdgt_concept_id'],$item['pax']);
                    $price=BdgtConcepts::getPricexPax($item['bdgt_concept_id']);
                    $concept=BdgtConcepts::model()->findByPk((int)$item['bdgt_concept_id']);

                    array_push($tabla,array(
                        'description'=>$concept->description,
                        'date'=>$item['fecha'],
                        'pax'=>$item['pax'],
                        'pricexpax'=>$price,
                        'subtotal'=>$subtotal
                    ));
                }

                $budget=Yii::app()->quoteUtil->tableActivities($tabla);

                $res=array('ok'=>true,'budget'=>$budget);

        }

            echo CJSON::encode($res);
            Yii::app()->end();

        }
    }

	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


	public function actionCreate()
	{
		$model=new BdgtReservation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BdgtReservation']))
		{
			$model->attributes=$_POST['BdgtReservation'];
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BdgtReservation']))
		{
			$model->attributes=$_POST['BdgtReservation'];
			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new BdgtReservation('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['BdgtReservation']))
        $model->attributes=$_GET['BdgtReservation'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}


	public function loadModel($id)
	{
		$model=BdgtReservation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bdgt-reservation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
