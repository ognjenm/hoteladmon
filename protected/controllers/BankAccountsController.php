<?php

class BankAccountsController extends Controller
{

	public $layout='//layouts/column2';


	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view','delete','getAccounts','checkbook'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionCheckbook($id)
    {
        $model=$this->loadModel($id);

        if(isset($_POST['BankAccounts']))
        {
            $model->attributes=$_POST['BankAccounts'];
            $model->consecutive=$model->cheq_num_start;

            if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }

        }

        $this->renderPartial('checkbook',array(
            'model'=>$model,
        ));
    }

    public function actionGetAccounts(){

        $res=array('ok'=>false,'accounts'=>array(''=>Yii::t('mx','Select')));
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            $paymentMethodId=(int)$_POST['paymentMethodId'];

            if($paymentMethodId==1 || $paymentMethodId==2){

                $data=BankAccounts::model()->findAll(
                    array('condition'=>'account_type_id=1 or account_type_id=2')
                );

            }

            switch($paymentMethodId){

                case 4: //tarjeta debito
                    $data=BankAccounts::model()->findAll(array('condition'=>'account_type_id=3'));
                    break;

                case 6: //tarjeta credito
                    $data=BankAccounts::model()->findAll( array('condition'=>'account_type_id=4'));
                    break;

                case 3: //transferencia a terceros
                    $data=BankAccounts::model()->findAll(array('condition'=>'account_type_id=1'));
                    break;
            }

            if($data){
                foreach($data as $item){
                    $options.=CHtml::tag('option', array('value'=>$item->id),CHtml::encode($item->bank->bank.' - '.substr($item->account_number,-4)),true);
                }
            }

            if($options) $res=array('ok'=>true,'accounts'=>$options);

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
		$model=new BankAccounts;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BankAccounts']))
		{
			$model->attributes=$_POST['BankAccounts'];
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

		if(isset($_POST['BankAccounts']))
		{
			$model->attributes=$_POST['BankAccounts'];
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
        $model=new BankAccounts('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['BankAccounts']))
        $model->attributes=$_GET['BankAccounts'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}

	public function loadModel($id)
	{
		$model=BankAccounts::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bank-accounts-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
