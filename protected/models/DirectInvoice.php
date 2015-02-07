<?php


class DirectInvoice extends CActiveRecord
{
    public $article_id;
    public $discount_article;
    public $vat_article;
    public $retiva_article;
    public $ieps_article;
    public $retisr_article;
    public $other_article;

    public $discount_sum;
    public $ieps_sum;
    public $retiva_sum;
    public $retisr_sum;
    public $vat_sum;
    public $other_sum;
    public $grandTotal;
    public $totalAmount;

    public $search;


	public function tableName()
	{
		return 'direct_invoice';
	}

	public function rules()
	{

		return array(
			array('datex, provider_id', 'required'),
			array('petty_cash_id, isactive, isinvoice, provider_id, user_id, document_type_id', 'numerical', 'integerOnly'=>true),
			array('n_invoice', 'length', 'max'=>50),
			array('amount, discount, subtotal, vat, retiva, ieps, retisr, other, total', 'length', 'max'=>10),
			array('n_invoice, datex, isactive, isinvoice, provider_id,total, search', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
            'directInvoiceItems' => array(self::HAS_MANY, 'DirectInvoiceItems', 'direct_invoice_id'),
            'provider' => array(self::BELONGS_TO, 'Providers', 'provider_id'),
            'documentType' => array(self::BELONGS_TO, 'DocumentTypes', 'document_type_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'petty_cash_id' => Yii::t('mx','N° Summary:'),
            'n_invoice' => Yii::t('mx','Folio bill'),
            'amount' => Yii::t('mx','Amount'),
            'datex' => Yii::t('mx','Date'),
            'isactive' => Yii::t('mx','Isactive'),
            'isinvoice' => Yii::t('mx','Isinvoice'),
            'provider_id' => Yii::t('mx','Provider'),
            'user_id' => Yii::t('mx','User'),
            'vat' => Yii::t('mx','IVA'),
            'vat_article' => Yii::t('mx','VAT Article'),
            'discount' => Yii::t('mx','Discount'),
            'discount_article' => Yii::t('mx','Discount Article'),
            'subtotal' => Yii::t('mx','Subtotal'),
            'retiva' => Yii::t('mx','Retention of VAT'),
            'retiva_article' => Yii::t('mx','Retention VAT Article'),
            'ieps' => Yii::t('mx','IEPS'),
            'ieps_article' => Yii::t('mx','IEPS Article'),
            'retisr' => Yii::t('mx','Retention ISR'),
            'retisr_article' => Yii::t('mx','Retention ISR Article'),
            'other' => Yii::t('mx','Other'),
            'other_article' => Yii::t('mx','Other Article'),
            'total' => Yii::t('mx','Total'),
			'document_type_id' => Yii::t('mx','Document Type'),
            'search'=>Yii::t('mx','Search by company, full name, suffix or note'),
		);
	}

    public function history()
    {

        $criteria=new CDbCriteria;

        $criteria->with = array(
            'documentType' => array(
                'together'=>false,
                'joinType' => 'INNER JOIN',
            ),
            'provider' => array(
                'together'=>false,
                'joinType' => 'INNER JOIN',
            ),
        );

        $criteria->compare('id',$this->id);
        $criteria->compare('datex',$this->datex,true);
        $criteria->compare('n_invoice',$this->n_invoice,true);
        $criteria->compare('provider_id',$this->provider_id);
        $criteria->compare('total',$this->total,true);

        if(isset($_POST['DirectInvoice']['search'])){
            $criteria->condition = 'match(provider.company,provider.first_name,provider.middle_name,provider.last_name,provider.suffix,provider.note) against(:busqueda in boolean mode)';
            $criteria->params = array(':busqueda'=>$_POST['DirectInvoice']['search']);
        }


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));
    }

	public function search()
	{

		$criteria=new CDbCriteria;

        $criteria->with = array(
            'documentType' => array(
                'together'=>true,
                'joinType' => 'INNER JOIN',
            ),
            'provider' => array(
                'together'=>true,
                'joinType' => 'INNER JOIN',
            ),
        );

		$criteria->compare('id',$this->id);
        $criteria->compare('datex',$this->datex,true);
        $criteria->compare('n_invoice',$this->n_invoice,true);
        $criteria->compare('provider_id',$this->provider_id);
        $criteria->compare('total',$this->total,true);
        $criteria->compare('documentType.billable',1);
        $criteria->compare('isactive',1);

        if(isset($_POST['DirectInvoice']['search'])){
            $criteria->condition = 'match(provider.company,provider.first_name,provider.middle_name,provider.last_name,provider.suffix,provider.note) against(:busqueda in boolean mode)';
            //$criteria->params = array(':busqueda'=>$_POST['DirectInvoice']['search']);
            $criteria->params = array(':busqueda'=>'"'.$_GET['Providers']['search'].'"');
        }


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
		));
	}

    public function getFormFilter(){

        return array(
            'id'=>'filterForm',
            'elements'=>array(
                "search"=>array(
                    'label'=>Yii::t('mx','Search'),
                    'type' => 'text',
                    'class'=>'span5 '
                ),
            ),
            'buttons' => array(
                'filter' => array(
                    'type' => 'submit',
                    'label' => Yii::t('mx','Ok'),
                    'layoutType' => 'primary',
                    'icon'=>'icon-search',
                    'url'=>Yii::app()->createUrl('/directInvoice/index'),
                    /*'ajaxOptions' => array(
                        'Type'=>'POST',
                        'dataType'=>'json',
                        'beforeSend' => 'function() {
                            $("#direct-invoice-grid-inner").addClass("loading");
                         }',
                        'complete' => 'function() {
                             $("#direct-invoice-grid-inner").removeClass("loading");
                        }',
                        'success' =>'function(data){
                            $("#direct-invoice-grid").yiiGridView("update", {
                                data: $(this).serialize()
                            });
                        }',
                    ),*/
                ),
            )
        );
    }

    public function beforeSave(){

        $datex=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->datex);
        $this->datex=date("Y-m-d",strtotime($datex));

        return parent::beforeSave();
    }

    public function afterFind() {

        $this->datex=date("d-M-Y",strtotime($this->datex));

        return  parent::afterFind();
    }

    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

    public function getTotalInvoice($invoiceIds){
        $suma=0;
        $ids=array_filter(explode(',',$invoiceIds));

        if(!empty($ids)){
            foreach($ids as $id){
                $lista=$this::model()->findByPk((int)$id);
                $suma+=$lista->total;
            }
        }


        return $suma;

    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}