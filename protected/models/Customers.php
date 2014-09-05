<?php


class Customers extends CActiveRecord
{
	public $body;

	public function tableName()
	{
		return 'customers';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('is_billed', 'numerical', 'integerOnly'=>true),
			array('email, first_name, last_name', 'length', 'max'=>100),
			array('alternative_email', 'length', 'max'=>500),
			array('country, state, city, home_phone, work_phone, cell_phone', 'length', 'max'=>50),
			array('international_code1, international_code2, international_code3', 'length', 'max'=>5),
			array('how_find_us', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, email, alternative_email, first_name, last_name, country, state, city, how_find_us, home_phone, work_phone, cell_phone, international_code1, international_code2, international_code3, is_billed', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{

		return array(
		);
	}


	public function attributeLabels()
	{
		return array(
            'id' => 'ID',
            'email' => Yii::t('mx','Email'),
            'alternative_email' => Yii::t('mx','Alternative Email'),
            'first_name' => Yii::t('mx','First Names'),
            'last_name' => Yii::t('mx','Last Names'),
            'country' => Yii::t('mx','Country'),
            'state' => Yii::t('mx','State'),
            'city' => Yii::t('mx','City'),
            'how_find_us' => Yii::t('mx','How did you hear about us?'),
            'home_phone' =>'',
            'work_phone' =>'',
            'cell_phone' => '',
            'international_code1' => Yii::t('mx','Home Phone'),
            'international_code2' => Yii::t('mx','Work Phone'),
            'international_code3' => Yii::t('mx','Cell Phone'),
			'is_billed' => Yii::t('mx','billed'),
            'body'=>''
		);
	}

	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('alternative_email',$this->alternative_email,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('how_find_us',$this->how_find_us,true);
		$criteria->compare('home_phone',$this->home_phone,true);
		$criteria->compare('work_phone',$this->work_phone,true);
		$criteria->compare('cell_phone',$this->cell_phone,true);
		$criteria->compare('international_code1',$this->international_code1,true);
		$criteria->compare('international_code2',$this->international_code2,true);
		$criteria->compare('international_code3',$this->international_code3,true);
		$criteria->compare('is_billed',$this->is_billed);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
	}

    public function listCustomers(){
        return CHtml::listData($this->model()->findAll(array('order'=>'first_name')),'id','first_name');
    }

    public function listFullname(){
        $list=array();
        $res=$this->model()->findAll(array('order'=>'first_name'));

        foreach($res as $item){
            $list[$item->id]=$item->first_name.' '.$item->last_name;
        }

        return $list;
    }

    public function listAllName(){
        $list=array();
        $res=$this->model()->findAll(array('order'=>'first_name'));

        foreach($res as $item){
            $list[$item->first_name.' '.$item->last_name]=$item->first_name.' '.$item->last_name;
        }

        return $list;
    }


    public function listAutocompleteFName(){
        $res=array(''=>'');

        $options=$this->model()->findAll(array('order'=>'first_name'));

        if($options !=null){
            foreach($options as $item){
                $res[]=$item->first_name;
            }
        }
        return $res;
    }


    public function listAutocompleteEmail(){
        $res=array();

        $options=$this->model()->findAll(array('order'=>'email'));

        if($options !=null){
            foreach($options as $item){
                $res[]=$item->email;
            }
        }
        return $res;
    }


    public function listEmail(){
        return CHtml::listData($this->model()->findAll(array('order'=>'email')),'email','email');
    }

    public function getForm($customerId=null){


        return array(
            'id'=>'customer-form',
            //'title' => Yii::t('mx','Customer Data'),
            'showErrorSummary' => true,
            'elements'=>array(

                'id'=>array(
                    'type'=>'hidden',
                ),

                'email'=>array(
                    'type' => 'zii.widgets.jui.CJuiAutoComplete',
                    'source'=>Customers::model()->listAutocompleteEmail(),
                    'options'=>array(
                        'showAnim'=>'fold',
                        'select'=>'js: function(event, ui) {

                                $.ajax({
                                    url: "'.CController::createUrl('/customers/getEmail').'",
                                    data: { email: $(this).val() },
                                    type: "POST",
                                    dataType: "json",
                                })

                                .done(function(data) {
                                        $("#Customers_id").val(data.id);
                                        $("#Customers_first_name").val(data.first_name);
                                        $("#Customers_last_name").val(data.last_name);
                                        $("#Customers_country").val(data.country);
                                        $("#Customers_state").val(data.state);
                                        $("#Customers_city").val(data.city);
                                        $("#Customers_how_find_us").val(data.how_find_us);
                                        $("#Customers_home_phone").val(data.home_phone);
                                        $("#Customers_work_phone").val(data.work_phone);
                                        $("#Customers_cell_phone").val(data.cell_phone);
                                })

                                .fail(function() { alert( "error" ); })
                         }',
                        'change' => 'js:function(event, ui) {
                             $.ajax({
                                    url: "'.CController::createUrl('/customers/getEmail').'",
                                    data: { email: $(this).val() },
                                    type: "POST",
                                    dataType: "json",
                                })

                                .done(function(data) {
                                        $("#Customers_id").val(data.id);
                                        $("#Customers_first_name").val(data.first_name);
                                        $("#Customers_last_name").val(data.last_name);
                                        $("#Customers_country").val(data.country);
                                        $("#Customers_state").val(data.state);
                                        $("#Customers_city").val(data.city);
                                        $("#Customers_how_find_us").val(data.how_find_us);
                                        $("#Customers_home_phone").val(data.home_phone);
                                        $("#Customers_work_phone").val(data.work_phone);
                                        $("#Customers_cell_phone").val(data.cell_phone);
                                })

                                .fail(function() { alert( "error" ); })
                        }',

                    ),
                    'htmlOptions'=>array(
                        'class'=>'span10',
                    ),
                ),

                'alternative_email'=>array(
                    'type'=>'text',
                    'class' => 'span10',
                ),
                'first_name'=>array(
                    'type'=>'text',
                    'class' => 'span10',
                ),
                'last_name'=>array(
                    'type'=>'text',
                    'class' => 'span10',
                ),
                'country'=>array(
                    'type'=>'text',
                    'class' => 'span10',
                ),
                'state'=>array(
                    'type'=>'text',
                    'class' => 'span10',
                ),
                'city'=>array(
                    'type'=>'text',
                    'class' => 'span10',
                ),
                'how_find_us'=>array(
                    'type'=>'textarea',
                    'class' => 'span10',
                ),
                'home_phone'=>array(
                    'mask' => '(999)-999-9999',
                    'type'=>'CMaskedTextField',
                    'htmlOptions'=>array(
                        'class' => 'span4',
                    )
                ),
                'work_phone'=>array(
                    'mask' => '(999)-999-9999',
                    'type'=>'CMaskedTextField',
                    'htmlOptions'=>array(
                        'class' => 'span4',
                    )
                ),

                'cell_phone'=>array(
                    'mask' => '(999)-999-9999',
                    'type'=>'CMaskedTextField',
                    'htmlOptions'=>array(
                        'class' => 'span4',
                    )
                ),

                'international_code1'=>array(
                    'type'=>'text',
                    'attributes'=>array(
                        'class' => 'span2',
                        'style'=>'background:#F5FCCE;border-style:dotted solid'
                    )
                ),
                'international_code2'=>array(
                    'type'=>'text',
                    'class' => 'span2',
                    'attributes'=>array(
                        'class' => 'span2',
                        'style'=>'background:#F5FCCE;border-style:dotted solid'
                    )
                ),
                'international_code3'=>array(
                    'type'=>'text',
                    'class' => 'span2',
                    'attributes'=>array(
                        'class' => 'span2',
                        'style'=>'background:#F5FCCE;border-style:dotted solid'
                    )
                ),


            ),

            'buttons' => array(

                'submit' => array(
                    'visible'=>$customerId !=null ? false : true,
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Reservar'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                    'url'=>Yii::app()->createUrl('/reservation/saveReservation'),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $("#messages-reservation").addClass("saving");
                         }',
                        'complete' => 'function() {
                             $("#messages-reservation").removeClass("saving");
                        }',
                        'success' =>'function(data){
                                var request=data.ok;
                                if(request==true){
                                    $("#customer-form").hide();
                                    $("#wizardReservation_tab_2").removeClass("tab-pane fade");
                                    $("#wizardReservation_tab_2").addClass("tab-pane fade active in");
                                }

                                if(data.ok==false){
                                     $.each(data.error, function(key, val) {
                                        $("#Customers_"+key+"_em_").text(val);
                                        $("#Customers_"+key+"_em_").show();
                                    });
                                 }

                        }',
                    ),
                ),

                'update' => array(
                    'visible'=>$customerId !=null ? true : false,
                    'type' => 'ajaxSubmit',
                    'label' => Yii::t('mx','Save'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-ok',
                    'url'=>Yii::app()->createUrl('/customers/update',array('id'=>$customerId)),
                    'ajaxOptions' => array(
                        'type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {  $("#messages-customer").addClass("saving"); }',
                        'complete' => 'function() {    $("#messages-customer").removeClass("saving"); }',
                        'success' =>'function(data){

                         if(data.ok==true) window.location.reload();
                         if(data.ok==false){

                            $.each(data.error, function(key, val) {
                                $("#Customers_"+key+"_em_").text(val);
                                $("#Customers_"+key+"_em_").show();
                            });

                         }

                         }',
                    ),
                ),
            )
        );
    }

    public function behaviors()
    {
        return array(
            'CustomerAuditBehavior'=> array(
                'class' => 'application.behaviors.CustomerAuditBehavior',
            )
        );

    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
