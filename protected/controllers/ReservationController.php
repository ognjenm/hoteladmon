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

            /*array('allow',  // allow all users to perform 'index' and 'view' actions
                'actions'=>array('roomsJson'),
                'users'=>array('*'),
            ),*/

            array('allow',
                'actions'=>array('BudgetWithDiscount','delete','create','update',
                                 'index','view','exportPdf','dayPassBudget','sendByEmail',
                                 'CabanaCalendar','exportExcel','getRooms','getChildren',
                                 'getRoomCapacity','saveReservation','scheduler_cabana',
                                 'budget','scheduler_camped','CabanaCamped',
                                 'undiscountedBudget','dayPassUndiscountedBudget',
                                 'GridReservation','overviewCalendar','SchedulerOverview',
                                 'emailFormats','getCustomerId','ChangeStatus','payment',
                                 'getInformation','dailyReport','exportDailyReport',
                                 'getDailyReport','scheduler_cabana_update','filter',
                                 'schedulerOverview_update','campedReport','getCampedReport',
                                 'roomsJson','cancel','disponibilidad','monthlyReport','getStatus','getAmount'

                ),
                'users'=>array('@'),
            ),

            array('deny',
                'users'=>array('*'),
            ),
        );
    }

    public function actionGetAmount(){

        $res=array('ok'=>false,'amount'=>0);
        $status=null;
        $checkin=null;
        $cargo=0;
        $reembolso=0;

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['customerId'])){
                $customerId=(int)$_POST['customerId'];

                $customerReservation=CustomerReservations::model()->findByPk($customerId);

                $reservation=Reservation::model()->findAll(
                    array(
                        'condition'=>'customer_reservation_id=:customerId',
                        'params'=>array('customerId'=>$customerId)
                    )
                );

                $payments=Payments::model()->find(array(
                    'condition'=>'customer_reservation_id=:customerReservationId',
                    'params'=>array('customerReservationId'=>$customerId)
                ));

                $total=$customerReservation->total;

                foreach($reservation as $item){
                    $status=$item->statux;
                    $checkin=$item->checkin;
                    break;
                }

                $today=$_POST['cancelDate'];
                $todayFecha=substr($today,0,11);
                $todayHora=substr($today,12,5);

                $cancelDate=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($todayFecha);
                $cancelDate=$cancelDate." ".$todayHora;
                $cancelDate=strtotime($cancelDate);

                $dateReservation=$checkin;
                $reservationDate=substr($dateReservation,0,11);
                $reservationTime=substr($dateReservation,12,5);

                $reservation=Yii::app()->quoteUtil->toEnglishDate($reservationDate);
                $reservation=$reservation." ".$reservationTime;
                $reservation=strtotime($reservation);

                $diferencia=$reservation-$cancelDate;

                $diferencia= round(($diferencia/60)/60);

                if($diferencia>=144)  $cargo=0;

                if($diferencia>=48 && $diferencia<=143) $cargo=($total*20)/100;

                if($diferencia>=24 && $diferencia<=47) $cargo=($total*50)/100;

                if($diferencia<24) $cargo=$total;

                $reembolso=$payments->amount-$cargo;

                $res=array('ok'=>true,'charge'=>$cargo,'reimburse'=>$reembolso,'total'=>$total,'status'=>$status);

            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }
    }

    public function actionGetStatus(){

        $res=array('ok'=>false,'status'=>'null');
        $url=false;

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['customerId'])){
                $customerId=(int)$_POST['customerId'];

                $reservation=Reservation::model()->find(array(
                    'condition'=>'customer_reservation_id=:customerReservationId',
                    'params'=>array(':customerReservationId'=>$customerId)
                ));

                if($reservation->statux=="PRE-RESERVED"){
                    Yii::app()->quoteUtil->changeStatusReservation($customerId,"CANCELLED");
                    $url=Yii::app()->createUrl('/reservation/index');
                }

                $res=array('ok'=>true,'status'=>$reservation->statux,'url'=>$url);

            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }
    }

    public function actionCancel($customerId){

        Yii::import('bootstrap.widgets.TbForm');

        $mreservation=new Reservation;

        $Formcancel = TbForm::createForm($mreservation->getFormCancel($customerId),$mreservation,
            array('htmlOptions'=>array(
                'class'=>'well'),
                'type'=>'horizontal',
            )
        );

        if(isset($_POST['Reservation'])){

            if($_POST['Reservation']['status']=='RESERVED' || $_POST['Reservation']['status']=='RESERVED-PENDING'){

                Yii::app()->quoteUtil->changeStatusReservation($customerId,"CANCELLED");

                $retirement=$_POST['Reservation']['reimburse'];
                $account_id=$_POST['Reservation']['account_id'];
                $customerReservation=CustomerReservations::model()->findByPk($customerId);

                $account=BankAccounts::model()->findByPk($account_id);
                $balance=$account->initial_balance-$retirement;
                $account->initial_balance=$balance;
                $errors=null;
                $cheque=false;

                switch($_POST['Reservation']['type_reimburse']){
                    case 5: //transferencia electronica
                        $released=$customerReservation->customer->first_name." ".$customerReservation->customer->last_name;
                        $concept=Yii::t('mx','Customer reimbursement')." ".Yii::t('mx','PENDING FOR BILLING');
                        //payment type, account_id, cheq, date, released, concept, person, bank concept, retirement, deposit, balance;
                        $errors=Yii::app()->quoteUtil->registerAccountCheques(5,$account_id,'TRA',date('Y-m-d'),$released,$concept,'------------','',$retirement,0,$balance);

                        break;

                    case 6: //cheque
                        $released=$customerReservation->customer->first_name." ".$customerReservation->customer->last_name;
                        $concept=Yii::t('mx','Customer reimbursement')." ".Yii::t('mx','PENDING FOR BILLING');
                        $errors=Yii::app()->quoteUtil->registerAccountCheques(6,$account_id,$account->consecutive,date('Y-m-d'),$released,$concept,'------------','',$retirement,0,$balance);

                        $numcheques=BankAccounts::model()->numerosCheque($account_id);
                        $account->consecutive=$account->consecutive+1;
                        $cheque=true;
                        break;

                }

                if(is_array($errors)){

                    $texto="";

                    foreach($errors as $error){
                        $texto.=$error;
                    }


                    Yii::app()->user->setFlash('error',$texto);
                    $this->redirect(array('cancel','customerId'=>$customerId));

                }else{

                    if($cheque){

                        if($numcheques > 0){
                            Yii::app()->user->setFlash('success','Success! numero de cheques disponibles: '.$numcheques);
                            $this->redirect(array('index'));
                        }else{
                            Yii::app()->user->setFlash('error','error! No hay cheques disponibles');
                            $this->redirect(array('cancel','customerId'=>$customerId));
                        }
                    }

                    $account->save();
                    Yii::app()->user->setFlash('success','Success!');
                    $this->redirect(array('index'));

                }

            }

        }

        $customerReservation=CustomerReservations::model()->findByPk($customerId);


        $this->render('cancel',array(
            'customerReservation'=>$customerReservation,
            'Formcancel'=>$Formcancel
        ));

    }

    public function actionMonthlyReport(){

        Yii::import('bootstrap.widgets.TbForm');
        $Report=new Reservation;

        $FormReport = TbForm::createForm($Report->FormReport(),$Report,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );

        $table='<table class="table" style="width:100%">';

        $cvPre='<tr><td>CV Pre-Reservada</td>';
        $cvRe='<tr><td>CV Reservada</td>';
        $cvDis='<tr><td>CV Disponible</td>';

        $caPre='<tr><td>CA Pre-Reservada</td>';
        $caRe='<tr><td>CA Reservada</td>';
        $caDis='<tr><td>CA Disponible</td>';

        $header='<thead><tr><th>Cabañas</th>';

        $res=array('ok'=>false);


        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['Reservation']['checkin']) && isset($_POST['Reservation']['checkout'])){

                $checkin= Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($_POST['Reservation']['checkin']);
                $checkout= Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($_POST['Reservation']['checkout']);
                $fechas=Yii::app()->quoteUtil->returnDateRange($checkin,$checkout);

                foreach($fechas as $index => $value){

                    $header.='<th>'.date('d-M',strtotime($value)).'</th>';

                    $countCvDis=Rooms::model()->count(array(
                        'condition'=>'room_type_id=1 and id not in(select room_id from reservation where
                                (service_type="CABANA" AND room_type_id=1 AND checkin BETWEEN :inicio AND :fin AND (statux=5 or statux=8 or statux=9 or statux=10)) OR
                                (service_type="CABANA" AND room_type_id=1 AND checkout BETWEEN :inicio AND :fin AND (statux=5 or statux=8 or statux=9 or statux=10)) OR
                                (service_type="CABANA" AND room_type_id=1 AND checkin <= :inicio and checkout >= :fin AND (statux=5 or statux=8 or statux=9 or statux=10))
                        )',
                        'params'=>array("inicio"=>$value." 15:00","fin"=>$value." 13:00")
                    ));

                    $countCaDis=Rooms::model()->count(array(
                        'condition'=>'room_type_id=2 and id not in(select room_id from reservation where
                                (service_type="CABANA" AND room_type_id=2 AND checkin BETWEEN :inicio AND :fin AND (statux=5 or statux=8 or statux=9 or statux=10)) OR
                                (service_type="CABANA" AND room_type_id=2 AND checkout BETWEEN :inicio AND :fin AND (statux=5 or statux=8 or statux=9 or statux=10)) OR
                                (service_type="CABANA" AND room_type_id=2 AND checkin <= :inicio and checkout >= :fin AND (statux=5 or statux=8 or statux=9 or statux=10))
                            )',
                        'params'=>array("inicio"=>$value." 15:00","fin"=>$value." 13:00")
                    ));

                    $countCvPre=Reservation::model()->count(array(
                        'condition'=>'(service_type="CABANA" AND room_type_id=1 AND checkin BETWEEN :inicio AND :fin AND statux=3) OR (service_type="CABANA" AND room_type_id=1 AND checkout BETWEEN :inicio AND :fin AND statux=3) OR (service_type="CABANA" AND room_type_id=1 AND checkin <= :inicio and checkout >= :fin AND statux=3)',
                        'params'=>array("inicio"=>$value." 15:00","fin"=>$value." 13:00")
                    ));

                    $countCaPre=Reservation::model()->count(array(
                        'condition'=>'(service_type="CABANA" AND room_type_id=2 AND checkin BETWEEN :inicio AND :fin AND statux=3) OR (service_type="CABANA" AND room_type_id=2 AND checkout BETWEEN :inicio AND :fin AND statux=3) OR (service_type="CABANA" AND room_type_id=2 AND checkin <= :inicio and checkout >= :fin AND statux=3)',
                        'params'=>array("inicio"=>$value." 15:00","fin"=>$value." 13:00")
                    ));

                    $countCvRe=Reservation::model()->count(array(
                        'condition'=>'(service_type="CABANA" AND room_type_id=1 AND checkin BETWEEN :inicio AND :fin AND statux=5) OR (service_type="CABANA" AND room_type_id=1 AND checkout BETWEEN :inicio AND :fin AND statux=5) OR (service_type="CABANA" AND room_type_id=1 AND checkin <= :inicio and checkout >= :fin AND statux=5)',
                        'params'=>array("inicio"=>$value." 15:00","fin"=>$value." 13:00")
                    ));

                    $countCaRe=Reservation::model()->count(array(
                        'condition'=>'(service_type="CABANA" AND room_type_id=2 AND checkin BETWEEN :inicio AND :fin AND statux=5) OR (service_type="CABANA" AND room_type_id=2 AND checkout BETWEEN :inicio AND :fin AND statux=5) OR (service_type="CABANA" AND room_type_id=2 AND checkin <= :inicio and checkout >= :fin AND statux=5)',
                        'params'=>array("inicio"=>$value." 15:00","fin"=>$value." 13:00")
                    ));

                    $cvPre.='<td>'.$countCvPre.'</td>';
                    $cvRe.='<td>'.$countCvRe.'</td>';
                    $cvDis.='<td>'.$countCvDis.'</td>';

                    $caPre.='<td>'.$countCaPre.'</td>';
                    $caRe.='<td>'.$countCaRe.'</td>';
                    $caDis.='<td>'.$countCaDis.'</td>';

                }

                $header.='<thead>';
                $cvPre.='</tr>';
                $cvRe.='</tr>';
                $cvDis.='</tr>';
                $caPre.='</tr>';
                $caRe.='</tr>';
                $caDis.='</tr>';

                $table.=$header.'<tbody>';
                $table.= $cvPre;
                $table.=$cvRe;
                $table.=$cvDis;
                $table.=$caPre;
                $table.=$caRe;
                $table.=$caDis;
                $table.='</tbody>';
                $table.='</table>';

                $res=array('ok'=>true,'table'=>$table);

                echo CJSON::encode($res);
                Yii::app()->end();

            }
        }

        $this->render('_monthlyReport',array(
            'FormReport'=>$FormReport
        ));

    }

    public function actionDisponibilidad(){

        $tabla="";

        $this->render('disponibilidad',array(
            'tabla'=>$tabla,
        ));

    }

    public function actionRoomsJson(){

        if(Yii::app()->request->isAjaxRequest){

            $roomType=$_POST['roomType'];
            $checkin=$_POST['checkin'];
            $checkout=$_POST['checkout'];
            $serviceType=$_POST['serviceType'];
            $array=array();

            $roomUnavailable=Yii::app()->quoteUtil->checkAvailability($serviceType,$checkin,$checkout);
            $options=Rooms::model()->getRoomsavailable($roomUnavailable,$roomType);

            if($options){
                foreach ($options as $key => $value) {
                    $array[]=array('key'=>$key,'value'=>$value);
                }
            }

            echo CJSON::encode($array);
            Yii::app()->end();

        }
    }

    public function actionFilter(){

        if(Yii::app()->request->isAjaxRequest){
            if(isset($_POST['Reservation']['first_name'])){
                $fullName=$_POST['Reservation']['first_name'];
                echo Yii::app()->quoteUtil->reservationTable($fullName);
            }
        }
    }

    public function actionGetDailyReport(){

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['date'])){

                $date=$_POST['date'];

                echo CJSON::encode(array(
                    'report'=>Yii::app()->quoteUtil->dailyReport($date)
                ));

            }else{
                echo CJSON::encode(array(
                    'report'=>'Seleccione una fecha'
                ));
            }

            Yii::app()->end();
        }

    }

    public function actionDailyReport(){

        $tabla=Yii::app()->quoteUtil->dailyReport();

        $this->render('dailyReport',array(
            'tabla'=>$tabla,
        ));

    }

    public function actionExportDailyReport(){
        Yii::app()->quoteUtil->exportDailyReport();
    }

    public function actionGetInformation(){

        $customerReservationId=$_POST['customerReservationId'];
        $payment=0;
        $totalPagado=0;
        $balance=0;

        if(Yii::app()->request->isAjaxRequest){

                $customerReservation=CustomerReservations::model()->findByPk((int)$customerReservationId);

                $payments=Payments::model()->findAll(array(
                    'condition'=>'customer_reservation_id=:customerReservationId',
                    'params'=>array(':customerReservationId'=>$customerReservationId)
                ));

                foreach($payments as $pago){
                    $payment=$payment+$pago->amount;
                }

                $totalPagado=$payment;
                $balance=$customerReservation->total-$totalPagado;

                echo CJSON::encode(array(
                    'total'=>number_format($customerReservation->total,2),
                    'abono'=>number_format($totalPagado,2),
                    'saldo'=>number_format($balance,2)
                ));

            Yii::app()->end();

        }

    }

    public function actionPayment($id){

        Yii::import('bootstrap.widgets.TbForm');

        $customer=CustomerReservations::model()->findByPk($id);
        $person=$customer->customer->first_name.' '.$customer->customer->last_name;
        $total=$customer->total;

        $payment=new Operations;

        $FormPayment = TbForm::createForm($payment->getFormPayment(),$payment,
            array('htmlOptions'=>array(),
                'type'=>'horizontal',
            )
        );

        if (isset($_POST['Operations'])){

            $payment->attributes=$_POST['Operations'];

            $balance=BankAccounts::model()->consultDeposit($payment->account_id,$payment->deposit);

            $payment->cheq='DEP';
            $payment->person=$person;
            $payment->released=BankAccounts::model()->accountByPk($payment->account_id);
            $payment->balance=$balance;

            if($payment->concept=="") $payment->concept=Yii::t('mx','PENDING FOR BILLING');

            if($payment->payment_type==3){    //debito
                $payment->vat_commission=($payment->deposit*2)/100;
                $payment->commission_fee=($payment->vat_commission*16)/100;
                $payment->charge_bank=$payment->deposit-($payment->vat_commission+$payment->commission_fee);
            }

            if($payment->payment_type==4){ // credito
                $payment->vat_commission=($payment->deposit*2.5)/100;
                $payment->commission_fee=($payment->vat_commission*16)/100;
                $payment->charge_bank=$payment->deposit-($payment->vat_commission+$payment->commission_fee);
            }


            if($payment->payment_type==6){
                $payment->cheq=BankAccounts::model()->consultConsecutiveCheque($payment->account_id);
            }

           if($payment->save()){

               $saveCheque=Yii::app()->quoteUtil->consecutiveCheque($payment->account_id);
               $saveDeposit=Yii::app()->quoteUtil->depositAccount($payment->account_id,$payment->deposit);

               if($saveCheque && $saveDeposit){

                   Yii::app()->quoteUtil->changeStatusReservation($id);

                   Yii::app()->user->setFlash('success','Success');
                   $this->redirect(array('index'));

               }
           }


        }


        $this->render('paymentRegister',array(
            'FormPayment'=>$FormPayment,
            'customer'=>$person,
            'total'=>$total
        ));

    }

    public function actionEmailFormats($id){

        $response=$_POST['response'];
        $requestFormat=$_POST['formatId'];
        $bankId=$_POST['bankId'];
        $status=null;
        $concepts=array();
        $concept="nada";
		
		$arrayocupados=array();
		$texto="";
		$tipodecabaña="";
		$disponibles=array();

        if($requestFormat==2) $status=5;
        if($requestFormat==1) $status=3;
		
		$reservations=Reservation::model()->findAll(array(
			'condition'=>'customer_reservation_id=:customerReservationId',
			'params'=>array('customerReservationId'=>$id)
		));
		
		
		foreach($reservations as $value){
			
			$arrayocupados=Reservation::model()->find(array(

				'condition'=>'(room_id=:roomId AND checkin BETWEEN :checkin AND :checkout AND (statux=5 or statux=8 or statux=9 or statux=10)) OR
							  (room_id=:roomId AND checkout BETWEEN :checkin AND :checkout AND (statux=5 or statux=8 or statux=9 or statux=10)) OR
							  (room_id=:roomId AND checkin <= :checkin and checkout >= :checkout AND (statux=5 or statux=8 or statux=9 or statux=10))',
				'params'=>array('roomId'=>$value->room_id,':checkin'=>$value->checkin,':checkout'=>$value->checkout)



			));

            print_r($arrayocupados);

			
			if(!empty($arrayocupados)){

				$tipodecabaña=($value->room_type_id==1) ? "CV-" :"CA-";
				$texto.="Ya existe una reservación para la cabaña ".$tipodecabaña.$value->room_id.", para estas fechas<br>";
				
				$aux=Yii::app()->quoteUtil->checkAvailability($value->service_type,$value->checkin,$value->checkout);
				$aux2=Rooms::model()->getRoomsavailable($aux,$value->room_type_id);
				
				foreach($aux2 as $i=>$v){
					array_push($disponibles,$v);
				}
				
			}
			
		}

				
			if($arrayocupados){
				$cabañas=implode(",",array_unique($disponibles));
				$texto.="Por favor, seleccione una de las siguientes cabañas disponibles: ".$cabañas;
				Yii::app()->user->setFlash('warning',$texto);
			}
		

			$criteria=array(
				'condition'=>'customer_reservation_id=:customerReservationId',
				'params'=>array('customerReservationId'=>$id)
			);

			$from=Poll::model()->find($criteria);
			$customerReservation=CustomerReservations::model()->findByPk($id);
			$customer=Customers::model()->findByPk($customerReservation->customer_id);


			$format=Yii::app()->quoteUtil->EmailFormats($id,$requestFormat,$response,$bankId);

			$this->render('accountNumber',array(
				'format'=>$format,
				'customerReservationId'=>$id,
				'from'=>($from!=null) ? $from->used_email : Yii::app()->params['adminEmail'],
				'email'=>$customer->email,
				'cc'=>$customer->alternative_email,
				'status'=>$status,
				'requestFormat'=>$requestFormat
			));
			
    }

    public function actionBudget($id){
        $policies=array();
        $poli=array();
        $models=array();
        $cotizacion='';
        $politicas=array();
        $response=$_POST['response'];
        $formatId=$_POST['formatId'];

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

        $activitiesRows=BdgtReservation::model()->findAll(array(
            'condition'=>'customer_reservation_id=:customerReservationId',
            'params'=>array('customerReservationId'=>$id)
        ));


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

           if($customerReservation->see_discount==true){
               $budget_table=Yii::app()->quoteUtil->getTableCotizacion($models);
               $amountReservations=Yii::app()->quoteUtil->getTotalPrice($models,true);
           }
           if($customerReservation->see_discount==false){
               $budget_table=Yii::app()->quoteUtil->getCotizacionNoDiscount($models);
               $amountReservations=Yii::app()->quoteUtil->getTotalPrice($models,false);
           }


            if($activitiesRows){

                $dataActivities=array();
                $amountActivities=0;

                foreach($activitiesRows as $itemActivity){

                    $concept=BdgtConcepts::model()->findByPk((int)$itemActivity['bdgt_concept_id']);
                    $price=BdgtConcepts::getPricexPax($itemActivity['bdgt_concept_id']);

                    array_push($dataActivities,array(
                        'description'=>$concept->description,
                        'date'=>$itemActivity['fecha'],
                        'pax'=>$itemActivity['pax'],
                        'pricexpax'=>$price,
                        'subtotal'=>$itemActivity['price']
                    ));
                    $amountActivities+=$itemActivity['price'];
                }

                $activities=Yii::app()->quoteUtil->tableActivities($dataActivities);
                $budget_table.="<br><br><br><br><br>";
                $budget_table.=$activities;
                $amountTotal=$amountReservations+$amountActivities;

                $grandTotal='
                <table class="items table table-condensed table-striped" align="right"  style="width: 500px;">
                    <tbody>
                        <tr>
                            <td style="text-align: right;"><strong>Total Reservacion:</strong></td>
                            <td style="text-align: right;"><strong>$'.number_format($amountReservations,2).'</strong></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;"><strong>Total Actividades:</strong></td>
                            <td style="text-align: right;"><strong><strong style="text-align: right;">$'.number_format($amountActivities,2).'</strong></strong></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">
                            <h3><strong>Total:</strong></h3>
                            </td>
                            <td style="text-align: right;">
                            <h3><strong>$'.number_format($amountTotal,2).'</strong></h3>
                            </td>
                        </tr>
                    </tbody>
                </table>
            ';

                $budget_table.=$grandTotal;
            }


            $budget_table.="<br><br><br>";


           $userId=(int)Yii::app()->user->id;
           $employee=Employees::model()->find(array('condition'=>'user_id=:userId','params'=>array('userId'=>$userId)));
           $settings=Settings::model()->find();

           $search=array(
               '{NOMBRE-CLIENTE}','{APELLIDO-CLIENTE}',
               '{PAIS-CLIENTE}','{ESTADO-CLIENTE}',
               '{CIUDAD-CLIENTE}','{TELEFONO-CASA-CLIENTE}',
               '{TELEFONO-TRABAJO-CLIENTE}','{TELEFONO-CELULAR-CLIENTE}',
               '{EMAIL-CLIENTE}','{EMAIL-ALTERNATIVO-CLIENTE}',
               '{RESPUESTA}','{TABLA-COTIZACION}',
               '{NOMBRE-USUARIO}',
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
               $employee->first_name.' '.$employee->last_name,
               $employee->job_title,
               $settings->days_limit_of_payment,
           );

           $cotizacion=str_replace($search,$replace,$cotizacion);

            $this->render('budget',array(
                'customerReservationId'=>$customerReservation->id,
                'from'=>($from!=null) ? $from->used_email : Yii::app()->params['adminEmail'],
                'email'=>$customer->email,
                'cc'=>$customer->alternative_email,
                'cotizacion'=>$cotizacion,
                'formatId'=>$formatId
            ));
    }

    public function actionSchedulerOverview()
    {
        $cn = Yii::app()->quoteUtil->conexion();

        //$list = new OptionsConnector($cn,'PDO');
        //$list->render_table("rooms","id","id(value),room(label)");

        $scheduler = new JSONSchedulerConnector($cn,'PDO');
        //$scheduler->set_options("rooms", $list);

        $sql="SELECT reservation.id,reservation.checkin as start_date,reservation.checkout as end_date,reservation.statux,
        reservation.description,reservation.room_id as section_id,concat(customers.first_name,' ',customers.last_name) as text,
        rooms.room, customers.id as customerId,customer_reservations.id as customerReservationId, FORMAT(customer_reservations.total,2) as total
        FROM customer_reservations
        INNER JOIN reservation on customer_reservations.id=reservation.customer_reservation_id
        INNER JOIN customers on customer_reservations.customer_id=customers.id
        INNER JOIN rooms on reservation.room_id=rooms.id
        WHERE reservation.statux='CANCELLED' or reservation.statux='RESERVED' or reservation.statux='RESERVED-PENDING' or reservation.statux='PRE-RESERVED'";

        $scheduler->render_sql($sql, "id","start_date,end_date,text,section_id,description,statux,room,customerId,customerReservationId,total");

    }

    public function actionScheduler_cabana(){
        $cn = Yii::app()->quoteUtil->conexion();
        //$list = new OptionsConnector($cn,'PDO');
        //$list->render_table("rooms","id","id(value),room(label)");
        $scheduler = new JSONSchedulerConnector($cn,'PDO');
        //$scheduler->set_options("rooms", $list);

        $sql="SELECT reservation.id,reservation.checkin as start_date,reservation.checkout as end_date,reservation.statux,
        reservation.description,customer_reservations.id as customerReservationId,reservation.room_id,customers.first_name,
        customers.last_name,rooms.room,concat(customers.first_name,' ',customers.last_name) as text
        FROM customer_reservations
        INNER JOIN reservation on customer_reservations.id=reservation.customer_reservation_id
        INNER JOIN customers on customer_reservations.customer_id=customers.id
        INNER JOIN rooms on reservation.room_id=rooms.id
        WHERE reservation.statux='CANCELLED' or reservation.statux='RESERVED' or reservation.statux='RESERVED-PENDING' or reservation.statux='PRE-RESERVED'";

        $scheduler->render_sql($sql, "id","start_date,end_date,text,statux,room,customerReservationId");

    }

    public function actionScheduler_cabana_update(){

        $cn = Yii::app()->quoteUtil->conexion();
        $scheduler = new JSONSchedulerConnector($cn,'PDO');
        $conditions='';

            $estados=explode(",",$_POST['estatus']);
            $totalestados=count($estados);
            $c=1;

            for($i=0;$i<$totalestados;$i++){
                if($c==$totalestados) $conditions.="reservation.statux='".$estados[$i]."'";
                else $conditions.="reservation.statux='".$estados[$i]."' or ";
                $c++;
            }


            $sql="SELECT reservation.id,reservation.checkin as start_date,reservation.checkout as end_date,reservation.statux,
            reservation.description,customer_reservations.id as customerReservationId,reservation.room_id,customers.first_name,
            customers.last_name,rooms.room,concat(customers.first_name,' ',customers.last_name) as text
            FROM customer_reservations
            INNER JOIN reservation on customer_reservations.id=reservation.customer_reservation_id
            INNER JOIN customers on customer_reservations.customer_id=customers.id
            INNER JOIN rooms on reservation.room_id=rooms.id
            WHERE ".$conditions;

            $scheduler->render_sql($sql, "id","start_date,end_date,text,statux,room,customerReservationId");

    }

    public function actionSchedulerOverview_update(){

        $cn = Yii::app()->quoteUtil->conexion();
        $scheduler = new JSONSchedulerConnector($cn,'PDO');
        $conditions='';

        $estados=explode(",",$_POST['estatus']);
        $totalestados=count($estados);
        $c=1;

        for($i=0;$i<$totalestados;$i++){
            if($c==$totalestados) $conditions.="reservation.statux='".$estados[$i]."'";
            else $conditions.="reservation.statux='".$estados[$i]."' or ";
            $c++;
        }

        $sql="SELECT reservation.id,reservation.checkin as start_date,reservation.checkout as end_date,reservation.statux,
        reservation.description,reservation.room_id as section_id,concat(customers.first_name,' ',customers.last_name) as text,
        rooms.room, customers.id as customerId,customer_reservations.id as customerReservationId, FORMAT(customer_reservations.total,2) as total
        FROM customer_reservations
        INNER JOIN reservation on customer_reservations.id=reservation.customer_reservation_id
        INNER JOIN customers on customer_reservations.customer_id=customers.id
        INNER JOIN rooms on reservation.room_id=rooms.id
        WHERE ".$conditions;

        $scheduler->render_sql($sql, "id","start_date,end_date,text,section_id,description,statux,room,customerId,customerReservationId,total");


    }

    public function actionScheduler_camped(){
        $cn = Yii::app()->quoteUtil->conexion();
        $scheduler = new JSONSchedulerConnector($cn,'PDO');

        $sql="SELECT reservation.id,reservation.service_type,reservation.checkin,reservation.checkout,reservation.statux,
        reservation.description,customer_reservations.id as customerReservationId,reservation.room_id,customers.first_name
        FROM customer_reservations
        INNER JOIN reservation on customer_reservations.id=reservation.customer_reservation_id
        INNER JOIN customers on customer_reservations.customer_id=customers.id
        WHERE (reservation.service_type='TENT' or reservation.service_type='CAMPED' OR reservation.service_type='DAYPASS')
        AND (reservation.statux='CANCELLED' or reservation.statux='RESERVED' or reservation.statux='RESERVED-PENDING' or reservation.statux='PRE-RESERVED')";

        $scheduler->render_sql($sql, "id","checkin,checkout,first_name,service_type,statux,customerReservationId");

    }

    public function actionSchedulerCamped_update(){
        $cn = Yii::app()->quoteUtil->conexion();
        $scheduler = new JSONSchedulerConnector($cn,'PDO');

        $conditions='';

        $estados=explode(",",$_POST['estatus']);
        $totalestados=count($estados);
        $c=1;

        for($i=0;$i<$totalestados;$i++){
            if($c==$totalestados) $conditions.="reservation.statux='".$estados[$i]."'";
            else $conditions.="reservation.statux='".$estados[$i]."' or ";
            $c++;
        }

        $sql="SELECT reservation.id,reservation.service_type,reservation.checkin,reservation.checkout,reservation.statux,
        reservation.description,customer_reservations.id as customerReservationId,reservation.room_id,customers.first_name
        FROM customer_reservations
        INNER JOIN reservation on customer_reservations.id=reservation.customer_reservation_id
        INNER JOIN customers on customer_reservations.customer_id=customers.id
        WHERE (reservation.service_type='TENT' or reservation.service_type='CAMPED' OR reservation.service_type='DAYPASS') and (".$conditions.")";

        $scheduler->render_sql($sql, "id","checkin,checkout,first_name,service_type,statux,customerReservationId");

    }

    public function actionCampedReport(){

        $tabla=Yii::app()->quoteUtil->campedReport();

        $this->render('campedReport',array('tabla'=>$tabla));
    }

    public function actionGetCampedReport(){

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['date'])){

                $date=$_POST['date'];

                echo CJSON::encode(array(
                    'report'=>Yii::app()->quoteUtil->campedReport($date)
                ));

            }else{
                echo CJSON::encode(array(
                    'report'=>'Seleccione una fecha'
                ));
            }

            Yii::app()->end();
        }

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

                //if($model->pets > 2) $pricepets=100*($model->pets-2);
                $mascotas=(int)$model->pets;
                $pricepets=Yii::app()->quoteUtil->pricePets($mascotas);


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

                //if($model->pets > 2) $pricepets=100*($model->pets-2);

                $mascotas=(int)$model->pets;
                $pricepets=Yii::app()->quoteUtil->pricePets($mascotas);

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
            $serviceType=$_POST['serviceType'];

                $roomUnavailable=Yii::app()->quoteUtil->checkAvailability($serviceType,$checkin,$checkout);

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
                    'params'=>array('CustomerId'=>$customer->id,'action'=>'SET'),
                    'with' => array('users')
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

        $activitiesRows=BdgtReservation::model()->findAll(
            array(
                'condition'=>'customer_reservation_id=:customerReservationId',
                'params'=>array('customerReservationId'=>$customerReservation->id)
            )
        );

        if($activitiesRows){

            $tabla=array();

            foreach($activitiesRows as $item){

                $concept=BdgtConcepts::model()->findByPk((int)$item['bdgt_concept_id']);
                $price=BdgtConcepts::getPricexPax($item['bdgt_concept_id']);
                $priceSupplier=BdgtConcepts::getPriceProviderxPax($item['bdgt_concept_id']);
                $amountSupplier=$item['pax']*$priceSupplier;

                array_push($tabla,array(
                    'description'=>$concept->description,
                    'date'=>$item['fecha'],
                    'pax'=>$item['pax'],
                    'pricexpax'=>$price,
                    'pricesupplier'=>$priceSupplier,
                    'subtotal'=>$item['price'],
                    'amountSupplier'=>$amountSupplier
                ));
            }

            $nameCustomer=$customer->first_name." ".$customer->last_name;
            $activities=Yii::app()->quoteUtil->tableActivities($tabla);
            $reportSupplier=Yii::app()->quoteUtil->reportActivitiesSupplier($tabla,$nameCustomer);

        }else{
            $activities=false;
            $reportSupplier="";
        }


        $poll=Poll::model()->find(array(
                'condition'=>'customer_reservation_id=:customerReservationId',
                'params'=>array('customerReservationId'=>$id)
        ));




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
            'formPayments'=>$formPayments,
            'activities'=>$activities,
            'reportSupplier'=>$reportSupplier,
            'poll'=>$poll
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
        $bdgtReservation=new BdgtReservation;
        $customerReservation=new CustomerReservations;
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
                'type'=>'vertical',
                'enableClientValidation'=>true,
                'focus'=>array($model,'email'),
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )
        );

        $bdgtReservationForm = TbForm::createForm($bdgtReservation->getForm(),$bdgtReservation,
            array(
                'type'=>'inline',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
            )
        );

        $customerReservationForm=TbForm::createForm($customerReservation->getForm(),$customerReservation,
            array(
                'id'=>'customerReservationForm',
                'type'=>'inline',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                'htmlOptions'=>array('class'=>'well'),
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


        $gridFindCustomerReservation=new Reservation('search2');
        $gridFindCustomerReservation->unsetAttributes();

        if(isset($_GET['CustomerReservations']))
            $gridFindCustomerReservation->first_name=$_GET['CustomerReservations']['customer_id'];
        else $gridFindCustomerReservation->first_name=0;


        $this->render('create',array(
            'form'=>$form,
            'CustomerForm'=>$CustomerForm,
            'reservationForm'=>$reservationForm,
            'model'=>$model,
            'reservation'=>$reservation,
            'validatedItems' => $validatedItems,
            'pollForm'=>$pollForm,
            'formSalesAgents'=>$formSalesAgents,
            'formReservationChannel'=>$formReservationChannel,
            'bdgtReservationForm'=>$bdgtReservationForm,
            'bdgtReservation'=>$bdgtReservation,
            'customerReservationForm'=>$customerReservationForm,
            'gridFindCustomerReservation'=>$gridFindCustomerReservation
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
        $errors=array();

        if(Yii::app()->request->isAjaxRequest){

            $customerReservationId=(int)$_GET['customerReservationId'];

            if(isset($_POST['Reservation']) && !empty($_POST['because']))
            {
                $reservationHistory= new ReservationHistory;
                $reservationHistory->change=date('Y-m-d H:i');
                $reservationHistory->because=$_POST['because'];
                $reservationHistory->user_id=Yii::app()->user->id;
                $reservationHistory->customer_reservation_id=$customerReservationId;
                $status=$_POST['Reservation']['u__'][0]['statux'];
                $reservationHistory->save();


                if(!empty($_POST['Reservation']['service_type'][0])){

                    $tope=count($_POST['Reservation']['service_type']);

                    for($i=0;$i<$tope;$i++){

                        $attributes[]=array(
                            'service_type' =>$_POST['Reservation']['service_type'][$i],
                            'room_type_id'=>$_POST['Reservation']['room_type_id'][$i],
                            'customer_reservation_id'=>$customerReservationId,
                            'room_id' =>$_POST['Reservation']['room_id'][$i],
                            'checkin' =>$_POST['Reservation']['checkin'][$i],
                            'checkout' =>$_POST['Reservation']['checkout'][$i],
                            'adults' =>$_POST['Reservation']['adults'][$i],
                            'children' =>$_POST['Reservation']['children'][$i],
                            'pets' =>$_POST['Reservation']['pets'][$i],
                        );
                    }

                    $aux=Yii::app()->quoteUtil->reservationAdd($attributes,$status);
                    $model=$aux['attributes'];
                    $errors=$aux['errors'];

                }

               $allExistingPk = isset($_POST['Reservation']['pk__']) ? $_POST['Reservation']['pk__'] : null;

               foreach($_POST['Reservation']['u__'] as $idx => $attrs){
                   $aux=Yii::app()->quoteUtil->reservationUpdate($attrs);
                   array_push($model,$aux['attributes']);
                   array_push($errors,$aux['errors']);

                   if (is_array($allExistingPk)) unset($allExistingPk[$idx]);
               }

                if (is_array($allExistingPk))
                    foreach($allExistingPk as $delPks)
                        Reservation::model()->deleteByPk($delPks['id']);

                $customerReservation=CustomerReservations::model()->findByPk($customerReservationId);
                $grandTotal=Yii::app()->quoteUtil->getTotalPrice($model,$customerReservation->see_discount);
                $customerReservation->total=$grandTotal;
                $customerReservation->save();

                $charge=Charges::model()->find(array(
                    'condition'=>'customer_reservation_id=:customerReservationId and concept_id=1',
                    'params'=>array('customerReservationId'=>$customerReservationId)
                ));

                $charge->amount=$grandTotal;
                $charge->save();

                if($errors !=null) $res=array('ok'=>true);

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
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
                'type'=>'inline',
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

    public function actionChangeStatus(){

        $res=array('ok'=>false);

        if(Yii::app()->request->isAjaxRequest){

            $customerReservationId=(int)$_POST['id'];
            $status=(int)$_POST['status'];

            Yii::app()->quoteUtil->changeStatusReservation($customerReservationId,$status);
            $res=array('ok'=>true,'url'=>$this->createUrl('/reservation/view',array('id'=>$customerReservationId)));

        }

        echo CJSON::encode($res);
        Yii::app()->end();

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

    public function actionError()
    {
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}