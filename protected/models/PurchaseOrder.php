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
                ),
                'addarticle' => array(
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
                    'htmlOptions'=>array(
                        'change'=>'
                           bootbox.alert("hola");
                        '
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
