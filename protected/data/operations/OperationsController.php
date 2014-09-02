<?php

class OperationsController extends Controller
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
				'actions'=>array('create',
                    'update','delete',
                    'index','view','deposit',
                    'payment','exportBalanceToPdf',
                    'cancel','ExportPdfToAccountant',
                    'transfer','getOperation'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionGetOperation(){

            $res=array('ok'=>false);

            if(Yii::app()->request->isPostRequest){

                $operationId=(int)$_POST['operationId'];

                $model=$this->loadModel($operationId);

                $res=array('ok'=>true,'price'=>$model->deposit);

                echo CJSON::encode($res);
                Yii::app()->end();

            }

    }


    public function actionTransfer(){

        $model=new Operations;
        $modelDestination= new Operations;

        if(isset($_POST['Operations'])){
            $model->attributes=$_POST['Operations'];
            $sourceAccount=(int)$_POST['sourceAccount'];
            $destinationaccount=(int)$_POST['destinationAccount'];

            $bankSource=Banks::model()->findByPk($sourceAccount);
            $bankDestination=Banks::model()->findByPk($destinationaccount);

            $model->bank_id=$bankSource->id;
            $model->balance=$bankSource->initial_balance-$model->retirement;

            $modelDestination->bank_id=$bankDestination->id;
            $modelDestination->balance=$bankDestination->initial_balance+$model->retirement;

            $bankDestination->initial_balance=$bankDestination->initial_balance+$model->retirement;
            $bankSource->initial_balance=$bankSource->initial_balance-$model->retirement;

            $model->cheq='TRA';
            $model->released=$bankDestination->bank.' '.substr($bankDestination->account_number,-4);
            $model->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankSource->bank.' '.substr($bankSource->account_number,-4);
            $model->person='------';


            $modelDestination->payment_type=$model->payment_type;
            $modelDestination->cheq='TRA';
            $modelDestination->released=$bankDestination->bank.' '.substr($bankDestination->account_number,-4);
            $modelDestination->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankSource->bank.' '.substr($bankSource->account_number,-4);
            $modelDestination->person='------';
            $modelDestination->deposit=$model->retirement;
            $modelDestination->datex=$model->datex;

            if($model->save()){
                $bankSource->save();
                $bankDestination->save();
                $modelDestination->save();
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }
        }

        $this->render('transfer',array(
            'model'=>$model,
        ));

    }

    public function actionCancel($id){

        $res=array('ok'=>false);

        if(Yii::app()->request->isPostRequest){
            $model=$this->loadModel($id);
            $account=Banks::model()->findByPk($model->bank_id);

            if($model->payment_type==6 && $model->iscancelled==0){
                $account->initial_balance=$account->initial_balance+$model->retirement;
                $model->balance=$model->balance+$model->retirement;
                $model->released=Yii::t('mx','CANCELLED');
                $model->concept=Yii::t('mx','CANCELLED');
                $model->bank_concept=Yii::t('mx','CANCELLED');
                $model->iscancelled=1;

                if($account->save() && $model->save()){
                    $res=array('ok'=>true);
                }

            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }

    }

    public function actionPayment()
    {
        $model=new Operations;

        if(isset($_POST['Operations'])){
            $model->attributes=$_POST['Operations'];
            $account=Banks::model()->findByPk($model->bank_id);
            $model->cheq='TRA';
            $model->person='------';
            $balance=$account->initial_balance-$model->retirement;
            $account->initial_balance=$balance;
            $model->balance=$balance;


            if($model->payment_type==6){
                $model->cheq=$account->consecutive;
                $account->consecutive=$account->consecutive+1;
            }

            if(!empty($_POST['name'])) {
                $model->released=$_POST['name'];
            }

            if($model->person=="") $model->person=Yii::t('mx','PENDING');
            if($model->bank_concept=="") $model->bank_concept=Yii::t('mx','PENDING');

            if($model->save()){
                $account->save();
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }
        }

        $this->render('payment',array(
            'model'=>$model,
        ));
    }


    public function actionDeposit()
    {
        $model=new Operations;

        if(isset($_POST['Operations'])){

            $model->attributes=$_POST['Operations'];
            $account=Banks::model()->findByPk($model->bank_id);
            $balance=$account->initial_balance+$model->deposit;
            $account->initial_balance=$balance;
            $model->balance=$balance;
            $model->cheq='DEP';
            $model->released=$account->bank.' '.substr($account->account_number,-4);

            if(!empty($_POST['name'])) {
                $model->person=$_POST['name'];
            }

            if($model->concept=="")         $model->concept=Yii::t('mx','PENDING FOR BILLING');
            if($model->person=="")          $model->person=Yii::t('mx','PENDING');
            if($model->bank_concept=="")    $model->bank_concept=Yii::t('mx','PENDING');


            if(!empty($_POST['reference'])){

                $reservationId=(int)$_POST['reference'];
                $customerReservation=CustomerReservations::model()->findByPk($reservationId);

                $criteria=array(
                    'condition'=>'customer_reservation_id=:customerReservationId',
                    'params'=>array('customerReservationId'=>$customerReservation->id)
                );

                $reservations=Reservation::model()->findAll($criteria);

                foreach($reservations as $item){

                    $checkin= Yii::app()->quoteUtil->toEnglishDateTime($item->checkin);
                    $checkout= Yii::app()->quoteUtil->toEnglishDateTime($item->checkout);
                    $item->checkin=date("Y-m-d H:i",strtotime($checkin));
                    $item->checkout=date("Y-m-d H:i",strtotime($checkout));

                    $item->statux="RESERVED";
                    $item->save();
                }

                $customerReservation->first_payment=1;
                $customerReservation->save();

            }

            if($model->save()){
                $account->save();
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }
        }

        $this->render('deposit',array(
            'model'=>$model,
        ));
    }

	public function actionView($id)
	{
        $model=$this->loadModel($id);

        $this->renderPartial('viewLog',array(
            'model'=>$model,
        ));

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Operations;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Operations']))
		{
			$model->attributes=$_POST['Operations'];
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Operations']))
		{
			$model->attributes=$_POST['Operations'];

            if(!empty($_POST['name'])) $model->person=$_POST['name'];

            /*if($model->released==null && $model->cheq=="DEP"){
                $account=Banks::model()->findByPk($model->bank_id);
                $model->released=$account->bank.' '.substr($account->account_number,-4);
            }*/


            if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('index'));
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
        Yii::import('bootstrap.widgets.TbForm');
        $model=new Operations('search');
        $model->unsetAttributes();  // clear any default values

        $formFilter = TbForm::createForm($model->getFormFilter(),$model,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );

        $operationsHistory=new CActiveDataProvider('AuditOperations',array (
                'criteria' => array (
                    'condition' => 'operation_id=:OperationId', 'order'=>'stamp DESC',
                    'params'=>array('OperationId'=>-1)
                ))
        );

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_GET[0])) {
                $operationId = $_GET[0];
                $operationsHistory=new CActiveDataProvider('AuditOperations',array (
                    'criteria' => array (
                        'condition' => 'operation_id=:OperationId', 'order'=>'stamp DESC',
                        'params'=>array('OperationId'=>$operationId)
                    ))
                );

                echo CJSON::encode($operationsHistory);
            }

        }


        if(isset($_GET['Operations'])){

            $model->attributes=$_GET['Operations'];

            $dataProvider= $model->search();
            $dataProvider->pagination= false;
            $data = $dataProvider->getData();
            Yii::app()->getSession()->add('BalanceToPdf',$data);

        }

        $this->render('index',array(
            'model'=>$model,
            'formFilter'=>$formFilter,
            'operationsHistory'=>$operationsHistory,
        ));

	}

    public function actionExportBalanceToPdf()
    {

        $this->render('_ajaxContent',array(
            'table'=>Yii::app()->quoteUtil->ExportBalance(),
        ));
        //Yii::app()->quoteUtil->ExportBalance();
    }

    public function actionExportPdfToAccountant(){
        $this->render('_ajaxContent',array(
            'table'=>Yii::app()->quoteUtil->ExportPdfToAccountant(),
        ));
    }

	public function loadModel($id)
	{
		$model=Operations::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='operations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
