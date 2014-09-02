<?php

require_once(Yii::getPathOfAlias('ext')."/dhtmlx/connector/scheduler_connector.php");
require_once(Yii::getPathOfAlias('ext')."/dhtmlx/connector/grid_connector.php");
require_once(Yii::getPathOfAlias('ext')."/dhtmlx/connector/db_pdo.php");


class ReservationController extends Controller
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

            array('allow',
                'actions'=>array('BudgetWithDiscount','delete','create','update',
                                 'index','view','exportPdf','dayPassBudget','sendByEmail',
                                 'CabanaCalendar','exportExcel','getRooms','getChildren',
                                 'getRoomCapacity','saveReservation','scheduler_cabana',
                                 'budget','scheduler_camped','CabanaCamped',
                                 'undiscountedBudget','dayPassUndiscountedBudget',
                                 'GridReservation','overviewCalendar','SchedulerOverview',
                                 'emailFormats','getCustomerId'
                ),
                'users'=>array('@'),
            ),

            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionEmailFormats($id){

        $response=$_POST['response'];
        $requestFormat=$_POST['formatId'];

        $criteria=array(
            'condition'=>'customer_reservation_id=:customerReservationId',
            'params'=>array('customerReservationId'=>$id)
        );

        $from=Poll::model()->find($criteria);
        $customerReservation=CustomerReservations::model()->findByPk($id);
        $customer=Customers::model()->findByPk($customerReservation->customer_id);

        $format=Yii::app()->quoteUtil->EmailFormats($id,$requestFormat,$response);

        $this->render('accountNumber',array(
            'format'=>$format,
            'customerReservationId'=>$id,
            'from'=>($from->used_email != null) ? $from->used_email : $from->arrived_email,
            'email'=>$customer->email,
            'cc'=>$customer->alternative_email,
        ));
    }


    public function actionBudget($id){
        $policies=array();
        $poli=array();
        $models=array();
        $cotizacion='';
        $politicas=array();
        $response=$_POST['response'];

        $criteria=array(
            'condition'=>'customer_reservation_id=:customerReservationId',
            'params'=>array('customerReservationId'=>$id)
        );

        $from=Poll::model()->find($criteria);


        $formats = Yii::app()->db->createCommand(array(
            'select' => array('distinct(service_type)'),
            'from' => 'reservation',
            'where' => 'customer_reservation_id=:id',
            'params' => array(':id'=>$id),
        ))->queryAll();

        foreach($formats as $item){

            $pol=BudgetFormat::model()->find(
              'budget=:serviceType',
                array(':serviceType'=>$item['service_type'])
            );

            $datax[]=$pol->id;

        }

        $policies=array();

        foreach($datax as $index){

            $sql2="select * from budget_format_items where budget_format_id=".$index." order by orden asc";
            $connection=Yii::app()->db;
            $command=$connection->createCommand($sql2);
            $rowCount=$command->execute(); // execute the non-query SQL
            $politicas=$command->queryAll(); // execute a query SQL

            foreach($politicas as $xi){
                array_push($policies,$xi['name']);
            }

        }

        foreach($policies as $item):
            $politicas=Policies::model()->findByPk($item);
            $cotizacion.=$politicas->content;
        endforeach;

        $customerReservation=CustomerReservations::model()->findByPk($id);
        $customer=Customers::model()->findByPk($customerReservation->customer_id);

           $criteriaReserv=array(
               'condition'=>'customer_reservation_id=:customer',
               'params'=>array(':customer'=>$customerReservation->id),
           );

           $reservations=Reservation::model()->findAll($criteriaReserv);

           if($reservations){
               foreach($reservations as $item):

                   $checkin= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkin);
                   $checkout= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkout);

                   $checkin_time=date("H:i",strtotime($checkin));
                   $checkout_time=date("H:i",strtotime($checkout));

                   $checkin=date("Y-m-d",strtotime($checkin));
                   $checkout=date("Y-m-d",strtotime($checkout));

                   $models[]=array(
                       'id' =>$item->id,
                       'service_type' =>$item->service_type,
                       'room_type_id'=>$item->room_type_id,
                       'customer_reservation_id' =>$item->customer_reservation_id,
                       'room_id' =>$item->room_id,
                       'checkin' =>$checkin,
                       'checkout' =>$checkout,
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
                       'checkin_hour'=>$checkin_time,
                       'checkout_hour'=>$checkout_time
                   );
               endforeach;
           }

           if($customerReservation->see_discount==true) $budget_table=Yii::app()->quoteUtil->getTableCotizacion($models);
           if($customerReservation->see_discount==false) $budget_table=Yii::app()->quoteUtil->getCotizacionNoDiscount($models);

           $userId=Yii::app()->user->id;
           $username = Yii::app()->user->um->getFieldValueInstance($userId,'nombres');
           $lastname = Yii::app()->user->um->getFieldValueInstance($userId,'apellidos');
           $puesto = Yii::app()->user->um->getFieldValueInstance($userId,'puesto');
           $settings=Settings::model()->find();

           $search=array(
               '{NOMBRE-CLIENTE}','{APELLIDO-CLIENTE}',
               '{PAIS-CLIENTE}','{ESTADO-CLIENTE}',
               '{CIUDAD-CLIENTE}','{TELEFONO-CASA-CLIENTE}',
               '{TELEFONO-TRABAJO-CLIENTE}','{TELEFONO-CELULAR-CLIENTE}',
               '{EMAIL-CLIENTE}','{EMAIL-ALTERNATIVO-CLIENTE}',
               '{RESPUESTA}','{TABLA-COTIZACION}',
               '{NOMBRE-USUARIO}','{APELLIDO-USUARIO}',
               '{PUESTO-USUARIO}','{DIAS-LIMITE-PAGO}'

           );
           $replace=array(
               $customer->first_name,
               $customer->last_name,
               $customer->country,
               $customer->state,
               $customer->city,
               $customer->home_phone,
               $customer->work_phone,
               $customer->cell_phone,
               $customer->email,
               $customer->alternative_email,
               $response,
               $budget_table,
               $username->value,
               $lastname->value,
               $puesto->value,
               $settings->days_limit_of_payment,
           );

           $cotizacion=str_replace($search,$replace,$cotizacion);

        $this->render('budget',array(
            'customerReservationId'=>$customerReservation->id,
            'from'=>$from->used_email,
            'email'=>$customer->email,
            'cc'=>$customer->alternative_email,
            'cotizacion'=>$cotizacion
        ));
    }


    public function actionSchedulerOverview()
    {
        $cn = Yii::app()->quoteUtil->conexion();

        $list = new OptionsConnector($cn,'PDO');
        $list->render_table("rooms","id","id(value),room(label)");

        $scheduler = new SchedulerConnector($cn,'PDO');
        $scheduler->set_options("rooms", $list);

        $sql="SELECT reservation.id,reservation.checkin as start_date,reservation.checkout as end_date,reservation.statux,reservation.description,
        reservation.room_id as section_id,customers.first_name as text,rooms.room FROM customer_reservations inner join reservation on
        customer_reservations.id=reservation.customer_reservation_id inner join customers on
        customer_reservations.customer_id=customers.id inner join rooms on reservation.room_id=rooms.id";

        $scheduler->render_sql($sql, "id","start_date,end_date,text,section_id,description,statux,room");

    }

    public function actionScheduler_cabana(){
               $cn = Yii::app()->quoteUtil->conexion();

               $list = new OptionsConnector($cn,'PDO');
               $list->render_table("rooms","id","id(value),room(label)");

               $scheduler = new SchedulerConnector($cn,'PDO');
               $scheduler->set_options("rooms", $list);

        $sql="SELECT reservation.id,reservation.checkin,reservation.checkout,reservation.statux,reservation.description,
        reservation.room_id,customers.first_name,rooms.room FROM customer_reservations inner join reservation on
        customer_reservations.id=reservation.customer_reservation_id inner join customers on
        customer_reservations.customer_id=customers.id inner join rooms on reservation.room_id=rooms.id";

        $scheduler->render_sql($sql, "id","checkin,checkout,first_name,description,statux,room_id,room");

    }

    public function actionScheduler_camped(){
        $cn = Yii::app()->quoteUtil->conexion();
        $scheduler = new SchedulerConnector($cn,'PDO');

        $sql="SELECT reservation.id,reservation.service_type,reservation.checkin,reservation.checkout,reservation.statux,reservation.description,
        reservation.room_id,customers.first_name FROM customer_reservations inner join reservation on
        customer_reservations.id=reservation.customer_reservation_id inner join customers on
        customer_reservations.customer_id=customers.id where reservation.room_id=0";

        $scheduler->render_sql($sql, "id","checkin,checkout,first_name,service_type,statux");

    }


    public function actionOverviewCalendar(){
        $this->render('overviewCalendar',array());
    }

    public function actionCabanaCalendar(){
        $this->render('cabanaCalendar',array());
    }

    public function actionCampedCalendar(){
        $this->render('campedCalendar',array());
    }


    public function actionBudgetWithDiscount(){

        $models = array();
        $pricepets=0;
        $priceLateCheckout=0;

        if (isset($_POST['Reservation'])){

            $tope=count($_POST['Reservation']['room_type_id']);

            for($i=0;$i<$tope;$i++){

                $model = new Reservation;
                $data=array();

                foreach ($_POST['Reservation'] as $id=>$values)
                {
                    $anexo=array($id=>$values[$i]);
                    $data=array_merge($data,$anexo);
                }

                $model->attributes= $data;
                $model->statux=1;

                $checkin= Yii::app()->quoteUtil->ToEnglishDateTime($model->checkin);
                $checkout= Yii::app()->quoteUtil->ToEnglishDateTime($model->checkout);

                $model->checkin_hour=date("H:i",strtotime($checkin));
                $model->checkout_hour=date("H:i",strtotime($checkout));

                $model->checkin=date("Y-m-d",strtotime($checkin));
                $model->checkout=date("Y-m-d",strtotime($checkout));

                $model->nights=Yii::app()->quoteUtil->nights($model->checkin,$model->checkout);
                $model->totalpax=$model->adults+$model->children;

                $model->nigth_ta=Yii::app()->quoteUtil->getPeakSeason($model->checkin,$model->checkout);
                $model->nigth_tb=Yii::app()->quoteUtil->getLowSeason($model->checkin,$model->checkout);

                $model->price_early_checkin=Yii::app()->quoteUtil->getEarlyCheckin($model->checkin_hour,$model->totalpax);
                $model->price_late_checkout=Yii::app()->quoteUtil->getLateCheckOut($model->checkout_hour,$model->totalpax);

                if($model->pets > 2) $pricepets=100*($model->pets-2);


                if($model->service_type=="CABANA"){  //cotizacion para cabaña

                    if($model->nigth_tb > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceCabana(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_tb,'BAJA'
                        );
                    }

                    if($model->nigth_ta > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceCabana(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_ta,'ALTA'
                        );
                    }
                    $model->price=($model->price_tb*$model->nigth_tb)+($model->price_ta*$model->nigth_ta)+($pricepets*$model->nights)+$model->price_early_checkin+$model->price_late_checkout;

                }

                if($model->service_type=="TENT"){   //cotizacion para casa de campaña

                    if($model->nigth_tb > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceTent(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_tb,'BAJA'
                        );
                    }
                    if($model->nigth_ta > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceTent(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_ta,'ALTA'
                        );
                    }

                    $model->price=($model->price_tb*$model->nigth_tb)+($model->price_ta*$model->nigth_ta)+($pricepets*$model->nights)+$model->price_early_checkin+$model->price_late_checkout;

                }

                if($model->service_type=="CAMPED"){  //cotizacion acampado

                    $model->room_id=0;

                    if($model->nigth_tb > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceCamped(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_tb,'BAJA'
                        );
                    }

                    if($model->nigth_ta > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceCamped(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_ta,'ALTA'
                        );
                    }

                    $model->price=($model->price_tb*$model->nigth_tb)+($model->price_ta*$model->nigth_ta)+($pricepets*$model->nights)+$model->price_early_checkin+$model->price_late_checkout;

                }

                if($model->service_type=="DAYPASS"){  //cotizacion admision al parque

                    $model->nigth_ta=Yii::app()->quoteUtil->getPeakSeasonDayPass($model->checkin);
                    $model->nigth_tb=Yii::app()->quoteUtil->getLowSeasonDayPass($model->checkin);

                    $hora3 = strtotime($model->checkout_hour); //hora en que sale el pax
                    $hora4 = strtotime("18:00");  //hora en que sebe salir el pax
                    if( $hora3 > $hora4 ) $priceLateCheckout=50*$model->totalpax;

                    $model->price_early_checkin=0;
                    $model->price_late_checkout=$priceLateCheckout;

                    $model->room_id=0;

                    if($model->nigth_tb > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceDaypass(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            'ALTA'
                        );
                    }
                    if($model->nigth_ta > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceDaypass(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            'BAJA'
                        );
                    }

                    $model->price=$model->price_ta+$model->price_tb+$pricepets+$model->price_late_checkout;

                }

                $models[]=array_merge($model->attributes,array(
                    'checkin_hour'=>$model->checkin_hour,
                    'checkout_hour'=>$model->checkout_hour,
                    'service_type'=>$model->service_type
                ));

            }

            Yii::app()->getSession()->add('modelExport',$models);
            Yii::app()->getSession()->add('seeDiscount',true);

            echo Yii::app()->quoteUtil->getTableCotizacion($models);



        }
    }

    public function actionUndiscountedBudget(){

        $models = array();
        $pricepets=0;
        $priceLateCheckout=0;

        if (isset($_POST['Reservation'])){

            $tope=count($_POST['Reservation']['room_type_id']);

            for($i=0;$i<$tope;$i++){

                $model = new Reservation;
                $data=array();

                foreach ($_POST['Reservation'] as $id=>$values)
                {
                    $anexo=array($id=>$values[$i]);
                    $data=array_merge($data,$anexo);
                }

                $model->attributes= $data;
                $model->statux=1;

                $checkin= Yii::app()->quoteUtil->ToEnglishDateTime($model->checkin);
                $checkout= Yii::app()->quoteUtil->ToEnglishDateTime($model->checkout);

                $model->checkin_hour=date("H:i",strtotime($checkin));
                $model->checkout_hour=date("H:i",strtotime($checkout));

                $model->checkin=date("Y-m-d",strtotime($checkin));
                $model->checkout=date("Y-m-d",strtotime($checkout));

                $model->nights=Yii::app()->quoteUtil->nights($model->checkin,$model->checkout);
                $model->totalpax=$model->adults+$model->children;

                $model->nigth_ta=Yii::app()->quoteUtil->getPeakSeason($model->checkin,$model->checkout);
                $model->nigth_tb=Yii::app()->quoteUtil->getLowSeason($model->checkin,$model->checkout);

                $model->price_early_checkin=Yii::app()->quoteUtil->getEarlyCheckin($model->checkin_hour,$model->totalpax);
                $model->price_late_checkout=Yii::app()->quoteUtil->getLateCheckOut($model->checkout_hour,$model->totalpax);

                if($model->pets > 2) $pricepets=100*($model->pets-2);


                if($model->service_type=="CABANA"){  //cotizacion para cabaña

                    if($model->nigth_tb > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceCabana(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_tb,'BAJA'
                        );
                    }

                    if($model->nigth_ta > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceCabana(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_ta,'ALTA'
                        );
                    }
                    $model->price=($model->price_tb*$model->nigth_tb)+($model->price_ta*$model->nigth_ta)+($pricepets*$model->nights)+$model->price_early_checkin+$model->price_late_checkout;

                }

                if($model->service_type=="TENT"){   //cotizacion para casa de campaña

                    if($model->nigth_tb > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceTent(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_tb,'BAJA'
                        );
                    }
                    if($model->nigth_ta > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceTent(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_ta,'ALTA'
                        );
                    }

                    $model->price=($model->price_tb*$model->nigth_tb)+($model->price_ta*$model->nigth_ta)+($pricepets*$model->nights)+$model->price_early_checkin+$model->price_late_checkout;

                }

                if($model->service_type=="CAMPED"){  //cotizacion acampado

                    $model->room_id=0;

                    if($model->nigth_tb > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceCamped(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_tb,'BAJA'
                        );
                    }

                    if($model->nigth_ta > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceCamped(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            $model->nigth_ta,'ALTA'
                        );
                    }

                    $model->price=($model->price_tb*$model->nigth_tb)+($model->price_ta*$model->nigth_ta)+($pricepets*$model->nights)+$model->price_early_checkin+$model->price_late_checkout;

                }

                if($model->service_type=="DAYPASS"){  //cotizacion admision al parque

                    $model->nigth_ta=Yii::app()->quoteUtil->getPeakSeasonDayPass($model->checkin);
                    $model->nigth_tb=Yii::app()->quoteUtil->getLowSeasonDayPass($model->checkin);

                    $hora3 = strtotime($model->checkout_hour); //hora en que sale el pax
                    $hora4 = strtotime("18:00");  //hora en que sebe salir el pax
                    if( $hora3 > $hora4 ) $priceLateCheckout=50*$model->totalpax;

                    $model->price_early_checkin=0;
                    $model->price_late_checkout=$priceLateCheckout;

                    $model->room_id=0;

                    if($model->nigth_tb > 0){
                        $model->price_ta=Yii::app()->quoteUtil->getPriceDaypass(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            'ALTA'
                        );
                    }
                    if($model->nigth_ta > 0){
                        $model->price_tb=Yii::app()->quoteUtil->getPriceDaypass(
                            $model->adults,$model->children,
                            $model->service_type,$model->room_type_id,
                            'BAJA'
                        );
                    }

                    $model->price=$model->price_ta+$model->price_tb+$pricepets+$model->price_late_checkout;

                }

                $models[]=array_merge($model->attributes,array(
                    'checkin_hour'=>$model->checkin_hour,
                    'checkout_hour'=>$model->checkout_hour,
                    'service_type'=>$model->service_type
                ));

            }

            Yii::app()->getSession()->add('modelExport',$models);
            Yii::app()->getSession()->add('seeDiscount',false);

            echo Yii::app()->quoteUtil->getCotizacionNoDiscount($models);
        }

    }

    public function actionGetRoomCapacity(){

        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);
        if(Yii::app()->request->isAjaxRequest){
            $roomId=$_POST['room_id'];
            if($roomId ==0){
                for($i=1;$i<=499;$i++):
                    $options.=CHtml::tag('option', array('value'=>$i),CHtml::encode($i),true);
                endfor;
            }
            else{
                $room=Rooms::model()->findByPk($roomId);
                $capacity=$room->capacity;
                for($i=1;$i<=$capacity;$i++):
                    $options.=CHtml::tag('option', array('value'=>$i),CHtml::encode($i),true);
                endfor;
            }

            echo $options;
            Yii::app()->end();
        }

    }

    public function actionGetChildren(){

        $options=CHtml::tag('option', array('value'=>0),CHtml::encode(Yii::t('mx','Select')),true);
        if(Yii::app()->request->isAjaxRequest){
            $adult=$_POST['adult'];
            if($_POST['room_id']==0){
                $tope=499-$adult;
            }
            else{
                $roomId=$_POST['room_id'];
                $room=Rooms::model()->findByPk($roomId);
                $capacity=$room->capacity;
                $tope=$capacity-$adult;
            }

            for($i=1;$i<=$tope;$i++):
                $options.=CHtml::tag('option', array('value'=>$i),CHtml::encode($i),true);
            endfor;

            echo $options;
            Yii::app()->end();
        }

    }

    public function actionGetRooms(){

        //$model = new FBReservation;

        if(Yii::app()->request->isAjaxRequest){

            $roomType=$_POST['roomType'];
            $checkin=$_POST['checkin'];
            $checkout=$_POST['checkout'];

            //if(isset($_POST['FBReservation'])){

                //$model->attributes = $_POST['FBReservation'];

                $roomUnavailable=Yii::app()->quoteUtil->checkAvailability($checkin,$checkout);
                $options=Rooms::model()->getRoomsavailable($roomUnavailable,$roomType);

                if($options){
                    //echo CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select Cabana')),true);
                    foreach ($options as $key => $value) {
                        echo CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
                    }
                }
                else{
                    echo CHtml::tag('option', array('value'=>0),CHtml::encode(Yii::t('mx','Select')),true);
                }

                Yii::app()->end();
            //}
        }
    }



    public function actionView($id){

        Yii::import('bootstrap.widgets.TbForm');
        Yii::import('ext.multimodelform.MultiModelForm');

        $reservation= new Reservation;
        $modelcustomer=new Customers;
        $validatedItems = array();
        $deleteItems=array();
        $models=array();
        $payments=new Payments;


        $form = TbForm::createForm($reservation->getForm(),$reservation,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $formPayments=TbForm::createForm($payments->getForm($id),$payments,
            array(//'htmlOptions'=>array('class'=>'well'),
                'type'=>'horizontal',
            )
        );


        $customerReservation=CustomerReservations::model()->findByPk($id);
        $customer=Customers::model()->findByPk($customerReservation->customer_id);

        $customerForm = TbForm::createForm($modelcustomer->getForm($customer->id),$customer,
            array('id'=>'customers-form',
                'type'=>'vertical',
                'enableClientValidation'=>true,
                'enableAjaxValidation'=>false,
                'focus'=>array($customer,'alternative_email'),
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )
        );

        $criteria=array(
            'condition'=>'customer_reservation_id=:customer',
            'params'=>array(':customer'=>$customerReservation->id),
        );

        $reserations=Reservation::model()->with(array(
            'room'=>array(
                'select'=>'room_type_id,room',
                'together'=>false,
                'joinType'=>'INNER JOIN',
            ),

        ))->findAll($criteria);

        $reservationHistory=new CActiveDataProvider('AuditReservations',array (
                'criteria' => array (
                    'condition' => 'customer_reservation_id=:CustomerReservationId and action<>:action', 'order'=>'stamp DESC',
                    'params'=>array('CustomerReservationId'=>$id,'action'=>'SET')
                ))
        );

        $reservationCreate=new CActiveDataProvider('AuditReservations',array (
                'criteria' => array (
                    'condition' => 'customer_reservation_id=:CustomerReservationId and action=:action',
                    'params'=>array('CustomerReservationId'=>$id,'action'=>'SET')
                ))
        );

        $customerHistory=new CActiveDataProvider('CustomerAudit',array (
                'criteria' => array (
                    'condition' => 'customer_id=:CustomerId and action<>:action', 'order'=>'stamp DESC',
                    'params'=>array('CustomerId'=>$customer->id,'action'=>'SET')
                ))
        );

        $customerCreated=new CActiveDataProvider('CustomerAudit',array (
                'criteria' => array (
                    'condition' => 'customer_id=:CustomerId and action=:action',
                    'params'=>array('CustomerId'=>$customer->id,'action'=>'SET')
                ))
        );

        foreach($reserations as $item):

            $checkin= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkin);
            $checkout= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkout);

            $checkin_time=date("H:i",strtotime($checkin));
            $checkout_time=date("H:i",strtotime($checkout));

            $checkin=date("Y-m-d",strtotime($checkin));
            $checkout=date("Y-m-d",strtotime($checkout));


            $models[]=array(
                'id' =>$item->id,
                'service_type' =>$item->room->roomType->service_type,
                'room_type_id'=>$item->room_type_id,
                'customer_reservation_id' =>$item->customer_reservation_id,
                'room_id' =>$item->room_id,
                'checkin' =>$checkin,
                'checkout' =>$checkout,
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
                'checkin_hour'=>$checkin_time,
                'checkout_hour'=>$checkout_time
            );
        endforeach;

        $reservationCamped=Reservation::model()->findAll(
            'customer_reservation_id=:id and room_id=:roomId',
            array('id'=>$customerReservation->id,'roomId'=>0)
        );

        foreach($reservationCamped as $item){

            $checkin= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkin);
            $checkout= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkout);

            $checkin_time=date("H:i",strtotime($checkin));
            $checkout_time=date("H:i",strtotime($checkout));

            $checkin=date("Y-m-d",strtotime($checkin));
            $checkout=date("Y-m-d",strtotime($checkout));

            $models[]=array(
                'id' =>$item->id,
                'service_type' =>$item->service_type,
                'room_type_id'=>$item->room_type_id,
                'customer_reservation_id' =>$item->customer_reservation_id,
                'room_id' =>$item->room_id,
                'checkin' =>$checkin,
                'checkout' =>$checkout,
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
                'checkin_hour'=>$checkin_time,
                'checkout_hour'=>$checkout_time
            );
        }

        $this->render('view',array(
            'model'=>$models,
            'customerReservation'=>$customerReservation,
            'customer'=>$customer,
            'form'=>$form,
            'reservation'=>$reservation,
            'validatedItems' => $validatedItems,
            'reservationHistory'=> $reservationHistory,
            'reservationCreate'=>$reservationCreate,
            'customerHistory'=>$customerHistory,
            'customerCreated'=>$customerCreated,
            'customerForm'=>$customerForm,
            'formPayments'=>$formPayments
        ));

    }


    public function actionCreate()
    {
        Yii::import('bootstrap.widgets.TbForm');
        Yii::import('ext.multimodelform.MultiModelForm');

        $FBmodel = new FBReservation;
        $reservation= new Reservation;
        $salesAgents=new SalesAgents;
        $reservationChannel= new ReservationChannel;
        $model= new Customers;
        $poll= new Poll;
        $validatedItems = array();
        $deleteItems=array();

        $form = TbForm::createForm($FBmodel->getForm(),$FBmodel,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $reservationForm = TbForm::createForm($reservation->getForm(),$reservation,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $pollForm = TbForm::createForm($poll->getForm(),$poll,
            array(
                //'htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $formSalesAgents=TbForm::createForm($salesAgents->getForm(),$salesAgents,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $formReservationChannel=TbForm::createForm($reservationChannel->getForm(),$reservationChannel,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );


        $CustomerForm = TbForm::createForm($model->getForm(),$model,
            array(
                //'htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
                'enableClientValidation'=>true,
                'focus'=>array($model,'email'),
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )
        );

        if(isset($_POST['CustomerReservations'])){
            $model->attributes=$_POST['CustomerReservations'];
            $masterValues = array ('customer_reservation_id'=>$model->id,'statux'=>1);
            if(MultiModelForm::save($reservation,$validatedItems,$deleteItems,$masterValues) && $model->save()) {

                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }
        }

        $this->render('create',array(
            'form'=>$form,
            'CustomerForm'=>$CustomerForm,
            'reservationForm'=>$reservationForm,
            'model'=>$model,
            'reservation'=>$reservation,
            'validatedItems' => $validatedItems,
            'pollForm'=>$pollForm,
            'formSalesAgents'=>$formSalesAgents,
            'formReservationChannel'=>$formReservationChannel
        ));
    }



    public function actionSaveReservation(){

        $res=array('ok'=>false);
        $totalPrice=0;
        $customerSave=false;
        $reservationSave=false;
        $customer=new Customers;
        $customerReservation= new CustomerReservations;
        $totalPrice=0;
        $reservations=Yii::app()->getSession()->get('modelExport');

        if(Yii::app()->request->isAjaxRequest){


            if(isset($_POST['Customers'])){

                if($_POST['Customers']['id'] ==""){
                    $customer->attributes=$_POST['Customers'];
                    if($customer->save()==true){

                        $customerId = $customer->getPrimaryKey();
                        $customerReservation->see_discount=(int)Yii::app()->getSession()->get('seeDiscount');
                        $customerReservation->customer_id=(int)$customerId;
                        $customerReservation->total=Yii::app()->quoteUtil->getTotalPrice($reservations,$customerReservation->see_discount);

                        if($customerReservation->save()==true){
                            $customerReservationId = $customerReservation->getPrimaryKey();
                            Yii::app()->getSession()->add('CustomerReservation',$customerReservationId);
                            $customerSave=true;
                        }

                    }else{
                        $res=array('ok'=>false,'error'=>$customer->getErrors());
                    }
                }
                else{

                    $customerId = $_POST['Customers']['id'];
                    $customerReservation->see_discount=(int)Yii::app()->getSession()->get('seeDiscount');
                    $customerReservation->customer_id=(int)$customerId;
                    $customerReservation->total=Yii::app()->quoteUtil->getTotalPrice($reservations,$customerReservation->see_discount);

                    if($customerReservation->save()==true){
                        $customerReservationId = $customerReservation->getPrimaryKey();
                        Yii::app()->getSession()->add('CustomerReservation',$customerReservationId);
                        $customerSave=true;
                    }

                }

               if($customerSave==true){


                    foreach($reservations as $items){
                        $reservation=new Reservation;
                        $reservation->attributes=$items;
                        $reservation->checkin=$items['checkin'].' '.$items['checkin_hour'];
                        $reservation->checkout=$items['checkout'].' '.$items['checkout_hour'];
                        $reservation->customer_reservation_id=$customerReservationId;

                        if($reservation->save()==true){ $reservationSave=true; }

                    }

                   if($reservationSave==true){

                       Yii::app()->getSession()->remove('modelExport');
                       Yii::app()->getSession()->remove('seeDiscount');
                       $res=array('ok'=>$reservationSave);
                   }
                }
            }

            echo CJSON::encode($res);

            Yii::app()->end();
        }

    }


    public function actionUpdate()
    {
        $res=array('ok'=>false);
        $attributes=array();
        $model=array();
        $tope=0;

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['Reservation']) && !empty($_POST['because']))
            {
                $reservationHistory= new ReservationHistory;
                $reservationHistory->change=date('Y-m-d H:i');
                $reservationHistory->because=$_POST['because'];
                $reservationHistory->user_id=Yii::app()->user->id;
                $reservationHistory->customer_reservation_id=$_POST['Reservation']['u__'][0]['customer_reservation_id'];
                $reservationHistory->save();


                if(!empty($_POST['Reservation']['service_type'][0])) $tope=count($_POST['Reservation']['service_type']);

                for($i=0;$i<$tope;$i++){

                    $attributes[]=array(
                        'customer_reservation_id'=>$_POST['Reservation']['u__'][0]['customer_reservation_id'],
                        'service_type' =>$_POST['Reservation']['service_type'][$i],
                        'room_type_id'=>$_POST['Reservation']['room_type_id'][$i],
                        'room_id' =>$_POST['Reservation']['room_id'][$i],
                        'checkin' =>$_POST['Reservation']['checkin'][$i],
                        'checkout' =>$_POST['Reservation']['checkout'][$i],
                        'adults' =>$_POST['Reservation']['adults'][$i],
                        'children' =>$_POST['Reservation']['children'][$i],
                        'pets' =>$_POST['Reservation']['pets'][$i],
                    );

                }

                if($attributes != null){
                    Yii::app()->quoteUtil->reservationAdd($attributes);
                }

               foreach($_POST['Reservation']['u__'] as $idx => $attributes){
                   $model[]=Yii::app()->quoteUtil->reservationUpdate($attributes);
               }

                if($model !=null){
                    //'table'=>Yii::app()->quoteUtil->getTableCotizacion($model)
                    $res=array('ok'=>true);
                }

            }
            echo CJSON::encode($res);
            Yii::app()->end();
        }

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


    public function actionIndex(){
        Yii::import('bootstrap.widgets.TbForm');

        $reservation=new Reservation('search');
        $reservation->unsetAttributes();

        $formFilter = TbForm::createForm($reservation->getFormFilter(),$reservation,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'horizontal',
            )
        );

        if(isset($_GET['Reservation'])){
            $reservation->attributes=$_GET['Reservation'];
        }

        $this->render('index',array(
            'customers'=>$reservation,
            'formFilter'=>$formFilter,
        ));

    }

    public function loadModel($id){
        $model=Reservation::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    public function actionGetCustomerId(){

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['idx'])){
                $customerId=(int)$_POST['idx'];
                $reservation=Reservation::model()->findByPk($customerId);
                $res=array('customerId'=>$reservation->customer_reservation_id);
            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }


    protected function performAjaxValidation($model){
        if (Yii::app()->getRequest()->getIsAjaxRequest()) {

            CActiveForm::validate(array($model));
            $errors = $model->getErrors();
            header('Content-type: application/json');
            if ($errors) echo CJSON::encode($errors);
            Yii::app()->end();
        }
    }

    public function actionSendByEmail(){
        $from=$_POST['from'];
        $to=$_POST['email'];
        $budget=$_POST['ckeditor'];
        $cc=$_POST['cc'];
        if(Yii::app()->crugemailer->SendFormat($from,$to,$cc,$budget)) echo "FAILED";
        else echo "SEND";
    }

    public function actionExportPdf(){
        Yii::app()->quoteUtil->exportPdf();
    }

    public function actionExportExcel(){
        $data=Yii::app()->getSession()->get('modelExport');
        Yii::app()->quoteUtil->QuoteToExcel($data);
        //Yii::app()->getSession()->remove('modelExport');
    }

}
