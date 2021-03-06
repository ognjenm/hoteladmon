<?php


class Reservation extends CActiveRecord
{
    public $checkin_hour;
    public $checkout_hour;
    public $first_name;
    public $roomName;
    public $customerId;
    public $cancelDate;
    public $type_reimburse;
    public $charge;
    public $reimburse;
    public $total;
    public $account_id;
    public $status;


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'reservation';
	}

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_reservation_id', 'required'),
			array('customer_reservation_id, room_id, adults, children, pets, totalpax, nigth_ta, nigth_tb, nights', 'numerical', 'integerOnly'=>true),
			array('room_type_id, price_ta, price_tb, price_early_checkin, price_late_checkout, price', 'length', 'max'=>10),
			//array('statux', 'length', 'max'=>13),
			array('checkin, checkin_hour, checkout, checkout_hour,description,service_type,statux,cancelDate', 'safe'),
			array('id,customer_reservation_id, checkin, checkin_hour, checkout, checkout_hour, statux,first_name,roomName', 'safe', 'on'=>'search'),
		);
	}

    public function FormReport(){

        return array(
            'id'=>'formMonthlyReport',
            //'title'=>Yii::t('mx','Report'),

            'elements'=>array(
                "checkin" => array(

                    'type'=>'date',
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'value'=>Yii::t('mx','Select'),
                    'options'=>array(
                        'format'=>'dd-M-yyyy',
                        'autoclose' => true,
                        'showAnim'=>'fold',
                    ),
                ),
                "checkout" => array(
                    'type'=>'date',
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array(
                        'format'=>'dd-M-yyyy',
                        'autoclose' => true,
                        'showAnim'=>'fold',
                    ),
                )
            ),
            'buttons' => array(
                'filter' => array(
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Ok'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-filter',
                    'url'=>Yii::app()->createUrl('/reservation/MonthlyReport'),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $("#mainDiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#mainDiv").removeClass("loading");
                        }',
                        'success' =>'function(data){

                                if(data.ok=true){
                                    CKEDITOR.instances.ckeditor1.updateElement();
                                    CKEDITOR.instances.ckeditor1.setData(data.table);
                                }

                        }',
                    ),

                ),
            )
        );
    }

	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customerReservation' => array(self::BELONGS_TO, 'CustomerReservations', 'customer_reservation_id'),
			'room' => array(self::BELONGS_TO, 'Rooms', 'room_id'),

		);
	}

    public function attributeLabels()
    {
        return array(

            'id' => 'ID',
            'room_type_id' => Yii::t('mx','Accommodation Type'),
            'customer_reservation_id' => Yii::t('mx','Customer Reservation'),
            'room_id' => Yii::t('mx','Cabana'),
            'checkin' => Yii::t('mx','Check In'),
            'checkin_hour' => Yii::t('mx','Check In Time'),
            'checkout' =>Yii::t('mx','Check Out'),
            'checkout_hour' => Yii::t('mx','Check Out Time'),
            'adults' =>Yii::t('mx','Adults  Upper 1.20 mts.'),
            'children' =>Yii::t('mx','Children Lower 1.20 mts.'),
            'pets' =>Yii::t('mx','Pets'),
            'totalpax' =>Yii::t('mx','Totalpax'),
            'statux' =>Yii::t('mx','Status'),
            'nigth_ta' =>Yii::t('mx','Night').' Ta',
            'nigth_tb' =>Yii::t('mx','Night').' Tb',
            'nights' =>Yii::t('mx','Nights'),
            'price_ta' =>Yii::t('mx','Price').' Ta',
            'price_tb' =>Yii::t('mx','Price').' Tb',
            'price_early_checkin' => Yii::t('mx','Price'). ' Early Checkin',
            'price_late_checkout' => Yii::t('mx','Price').' Late Checkout',
            'price' =>Yii::t('mx','Price'),
            'description' =>Yii::t('mx','Description'),
            'first_name'=>'',    //Yii::t('mx','First Name'),
            'roomName'=>Yii::t('mx','Cabana'),
            'service_type'=>Yii::t('mx','Service Type'),
            'cancelDate'=>Yii::t('mx','Date and time of cancellation'),
            'type_reimburse'=>Yii::t('mx','Type reimburse'),
            'charge'=>Yii::t('mx','Penalty charge'),
            'reimburse'=>Yii::t('mx','Reimburse'),
            'total'=>Yii::t('mx','Total reservation'),
            'account_id'=>Yii::t('mx','Account'),
            'status'=>Yii::t('mx','Status')
        );
    }

    public function search2(){

        $criteria=new CDbCriteria;
        $criteria->compare('checkin','>'.date('Y-m-d'));
        $criteria->compare('customerReservation.customer_id',$this->first_name);
        $criteria->order = 'checkin ASC';
        $criteria->group='customer_reservation_id';

        $criteria->with = array(
            'customerReservation' => array(
                'joinType' => 'INNER JOIN',
            ),
        );

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));

    }

	public function search(){

		$criteria=new CDbCriteria;


        $checkin= Yii::app()->quoteUtil->englishOnlyDate($this->checkin);
        $checkout= Yii::app()->quoteUtil->englishOnlyDate($this->checkout);

		$criteria->compare('t.id',$this->id);
        //$criteria->compare('checkin','>='.date('Y-m-d'));

        if(!empty($this->checkout) && !empty($this->checkin)){
            $this->checkin=date("Y-m-d",strtotime($checkin));
            $this->checkout=date("Y-m-d",strtotime($checkout));
            $criteria->compare('checkin','>='.$this->checkin);
            $criteria->compare('checkout','<='.$this->checkout.' 23:59');
        }

        if(!empty($this->checkin) && empty($this->checkout)){
            $this->checkin=date("Y-m-d",strtotime($checkin));
            $criteria->compare('checkin',$this->checkin,true);
        }

        if(!empty($this->checkout) && empty($this->checkin)){
            $this->checkout=date("Y-m-d",strtotime($checkout));
            $criteria->compare('checkout',$this->checkout,true);
        }

        $criteria->compare('room.room', $this->roomName,true);
        $criteria->compare('statux',$this->statux,true);
        $criteria->compare('customerReservation.customer_id',$this->first_name,true);

        //$criteria->condition="checkin>='".date('Y-m-d')."'";
        $criteria->order = 'checkin ASC';

        $criteria->with = array(
            'customerReservation' => array(
                'select'=>'customerReservation.customer_id',
                'joinType' => 'INNER JOIN',
            ),
            'room' => array(
                'select'=>'room.room',
                'joinType' => 'INNER JOIN',
            )
        );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
	}

    //'FOR-CONFIRMED','RESERVED','CANCELLED','NO-SHOW','OCCUPIED'

    public function getColor() {

        $statuscolor='white';

        switch ($this->statux) {
            case 'OCCUPIED':
                $statuscolor='info';
                break;
            case 'PRE-RESERVED':
                $statuscolor='warning';
                break;
            case 'CANCELLED':
                $statuscolor='error';
                break;
            case 'NO-SHOW':
                $statuscolor='success';
                break;
        }

        return $statuscolor;

    }

    public function listStatus(){

        return array(
            'AVAILABLE'=>Yii::t('mx','AVAILABLE'), //1
            'BUDGET-SUBMITTED'=>Yii::t('mx','BUDGET-SUBMITTED'),
            'PRE-RESERVED'=>Yii::t('mx','PRE-RESERVED'),
            'RESERVED-PENDING'=>Yii::t('mx','RESERVED-PENDING'),
            'RESERVED'=>Yii::t('mx','RESERVED'),
            'CANCELLED'=>Yii::t('mx','CANCELLED'),
            'NO-SHOW'=>Yii::t('mx','NO-SHOW'),
            'OCCUPIED'=>Yii::t('mx','OCCUPIED'),
            'ARRIVAL'=>Yii::t('mx','ARRIVAL'),
            'CHECKIN'=>Yii::t('mx','CHECKIN'),
            'CHECKOUT'=>Yii::t('mx','CHECKOUT'),
            'DIRTY'=>Yii::t('mx','DIRTY'),
        );

    }

    public function ArrayStatus(){

        //'FOR-CONFIRMED','RESERVED','CANCELLED','NO-SHOW','OCCUPIED','AVAILABLE'

        return array(
            Yii::t('mx','AVAILABLE'),
            Yii::t('mx','BUDGET-SUBMITTED'),
            Yii::t('mx','PRE-RESERVED'),
            Yii::t('mx','RESERVED-PENDING'),
            Yii::t('mx','RESERVED'),
            Yii::t('mx','CANCELLED'),
            Yii::t('mx','NO-SHOW'),
            Yii::t('mx','OCCUPIED'),
            Yii::t('mx','ARRIVAL'),
            Yii::t('mx','CHECKIN'),
            Yii::t('mx','CHECKOUT'),
            Yii::t('mx','DIRTY'),
        );

    }

    public function getReservationsJson(){

        $json="[\n";

        $reservations=Reservation::model()->with(array(
            'customerReservation'=>array(
                'select'=>'customer_id',
                'together'=>false,
                'joinType'=>'INNER JOIN',
            ),

        ))->findAll();



        foreach($reservations as $item):
            $checkin=date('Y-m-d',strtotime(Yii::app()->quoteUtil->englishOnlyDate($item->checkin)));
            $checkout=date('Y-m-d',strtotime(Yii::app()->quoteUtil->englishOnlyDate($item->checkout)));
            $checkin=$checkin.' '.$item->checkin_hour;
            $checkout=$checkout.' '.$item->checkout_hour;

            $json.="\t{start_date:'".$checkin."', end_date:'".$checkout."', text:'".$item->customerReservation->customer->first_name."', section_id:".$item->room_id.", statux:'".$item->statux."', room:'".$item->statux."'},\n";
        endforeach;

        $json.="]";
        echo $json;
    }

    public function getGridColumns(){

        return array(
            //'id',
            array(
                'name' => 'roomName',
                'value' => '$data->room->room',
            ),
            array(
                'name' =>'customer_reservation_id',
                'value' =>'$data->customer_reservation_id',
                'headerHtmlOptions' => array('style'=>'display:none'),
                'htmlOptions' =>array('style'=>'display:none')
            ),

            array(
                'name' => 'checkin',
                'value' =>'Yii::app()->quoteUtil->spanishDate(date("Y-M-d",strtotime($data->checkin)))'
            ),
            'checkin_hour',
            array(
                'name' => 'checkout',
                'value' => 'Yii::app()->quoteUtil->spanishDate(date("Y-M-d",strtotime($data->checkout)))',
            ),
            'checkout_hour',
            array(
                'name' => 'statux',
                'value' => '$data->statux',
            ),
            'adults',
            'children',
            'pets',
            'nigth_ta',
            'nigth_tb',
            'nights',
            'price_ta',
            'price_tb',
            'price_early_checkin',
            'price_late_checkout',
            array(
                'name' => 'price',
                'value' =>'number_format("$data->price",2)'
            ),

        );
    }

    public function getFormCancel($customerId){
        return array(
            'id'=>'cancelForm',
            'elements'=>array(
                "status"=>array(
                    'type'=>'hidden',
                ),
                "account_id"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>BankAccounts::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select')
                ),
                "total"=>array(
                    'type'=>'text',
                    'class' => 'input-medium',
                    'readonly'=>'readonly'
                ),
                "charge"=>array(
                   'type'=>'text',
                   'class' => 'input-medium',
                    'readonly'=>'readonly'
                ),
                "reimburse"=>array(
                    'type'=>'text',
                    'class' => 'input-medium',
                    'readonly'=>'readonly'
                ),
                "type_reimburse"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>PaymentsTypes::model()->listAll(),
                    'prompt'=>Yii::t('mx','Select')
                ),
                "cancelDate" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>'dd-M-yy',
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),
            ),
            'buttons' => array(
                'cancel' => array(
                    'type' => 'submit',
                    'label' => Yii::t('mx','Aplicar Cargo'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok'
                ),
                'si' => array(
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Si'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                    'url'=>Yii::app()->createUrl('/reservation/getStatus'),
                    'ajaxOptions' => array(
                        'data'=>array('customerId'=>$customerId),
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $("#mainDiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#mainDiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                if(data.ok==true){

                                        if(data.status=="RESERVED" || data.status=="RESERVED-PENDING"){
                                            $("#fechayhora").show("slow");
                                            $("#botones").hide("slow");
                                        }

                                        if(data.status=="PRE-RESERVED"){
                                           location.href=data.url;
                                        }
                                }
                        }',
                    ),
                ),
                'no' => array(
                    'type' => 'link',
                    'label' => Yii::t('mx','No'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-remove',
                    'url'=>Yii::app()->createUrl('/reservation/index'),
                ),
                'ok' => array(
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','ok'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                    'url'=>Yii::app()->createUrl('/reservation/getAmount'),
                    'ajaxOptions' => array(
                        'data'=>array('customerId'=>$customerId,'cancelDate'=>'js:$("#Reservation_cancelDate").val()'),
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $("#mainDiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#mainDiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                if(data.ok==true){
                                            $("#Reservation_total").val(data.total)
                                            $("#Reservation_charge").val(data.charge);
                                            $("#Reservation_reimburse").val(data.reimburse);
                                            $("#Reservation_status").val(data.status);
                                            $("#devolucionDiv").show("slow");
                                            $("#fechayhora").hide("slow");
                                }
                        }',
                    ),
                ),
            )
        );
    }

    public function getFormFilter(){

        return array(
            'id'=>'filterForm',
            'title'=>Yii::t('mx','Criteria'),

            'elements'=>array(

               /* "id"=>array(
                    'label'=>'',
                    'type'=>'text',
                    'class' => 'input-medium',
                ),*/
                "first_name"=>array(
                    'label'=>'',
                    'type' => 'select2',
                    'data'=>Customers::model()->listAllName(),
                    'prompt'=>Yii::t('mx','Search'),
                ),
               /* "checkin" => array(
                    'type'=>'date',
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array(
                        'format'=>'yyyy-M-dd',
                        'autoclose' => true,
                        'showAnim'=>'fold',

                    ),
                ),
                "checkout" => array(
                    'type'=>'date',
                    'prepend'=>'<i class="icon-calendar"></i>',
                    'options'=>array(
                        'format'=>'yyyy-M-dd',
                        'autoclose' => true,
                        'showAnim'=>'fold',

                    ),
                ),
                "roomName"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>Rooms::model()->listAllRoomsNames(),
                    'prompt'=>Yii::t('mx','Select')
                ),
                "statux"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>$this->listStatus(),
                    'prompt'=>Yii::t('mx','Select')
                ),*/

            ),
            'buttons' => array(
                'filter' => array(
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Filter'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-filter',
                    'url'=>Yii::app()->createUrl('/reservation/filter'),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'beforeSend' => 'function() {
                            $("#reservation-grid-inner").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#reservation-grid-inner").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                $("#reservationsFilter").html(data);
                                $("#reservationsContainer").hide();
                        }',
                    ),
                ),
            )
        );
    }

    public function getFormUpdate(){
        return array(

            'elements'=>array(
                "checkin" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                        'minDate'=>0,
                        'hour'=>15,
                        'minute'=>0,
                        'onClose'=>' function(dateText, inst) {
                            if ($("#end").val() != "") {
                                var testStartDate = $("#start").datetimepicker("getDate");
                                var testEndDate = $("#end").datetimepicker("getDate");

                                if (testStartDate > testEndDate)
                                    $("#end").datetimepicker("setDate", testStartDate);

                            }
                            else {
                                $("#end").val(dateText);
                            }
                        }',
                        'onSelect'=>'function (selectedDateTime){
                            $("#end").datetimepicker("option", "minDate", $("#start").datetimepicker("getDate") );
                        }'
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),

                "checkout" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                        'minDate'=>0,
                        'hour'=>13,
                        'minute'=>0,

                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),

                "service_type"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>Rates::model()->listServiceType(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                            var serviceType=$(this).val();
                            var index=$(this).attr("id");
                            index=index.substring(24,26);

                            var indexupdate=$(this).attr("id");
                            indexupdate=indexupdate.substring(0,18);

                            $.ajax({
                                    url: "'.CController::createUrl('/roomsType/getAccommodationType').'",
                                    data: { serviceType: serviceType  },
                                    type: "POST",
                                    beforeSend: function() {
                                        $("#maindiv").addClass("loading");
                                    }
                            })

                            .done(function(data) {

                                $("#Reservation_room_type_id"+index).html(data);
                                $("#"+indexupdate+"room_type_id").html(data);

                            })
                            .fail(function(data) { alert(data); })
                            .always(function() { $("#maindiv").removeClass("loading"); });


                            if(serviceType=="CAMPED"){

                                $.ajax({
                                    url: "'.CController::createUrl('/reservation/getRoomCapacity').'",
                                    data: { room_id: 0  },
                                    type: "POST",
                                    beforeSend: function() {
                                        $("#maindiv").addClass("loading");
                                    }
                                })

                                .done(function(data) {
                                    $("#Reservation_adults"+index).html(data);
                                    $("#"+indexupdate+"adults").html(data);


                                 })
                                .fail(function() { alert( "error" ); })
                                .always(function() { $("#maindiv").removeClass("loading"); });

                            }

                            if(serviceType=="DAYPASS"){

                                $.ajax({
                                    url: "'.CController::createUrl('/reservation/getRoomCapacity').'",
                                    data: { room_id: 0  },
                                    type: "POST",
                                    beforeSend: function() {
                                        $("#maindiv").addClass("loading");
                                    }
                                })

                                .done(function(data) {
                                    $("#Reservation_adults"+index).html(data);
                                    $("#"+indexupdate+"adults").html(data);

                                 })
                                .fail(function() { alert( "error" ); })
                                .always(function() { $("#maindiv").removeClass("loading"); });
                            }

                    ',
                ),
                "room_type_id"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-large',
                    'items'=>RoomsType::model()->listAllRoomsTypes(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                        var roomType=$(this).val();

                        var index=$(this).attr("id");
                        index=index.substring(24,26);

                        var indexupdate=$(this).attr("id");
                        indexupdate=indexupdate.substring(0,18);

                        var checkin=$("#"+indexupdate+"checkin").val();
                        var checkout=$("#"+indexupdate+"checkout").val();

                        if(checkin == undefined){
                            var checkin=$("#Reservation_checkin"+index).val();
                            var checkout=$("#Reservation_checkout"+index).val();
                        }

                        var serviceType=$("#Reservation_service_type"+index).val();

                        if(!serviceType) var serviceType=$("#"+indexupdate+"service_type").val();

                        $.ajax({
                            url: "'.CController::createUrl('/reservation/getRooms').'",
                            data: { serviceType: serviceType, roomType: roomType,checkin:checkin,checkout: checkout  },
                            type: "POST",
                            beforeSend: function() { $("#maindiv").addClass("loading"); }
                        })

                        .done(function(data) {
                            $("#Reservation_room_id"+index).html(data);
                            $("#"+indexupdate+"room_id").html(data);
                        })
                        .fail(function() { bootbox.alert("error"); })
                        .always(function() { $("#maindiv").removeClass("loading"); });

                    ',

                ),

                "room_id"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>Rooms::model()->listAllRooms(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'
                            var roomId=$(this).val();
                            var index=$(this).attr("id");
                            index=index.substring(19,21);

                            var indexupdate=$(this).attr("id");
                            indexupdate=indexupdate.substring(0,18);

                            $.ajax({
                                url: "'.CController::createUrl('/reservation/getRoomCapacity').'",
                                data: { room_id: roomId  },
                                type: "POST",
                                beforeSend: function() {
                                    $("#maindiv").addClass("loading");
                                }
                            })

                            .done(function(data) {
                                $("#Reservation_adults"+index).html(data);
                                $("#"+indexupdate+"adults").html(data);

                            })
                            .fail(function() { alert( "error" ); })
                            .always(function() { $("#maindiv").removeClass("loading"); });
                    ',
                ),

                "adults"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-small',
                    'items'=>array(''=>Yii::t('mx','Select'),1=>1,2=>2,3=>3,4=>4,5=>5,6=>6),
                    'onchange'=>'

                            var adult=$(this).val();
                            var index=$(this).attr("id");
                            index=index.substring(18,20);
                            var indexupdate=$(this).attr("id");
                            indexupdate=indexupdate.substring(0,18);

                            var roomId=$("#"+indexupdate+"room_id").val();

                            if(roomId == undefined){
                                 var roomId=$("#Reservation_room_id"+index).val();
                            }

                            $.ajax({
                                url: "'.CController::createUrl('/reservation/getChildren').'",
                                data: { adult: adult,room_id: roomId },
                                type: "POST",
                                error: function () {
                                    alert("An error ocurred.");
                                },
                                success: function (data) {
                                    $("#Reservation_children"+index).html(data);
                                    $("#"+indexupdate+"children").html(data);

                                }
                            });
                    ',
                ),

                "children"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-small',
                    'items'=>array(0=>Yii::t('mx','Select'),1=>1,2=>2,3=>3,4=>4,5=>5),
                ),
                "pets"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-small',
                    'items'=>array(0=>Yii::t('mx','Select'),1=>1,2=>2,3=>3,4=>4,5=>5),
                ),
                "statux"=>array(
                    'type'=>"hidden"
                ),
                "id"=>array(
                    "type"=>"hidden"
                )
            ));
    }

    public function getForm(){

        return array(

            'elements'=>array(
                "service_type"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>Rates::model()->listServiceType(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                            var serviceType=$(this).val();
                            var index=$(this).attr("id");
                            index=index.substring(24,26);

                            $("#Reservation_checkin"+index).val($("#FBReservation_checkin").val()+" 15:00");
                            $("#Reservation_checkout"+index).val($("#FBReservation_checkout").val()+" 13:00");

                            $.ajax({
                                    url: "'.CController::createUrl('/roomsType/getAccommodationType').'",
                                    data: { serviceType: serviceType  },
                                    type: "POST",
                                    beforeSend: function() {
                                        $("#maindiv").addClass("loading");
                                    }
                            })

                            .done(function(data) { $("#Reservation_room_type_id"+index).html(data); })
                            .fail(function(data) { alert(data); })
                            .always(function() { $("#maindiv").removeClass("loading"); });


                            if(serviceType=="CAMPED"){

                                $.ajax({
                                    url: "'.CController::createUrl('/reservation/getRoomCapacity').'",
                                    data: { room_id: 0  },
                                    type: "POST",
                                    beforeSend: function() {
                                        $("#maindiv").addClass("loading");
                                    }
                                })

                                .done(function(data) { $("#Reservation_adults"+index).html(data); })
                                .fail(function() { alert( "error" ); })
                                .always(function() { $("#maindiv").removeClass("loading"); });

                            }

                            if(serviceType=="DAYPASS"){

                                $("#Reservation_checkin"+index).val($("#FBReservation_checkin").val()+" 09:00");
                                $("#Reservation_checkout"+index).val($("#FBReservation_checkout").val()+" 18:00");

                                $.ajax({
                                    url: "'.CController::createUrl('/reservation/getRoomCapacity').'",
                                    data: { room_id: 0  },
                                    type: "POST",
                                    beforeSend: function() {
                                        $("#maindiv").addClass("loading");
                                    }
                                })

                                .done(function(data) { $("#Reservation_adults"+index).html(data); })
                                .fail(function() { alert( "error" ); })
                                .always(function() { $("#maindiv").removeClass("loading"); });
                            }

                    ',
                ),
                "room_type_id"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-large',
                    'items'=>RoomsType::model()->listAllRoomsTypes(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                        var roomType=$(this).val();
                        var checkin=$("#FBReservation_checkin").val()+" 15:00";
                        var checkout=$("#FBReservation_checkout").val()+" 13:00";

                        var index=$(this).attr("id");
                        index=index.substring(24,26);

                        var serviceType=$("#Reservation_service_type"+index).val();

                        $.ajax({
                            url: "'.CController::createUrl('/reservation/roomsJson').'",
                            data: { serviceType: serviceType, roomType: roomType, checkin: checkin, checkout: checkout  },
                            type: "POST",
                            dataType:"JSON",
                            beforeSend: function() {
                                $("#maindiv").addClass("loading");
                            }
                        })

                        .done(function(data) {

                            $("#Reservation_room_id"+index).html("");

                             $.each(data, function(idx, obj) {
                                $("#Reservation_room_id"+index).append(new Option(obj.value, obj.key));
                             });

                            if(index != ""){

                                $("#Reservation_room_id"+index).html("");
                                var indexAnterior=index-1;
                                var del=$("#Reservation_room_id").val();

                                if(indexAnterior > 1) var del=$("#Reservation_room_id"+indexAnterior).val();

                                roomOptionsRemove.push(del);

                                for(var x=0;x<roomOptionsRemove.length;x++){
                                    for(var i=0; i<data.length; i++) {
                                        if(data[i].key == roomOptionsRemove[x]) {
                                            data.splice(i, 1);
                                            break;
                                        }
                                    }
                                }

                                $.each(data, function(idx, obj) {
                                    $("#Reservation_room_id"+index).append(new Option(obj.value, obj.key));
                                });

                            }


                        })

                        .fail(function() { alert( "error" ); })
                        .always(function() { $("#maindiv").removeClass("loading"); });

                    ',

                ),

                "room_id"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-medium',
                    'items'=>array(),//Rooms::model()->listAllRooms(),
                    'prompt'=>Yii::t('mx','Select'),
                    'onchange'=>'

                            var roomId=$(this).val();
                            var index=$(this).attr("id");
                            index=index.substring(19,21);

                            $.ajax({
                                url: "'.CController::createUrl('/reservation/getRoomCapacity').'",
                                data: { room_id: roomId  },
                                type: "POST",
                                beforeSend: function() {
                                    $("#maindiv").addClass("loading");
                                }
                            })

                            .done(function(data) {

                             $("#Reservation_adults"+index).html(data);

                             })

                            .fail(function() { alert( "error" ); })
                            .always(function() { $("#maindiv").removeClass("loading"); });
                    ',
                ),

                "checkin" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                        'hour'=>15,
                        'minute'=>00,
                        'hourMin'=>9,
                        'minDate'=>0
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),

                "checkout" => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'datetime',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'changeYear' => true,
                        'changeMonth' => true,
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'timeText'=> Yii::t('mx','Schedule'),
                        'hourText'=> Yii::t('mx','Hour'),
                        'minuteText'=>Yii::t('mx','Minute'),
                        'timeOnlyTitle'=>Yii::t('mx','Choose Time'),
                        'hour'=>13,
                        'minute'=>00,
                        'hourMin'=>13,
                        'hourMax'=>18
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),

                "adults"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-small',
                    'items'=>array(''=>Yii::t('mx','Select'),1=>1,2=>2,3=>3,4=>4,5=>5,6=>6),
                    'onchange'=>'

                            var adult=$(this).val();
                            var index=$(this).attr("id");
                            index=index.substring(18,20);

                            $.ajax({
                                url: "'.CController::createUrl('/reservation/getChildren').'",
                                data: { adult: adult,room_id: $("#Reservation_room_id"+index).val() },
                                //dataType: "json",
                                type: "POST",
                                error: function () {
                                    alert("An error ocurred.");
                                },
                                success: function (data) {
                                    $("#Reservation_children"+index).html(data);
                                }
                            });
                    ',
                ),

                "children"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-small',
                    'items'=>array(0=>Yii::t('mx','Select'),1=>1,2=>2,3=>3,4=>4,5=>5),
                ),
                "pets"=>array(
                    'type'=>'dropdownlist',
                    'class' => 'input-small',
                    'items'=>array(0=>Yii::t('mx','Select'),1=>1,2=>2,3=>3,4=>4,5=>5),
                ),
            ),

            'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-money',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Budget With Discount'),
                    'url'=>Yii::app()->createUrl('/reservation/budgetWithDiscount'),
                    'ajaxOptions' => array(
                        'beforeSend' => 'function() {
                            $("#maindiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#maindiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                $("#detailsGrid").html(data);
                                $("#actions").show();
                        }',
                    ),
                ),

                'undiscountedBudget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-money',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Undiscounted Budget'),
                    'url'=>Yii::app()->createUrl('/reservation/undiscountedBudget'),
                    'ajaxOptions' => array(
                        'beforeSend' => 'function() {
                            $("#maindiv").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#maindiv").removeClass("loading");
                        }',
                        'success' =>'function(data){
                                $("#detailsGrid").html(data);
                                $("#actions").show();
                        }',
                    ),
                ),
            )
        );
    }

    public function afterFind() {

        $checkin= date("Y-M-d H:i",strtotime($this->checkin));
        $checkout= date("Y-M-d H:i",strtotime($this->checkout));

        $this->checkin= Yii::app()->quoteUtil->toSpanishDateTime($checkin);
        $this->checkout= Yii::app()->quoteUtil->toSpanishDateTime($checkout);

        /*$this->price_ta= number_format($this->price_ta,2);
        $this->price_tb= number_format($this->price_tb,2);
        $this->price_early_checkin= number_format($this->price_early_checkin,2);
        $this->price_late_checkout= number_format($this->price_late_checkout,2);
        */

        //$this->statux=Yii::t('mx',$this->statux);

       return  parent::afterFind();
    }


    /*public function beforeSave(){

        $this->price_ta= str_replace(",","",$this->price_ta);
        $this->price_tb= str_replace(",","",$this->price_tb);
        $this->price_early_checkin= str_replace(",","",$this->price_early_checkin);
        $this->price_late_checkout= str_replace(",","",$this->price_late_checkout);

       return parent::beforeSave();

    }*/

    public function behaviors()
    {
        return array(
            'AuditReservationsBehavior'=> array(
                'class' => 'application.behaviors.AuditReservationsBehavior',
                'allowed' => array(
                    'customer_reservation_id',
                    'checkin',
                    'checkout',
                    'service_type',
                    'room_type_id',
                    'room_id',
                    'adults',
                    'children',
                    'pets',
                    'statux',
                    'description',
                ),
                'ignored' => array(
                    'totalpax',
                    'nigth_ta',
                    'nigth_tb',
                    'nights',
                    'price_ta',
                    'price_tb',
                    'price_early_checkin',
                    'price_late_checkout',
                    'price',

                )
            )
        );

    }




}