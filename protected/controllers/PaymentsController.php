<?php

class PaymentsController extends Controller
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
		$this->renderPartial('view',array(
			'model'=>$this->loadModel($id),
		));
	}


	public function actionCreate($id)
	{
		$model=new Payments;
        $res=array('ok'=>false);
        $numcheques=true;

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['Payments'])){

                $model->attributes=$_POST['Payments'];
                $model->amount=str_replace(",","",$_POST['Payments']['amount']);
                $model->customer_reservation_id=$id;
                $model->user_id=Yii::app()->user->id;
                $model->baucher=$_POST['Payments']['baucher'];
                $model->n_operation=$_POST['Payments']['n_operation'];
                $model->n_tarjeta=$_POST['Payments']['n_tarjeta'];

                $customer=CustomerReservations::model()->findByPk($id);
                $person=$customer->customer->first_name.' '.$customer->customer->last_name;
                $balance=BankAccounts::model()->consultDeposit($model->account_id,$model->amount);

                $payment=new Operations;
                $payment->cheq='DEP';
                $payment->person=$person;
                $payment->released=BankAccounts::model()->accountByPk($model->account_id);
                $payment->balance=$balance;
                $payment->concept=Yii::t('mx','PENDING FOR BILLING');
                $payment->deposit=$model->amount;
                $payment->datex=date('Y-m-d');
                $payment->baucher=$model->baucher;
                $payment->n_operation=$model->n_operation;
                $payment->n_tarjeta=$model->n_tarjeta;
                $payment->payment_type=$model->payment_type;
                $payment->account_id=$model->account_id;


                switch($model->payment_type){ //evalua el tipo de pago
                    case 3: //debito
                        //$payment->commission_fee=($payment->deposit*2)/100;
                        //$payment->vat_commission=($payment->commission_fee*16)/100;
                        $payment->charge_bank=$payment->deposit; //-($payment->commission_fee+$payment->vat_commission);
                    break;

                    case 4: //credito
                        //$payment->commission_fee=($payment->deposit*2.5)/100;
                        //$payment->vat_commission=($payment->commission_fee*16)/100;
                        $payment->charge_bank=$payment->deposit; //-($payment->commission_fee+$payment->vat_commission);
                    break;

                    case 6: //cheque
                        $payment->cheq=BankAccounts::model()->consultConsecutiveCheque($payment->account_id);
                        Yii::app()->quoteUtil->consecutiveCheque($payment->account_id);
                        $saveDeposit=Yii::app()->quoteUtil->depositAccount($payment->account_id,$payment->deposit);

                    break;

                }

                if($model->save() && $payment->save()){

                    if($customer->first_payment==0){

                        Yii::app()->quoteUtil->changeStatusReservation($id,"RESERVED"); //cambia todos los estados de las reservaciones que tengan el ID customer_reservation_id

                        $customer->first_payment=1;
                        $customer->save();

                    }

                    $res=array('ok'=>true);

                }
                else $res=array('ok'=>false,'error'=>$model->getErrors());

                echo CJSON::encode($res);
                Yii::app()->end();
            }

        }

	}


	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Payments']))
		{
			$model->attributes=$_POST['Payments'];
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
	public function actionIndex($id)
	{
        Yii::import('bootstrap.widgets.TbForm');
        $payments=new Payments;
        $charges=new Charges;
        $totalcharges=0;
        $totalpayments=0;

        $cusRes=CustomerReservations::model()->findByPk($id);
        $customer=Customers::model()->findByPk($cusRes->customer_id);

        $formPayments=TbForm::createForm($payments->getForm($id),$payments,
            array('type'=>'horizontal')
        );

        $formCharges=TbForm::createForm($charges->getForm($id),$charges,
            array('type'=>'horizontal')
        );

        $gridPayments=new CActiveDataProvider('Payments',array (
                'criteria' => array (
                    'condition' => 'customer_reservation_id=:CustomerReservationId', 'order'=>'datex DESC',
                    'params'=>array('CustomerReservationId'=>$id)
                ))
        );

        $gridCharges=new CActiveDataProvider('Charges',array (
                'criteria' => array (
                    'condition' => 'customer_reservation_id=:CustomerReservationId', 'order'=>'datex DESC',
                    'params'=>array('CustomerReservationId'=>$id)
                ))
        );

        foreach($gridCharges->getData() as $item){
            $totalcharges+=$item->amount;
        }

        foreach($gridPayments->getData() as $item){
            $totalpayments+=$item->amount;
        }

        $this->render('index',array(
            'gridPayments'=>$gridPayments,
            'gridCharges'=>$gridCharges,
            'id'=>$id,
            'customer'=>$customer,
            'formPayments'=>$formPayments,
            'formCharges'=>$formCharges,
            'totalcharges'=>$totalcharges,
            'totalpayments'=>$totalpayments,
            'importe'=>$cusRes
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
		$model=Payments::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='payments-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
