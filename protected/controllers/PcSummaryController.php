<?php

class PcSummaryController extends Controller
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
				'actions'=>array('create','update','index','view','delete','getQuantity','generateCheck'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


    public function actionGenerateCheck(){

        $res=array('ok'=>false,'msg'=>Yii::t('mx','Error'));
        $ids=array();

        if(Yii::app()->request->isPostRequest){

            if(isset($_POST['ids'])){

                $ids=$_POST['ids'];

                foreach($ids as $id){
                    $pcSummary=$this->loadModel($id);
                    $pcSummary->isactive=2;
                }
                $res=array('ok'=>true,'msg'=>Yii::t('mx','Success'));
            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }

    }


    public function actionGetQuantity(){

        $res=array('ok'=>false,'quantity'=>Yii::t('mx','Please Select Item'));
        $ids=array();

        if(Yii::app()->request->isPostRequest){

            $suma=0;

            if(isset($_POST['ids'])){

                $ids=$_POST['ids'];

                foreach($ids as $id){
                    $sumary=$this->loadModel($id);
                    $suma=$suma+$sumary->price;
                }
                $res=array('ok'=>true,'quantity'=>number_format($suma,2));
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
		$model=new PcSummary;

        // Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PcSummary']))
		{


            $criteria=array(
                'condition'=>'user_id=:userId',
                'params'=>array('userId'=>Yii::app()->user->id)
            );

            $pettycash=PettyCash::model()->find($criteria);

			$model->attributes=$_POST['PcSummary'];
            $model->petty_cash_id=$pettycash->id;
            $model->isactive=1;

            $pettycash->amount=$pettycash->amount-$model->price;

            if(empty($_POST['PcSummary']['n_invoice'])) $model->isinvoice=0;
            else $model->isinvoice=1;



			if($model->save() && $pettycash->save()){
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

		if(isset($_POST['PcSummary']))
		{
			$model->attributes=$_POST['PcSummary'];
			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{

        $criteria=array(
            'condition'=>'user_id=:userId',
            'params'=>array('userId'=>Yii::app()->user->id)
        );

        $pettyCash=PettyCash::model()->find($criteria);


        $model=new PcSummary('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['PcSummary']))
        $model->attributes=$_GET['PcSummary'];

        $this->render('index',array(
            'model'=>$model,
            'pettyCash'=>$pettyCash
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
		$model=PcSummary::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='pc-summary-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
