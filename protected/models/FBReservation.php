<?php


class FBReservation extends CFormModel{

    public $checkin;
    public $checkout;
    public $type_cabana;

    public function rules()
    {
        return array(
            array('checkin, checkout,type_cabana', 'required'),
            array('type_cabana', 'numerical', 'integerOnly'=>true),

        );

    }

    public function attributeLabels()
    {
        return array(
            'checkin' => Yii::t('mx','Check In'),
            'checkout' => Yii::t('mx','Check Out'),
            'type_cabana' => Yii::t('mx','Type Cabana'),
        );
    }

    public function getForm()
    {
        return array(
            'title' => Yii::t('mx','Availability'),
            'showErrorSummary' => true,
            'elements' => array(

                'checkin' => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'date',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'changeYear' => true,
                        'changeMonth' => true,
                        'minDate'=>0,
                        'onClose'=>'js:function(dateText, inst) {
                            if (endDateTextBox1.val() != "") {
                                var testStartDate = startDateTextBox1.datetimepicker("getDate");
                                var testEndDate = endDateTextBox1.datetimepicker("getDate");
                                if (testStartDate > testEndDate)
                                    endDateTextBox1.datetimepicker("setDate", testStartDate);
                            }
                            else {
                                endDateTextBox1.val(dateText);
                            }
                        }',
                        'onSelect'=>'js:function (selectedDateTime){
                            endDateTextBox1.datetimepicker("option", "minDate", startDateTextBox1.datetimepicker("getDate") );
                        }'
                        /*'beforeShowDay'=> 'js:function(date) {
                            var day = date.getDate();
                            var f=new Date();
                            fechaActual=f.getDate();
                            if (day < fechaActual) {
                                return {0: false}
                            } else {
                                return {0: true}
                            }
                        }',*/
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),

                'checkout' => array(
                    'type'=>'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
                    'language'=>substr(Yii::app()->getLanguage(), 0, 2),
                    'mode'=>'date',
                    'options'=>array(
                        'showAnim'=>'slide',
                        'dateFormat'=>Yii::app()->format->dateFormat,
                        'changeYear' => true,
                        'changeMonth' => true,
                        'minDate'=>0,
                        'onClose'=>'js:function(dateText, inst) {
                            if (startDateTextBox1.val() != "") {
                                var testStartDate = startDateTextBox1.datetimepicker("getDate");
                                var testEndDate = endDateTextBox1.datetimepicker("getDate");
                                if (testStartDate > testEndDate)
                                    startDateTextBox1.datetimepicker("setDate", testEndDate);
                            }
                            else {
                                startDateTextBox1.val(dateText);
                            }
                        }',
                        'onSelect'=>'js:function (selectedDateTime){
                            startDateTextBox1.datetimepicker("option", "maxDate", endDateTextBox1.datetimepicker("getDate") );
                        }'

                        /*'beforeShowDay'=> 'js:function(date) {
                            var day = date.getDate();
                            var f=new Date();
                            fechaActual=f.getDate();
                            if (day < fechaActual) {
                                return {0: false}
                                return [false, "somecssclass"]
                            } else {
                                return {0: true}
                            }
                        }',*/
                    ),
                    'htmlOptions' => array(
                        'class' => 'input-medium',
                    ),
                ),

            ),

            'buttons' => array(

                'search' => array(
                    'type' => 'button',
                    'icon'=>'icon-search',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Search'),
                    'htmlOptions'=>array(
                        'onclick'=>'
                            $("#Reservation_checkin").val($("#FBReservation_checkin").val()+" 15:00");
                            $("#Reservation_checkout").val($("#FBReservation_checkout").val()+" 13:00");
                            $("#reserv").show();
                        '
                    ),
                ),
            )
        );
    }


}