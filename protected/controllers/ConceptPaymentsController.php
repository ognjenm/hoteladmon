<?php

class ConceptPaymentsController extends Controller
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
				'actions'=>array('create','update','index','view','delete','concepts'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionConcepts(){

		$res=array('ok'=>false);

		if(Yii::app()->request->isPostRequest){

			$providerId=(int)$_POST['provider_id'];
			$concept=$_POST['concept'];

			$model= new ConceptPayments;
			$model->provider_id=$providerId;
			$model->concept=$concept;

			if($model->save()){$res=array('ok'=>true); }

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
		$model=new ConceptPayments;
        $res=array('ok'=>false,'concepts'=>array(''=>Yii::t('mx','Select')));
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            $providerId=(int)$_POST['ConceptPayments']['provider_id'];
            $concept=$_POST['ConceptPayments']['concept'];
            $model->provider_id=$providerId;
            $model->concept=$concept;

            if($model->save()){

                $data=ConceptPayments::model()->findAll(
                    array('condition'=>'provider_id=:providerId',
                        'params'=>array('providerId'=>$providerId)
                    )
                );

                if($data){
                    foreach($data as $item){
                        $options.=CHtml::tag('option', array('value'=>$item->id),CHtml::encode($item->concept),true);
                    }
                }

                $res=array('ok'=>true,'concepts'=>$options);

            }


            echo CJSON::encode($res);
            Yii::app()->end();

        }

		if(isset($_POST['ConceptPayments']))
		{
			$model->attributes=$_POST['ConceptPayments'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['ConceptPayments']))
		{
			$model->attributes=$_POST['ConceptPayments'];
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
        $model=new ConceptPayments('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ConceptPayments']))
        $model->attributes=$_GET['ConceptPayments'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}

	public function loadModel($id)
	{
		$model=ConceptPayments::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='concept-payments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
