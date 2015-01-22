<?php

class PolizasController extends Controller
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

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view','delete','polizaToPdf','generaCheque','gridPolizaNoBill','createPolizaNoBill','close','polizadifference'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionPolizadifference(){


        $model=new Polizas('searchInvoiceDiference');
        $model->unsetAttributes();

        if(isset($_GET['Polizas'])) $model->attributes=$_GET['Polizas'];

        $this->render('difference',array(
            'model'=>$model,
        ));

    }


    public function actionClose($id){

        $res=array('ok'=>false,'errors'=>null);

        if(Yii::app()->request->isPostRequest){

            $poliza=Polizas::model()->findByPk((int)$id);
            $poliza->has_bill=1;

            if($poliza->save()){
                $res=array('ok'=>true,'errors'=>null);
            }
            else{
                $res=array('ok'=>false,'errors'=>$poliza->getErrors());
            }
        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }

    public function actionGridPolizaNoBill(){

        $model=new Polizas('searchNoBill');
        $model->unsetAttributes();
        if(isset($_GET['Polizas']))
            $model->attributes=$_GET['Polizas'];

        $this->render('noBill',array(
            'model'=>$model,
        ));

    }

    public function actionCreatePolizaNoBill(){

        $res=array('ok'=>false,'url'=>null,'errors'=>null);
        $user=Yii::app()->user->id;

        if(Yii::app()->request->isPostRequest){

            $accounId=(int)$_POST['Operations']['account_id2'];
            $providerId=(int)$_POST['Operations']['released2'];
            $authorized=(int)$_POST['Operations']['authorized2'];
            $conceptId=(int)$_POST['Operations']['concept2'];
            $paymentMethod=(int)$_POST['Operations']['typeCheq2'];
            $forBeneficiaryAccount=$_POST['Operations']['abonoencuenta2'];
            $totalPoliza=$_POST['Operations']['amount'];

            $account=BankAccounts::model()->findByPk($accounId);
            $balance=$account->initial_balance-$totalPoliza;
            $account->initial_balance=$balance;
            $account->consecutive=$account->consecutive+1;

            $released=Providers::model()->findByPk($providerId);
            $released=$released->company;
            $concept=ConceptPayments::model()->findByPk($conceptId);
            $concept=$concept->concept;

            switch($paymentMethod){
                case 1 : //CHEQUE DE CAJA
                    $operationId=Yii::app()->quoteUtil->registerAccountCheques(6,$accounId,$account->consecutive,date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;

                case 2: //CHEQUE NOMINATIVO
                    $operationId=Yii::app()->quoteUtil->registerAccountCheques(6,$accounId,$account->consecutive,date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;

                case 3: // TRANSFERENCIA ELECTRONICA A TERCEROS
                    $operationId=Yii::app()->quoteUtil->registerAccountCheques(5,$accounId,'TRA',date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;

                case 4: // TARJETA DEBITO
                    $operationId=Yii::app()->quoteUtil->registerAccountDebit(3,$accounId,'RET',date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;
                case 6: // TARJETA CREDITO
                    $operationId=Yii::app()->quoteUtil->registerAccountCredit(4,$accounId,'RET',date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;
            }


            if(!is_array($operationId)){
                $poliza=new Polizas;
                $poliza->operation_id=$operationId;
                $poliza->invoice_ids=0;
                $poliza->has_bill=0;
                $poliza->user_id=$user;
                $poliza->authorized_by=$authorized;
                $poliza->payment_type=$paymentMethod;
                $poliza->for_beneficiary_account=$forBeneficiaryAccount;

                if($poliza->save()){
                    $account->save();
                    $res=array('ok'=>true,'url'=>$this->createUrl('polizas/view',array('id'=>$poliza->id)));
                }else{

                    $res=array('ok'=>false,'url'=>null,'errors'=>$poliza->getErrors());
                }
            }

        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }

    public function actionGeneraCheque($id){

        Yii::app()->quoteUtil->generaCheque($id);

    }

	public function actionPolizaToPdf($id){
        $polizaTitle="POLIZA DE CHEQUE";
        $polizaTitleCopia="COPIA POLIZA DE CHEQUE";
        $resumenTitle="RESUMEN REPOSICION FONDO FIJO DE CAJA";
        $resumenTitleCopia="COPIA RESUMEN REPOSICION FONDO FIJO DE CAJA";
        $table=array();
        $poliza=$this->loadModel($id);

        $table[]=Yii::app()->quoteUtil->generaPoliza($poliza,$polizaTitle,$resumenTitle);
        $table[]=Yii::app()->quoteUtil->generaPoliza($poliza,$polizaTitleCopia,$resumenTitleCopia);
        Yii::app()->quoteUtil->polizaToPdf($table);

    }

	public function actionView($id)
	{
        $polizaTitle="POLIZA DE CHEQUE";
        $resumenTitle="RESUMEN REPOSICION FONDO FIJO DE CAJA";

        $poliza=$this->loadModel($id);
        $tablaPoliza=Yii::app()->quoteUtil->generaPoliza($poliza,$polizaTitle,$resumenTitle);

		$this->render('view',array(
			'model'=>$tablaPoliza,
            'polizaId'=>$id
		));
	}


	public function actionCreate()
	{
		$model=new Polizas;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Polizas']))
		{
			$model->attributes=$_POST['Polizas'];
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

		if(isset($_POST['Polizas']))
		{
			$model->attributes=$_POST['Polizas'];
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

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Polizas('search');
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['Polizas']))
        $model->attributes=$_GET['Polizas'];

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
		$model=Polizas::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='polizas-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
