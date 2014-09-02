<?php

class PettyCashController extends Controller
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
            array('CrugeAccessControlFilter'),  // perform access control for CRUD operations
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
				'actions'=>array('create','update','index','view','delete','close','confirmed'),
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

    public function actionConfirmed(){


        $res=array('ok'=>false,'msg'=>'Error');

        if(Yii::app()->request->isPostRequest){

            $criteria=array(
                'condition'=>'user_id=:userId',
                'params'=>array('userId'=>Yii::app()->user->id)
            );

            $data=PettyCash::model()->find($criteria);

            $data->isconfirmed=1;


            if($data->save()){
                $res=array('ok'=>true,'msg'=>'Success');
            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }

    }


    public function actionClose($id){

        $res=array('ok'=>false);

        $success='<div class="alert in alert-block fade alert-success">
        <strong>done!</strong>
                '.Yii::t('mx','Success').'
        </div>';


        if(Yii::app()->request->isAjaxRequest){

            $pettyCash=$this->loadModel($id);
            $pettyCash->isopen=0;

            if($pettyCash->save()) $res=array('ok'=>true,'response'=>$success);

            else{

                $error='<div class="alert in alert-block fade alert-error">
                <strong>done!</strong>
                        '.$pettyCash->getErrors().'
                </div>';

                $res=array('ok'=>false,'response'=>$error);
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */

	public function actionCreate()
	{
		$model=new PettyCash;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PettyCash']))
		{
			$model->attributes=$_POST['PettyCash'];
            $model->isconfirmed=0;

			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
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

		if(isset($_POST['PettyCash']))
		{
			$model->attributes=$_POST['PettyCash'];
            $model->isconfirmed=0;

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
        $model=new PettyCash('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['PettyCash']))
        $model->attributes=$_GET['PettyCash'];

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
		$model=PettyCash::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='petty-cash-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
