<?php

class Employees extends CActiveRecord
{

	public function tableName()
	{
		return 'employees';
	}


	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, n_degrees, n_minuts, w_degrees, w_minuts, zone', 'numerical', 'integerOnly'=>true),
			array('outside_number, internal_number, contract_duration, test_period, initials, nickname, work_zip, home_zip, postal_zip, day_rest', 'length', 'max'=>20),
			array('reference', 'length', 'max'=>200),
			array('company, organization, url_work', 'length', 'max'=>150),
			array('rfc, curp, nss, telephone_work1, telephone_work2, telephone_home1, telephone_home2, cell_phone, car_phone, pager, additional_telephone, fax_work, fax_home, isdn, preferred_telephone, telex', 'length', 'max'=>25),
			array('key_voter, n_card, cedula, payment_type, department, job_title, role, account_number, latitude, longitude, civil_status, nationality', 'length', 'max'=>50),
			array('name_wife, name_father, name_mother, first_name, middle_name, last_name, work_street, work_neighborhood, home_street, postal_street, email, email_work, email_home', 'length', 'max'=>100),
			array('have_contract', 'length', 'max'=>1),
			array('prefix, suffix', 'length', 'max'=>255),
			array('full_name', 'length', 'max'=>300),
			array('education_title, work_city, work_region, work_country, home_city, home_region, home_country, postal_city, postal_region, postal_country, municipality', 'length', 'max'=>30),
			array('note', 'length', 'max'=>3000),
			array('n_seconds, w_seconds, salary', 'length', 'max'=>10),
			array('birthday, real_ingress, ingress_ss, name_children, comments, output_date_r, output_date_ss, contract_start, contract_end, start_test_period, end_test_period', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, outside_number, internal_number, reference, company, birthday, rfc, curp, nss, key_voter, n_card, cedula, real_ingress, ingress_ss, payment_type, name_wife, name_children, name_father, name_mother, comments, output_date_r, output_date_ss, have_contract, contract_start, contract_end, contract_duration, test_period, start_test_period, end_test_period, user_id, initials, first_name, middle_name, last_name, prefix, suffix, full_name, education_title, nickname, organization, department, job_title, note, telephone_work1, telephone_work2, telephone_home1, telephone_home2, cell_phone, car_phone, pager, additional_telephone, fax_work, fax_home, isdn, preferred_telephone, telex, work_street, work_neighborhood, work_city, work_region, work_country, work_zip, home_street, home_zip, home_city, home_region, home_country, postal_street, postal_zip, postal_city, postal_region, postal_country, url_work, role, email, email_work, email_home, account_number, n_degrees, n_minuts, n_seconds, w_degrees, w_minuts, w_seconds, municipality, latitude, longitude, zone, salary, day_rest, civil_status, nationality', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{

		return array(
            'assignments' => array(self::HAS_MANY, 'Assignment', 'employeed_id'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
            'outside_number' => Yii::t('mx','Outside Number'),
            'internal_number' => Yii::t('mx','Internal Number'),
            'reference' => Yii::t('mx','Reference'),
            'company' => Yii::t('mx','Company'),
            'birthday' => Yii::t('mx','Birthday'),
            'rfc' => Yii::t('mx','Rfc'),
            'curp' => Yii::t('mx','Curp'),
            'nss' => Yii::t('mx','Social Security Number'),
            'key_voter' => Yii::t('mx','Key Voter'),
            'n_card' => Yii::t('mx','Voter Card Number'),
            'cedula' => Yii::t('mx','Cedula'),
            'real_ingress' => Yii::t('mx','Real Ingress'),
            'ingress_ss' => Yii::t('mx','Ingress Social Security'),
            'payment_type' => Yii::t('mx','Payment Type'),
            'name_wife' => Yii::t('mx','Name Wife'),
            'name_children' => Yii::t('mx','Name Children'),
            'name_father' => Yii::t('mx','Name Father'),
            'name_mother' => Yii::t('mx','Name Mother'),
            'comments' => Yii::t('mx','Comments'),
            'output_date_r' => Yii::t('mx','Output Date Real'),
            'output_date_ss' => Yii::t('mx','Ouput Date Social Security'),
            'have_contract' => Yii::t('mx','Have Contract'),
            'contract_start' => Yii::t('mx','Contract Start'),
            'contract_end' => Yii::t('mx','Contract End'),
            'contract_duration' => Yii::t('mx','Contract Duration'),
            'test_period' => Yii::t('mx','Test Period'),
            'start_test_period' => Yii::t('mx','Start Test Period'),
            'end_test_period' => Yii::t('mx','End Test Period'),
            'user_id' => Yii::t('mx','User'),
            'initials' => Yii::t('mx','Initials'),
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
            'salary' => Yii::t('mx','Salary'),
			'day_rest' => Yii::t('mx','Day Of Rest'),
			'civil_status' => Yii::t('mx','Civil Status'),
			'nationality' => Yii::t('mx','Nationality'),
		);
	}


	public function search()
	{


		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('outside_number',$this->outside_number,true);
		$criteria->compare('internal_number',$this->internal_number,true);
		$criteria->compare('reference',$this->reference,true);
		$criteria->compare('company',$this->company,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('rfc',$this->rfc,true);
		$criteria->compare('curp',$this->curp,true);
		$criteria->compare('nss',$this->nss,true);
		$criteria->compare('key_voter',$this->key_voter,true);
		$criteria->compare('n_card',$this->n_card,true);
		$criteria->compare('cedula',$this->cedula,true);
		$criteria->compare('real_ingress',$this->real_ingress,true);
		$criteria->compare('ingress_ss',$this->ingress_ss,true);
		$criteria->compare('payment_type',$this->payment_type,true);
		$criteria->compare('name_wife',$this->name_wife,true);
		$criteria->compare('name_children',$this->name_children,true);
		$criteria->compare('name_father',$this->name_father,true);
		$criteria->compare('name_mother',$this->name_mother,true);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('output_date_r',$this->output_date_r,true);
		$criteria->compare('output_date_ss',$this->output_date_ss,true);
		$criteria->compare('have_contract',$this->have_contract,true);
		$criteria->compare('contract_start',$this->contract_start,true);
		$criteria->compare('contract_end',$this->contract_end,true);
		$criteria->compare('contract_duration',$this->contract_duration,true);
		$criteria->compare('test_period',$this->test_period,true);
		$criteria->compare('start_test_period',$this->start_test_period,true);
		$criteria->compare('end_test_period',$this->end_test_period,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('initials',$this->initials,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('prefix',$this->prefix,true);
		$criteria->compare('suffix',$this->suffix,true);
		$criteria->compare('full_name',$this->full_name,true);
		$criteria->compare('education_title',$this->education_title,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('organization',$this->organization,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('job_title',$this->job_title,true);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('telephone_work1',$this->telephone_work1,true);
		$criteria->compare('telephone_work2',$this->telephone_work2,true);
		$criteria->compare('telephone_home1',$this->telephone_home1,true);
		$criteria->compare('telephone_home2',$this->telephone_home2,true);
		$criteria->compare('cell_phone',$this->cell_phone,true);
		$criteria->compare('car_phone',$this->car_phone,true);
		$criteria->compare('pager',$this->pager,true);
		$criteria->compare('additional_telephone',$this->additional_telephone,true);
		$criteria->compare('fax_work',$this->fax_work,true);
		$criteria->compare('fax_home',$this->fax_home,true);
		$criteria->compare('isdn',$this->isdn,true);
		$criteria->compare('preferred_telephone',$this->preferred_telephone,true);
		$criteria->compare('telex',$this->telex,true);
		$criteria->compare('work_street',$this->work_street,true);
		$criteria->compare('work_neighborhood',$this->work_neighborhood,true);
		$criteria->compare('work_city',$this->work_city,true);
		$criteria->compare('work_region',$this->work_region,true);
		$criteria->compare('work_country',$this->work_country,true);
		$criteria->compare('work_zip',$this->work_zip,true);
		$criteria->compare('home_street',$this->home_street,true);
		$criteria->compare('home_zip',$this->home_zip,true);
		$criteria->compare('home_city',$this->home_city,true);
		$criteria->compare('home_region',$this->home_region,true);
		$criteria->compare('home_country',$this->home_country,true);
		$criteria->compare('postal_street',$this->postal_street,true);
		$criteria->compare('postal_zip',$this->postal_zip,true);
		$criteria->compare('postal_city',$this->postal_city,true);
		$criteria->compare('postal_region',$this->postal_region,true);
		$criteria->compare('postal_country',$this->postal_country,true);
		$criteria->compare('url_work',$this->url_work,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('email_work',$this->email_work,true);
		$criteria->compare('email_home',$this->email_home,true);
		$criteria->compare('account_number',$this->account_number,true);
		$criteria->compare('n_degrees',$this->n_degrees);
		$criteria->compare('n_minuts',$this->n_minuts);
		$criteria->compare('n_seconds',$this->n_seconds,true);
		$criteria->compare('w_degrees',$this->w_degrees);
		$criteria->compare('w_minuts',$this->w_minuts);
		$criteria->compare('w_seconds',$this->w_seconds,true);
		$criteria->compare('municipality',$this->municipality,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('zone',$this->zone);
		$criteria->compare('salary',$this->salary,true);
		$criteria->compare('day_rest',$this->day_rest,true);
		$criteria->compare('civil_status',$this->civil_status,true);
		$criteria->compare('nationality',$this->nationality,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function afterFind() {

        $this->birthday=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->birthday)));
        $this->real_ingress=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->real_ingress)));
        $this->ingress_ss=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->ingress_ss)));
        $this->output_date_r=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->output_date_r)));
        $this->output_date_ss=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->output_date_ss)));
        $this->contract_start=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->contract_start)));
        $this->contract_end=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->contract_end)));
        $this->start_test_period=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->start_test_period)));
        $this->end_test_period=Yii::app()->quoteUtil->toSpanishDateFromDb(date('Y-M-d',strtotime($this->end_test_period)));


        return  parent::afterFind();
    }

    public function beforeSave(){

        $birthday=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->birthday);
        $this->birthday=date("Y-m-d",strtotime($birthday));

        $real_ingress=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->real_ingress);
        $this->real_ingress=date("Y-m-d",strtotime($real_ingress));

        $ingress_ss=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->ingress_ss);
        $this->ingress_ss=date("Y-m-d",strtotime($ingress_ss));

        $output_date_r=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->output_date_r);
        $this->output_date_r=date("Y-m-d",strtotime($output_date_r));

        $output_date_ss=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->output_date_ss);
        $this->output_date_ss=date("Y-m-d",strtotime($output_date_ss));

        $contract_start=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->contract_start);
        $this->contract_start=date("Y-m-d",strtotime($contract_start));

        $contract_end=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->contract_end);
        $this->contract_end=date("Y-m-d",strtotime($contract_end));

        $start_test_period=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->start_test_period);
        $this->start_test_period=date("Y-m-d",strtotime($start_test_period));

        $end_test_period=Yii::app()->quoteUtil->ToEnglishDateFromFormatdMyyyy($this->end_test_period);
        $this->end_test_period=date("Y-m-d",strtotime($end_test_period));

        return parent::beforeSave();

    }

    public function listAll(){

        $lista=array(''=>Yii::t('mx','Select'));
        $result=$this->model()->findAll(array('order'=>'first_name'));

        foreach($result as $item){
            $lista[$item->id]=$item->first_name;
        }

        return $lista;

    }

    public function getInitials($id){

        $employee=$this->find(
            array(
                'condition'=>'user_id=:userId',
                'params'=>array('userId'=>$id)
            )
        );

        return $employee->initials;

    }


    public function behaviors()
    {
        return array(
            'LoggableBehavior'=>
                'application.modules.auditTrail.behaviors.LoggableBehavior',
        );
    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
