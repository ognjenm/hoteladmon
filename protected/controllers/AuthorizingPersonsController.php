<?php

class AuthorizingPersonsController extends Controller
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
				'actions'=>array('create','update','index','view','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionGetAuthorized(){

        $res=array('ok'=>false,'authorized'=>array(''=>Yii::t('mx','Select')));
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            $bankId=(int)$_POST['bankId'];

            $data=AuthorizingPersons::model()->findAll(
                array('condition'=>'bank_id=:bankId',
                    'params'=>array('bankId'=>$bankId)
                )
            );

            if($data){
                foreach($data as $item){
                    $options.=CHtml::tag('option', array('value'=>$item->id),CHtml::encode($item->name),true);
                }
            }

            if($options) $res=array('ok'=>true,'authorized'=>$options);

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
		$model=new AuthorizingPersons;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['AuthorizingPersons']))
		{
			$model->attributes=$_POST['AuthorizingPersons'];
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

		if(isset($_POST['AuthorizingPersons']))
		{
			$model->attributes=$_POST['AuthorizingPersons'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
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
        $model=new AuthorizingPersons('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['AuthorizingPersons']))
        $model->attributes=$_GET['AuthorizingPersons'];

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
		$model=AuthorizingPersons::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='authorizing-persons-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
