<?php

class Providers extends CActiveRecord
{
    public $latitude1;
    public $longitude1;
    public $full_name2;
    public $search;
    public $searchEmailsAndPhones;

	public function tableName()
	{
		return 'providers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('n_degrees, n_minuts, w_degrees, w_minuts, zone', 'numerical', 'integerOnly'=>true),
			array('first_name, middle_name, last_name, work_street, work_neighborhood, home_street, postal_street, email, email_work, email_home', 'length', 'max'=>100),
			array('prefix, suffix', 'length', 'max'=>255),
			array('full_name', 'length', 'max'=>300),
			array('education_title, work_city, work_region, work_country, home_city, home_region, home_country, postal_city, postal_region, postal_country, municipality', 'length', 'max'=>30),
			array('nickname, work_zip, home_zip, postal_zip, outside_number, internal_number', 'length', 'max'=>20),
			array('company, organization, url_work', 'length', 'max'=>150),
			array('department, job_title, role, account_number, latitude, longitude', 'length', 'max'=>50),
			array('note', 'length', 'max'=>3000),
			array('telephone_work1, telephone_work2, telephone_home1, telephone_home2, cell_phone, car_phone, pager, additional_telephone, fax_work, fax_home, isdn, preferred_telephone, telex, rfc', 'length', 'max'=>25),
			array('reference', 'length', 'max'=>200),
			array('n_seconds, w_seconds', 'length', 'max'=>10),
			array('birthday', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, full_name2, suffix, full_name, company, searchEmailsAndPhones', 'safe', 'on'=>'search'),
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
            'zone1'=>array(self::BELONGS_TO, 'Zones', 'zone'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'first_name' => Yii::t('mx','First Name'),
            'middle_name' => Yii::t('mx','Middle Name'),
            'last_name' => Yii::t('mx','Last Name'),
            'prefix' => Yii::t('mx','Prefix'),
            'suffix' => Yii::t('mx','Suffix'),
            'full_name' => Yii::t('mx','Full Name'),
            'education_title' => Yii::t('mx','Education Title'),
            'nickname' => Yii::t('mx','Nickname'),
            'company' => Yii::t('mx','Legal name of the company'),
            'organization' => Yii::t('mx','Organization'),
            'department' => Yii::t('mx','Department'),
            'job_title' => Yii::t('mx','Job Title'),
            'note' => Yii::t('mx','Notes'),
            'telephone_work1' => Yii::t('mx','Work1'),
            'telephone_work2' => Yii::t('mx','Work2'),
            'telephone_home1' => Yii::t('mx','Home1'),
            'telephone_home2' => Yii::t('mx','Home2'),
            'cell_phone' => Yii::t('mx','Cell 1'),
            'car_phone' => Yii::t('mx','Cell 2'),
            'pager' => Yii::t('mx','Nextel'),
            'additional_telephone' => Yii::t('mx','Other Telephone 1'),
            'fax_work' => Yii::t('mx','Fax Work'),
            'fax_home' => Yii::t('mx','Fax Home'),
            'isdn' => Yii::t('mx','Isdn'),
            'preferred_telephone' => Yii::t('mx','Other Telephone 2'),
            'telex' => Yii::t('mx','Telex'),
            'work_street' => Yii::t('mx','Work Street'),
            'work_neighborhood' => Yii::t('mx','Work Neighborhood'),
            'work_city' => Yii::t('mx','Work City'),
            'work_region' => Yii::t('mx','Work Region'),
            'work_country' => Yii::t('mx','Work Country'),
            'work_zip' => Yii::t('mx','Work Zip'),
            'home_street' => Yii::t('mx','Street and number of domicile'),
            'home_zip' => Yii::t('mx','Domicile postal code'),
            'home_city' => Yii::t('mx','City of domicile'),
            'home_region' => Yii::t('mx','State of domicile'),
            'home_country' => Yii::t('mx','Country of domicile'),
            'postal_street' => Yii::t('mx','Street and number of branch'),
            'postal_zip' => Yii::t('mx','Postal Branch'),
            'postal_city' => Yii::t('mx','City branch'),
            'postal_region' => Yii::t('mx','State Branch'),
            'postal_country' => Yii::t('mx','Country Branch'),
            'url_work' => Yii::t('mx','Url'),
            'role' => Yii::t('mx','Role'),
            'birthday' => Yii::t('mx','Birthday'),
            'email' => Yii::t('mx','Main Email'),
            'email_work' => Yii::t('mx','Email Work'),
            'email_home' => Yii::t('mx','Other Email'),
            'rfc' => Yii::t('mx','RFC').' (usar formato XXXX-000000-XXX)',
            'outside_number' => Yii::t('mx','Outside Number'),
            'internal_number' => Yii::t('mx','Internal Number'),
            'reference' => Yii::t('mx','Reference'),
            'account_number' => Yii::t('mx','Last 4 numbers of the account'),
            'n_degrees' => '',
            'n_minuts' => '',
            'n_seconds' => '',
            'w_degrees' => '',
            'w_minuts' => '',
            'w_seconds' => '',
            'municipality' => Yii::t('mx','Municipality Work'),
            'latitude' => Yii::t('mx','Latitude'),
            'longitude' => Yii::t('mx','Longitude'),
            'full_name2'=>Yii::t('mx','Full Name'),
            'search'=>Yii::t('mx','Search by company, full name, suffix or note'),
			'zone' => Yii::t('mx','Zone'),
            'searchEmailsAndPhones'=>Yii::t('mx','Search Emails And Phones')
		);
	}


    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id);
        $criteria->compare('company',$this->company,true);
        $criteria->compare('full_name2',$this->first_name,true);
        $criteria->compare('suffix',$this->suffix,true);

