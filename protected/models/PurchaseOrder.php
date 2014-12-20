<?php

class PurchaseOrder extends CActiveRecord
{
    public $provider_id;
    public $provider_id2;
    public $article_id;
    public $article_id2;
    public $address;
    public $logo;
    public $phone;
    public $price;
    public $quantity;
    public $price2;
    public $quantity2;


	public function tableName()
	{
		return 'purchase_order';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('datex', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, datex, user_id', 'safe', 'on'=>'search'),
		);
	}


	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'purchaseOrderProvider' => array(self::HAS_MANY, 'PurchaseOrderProvider', 'purchase_order_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'datex' => Yii::t('mx','Date'),
			'user_id' => Yii::t('mx','User'),
            'provider_id'=>'',
            'provider_id2'=>'',
            'article_id'=>'',
            'article_id2'=>'',
            'price'=>Yii::t('mx','Price'),
            'price2'=>Yii::t('mx','Price'),
            'quantity'=>Yii::t('mx','Quantity'),
            'quantity2'=>Yii::t('mx','Quantity')
		);
	}

    /*
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->with = array(
            'purchaseOrderProvider' => array(
                'joinType' => 'INNER JOIN',
            ),
        );

        $criteria->compare('datex',$this->datex,true);
        $criteria->compare('purchaseOrderProvider.provider_id',$this->provider_id);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'datex DESC',
                'attributes'=>array(
                    'provider_id'=>array(
                        'asc'=>'purchaseOrderProvider.provider_id',
                        'desc'=>'purchaseOrderProvider.provider_id',
                    ),
                ),
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }
*/

	public function search()
	{

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('datex',$this->datex,true);
		$criteria->compare('user_id',$this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getFormFilter(){

        return array(
            'id'=>'filterForm',
            'title'=>Yii::t('mx','Search Criteria'),
            'elements'=>array(
                "provider_id"=>array(
                    'label'=>'',
                    'type' => 'select2',
                    'data'=>Providers::model()->listAllOrganization(),
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
                                    $("#PurchaseOrder_article_id").html(data.articles);
                                }
                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() { });

                        }',
                    )
                ),
                "article_id"=>array(
                    'label'=>'',
                    'type' => 'select2',
                    'data'=>array(0=>Yii::t('mx','Select')),
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
                                   $("#PurchaseOrder_price").val(data.price);
                                })

                                .fail(function() { bootbox.alert("Error"); })
                                .always(function() {});

                        }',
                    )
                ),
                "price"=>array(
                    'label'=>Yii::t('mx','Price'),
                    'type'=>'text',
                    'class'=>'span1'
                ),
                "quantity"=>array(
                    'label'=>Yii::t('mx','Quantity'),
                    'type'=>'text',
                    'class'=>'span1'
                )
            ),
            'buttons' => array(
                'addprovider' => array(
                    'type' => 'button',
                    'label' => Yii::t('mx','Add')." ".Yii::t('mx','Provider'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-user',
                    'htmlOptions'=> array(
                        'onclick' => '

                            aux[providers]=$(this).val();

                            //note[noteIndex]=$("#note"+noteIndex).val();
                            //orders.push({"provider": aux[providers-1], "items": items, "note": note[noteIndex]});
                            //items=[];

                           providers++;
                           var prov=$("#PurchaseOrder_provider_id option:selected").text();

                        html+="<tr id=\'"+providers+"\' style=\'cursor: move;\'>"+
                                    "<td>&nbsp;</td>"+
                                    "<td>"+
                                        "<table id=\'providers"+providers+"\' style=\'width:100%\'><tbody><tr><th colspan=\'4\' scope=\'row\'>"+ prov +"</th></tr></tbody></table>"+
                                    "</td>"+
                                    "<td style=\'text-align: center;vertical-align: middle;\'><button class=\'btn btn-danger\' type=\'button\'  id=\'" + providers + "\' value=\'Eliminar\' onclick=\'$(this).parents().get(1).remove(); orders.splice("+(providers-1)+",1);\'><i class=\'icon-remove\'></i></button></td>" +
                               "</tr>";

                        $("#bill_table").append(html);
                        html="";

                        '
                    ),
                ),
                'addarticle' => array(
                    'type' => 'button',
                    'label' => Yii::t('mx','Add')." ".Yii::t('mx','Article'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-shopping-cart',
                    'htmlOptions'=> array(
                        'onclick' =>'

                         var item={
                            "ROW_ID" : itemCount,
                            "ITEM_ARTICLE_ID" :  $("#PurchaseOrder_article_id").val(),
                            "ITEM_PRICE" : $("#PurchaseOrder_price").val(),
                            "ITEM_QUANTITY" : $("#PurchaseOrder_quantity").val()
                        }

                        items.push(item);

                         itemCount++;

                        html= "<tr id=\'tr"+itemCount+"\'>" +
                                    "<td>"+$("#PurchaseOrder_article_id option:selected").text()+"</td>" +
                                    "<td>" +  item["ITEM_PRICE"] + " </td>" +
                                    "<td>" +  item["ITEM_QUANTITY"] + " </td>" +
                                    "<td><button class=\'btn btn-danger\' type=\'button\' id=\'btn" + itemCount + "\' onclick=\'$(this).parents().get(1).remove(); orders["+(providers-1)+"].items.splice("+(itemCount-1)+ ",1);\' ><i class=\'icon-remove\'></i></button></td>" +
                                "</tr>";

                        $("#providers"+providers).append(html);

                        html="";

                        $("#PurchaseOrder_article_id").prop("selectedIndex",0);
                        $("#PurchaseOrder_price").val("");
                        $("#PurchaseOrder_quantity").val("");

                        $("#bill_table").tableDnDUpdate();

                        '
                    ),
                ),
                'addnote' => array(
                    'type' => 'button',
                    'label' => Yii::t('mx','Add')." ".Yii::t('mx','Note'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-file-alt',
                    'htmlOptions'=> array(
                        'onclick' =>'

                            note[noteIndex]=$("#note"+noteIndex).val();

                            itemCount++;
                            noteIndex++;

                            html="<tr>"+
                                "<td colspan=\'4\' scope=\'row\'>"+
                                "<textarea id=\'note"+noteIndex+ "\' rows=\'3\' style=\'width: 100%;\'></textarea>"
                                "</td></tr>";

                            $("#providers"+providers).append(html);

                            html="";

                            $("#bill_table").tableDnDUpdate();
                        '
                    ),
                ),
            )
        );
    }

    public function getFormFilterArticle(){

        return array(
            'id'=>'filterFormArticle',
            'title'=>Yii::t('mx','Search Criteria'),
            'elements'=>array(
                "article_id2"=>array(
                    'label'=>'',
                    'type' => 'select2',
                    'data'=>Articles::model()->listAll(),
                    'options' => array(
                        'allowClear' => true,
                    ),
                    'events' =>array(
                        'change'=>'js:function(e){

                             $.ajax({
                                url: "'.CController::createUrl('/providers/getProviderDescription').'",
                                data: { article_id: $(this).val() },
                                type: "POST",
                                beforeSend: function() {}
                            })

                            .done(function(data) {
                               $("#PurchaseOrder_provider_id2").html(data);
                            })

                            .fail(function() { bootbox.alert("Error"); })
                            .always(function() { });
                        }',
                    )
                ),
                "provider_id2"=>array(
                    'label'=>'',
                    'type' => 'select2',
                    'data'=>array(0=>Yii::t('mx','Select')),

                ),
                "price"=>array(
                    'label'=>Yii::t('mx','Price'),
                    'type'=>'text',
                    'class'=>'span1'
                ),
                "quantity"=>array(
                    'label'=>Yii::t('mx','Quantity'),
                    'type'=>'text',
                    'class'=>'span1'
                )
            ),
            'buttons' => array(
                'addprovider2' => array(
                    'type' => 'button',
                    'label' => Yii::t('mx','Add')." ".Yii::t('mx','Provider'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-user',
                ),
                'addarticle2' => array(
                    'type' => 'button',
                    'label' => Yii::t('mx','Add')." ".Yii::t('mx','Article'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-shopping-cart',
                ),
                'addnote' => array(
                    'type' => 'button',
                    'label' => Yii::t('mx','Add')." ".Yii::t('mx','Note'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-file-alt',
                ),
            )
        );
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
