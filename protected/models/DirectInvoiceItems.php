<?php

/**
 * This is the model class for table "direct_invoice_items".
 *
 * The followings are the available columns in table 'direct_invoice_items':
 * @property integer $id
 * @property integer $direct_invoice_id
 * @property integer $article_id
 * @property string $quantity
 * @property string $price
 * @property string $amount
 * @property string $discount
 * @property string $subtotal
 * @property string $vat
 * @property string $ieps
 * @property string $retiva
 * @property string $retisr
 * @property string $total
 *
 * The followings are the available model relations:
 * @property DirectInvoice $directInvoice
 */
class DirectInvoiceItems extends CActiveRecord
{

    public $presentation;
    public $discount_percent;
    public $ieps_percent;
    public $retiva_percent;
    public $retisr_percent;
    public $vat_percent;

    public $quantity2;
    public $price2;
    public $provider1;
    public $provider2;
    public $article1;
    public $article2;
    public $total2;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'direct_invoice_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('direct_invoice_id, quantity', 'required'),
			array('direct_invoice_id, article_id', 'numerical', 'integerOnly'=>true),
			array('quantity, price, amount, discount, subtotal, vat, ieps, retiva, retisr, total,discount_percent,ieps_percent,retiva_percent,retisr_percent,vat_percent', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, direct_invoice_id, article_id, quantity, price, amount, discount, subtotal, vat, ieps, retiva, retisr, total', 'safe', 'on'=>'search'),
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
            'directInvoice' => array(self::BELONGS_TO, 'DirectInvoice', 'direct_invoice_id'),
            'article' => array(self::BELONGS_TO, 'Articles', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'direct_invoice_id' => Yii::t('mx','Direct Invoice'),
			'article_id' => Yii::t('mx','Article'),
			'quantity' => Yii::t('mx','Quantity'),
			'price' => Yii::t('mx','Price'),
			'amount' => Yii::t('mx','Amount'),
			'discount' => Yii::t('mx','Discount'),
			'subtotal' => Yii::t('mx','Subtotal'),
			'vat' => Yii::t('mx','VAT'),
			'ieps' => Yii::t('mx','IEPS'),
			'retiva' => Yii::t('mx','Retention IVA'),
			'retisr' => Yii::t('mx','Retention ISR'),
			'total' => Yii::t('mx','Total'),
            'discount_percent'=>Yii::t('mx','Total'),
            'ieps_percent'=>Yii::t('mx','IEPS Percent'),
            'retiva_percent'=>Yii::t('mx','Retention VAT Percent'),
            'retisr_percent'=>Yii::t('mx','Retention ISR Percent'),
            'vat_precent'=>Yii::t('mx','VAT Percent'),
            'presentation2'=>Yii::t('mx','Presentation'),
            'quantity2'=>Yii::t('mx','Quantity'),
            'price2'=>Yii::t('mx','Price'),
            'provider1'=>'',
            'provider2'=>'',
            'article1'=>'',
            'article2'=>'',
            'total2'=>Yii::t('mx','Total')
		);
	}


	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('direct_invoice_id',$this->direct_invoice_id);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('discount',$this->discount,true);
		$criteria->compare('subtotal',$this->subtotal,true);
		$criteria->compare('vat',$this->vat,true);
		$criteria->compare('ieps',$this->ieps,true);
		$criteria->compare('retiva',$this->retiva,true);
		$criteria->compare('retisr',$this->retisr,true);
		$criteria->compare('total',$this->total,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getForm(){

        return array(
            'id'=>'Transport-form',
            'showErrorSummary' => true,
            'title'=>Yii::t('mx','Public Transport'),
            'elements'=>array(
                'quantity'=>array(
                    'type'=>'text',
                    'class'=>'span2',
                    'onchange'=>'


                        $.ajax({
                                url: "'.CController::createUrl('/articles/GetAttributesArticle').'",
                                data: { articleId: $("#DirectInvoiceItems_article1").val() },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {}
                            })

                            .done(function(data) {
                                $("#DirectInvoiceItems_price").val(data.price);

                                var price=data.price;
                                var quantity=$("#DirectInvoiceItems_quantity").val();
                                var total=price*quantity;
                                $("#DirectInvoiceItems_total").val(total.toFixed(2));

                                //====================================================

                                var invoice=$.fn.yiiGridView.getChecked("direct-invoice-grid","chk").toString();
                                var adultos=$("#DirectInvoiceItems_total").val();
                                var estudiantes=$("#DirectInvoiceItems_total2").val();

                                if(invoice!=""){
                                    $.ajax({
                                        url: "'.CController::createUrl('/directInvoice/sumaInvoices').'",
                                        data: { ids: invoice, adulto: adultos, estudiante: estudiantes },
                                        type: "POST",
                                        dataType: "json",
                                        beforeSend: function() { $("#direct-invoice-grid-inner").addClass("loading"); }
                                    })

                                    .done(function(data) {  $("#suma").html(data.suma); })
                                    .fail(function() { bootbox.alert("Error");  })
                                    .always(function() { $("#direct-invoice-grid-inner").removeClass("loading"); });
                                }

                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() {});

                    '
                ),
                'provider1'=>array(
                    'type'=>'select2',
                    'data'=>Providers::model()->listAllOrganization(),
                    'options' => array(
                        'allowClear'=>true,
                    ),
                    'events' =>array(
                        'change'=>'js:function(e){
                            $.ajax({
                                url: "'.CController::createUrl('/articles/getArticleDescription').'",
                                data: { provider: $(this).val() },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {}
                            })

                            .done(function(data) {
                                if(data.ok==true){
                                    $("#DirectInvoiceItems_article1").html(data.articles);
                                }
                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() { });
                        }'
                    ),

                ),
                'article1'=>array(
                    'type'=>'select2',
                    'data'=>array(0=>Yii::t('mx','Article')),
                    'events' =>array(
                        'change'=>'js:function(e){
                            $.ajax({
                                url: "'.CController::createUrl('/articles/GetAttributesArticle').'",
                                data: { articleId: $(this).val() },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {}
                            })

                            .done(function(data) {
                                $("#DirectInvoiceItems_price").val(data.price);

                                var price=data.price;
                                var quantity=$("#DirectInvoiceItems_quantity").val();
                                var total=price*quantity;
                                $("#DirectInvoiceItems_total").val(total.toFixed(2));

                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() {});
                        }'
                    ),
                ),
                'price'=>array(
                    'type'=>'text',
                    'class'=>'input-small',
                    'readonly'=>'readonly'
                ),
                'total'=>array(
                    'type'=>'text',
                    'class'=>'input-small',
                    'readonly'=>'readonly'
                ),

                'quantity2'=>array(
                    'type'=>'text',
                    'class'=>'span2',
                    'onchange'=>'

                        $.ajax({
                                url: "'.CController::createUrl('/articles/GetAttributesArticle').'",
                                data: { articleId: $("#DirectInvoiceItems_article2").val() },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {}
                            })

                            .done(function(data) {
                                $("#DirectInvoiceItems_price2").val(data.price);

                                var price=data.price;
                                var quantity=$("#DirectInvoiceItems_quantity2").val();
                                var total=price*quantity;
                                $("#DirectInvoiceItems_total2").val(total.toFixed(2));

                                 //====================================================

                                var invoice=$.fn.yiiGridView.getChecked("direct-invoice-grid","chk").toString();
                                var adultos=$("#DirectInvoiceItems_total").val();
                                var estudiantes=$("#DirectInvoiceItems_total2").val();

                                if(invoice!=""){
                                    $.ajax({
                                        url: "'.CController::createUrl('/directInvoice/sumaInvoices').'",
                                        data: { ids: invoice, adulto: adultos, estudiante: estudiantes },
                                        type: "POST",
                                        dataType: "json",
                                        beforeSend: function() { $("#direct-invoice-grid-inner").addClass("loading"); }
                                    })

                                    .done(function(data) {  $("#suma").html(data.suma); })
                                    .fail(function() { bootbox.alert("Error");  })
                                    .always(function() { $("#direct-invoice-grid-inner").removeClass("loading"); });
                                }

                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() {});

                    '
                ),
                'provider2'=>array(
                    'type'=>'select2',
                    'data'=>Providers::model()->listAllOrganization(),
                    'options' => array(
                        'allowClear'=>true,
                    ),
                    'events' =>array(
                        'change'=>'js:function(e){
                            $.ajax({
                                url: "'.CController::createUrl('/articles/getArticleDescription').'",
                                data: { provider: $(this).val() },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {}
                            })

                            .done(function(data) {
                                if(data.ok==true){
                                    $("#DirectInvoiceItems_article2").html(data.articles);
                                }
                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() { });
                        }'
                    ),

                ),
                'article2'=>array(
                    'type'=>'select2',
                    'data'=>array(0=>Yii::t('mx','Article')),
                    'events' =>array(
                        'change'=>'js:function(e){
                            $.ajax({
                                url: "'.CController::createUrl('/articles/GetAttributesArticle').'",
                                data: { articleId: $(this).val() },
                                type: "POST",
                                dataType: "json",
                                beforeSend: function() {}
                            })

                            .done(function(data) {
                                $("#DirectInvoiceItems_price2").val(data.price);

                                var price=data.price;
                                var quantity=$("#DirectInvoiceItems_quantity2").val();
                                var total=price*quantity;
                                $("#DirectInvoiceItems_total2").val(total.toFixed(2));

                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() {});
                        }'
                    ),
                ),
                'price2'=>array(
                    'type'=>'text',
                    'class'=>'input-small',
                    'readonly'=>'readonly'
                ),
                'total2'=>array(
                    'type'=>'text',
                    'class'=>'input-small',
                    'readonly'=>'readonly'
                ),

            ),

           /* 'buttons' => array(

                'budget' => array(
                    'type' => 'ajaxSubmit',
                    'icon'=>'icon-ok',
                    'layoutType' => 'primary',
                    'label' => Yii::t('mx','Ok'),
                    'url'=>Yii::app()->createUrl('/directInvoice/sumaInvoices'),
                    'ajaxOptions' => array(
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $(".modal-body").addClass("saving");
                         }',
                        'complete' => 'function() {
                             $(".modal-body").removeClass("saving");
                        }',
                        'success' =>'function(data){
                            if(data.ok==true){
                                    $("#suma").html(data.suma);
                            }
                        }',
                    ),
                ),

            )
           */
        );
    }


	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