        if(isset($_GET['Providers']['search']) && empty($_GET['Providers']['searchEmailsAndPhones']) ){
            $criteria->condition = 'match(company,first_name,middle_name,last_name,suffix,note) against(:busqueda in boolean mode)';
            $criteria->params = array(':busqueda'=>'"'.$_GET['Providers']['search'].'"');
        }

        if(isset($_GET['Providers']['searchEmailsAndPhones']) && empty($_GET['Providers']['search'])){
            $criteria->condition = 'match(telephone_work1,telephone_work2,telephone_home1,telephone_home2,cell_phone,car_phone,pager,additional_telephone,fax_work,fax_home,isdn,preferred_telephone,email,email_work,email_home) against(:busqueda in boolean mode)';
            $criteria->params = array(':busqueda'=>'"'.$_GET['Providers']['searchEmailsAndPhones'].'"');
        }

        if(Yii::app()->request->getQuery("company")){
            $criteria->compare('company', $_GET['company'], true);
        }

        if(Yii::app()->request->getQuery("full_name2")){
            $this->full_name2=$_GET['full_name2'];
            $criteria->addSearchCondition('concat(first_name," ",middle_name," ",last_name)', $this->full_name2);
        }

        if(Yii::app()->request->getQuery("suffix")){
            $criteria->compare('suffix', $_GET['suffix'], true);
        }


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,

        ));
    }

    public static function imageUrl($url){

        if($url) $icono='<a href="http://'.$url.'" target="_blank"><i class="icon-globe icon-2x"></i></a>';
        else $icono="";

        return $icono;

    }

    public static function popoverUrl($url){

        $popover=Yii::t('mx','Not set');

        if($url!=null){

            $popover='<p class="popover-examples">';
            $popover.='<a href="http://';
            $popover.=$url;
            $popover.='" target="_blank"';
            $popover.='" class="" data-toggle="popover"';
            $popover.=' data-title="';
            $popover.='<h4>'.Yii::t('mx','URL').'</h4>';
            $popover.='"';
            $popover.=' data-content="';
            $popover.='</p><strong>'.$url.'</strong></p>';
            $popover.='">';
            $popover.='<i class="icon-globe icon-2x"></i>';
            $popover.='</a>';
            $popover.='</p>';
        }


        return $popover;

    }

    public static function popover($data){

        $popover=Yii::t('mx','Not set');

        if($data!=null){

            $popover='<p class="popover-examples">';


            $provider= Providers::model()->findByPk($data);

            $popover.='<a href="#';
            $popover.='" class="" data-toggle="popover"';
            $popover.=' data-title="';
            $popover.='<h4>'.Yii::t('mx','EMAILS AND PHONES').'</h4>';
            $popover.='"';
            $popover.=' data-content="';

            $popover.='<p><h5>'.Yii::t('mx','EMAILS').'</h5></p>';
            $popover.='<hr>';

            if($provider->email) $popover.='<p><strong>'.Yii::t('mx','Email').':</strong> '.$provider->email.'</p>';
            if($provider->email_work) $popover.='<p><strong>'.Yii::t('mx','Email Work').':</strong> '.$provider->email_work.'</p>';
            if($provider->email_home) $popover.='<p><strong>'.Yii::t('mx','Email Home').':</strong> '.$provider->email_home.'</p>';

            $popover.='<hr>';
            $popover.='<p><h5>'.Yii::t('mx','PHONES').'</h5></p>';
            $popover.='<hr>';

            if($provider->telephone_work1) $popover.='<p><strong>'.Yii::t('mx','Work1').':</strong> '.$provider->telephone_work1.'</p>';
            if($provider->telephone_work2) $popover.='<p><strong>'.Yii::t('mx','Work2').':</strong> '.$provider->telephone_work2.'</p>';
            if($provider->fax_work) $popover.='<p><strong>'.Yii::t('mx','Fax Work').':</strong> '.$provider->fax_work.'</p>';
            if($provider->cell_phone) $popover.='<p><strong>'.Yii::t('mx','Cell 1').':</strong> '.$provider->cell_phone.'</p>';
            if($provider->car_phone) $popover.='<p><strong>'.Yii::t('mx','Cell 2').':</strong> '.$provider->car_phone.'</p>';
            if($provider->pager) $popover.='<p><strong>'.Yii::t('mx','Nextel').':</strong> '.$provider->pager.'</p>';
            if($provider->additional_telephone) $popover.='<p><strong>'.Yii::t('mx','Other Telephone 1').':</strong> '.$provider->additional_telephone.'</p>';
            if($provider->preferred_telephone) $popover.='<p><strong>'.Yii::t('mx','Other Telephone 2').':</strong> '.$provider->preferred_telephone.'</p>';
            if($provider->telephone_home1) $popover.='<p><strong>'.Yii::t('mx','Home1').':</strong> '.$provider->telephone_home1.'</p>';
            if($provider->telephone_home2) $popover.='<p><strong>'.Yii::t('mx','Home2').':</strong> '.$provider->telephone_home2.'</p>';
            if($provider->fax_home) $popover.='<p><strong>'.Yii::t('mx','Fax Home').':</strong> '.$provider->fax_home.'</p>';
            if($provider->isdn) $popover.='<p><strong>'.Yii::t('mx','Isdn').':</strong> '.$provider->isdn.'</p>';

            $popover.='">';
            $popover.='<i class="icon-list-alt icon-large"></i>';
            $popover.='</a>';

            $popover.='</p>';
        }


        return $popover;

    }

    public function getFormFilter(){

        return array(
            'id'=>'filterForm',
            //'title'=>Yii::t('mx','Search Criteria'),
            'elements'=>array(
                "search"=>array(
                    'label'=>Yii::t('mx','Search'),
                    'type' => 'text',
                    'class'=>'span5 '
                ),
                "searchEmailsAndPhones"=>array(
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
                    'url'=>Yii::app()->createUrl('/providers/index'),
                ),
            )
        );
    }


    public function getFull_Name()
    {
        if($this->first_name!=null || $this->middle_name!=null || $this->last_name){
            return $this->first_name.' '.$this->middle_name.' '.$this->last_name;
        }else{
            return Yii::t('mx','Not set');
        }

    }


    public function getSelectCompany(){
        $categories = $this->model()->findAll();
        $data = array();
        foreach($categories as $category){
            $data[$category->company] = $category->company;
        }


        return $data;

    }

    public function linkMap($latitude,$longitude){

        return CHtml::link('<i class="icon-map-marker icon-2x"></i>','https://maps.google.com/?q='.$latitude.','.$longitude.'&t=h&z=15',array('target'=>'_blank'));

    }

    public function listAllOrganization(){
        $list=array(
            'No existen proveedores'=>'No existen proveedores'
        );

        $empresa="";

        $res=$this->model()->findAll(array('order'=>'company'));

        if($res){
            $list=array(0=>Yii::t('mx','Select'));

            foreach($res as $item){

                $empresa="";
                $empresa.=$item->company != "" ? $item->company." - " : "";
                $empresa.=$item->first_name != "" ? $item->first_name." " : "";
                $empresa.=$item->middle_name !="" ? $item->middle_name." " : "";
                $empresa.=$item->last_name !="" ? $item->last_name." - " : "";
                $empresa.=$item->suffix != "" ? $item->suffix : "";

                $list[$item->id]=$empresa;
            }

        }

        return $list;
    }

    public function CompanyByPk($id){

        $empresa="";

        $company=$this->model()->findByPk($id);

        $empresa.=$company->company != "" ? $company->company." - " : "";
        $empresa.=$company->first_name != "" ? $company->first_name." " : "";
        $empresa.=$company->middle_name !="" ? $company->middle_name." " : "";
        $empresa.=$company->last_name !="" ? $company->last_name." - " : "";
        $empresa.=$company->suffix != "" ? $company->suffix : "";


        return $empresa;
    }


    public function listAll(){

        $list=array(''=>Yii::t('mx','Select'));

        $providers=$this->model()->findAll(array('order'=>'company'));

        if($providers){

            array_unshift($providers,$list);

            return CHtml::listData($providers,'id','company');
        }
        else{
            return $list;
        }

    }

    public function behaviors()
    {
        return array(
            'CustomerAuditBehavior'=> array(
                'class' => 'application.behaviors.ProvidersAuditBehavior',
            )
        );

    }

    public function afterFind() {

        if($this->birthday !=null){
            $bday=date("Y-M-d",strtotime($this->birthday));
            $this->birthday=Yii::app()->quoteUtil->ToSpanishDateFromFormatdMyyyy($bday);
        }


        return  parent::afterFind();
    }

    public function beforeSave(){

        if($this->birthday !=null){
            $bday=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->birthday);
            $this->birthday=date("Y-m-d",strtotime($bday));
        }


        return parent::beforeSave();

    }


    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
