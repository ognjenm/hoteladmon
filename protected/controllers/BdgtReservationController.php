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
				'actions'=>array('create','update','index','view','delete','budgetWithDiscount','save'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionSave(){

        $activities=Yii::app()->getSession()->get('reservationActivities');
        $errors=array();

        if(Yii::app()->request->isAjaxRequest){

            if (isset($_POST['customerReservationId'])){
                $ReservationId=(int)$_POST['customerReservationId'];

                $reservation = Yii::app()->db->createCommand()
                    ->select("DISTINCT(reservation.customer_reservation_id),customer_reservations.customer_id")
                    ->from('reservation')
                    ->join('customer_reservations','reservation.customer_reservation_id=customer_reservations.id')
                    ->where('reservation.id=:reservationId',array(':reservationId'=>$ReservationId))
                    ->queryRow();

                $customerReservationId=$reservation['customer_reservation_id'];
                $customerId=$reservation['customer_id'];

                if(!empty($activities)){
                    foreach($activities as $item){
                        $bdgtReservation=new BdgtReservation;
                        $bdgtReservation->bdgt_group_id=$item['bdgt_group_id'];

                        $bdgtReservation->bdgt_concept_id=$item['bdgt_concept_id'];
                        $bdgtReservation->customer_reservation_id=$customerReservationId;
                        $bdgtReservation->pax=$item['pax'];
                        $bdgtReservation->price=BdgtConcepts::getSubtotal($item['bdgt_concept_id'],$item['pax']);

                        $fecha=substr($item['fecha'],0,11);
                        $hora=substr($item['fecha'],12,5);

                        $fecha=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($fecha);
                        $dateTime=$fecha." ".$hora;

                        $bdgtReservation->fecha=date('Y-m-d H:i',strtotime($dateTime));

                        if(!$bdgtReservation->save()){
                            array_push($errors,$bdgtReservation->getErrors());
                        }
                    }

                    if(empty($errors)){

                        $grandTotal=BdgtReservation::getAmount($customerReservationId);
                        $customerReservation=CustomerReservations::model()->findByPk($customerReservationId);

                        $totalReservation=$customerReservation->total;
                        $totalActivities=$grandTotal;
                        $customerReservation->total=$totalReservation+$totalActivities;
                        $customerReservation->save();

                        $charges=new Charges;
                        $charges->customer_reservation_id=$customerReservationId;
                        $charges->concept_id=2;
                        $charges->description='Actividades';
                        $charges->amount=$grandTotal;
                        $charges->datex=$fecha;
                        $charges->user_id=Yii::app()->user->id;
                        $charges->guest_name='Cargo Automatico';
                        $charges->save();

                    }


                    if(!empty($errors)){
                        $res=array('ok'=>false,'errors'=>$errors);
                    }else{
                        $res=array('ok'=>true,'url'=>$this->createUrl('/reservation/view',array('id'=>$customerReservationId)));
                        Yii::app()->getSession()->remove('reservationActivities');
                    }
                }else{
                    $res=array('ok'=>false,'errors'=>'Por favor, click al botón de cotizar...');
                }
            }



            echo CJSON::encode($res);
            Yii::app()->end();

        }



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

                Yii::app()->getSession()->add('reservationActivities',$model);

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
