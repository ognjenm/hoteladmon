<?php

class KeepController extends Controller
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

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model=$this->loadModel($id);

        $items=KeepItems::model()->findAll(array(
            'condition'=>'keep_id=:keepId',
            'params'=>array('keepId'=>$model->id)
        ));

		$this->render('view',array(
			'model'=>$model,
            'items'=>$items
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{

        Yii::import('ext.multimodelform.MultiModelForm');
        $validatedMembers = array();
        $items=new KeepItems;
        $model=new Keep;

        if(isset($_POST['Keep']))
        {

            $model->attributes=$_POST['Keep'];

                if($model->save()){
                    $masterValues = array ('keep_id'=>$model->id);

                    if (MultiModelForm::save($items,$validatedMembers,$deleteMembers,$masterValues)){
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('view','id'=>$model->id));
                    }
                }

            }


		$this->render('create',array(
            //'keep'=>$model,
            'model'=>$model,
            'items'=>$items,
            'validatedMembers' => $validatedMembers,


        ));
	}


	public function actionUpdate($id){

        Yii::import('ext.multimodelform.MultiModelForm');

        $model=$this->loadModel($id);
        $items=new KeepItems;
        $validatedMembers = array();

        if(isset($_POST['Keep']))
        {
            $model->attributes=$_POST['Keep'];
            //$model->policies = implode(',',$_POST['BudgetFormat']['policies']);
            $masterValues = array ('keep_id'=>$model->id);

            if(MultiModelForm::save($items,$validatedMembers,$deleteMembers,$masterValues) && $model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

        }

        $this->render('update',array(
            'model'=>$model,
            'items'=>$items,
            'validatedMembers' => $validatedMembers,
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
        $model=new Keep('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Keep']))
        $model->attributes=$_GET['Keep'];

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
		$model=Keep::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='keep-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
