<?php

class BudgetFormatController extends Controller
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
				'actions'=>array('create','update','index','view','delete','getFormat'),
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

    public function actionGetFormat(){

        $formatId=$_POST['format'];
        $customerReservationId=$_POST['customerReservationId'];
        $cotizacion='';
        $models=array();

        $customerReservation=CustomerReservations::model()->findByPk($customerReservationId);
        $customer=Customers::model()->findByPk($customerReservation->customer_id);


        $criteria=array(
            'condition'=>'customer_reservation_id=:customer',
            'params'=>array(':customer'=>$customerReservation->id),
        );

        $reservations=Reservation::model()->with(array(
            'room'=>array(
                'select'=>'room_type_id,room',
                'together'=>false,
                'joinType'=>'INNER JOIN',
            ),

        ))->findAll($criteria);

        if($reservations){
            foreach($reservations as $item):
                $models[]=array(
                    'id' =>$item->id,
                    'service_type' =>$item->room->roomType->service_type,
                    'room_type_id'=>$item->room_type_id,
                    'customer_reservation_id' =>$item->customer_reservation_id,
                    'room_id' =>$item->room_id,
                    'checkin' =>$item->checkin,
                    'checkout' =>$item->checkout,
                    'adults' =>$item->adults,
                    'children' =>$item->children,
                    'pets' =>$item->pets,
                    'totalpax' =>$item->totalpax,
                    'statux' =>$item->statux,
                    'nigth_ta' =>$item->nigth_ta,
                    'nigth_tb' =>$item->nigth_tb,
                    'nights' =>$item->nights,
                    'price_ta' =>$item->price_ta,
                    'price_tb' => $item->price_tb,
                    'price_early_checkin' =>$item->price_early_checkin,
                    'price_late_checkout' =>$item->price_late_checkout,
                    'price' => $item->price,
                    'description' => $item->description,
                    'checkin_hour'=>$item->checkin_hour,
                    'checkout_hour'=>$item->checkout_hour
                );
            endforeach;


            $reservationCamped=Reservation::model()->findAll(
                'customer_reservation_id=:id and room_id=:roomId',
                array('id'=>$customerReservation->id,'roomId'=>0)
            );

            foreach($reservationCamped as $item){
                $models[]=array(
                    'id' =>$item->id,
                    'service_type' =>$item->service_type,
                    'room_type_id'=>$item->room_type_id,
                    'customer_reservation_id' =>$item->customer_reservation_id,
                    'room_id' =>$item->room_id,
                    'checkin' =>$item->checkin,
                    'checkout' =>$item->checkout,
                    'adults' =>$item->adults,
                    'children' =>$item->children,
                    'pets' =>$item->pets,
                    'totalpax' =>$item->totalpax,
                    'statux' =>$item->statux,
                    'nigth_ta' =>$item->nigth_ta,
                    'nigth_tb' =>$item->nigth_tb,
                    'nights' =>$item->nights,
                    'price_ta' =>$item->price_ta,
                    'price_tb' => $item->price_tb,
                    'price_early_checkin' =>$item->price_early_checkin,
                    'price_late_checkout' =>$item->price_late_checkout,
                    'price' => $item->price,
                    'description' => $item->description,
                    'checkin_hour'=>$item->checkin_hour,
                    'checkout_hour'=>$item->checkout_hour
                );
            }
        }

        $sql="SELECT budget_format.budget,labels_format.order,labels.label,budget_format.policies FROM
         `budget_format` inner join labels_format on budget_format.id=labels_format.budget_format_id inner join
          labels on labels.id=labels_format.label_id where budget_format.id=".$formatId;

        $connection = Yii::app()->db;
        $command = $connection->createCommand($sql);
        $formato = $command->queryAll();

        $policies=explode(',',$formato[0]['policies']);

        $politicas=array();

        foreach($policies as $id):
            $politicas[]=Policies::model()->findByPk($id);
        endforeach;

        $cotizacion.="<strong>".$formato[0]['label'].":</strong> ".$customer->first_name." ".$customer->last_name."<br>";
        $cotizacion.="<strong>".$formato[1]['label'].":</strong> ".$customer->home_phone."<br>";
        $cotizacion.="<strong>".$formato[2]['label'].":</strong> ".$customer->state."<br>";
        $cotizacion.="<strong>".$formato[3]['label'].":</strong> ".$customer->email."<br>";
        $cotizacion.="<br>";
        $cotizacion.="<br>";
        $cotizacion.="<strong>".$formato[4]['label'].":</strong> ".$customer->first_name."<br>";
        $cotizacion.="<br>";
        $cotizacion.="<br>";
        $cotizacion.="Gracias por su interés en visitarnos";
        $cotizacion.="<br>";
        $cotizacion.="Favor de visitar nuestra página: www.cocoaventura.com";
        $cotizacion.="<br>";
        $cotizacion.="<br>";

        if($customerReservation->see_discount==true) $cotizacion.=Yii::app()->quoteUtil->getTableCotizacion($models);
        if($customerReservation->see_discount==false) $cotizacion.=Yii::app()->quoteUtil->getCotizacionNoDiscount($models);

        $cotizacion.="<br>";
        $cotizacion.="<br>";

        foreach($politicas as $item):
            $cotizacion.="<br>";
            $cotizacion.="<br>";
            $cotizacion.=$item->content;
        endforeach;

        $cotizacion.="<br><br><br><br><br>";
        $cotizacion.="Atte:\n";

        $userId=Yii::app()->user->id;
        $nombres = Yii::app()->user->um->getFieldValueInstance($userId,'nombres');
        $apellidos = Yii::app()->user->um->getFieldValueInstance($userId,'apellidos');
        $atte=$nombres->value.' '.$apellidos->value;

        $cotizacion.=$atte;

        echo $cotizacion;

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
        Yii::import('ext.multimodelform.MultiModelForm');
        $validatedMembers = array();
        $model=new BudgetFormat;
        $items=new BudgetFormatItems;


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BudgetFormat']))
		{
			$model->attributes=$_POST['BudgetFormat'];
            //$model->policies = implode(',',$_POST['BudgetFormat']['policies']);

			if($model->save()){

                $masterValues = array ('budget_format_id'=>$model->id);

                if (MultiModelForm::save($items,$validatedMembers,$deleteMembers,$masterValues)){
                    Yii::app()->user->setFlash('success','Success');
                    $this->redirect(array('view','id'=>$model->id));
                }
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'items'=>$items,
            'validatedMembers' => $validatedMembers,

		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        Yii::import('ext.multimodelform.MultiModelForm');

        $model=$this->loadModel($id);
        $items=new BudgetFormatItems;
        $validatedMembers = array();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BudgetFormat']))
		{
			$model->attributes=$_POST['BudgetFormat'];
            //$model->policies = implode(',',$_POST['BudgetFormat']['policies']);
            $masterValues = array ('budget_format_id'=>$model->id);

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
        $model=new BudgetFormat('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['BudgetFormat']))
        $model->attributes=$_GET['BudgetFormat'];

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
		$model=BudgetFormat::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='budget-format-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
