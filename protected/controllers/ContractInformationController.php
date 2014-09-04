<?php

class ContractInformationController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
            array('CrugeAccessControlFilter'), // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view','admin','contract','exportPdf','property','exportWord','services','gridContract','CreateContract'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionCreateContract(){

        $contract=new Contract;

            if(isset($_POST['Contract']))
            {
                $contract->attributes=$_POST['Contract'];

                if($contract->save()){
                    Yii::app()->user->setFlash('success','Success');
                    $this->redirect(array('gridContract'));
                }
            }

            $this->render('contract',array('contract'=>$contract));

    }

    public function actionGridContract(){

        $model=new Contract('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ContractInformation']))
            $model->attributes=$_GET['ContractInformation'];

        $this->render('contracts',array(
            'model'=>$model,
        ));

    }

    public function actionContract($id){

    $contract=Contract::model()->findByPk($id);

        if(isset($_POST['Contract']))
        {
            $contract->attributes=$_POST['Contract'];

            if($contract->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('gridContract'));
            }
        }

        $this->render('contract',array('contract'=>$contract));

    }


    public function actionServices(){

        $res=array('ok'=>false);
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            if(!empty($_POST['Services'])){

                $service=new Services;
                $service->service=$_POST['Services']['service'];

                if($service->save()){

                    $list = CHtml::listData(Services::model()->findAll(array('order'=>'service')),'id','service');

                    foreach($list as $key =>$value){
                        $options.=CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
                    }
                    $res=array('ok'=>true,'message'=>$options);
                }
            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }

    public function actionProperty(){

        $res=array('ok'=>false);
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);

        if(Yii::app()->request->isPostRequest){

            if(!empty($_POST['PropertyTypes'])){

                $property=new PropertyTypes;
                $property->property=$_POST['PropertyTypes']['property'];
                $property->save();

                if($property){

                    $list = CHtml::listData(PropertyTypes::model()->findAll(array('order'=>'property')),'id','property');

                    foreach($list as $key =>$value){
                        $options.=CHtml::tag('option', array('value'=>$key),CHtml::encode($value),true);
                    }
                    $res=array('ok'=>true,'message'=>$options);
                }
            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }
    }

    public function actionExportWord($id){
        Yii::import('ext.PHPWord.PHPWord');

        $model=ContractInformation::model()->findByPk($id);
        $PHPWord = new PHPWord();
        $document = $PHPWord->loadTemplate('template.docx');
        $iva="";
        $isr="";
        $retiva="";
        $total="";
        $cadena="";

        $gender_owner= ($model->gender_owner==1) ? Yii::t('mx','Propietario') : Yii::t('mx','Propietaria');
        $gender_lessee= ($model->gender_lessee==1) ? Yii::t('mx','Arrendatario') : Yii::t('mx','Arrendataria');
        $gender_surety= ($model->gender_surety==1) ? Yii::t('mx','Fiador') : Yii::t('mx','Fiadora');
        $properties=PropertyTypes::model()->findByPk($model->property_type);
        $property_type=$properties->property;
        $inception_lease=date('Y-M-d',strtotime($model->inception_lease));
        $end_lease=date('Y-M-d',strtotime($model->end_lease));
        $inception_lease=Yii::app()->quoteUtil->toSpanishDateDescription($inception_lease);
        $end_lease=Yii::app()->quoteUtil->toSpanishDateDescription($end_lease);

        $amount_rent=Yii::app()->quoteUtil->numtoletras($model->amount_rent);
        $amount_rent="$".number_format($model->amount_rent,2).' ('.$amount_rent.')';

        $new_rent_payment=Yii::app()->quoteUtil->numtoletras($model->new_rent_payment);
        $new_rent_payment="$".number_format($model->new_rent_payment,2).' ('.$new_rent_payment.')';

        $deposit_guarantee=Yii::app()->quoteUtil->numtoletras($model->deposit_guarantee);
        $deposit_guarantee="$".number_format($model->deposit_guarantee,2).' ('.$deposit_guarantee.')';

        $payment_services=Yii::app()->quoteUtil->numtoletras($model->payment_services);
        $payment_services="$".number_format($model->payment_services,2).' ('.$payment_services.')';


        if($model->is_iva==true){
            $iva_letras=Yii::app()->quoteUtil->numtoletras($model->iva);
            $iva=" MAS I.V.A., ACTUALMENTE AL ".$model->iva_percent."%, $".number_format($model->iva,2)." (".$iva_letras."), ";
        }

        if($model->is_isr==true){
            $isr_letras=Yii::app()->quoteUtil->numtoletras($model->isr);
            $isr="MENOS RETENCION DEL  I.S.R., ACTUALMENTE AL ".$model->isr_percent."%, $".number_format($model->isr,2)." (".$isr_letras."), ";
        }

        if($model->is_retiva==true){
            $retiva_letras=Yii::app()->quoteUtil->numtoletras($model->retiva);
            $retiva="MENOS RETENCION DEL  I.V.A., ACTUALMENTE DOS TERCERAS PARTES DEL I.V.A, $".number_format($model->retiva,2)." (".$retiva_letras."), ";
        }

        if($model->is_iva==true || $model->is_isr==true || $model->is_retiva==true){

            $subtotal=$model->amount_rent+$model->iva-$model->isr-$model->retiva;
            $subtotal_letras=Yii::app()->quoteUtil->numtoletras($subtotal);

            $total="SIENDO LIQUIDA LA CANTIDAD DE $".number_format($subtotal,2)." (".$subtotal_letras."); ";

            $cadena=$amount_rent.$iva.$isr.$retiva.$total;
        }


        $document->setValue('LESSEE',strtoupper($model->lessee));
        $document->setValue('GENDER_LESSEE',strtoupper($gender_lessee));
        $document->setValue('OWNER',strtoupper($model->owner));
        $document->setValue('GENDER_OWNER',strtoupper($gender_owner));
        $document->setValue('PROPERTY_LOCATION',strtoupper($model->property_location));
        $document->setValue('PROPERTY_TYPE',strtoupper($property_type));
        $document->setValue('ADDRESS_PAYMENT',strtoupper($model->address_payment));
        $document->setValue('PAYDAYS',strtoupper($model->paydays));
        $document->setValue('AMOUNT_RENT',$cadena);
        $document->setValue('FORCED_MONTHS',strtoupper($model->forced_months));
        $document->setValue('INCEPTION_LEASE',strtoupper($inception_lease));
        $document->setValue('END_LEASE',strtoupper($end_lease));
        $document->setValue('PAYMENT_SERVICES',$payment_services);
        $document->setValue('MONTHLY_PAYMENT_ARREARS',$model->monthly_payment_arrears);
        $document->setValue('NEW_RENT_PAYMENT',$new_rent_payment);
        $document->setValue('MONTHLY_PAYMENT_INCREASE',$model->monthly_payment_increase);
        $document->setValue('PENALTY_NONPAYMENT',$model->penalty_nonpayment);
        $document->setValue('DEPOSIT_GUARANTEE',$deposit_guarantee);
        $document->setValue('NAME_SURETY',strtoupper($model->name_surety));
        $document->setValue('GENDER_SURETY',strtoupper($gender_surety));
        $document->setValue('ADDRESS_SURETY',strtoupper($model->address_surety));
        $document->setValue('PROPERTY_ADDRESS_SURETY',strtoupper($model->property_address_surety));
        $document->setValue('ADDRESS_PUBLIC_REGISTER',strtoupper($model->address_public_register));
        $document->setValue('DATE_SIGNATURE',strtoupper($model->date_signature));

        $document->save('contrato.docx');

        $file=basename('contrato.docx');
        $filesize=filesize('contrato.docx');
        Yii::app()->quoteUtil->Download($file,$filesize);


    }


    public function actionExportPdf($id){

        Yii::app()->quoteUtil->ContractToPdf($id);

    }

	public function actionView($id)
	{

		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}



	public function actionCreate()
	{
        Yii::import('bootstrap.widgets.TbForm');

		$model=new ContractInformation;
        $search=array();
        $property=new PropertyTypes;
        $services= new Services;
        $iva="";
        $isr="";
        $retiva="";
        $total="";
        $cadena="";
        $contract_start=array();
        $lesseeString='';
        $ownerString='';
        $prefix_lessee='';
        $prefix_owner='';

        $propertyTypes = TbForm::createForm($property->getForm(),$property,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $servicesForm = TbForm::createForm($services->getForm(),$services,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

		if(isset($_POST['ContractInformation']))
		{
			$model->attributes=$_POST['ContractInformation'];

            foreach($model->tableSchema->columns as $column){
                $search[]='{'.strtoupper($column->name).'}';
            }

            array_push($search,'{CONTRACT_START}','{COMPANY/LESSEE}','{PREFIX_LESSEE}','{PREFIX_OWNER}');


            $gender_owner= ($model->gender_owner==1) ? Yii::t('mx','El propietario') : Yii::t('mx','La propietaria');
            $gender_lessee= ($model->gender_lessee==1) ? Yii::t('mx','El arrendatario') : Yii::t('mx','La arrendataria');
            $gender_surety= ($model->gender_surety==1) ? Yii::t('mx','El fiador') : Yii::t('mx','La Fiadora');
            $properties=PropertyTypes::model()->findByPk($model->property_type);
            $property_type=$properties->property;
            $inception_lease=date('Y-M-d',strtotime($model->inception_lease));
            $end_lease=date('Y-M-d',strtotime($model->end_lease));
            $inception_lease=Yii::app()->quoteUtil->toSpanishDateDescription($inception_lease);
            $end_lease=Yii::app()->quoteUtil->toSpanishDateDescription($end_lease);


            $amount_rent2=(string)$model->amount_rent;
            $amount_rent2=str_replace(',','',$amount_rent2);
            $model->amount_rent=$amount_rent2;

            $new_rent_payment2=(string)$model->new_rent_payment;
            $new_rent_payment2=str_replace(',','',$new_rent_payment2);
            $model->new_rent_payment=$new_rent_payment2;

            $deposit_guarantee2=(string)$model->deposit_guarantee;
            $deposit_guarantee2=str_replace(',','',$deposit_guarantee2);
            $model->deposit_guarantee=$deposit_guarantee2;

            $payment_services2=(string)$model->payment_services;
            $payment_services2=str_replace(',','',$payment_services2);
            $model->payment_services=$payment_services2;

            $totalAmount=(string)$model->total_amount;
            $totalAmount=str_replace(',','',$totalAmount);
            $model->total_amount=$totalAmount;

            $amount_rent=Yii::app()->quoteUtil->numtoletras($model->amount_rent);
            $amount_rent=number_format($model->amount_rent,2).' ('.$amount_rent.')';

            $new_rent_payment=Yii::app()->quoteUtil->numtoletras($model->new_rent_payment);
            $new_rent_payment=number_format($model->new_rent_payment,2).' ('.$new_rent_payment.')';

            $deposit_guarantee=Yii::app()->quoteUtil->numtoletras($model->deposit_guarantee);
            $deposit_guarantee=number_format($model->deposit_guarantee,2).' ('.$deposit_guarantee.')';


            if($model->payment_services!=null){
                $payment_services=Yii::app()->quoteUtil->numtoletras($model->payment_services);
                $payment_services=number_format($model->payment_services,2).' ('.$payment_services.')';
            }
            else{
                $payment_services='0.00'.' (Cero Pesos 00/100 M.N.)';
            }

            if($model->is_iva==true){
                $iva_letras=Yii::app()->quoteUtil->numtoletras($model->iva);
                $iva=" MAS I.V.A., ACTUALMENTE AL ".$model->iva_percent."%, $".number_format($model->iva,2)." (".$iva_letras."), ";
            }

            if($model->is_isr==true){
                $isr_letras=Yii::app()->quoteUtil->numtoletras($model->isr);
                $isr="MENOS RETENCION DEL I.S.R., ACTUALMENTE AL ".$model->isr_percent."%, $".number_format($model->isr,2)." (".$isr_letras."), ";
            }

            if($model->is_retiva==true){
                $retiva_letras=Yii::app()->quoteUtil->numtoletras($model->retiva);
                $retiva="MENOS RETENCION DEL  I.V.A., ACTUALMENTE DOS TERCERAS PARTES DEL I.V.A, $".number_format($model->retiva,2)." (".$retiva_letras."), ";
            }

            if($model->is_iva==true || $model->is_isr==true || $model->is_retiva==true){

                //$subtotal=$model->amount_rent+$model->iva-$model->isr-$model->retiva;
                $subtotal=$model->total_amount;
                $subtotal_letras=Yii::app()->quoteUtil->numtoletras($subtotal);

                $total="SIENDO LA CANTIDAD LIQUIDA DE ".number_format($subtotal,2)." (".$subtotal_letras."); ";

                $cadena=$iva.$isr.$retiva.$total;
            }

            $date_signature=Yii::app()->quoteUtil->fechaALetras($model->date_signature);

            $contract_start=$date=explode('-',$model->inception_lease);

            $generoLessee=($model->gender_lessee==1) ? 'El C. ' : 'La C. ';

            $generoOwner=($model->gender_owner==1) ? 'El C. ' : 'La C. ';

            if($model->iscompany_lessee){

                $lesseeString.=$model->company_lessee.' ';
                $lesseeString.='representada por ';
                $lesseeString.=$generoLessee.$model->lessee;
                $prefix_lessee='La Sociedad Mercantil denominada';
            }else{
                $lesseeString=$generoLessee.$model->lessee;
            }

            if($model->iscompany_owner){
                $ownerString.=$model->company_owner.' ';
                $ownerString.='representada por ';
                $ownerString.=$generoOwner.$model->owner;
                $prefix_owner='La Sociedad Mercantil denominada';
            }
            else{
                $ownerString=$generoOwner.$model->owner;
            }

            if($model->has_surety){
                $contract=Contract::model()->findByPk(1);
            }else{
                $contract=Contract::model()->findByPk(2);
            }

            $replace=array(
                'id'=>$model->id,
                'lessee'=>strtoupper($lesseeString),
                'gender_lessee'=>strtoupper($gender_lessee),
                'owner'=>strtoupper($ownerString),
                'gender_owner'=>strtoupper($gender_owner),
                'property_location'=>strtoupper($model->property_location),
                'property_type'=>strtoupper($property_type),
                'address_payment'=>strtoupper($model->address_payment),
                'paydays'=>strtoupper($model->paydays),
                'amount_rent'=>$amount_rent.$cadena,
                'forced_months'=>strtoupper($model->forced_months),
                'inception_lease'=>strtoupper($inception_lease),
                'end_lease'=>strtoupper($end_lease),
                'payment_services'=>$payment_services,
                'monthly_payment_arrears'=>$model->monthly_payment_arrears,
                'new_rent_payment'=>$new_rent_payment,
                'monthly_payment_increase'=>$model->monthly_payment_increase,
                'penalty_nonpayment'=>$model->penalty_nonpayment,
                'deposit_guarantee'=>$deposit_guarantee,
                'has_surety'=>$model->has_surety,
                'name_surety'=>strtoupper($model->name_surety),
                'gender_surety'=>strtoupper($gender_surety),
                'address_surety'=>strtoupper($model->address_surety),
                'property_address_surety'=>strtoupper($model->property_address_surety),
                'address_public_register'=>strtoupper($model->address_public_register),
                'date_signature'=>strtoupper($date_signature),
                'title'=>$model->title,
                'content'=>$model->content,
                'is_iva'=>$model->is_iva,
                'iva_percent'=>$model->iva_percent,
                'iva'=>$model->iva,
                'is_isr'=>$model->is_isr,
                'isr_percent'=>$model->isr_percent,
                'isr'=>$model->isr,
                'is_retiva'=>$model->is_retiva,
                'retiva'=>$model->retiva,
                'total'=>$model->total,
                'service_id'=>strtoupper($model->services->service),
                'iscompany_lessee' => $model->iscompany_lessee,
                'company_lessee' =>($model->company_lessee),
                'rfc_lessee' =>strtoupper($model->rfc_lessee),
                'iscompany_owner' => $model->iscompany_owner,
                'company_owner' =>strtoupper($model->company_owner),
                'total_amount'=>$model->total_amount,
                'contract_start'=>$contract_start[0],
                'company/lessee'=>strtoupper($lesseeString),
                'prefix_lessee'=>$prefix_lessee,
                'prefix_owner'=>$prefix_owner
            );

            $formato=$contract->content;
            //$replace=$model->attributes;

            $content=str_replace($search,$replace,$formato);
            $model->content=$content;


			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('create',array(
			'model'=>$model,
            'property'=>$propertyTypes,
            'servicesForm'=>$servicesForm
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        Yii::import('bootstrap.widgets.TbForm');

		$model=$this->loadModel($id);
        $search=array();
        $property=new PropertyTypes;
        $services= new Services;
        $iva="";
        $isr="";
        $retiva="";
        $total="";
        $cadena="";
        $contract_start=array();
        $lesseeString='';
        $ownerString='';
        $prefix_lessee='';
        $prefix_owner='';

        $propertyTypes = TbForm::createForm($property->getForm(),$property,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

        $servicesForm = TbForm::createForm($services->getForm(),$services,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

		if(isset($_POST['ContractInformation']))
		{
			$model->attributes=$_POST['ContractInformation'];

            foreach($model->tableSchema->columns as $column){
                $search[]='{'.strtoupper($column->name).'}';
            }

            array_push($search,'{CONTRACT_START}','{COMPANY/LESSEE}','{PREFIX_LESSEE}','{PREFIX_OWNER}');

            $gender_owner= ($model->gender_owner==1) ? Yii::t('mx','El propietario') : Yii::t('mx','La propietaria');
            $gender_lessee= ($model->gender_lessee==1) ? Yii::t('mx','El arrendatario') : Yii::t('mx','La arrendataria');
            $gender_surety= ($model->gender_surety==1) ? Yii::t('mx','El fiador') : Yii::t('mx','La Fiadora');
            $properties=PropertyTypes::model()->findByPk($model->property_type);
            $property_type=$properties->property;

            $inception_lease=date('Y-M-d',strtotime($model->inception_lease));
            $end_lease=date('Y-M-d',strtotime($model->end_lease));
            $inception_lease=Yii::app()->quoteUtil->toSpanishDateDescription($inception_lease);
            $end_lease=Yii::app()->quoteUtil->toSpanishDateDescription($end_lease);


            $amount_rent2=(string)$model->amount_rent;
            $amount_rent2=str_replace(',','',$amount_rent2);
            $model->amount_rent=$amount_rent2;

            $new_rent_payment2=(string)$model->new_rent_payment;
            $new_rent_payment2=str_replace(',','',$new_rent_payment2);
            $model->new_rent_payment=$new_rent_payment2;

            $deposit_guarantee2=(string)$model->deposit_guarantee;
            $deposit_guarantee2=str_replace(',','',$deposit_guarantee2);
            $model->deposit_guarantee=$deposit_guarantee2;

            $payment_services2=(string)$model->payment_services;
            $payment_services2=str_replace(',','',$payment_services2);
            $model->payment_services=$payment_services2;

            $totalAmount=(string)$model->total_amount;
            $totalAmount=str_replace(',','',$totalAmount);
            $model->total_amount=$totalAmount;

            $amount_rent=Yii::app()->quoteUtil->numtoletras($model->amount_rent);
            $amount_rent=number_format($model->amount_rent,2).' ('.$amount_rent.')';

            $new_rent_payment=Yii::app()->quoteUtil->numtoletras($model->new_rent_payment);
            $new_rent_payment=number_format($model->new_rent_payment,2).' ('.$new_rent_payment.')';

            $deposit_guarantee=Yii::app()->quoteUtil->numtoletras($model->deposit_guarantee);
            $deposit_guarantee=number_format($model->deposit_guarantee,2).' ('.$deposit_guarantee.')';


            if($model->payment_services!=null){
                $payment_services=Yii::app()->quoteUtil->numtoletras($model->payment_services);
                $payment_services=number_format($model->payment_services,2).' ('.$payment_services.')';
            }
            else{
                $payment_services='0.00'.' (Cero Pesos 00/100 M.N.)';
            }

            if($model->is_iva==true){
                $iva_letras=Yii::app()->quoteUtil->numtoletras($model->iva);
                $iva=" MAS I.V.A., ACTUALMENTE AL ".$model->iva_percent."%, $".number_format($model->iva,2)." (".$iva_letras."), ";
            }

            if($model->is_isr==true){
                $isr_letras=Yii::app()->quoteUtil->numtoletras($model->isr);
                $isr="MENOS RETENCION DEL  I.S.R., ACTUALMENTE AL ".$model->isr_percent."%, $".number_format($model->isr,2)." (".$isr_letras."), ";
            }

            if($model->is_retiva==true){
                $retiva_letras=Yii::app()->quoteUtil->numtoletras($model->retiva);
                $retiva="MENOS RETENCION DEL  I.V.A., ACTUALMENTE DOS TERCERAS PARTES DEL I.V.A, $".number_format($model->retiva,2)." (".$retiva_letras."), ";
            }

            if($model->is_iva==true || $model->is_isr==true || $model->is_retiva==true){

                //$subtotal=$model->amount_rent+$model->iva-$model->isr-$model->retiva;
                $subtotal=$model->total_amount;
                $subtotal_letras=Yii::app()->quoteUtil->numtoletras($subtotal);

                $total="SIENDO LIQUIDA LA CANTIDAD DE ".number_format($subtotal,2)." (".$subtotal_letras."); ";

                $cadena=$iva.$isr.$retiva.$total;
            }

            $date_signature=Yii::app()->quoteUtil->fechaALetras($model->date_signature);

            $contract_start=$date=explode('-',$model->inception_lease);

            $generoLessee=($model->gender_lessee==1) ? 'El C. ' : 'La C. ';
            $generoOwner=($model->gender_owner==1) ? 'El C. ' : 'La C. ';


            if($model->iscompany_lessee){

                $lesseeString.=$model->company_lessee.' ';
                $lesseeString.='representada por ';
                $lesseeString.=$generoLessee.$model->lessee;
                $prefix_lessee='La Sociedad Mercantil denominada';
            }else{
                $lesseeString=$generoLessee.$model->lessee;
            }

            if($model->iscompany_owner){
                $ownerString.=$model->company_owner.' ';
                $ownerString.='representada por ';
                $ownerString.=$generoOwner.$model->owner;
                $prefix_owner='La Sociedad Mercantil denominada';
            }
            else{
                $ownerString=$generoOwner.$model->owner;
            }

            if($model->has_surety){
                $contract=Contract::model()->findByPk(1);
            }else{
                $contract=Contract::model()->findByPk(2);
            }

            $replace=array(
                'id'=>$model->id,
                'lessee'=>strtoupper($lesseeString),
                'gender_lessee'=>strtoupper($gender_lessee),
                'owner'=>strtoupper($ownerString),
                'gender_owner'=>strtoupper($gender_owner),
                'property_location'=>strtoupper($model->property_location),
                'property_type'=>strtoupper($property_type),
                'address_payment'=>strtoupper($model->address_payment),
                'paydays'=>strtoupper($model->paydays),
                'amount_rent'=>$amount_rent.$cadena,
                'forced_months'=>strtoupper($model->forced_months),
                'inception_lease'=>strtoupper($inception_lease),
                'end_lease'=>strtoupper($end_lease),
                'payment_services'=>$payment_services,
                'monthly_payment_arrears'=>$model->monthly_payment_arrears,
                'new_rent_payment'=>$new_rent_payment,
                'monthly_payment_increase'=>$model->monthly_payment_increase,
                'penalty_nonpayment'=>$model->penalty_nonpayment,
                'deposit_guarantee'=>$deposit_guarantee,
                'has_surety'=>$model->has_surety,
                'name_surety'=>strtoupper($model->name_surety),
                'gender_surety'=>strtoupper($gender_surety),
                'address_surety'=>strtoupper($model->address_surety),
                'property_address_surety'=>strtoupper($model->property_address_surety),
                'address_public_register'=>strtoupper($model->address_public_register),
                'date_signature'=>strtoupper($date_signature),
                'title'=>$model->title,
                'content'=>$model->content,
                'is_iva'=>$model->is_iva,
                'iva_percent'=>$model->iva_percent,
                'iva'=>$model->iva,
                'is_isr'=>$model->is_isr,
                'isr_percent'=>$model->isr_percent,
                'isr'=>$model->isr,
                'is_retiva'=>$model->is_retiva,
                'retiva'=>$model->retiva,
                'total'=>$model->total,
                'service_id'=>strtoupper($model->services->service),
                'iscompany_lessee' => $model->iscompany_lessee,
                'company_lessee' =>strtoupper($model->company_lessee),
                'rfc_lessee' =>strtoupper($model->rfc_lessee),
                'iscompany_owner' => $model->iscompany_owner,
                'company_owner' =>strtoupper($model->company_owner),
                'total_amount'=>$model->total_amount,
                'contract_start'=>$contract_start[0],
                'company/lessee'=>strtoupper($lesseeString),
                'prefix_lessee'=>$prefix_lessee,
                'prefix_owner'=>$prefix_owner
            );

            $formato=$contract->content;

            $content=str_replace($search,$replace,$formato);
            $model->content=$content;

			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }


		}

		$this->render('update',array(
			'model'=>$model,
            'property'=>$propertyTypes,
            'servicesForm'=>$servicesForm
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new ContractInformation('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['ContractInformation']))
        $model->attributes=$_GET['ContractInformation'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}

	/**
	 * Manages all models.
	 */

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=ContractInformation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contract-information-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
