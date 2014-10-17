<?php

/**
 * This is the model class for table "reservation".
 *
 * The followings are the available columns in table 'reservation':
 * @property integer $id
 * @property string $type_reservation
 * @property integer $customer_reservation_id
 * @property integer $room_id
 * @property string $checkin
 * @property string $checkin_hour
 * @property string $checkout
 * @property string $checkout_hour
 * @property integer $adults
 * @property integer $children
 * @property integer $pets
 * @property integer $totalpax
 * @property string $statux
 * @property integer $nigth_ta
 * @property integer $nigth_tb
 * @property integer $nights
 * @property string $price_ta
 * @property string $price_tb
 * @property string $price_early_checkin
 * @property string $price_late_checkout
 * @property string $price
 *
 * The followings are the available model relations:
 * @property CustomerReservations $customerReservation
 * @property Rooms $room
 */
class Reservation extends CActiveRecord
{
    public $checkin_hour;
    public $checkout_hour;
    public $first_name;
    public $roomName;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reservation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reservation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('customer_reservation_id', 'required'),
			array('customer_reservation_id, room_id, adults, children, pets, totalpax, nigth_ta, nigth_tb, nights', 'numerical', 'integerOnly'=>true),
			array('room_type_id, price_ta, price_tb, price_early_checkin, price_late_checkout, price', 'length', 'max'=>10),
			array('statux', 'length', 'max'=>13),
			array('checkin, checkin_hour, checkout, checkout_hour,description,service_type', 'safe'),
			array('id,customer_reservation_id, checkin, checkin_hour, checkout, checkout_hour, statux,first_name,roomName', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'customerReservation' => array(self::BELONGS_TO, 'CustomerReservations', 'customer_reservation_id'),
			'room' => array(self::BELONGS_TO, 'Rooms', 'room_id'),

		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
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
        );
    }


        /**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
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

                        $.ajax({
                            url: "'.CController::createUrl('/reservation/getRooms').'",
                            data: { roomType: roomType,checkin:checkin,checkout: checkout  },
                            type: "POST",
                            beforeSend: function() { $("#maindiv").addClass("loading"); }
                        })

                        .done(function(data) {
                            $("#Reservation_room_id"+index).html(data);
                            $("#"+indexupdate+"room_id").html(data);
                        })
                        .fail(function() { alert( "error" ); })
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

                            //$("#Reservation_checkin"+index).val($("#FBReservation_checkin").val()+" 15:00");
                            //$("#Reservation_checkout"+index).val($("#FBReservation_checkout").val()+" 13:00");

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

                                $("#Reservation_checkin").val($("#FBReservation_checkin"+index).val()+" 09:00");
                                $("#Reservation_checkout").val($("#FBReservation_checkout"+index).val()+" 18:00");

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

                        $.ajax({
                            url: "'.CController::createUrl('/reservation/getRooms').'",
                            data: { roomType: roomType,checkin:checkin,checkout: checkout  },
                            type: "POST",
                            beforeSend: function() {
                                $("#maindiv").addClass("loading");
                            }
                        })

                        .done(function(data) {$("#Reservation_room_id"+index).html(data); })
                        .fail(function() { alert( "error" ); })
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

                            $.ajax({
                                url: "'.CController::createUrl('/reservation/getRoomCapacity').'",
                                data: { room_id: roomId  },
                                type: "POST",
                                beforeSend: function() {
                                    $("#maindiv").addClass("loading");
                                }
                            })

                            .done(function(data) { $("#Reservation_adults"+index).html(data); })
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

        $this->price_ta= number_format($this->price_ta,2);
        $this->price_tb= number_format($this->price_tb,2);
        $this->price_early_checkin= number_format($this->price_early_checkin,2);
        $this->price_late_checkout= number_format($this->price_late_checkout,2);

        //$this->statux=Yii::t('mx',$this->statux);

       return  parent::afterFind();
    }


    public function beforeSave(){

        $this->price_ta= str_replace(",","",$this->price_ta);
        $this->price_tb= str_replace(",","",$this->price_tb);
        $this->price_early_checkin= str_replace(",","",$this->price_early_checkin);
        $this->price_late_checkout= str_replace(",","",$this->price_late_checkout);

        /*$checkin=$this->checkin.' '.$this->checkin_hour;
        $checkout=$this->checkout.' '.$this->checkin_hour;

        $this->checkin=Yii::app()->quoteUtil->toEnglishDateTime($checkin);
        $this->checkout=Yii::app()->quoteUtil->toEnglishDateTime($checkout);

        $this->checkin= date("Y-m-d H:i",strtotime($this->checkin));
        $this->checkout= date("Y-m-d H:i",strtotime($this->checkout));
        */

       return parent::beforeSave();

    }

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