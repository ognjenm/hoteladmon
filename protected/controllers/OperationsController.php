<?php

class OperationsController extends Controller
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


	public function accessRules()
	{
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create',
                    'update','delete',
                    'index','view','deposit',
                    'payment','exportBalanceToPdf',
                    'cancel','ExportPdfToAccountant',
                    'transfer','getOperation','saldos','sumaOperations','closeOperations'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionCloseOperations(){

        $res=array('ok'=>false);
        $suma=0;

        if(Yii::app()->request->isPostRequest){

            $values=$_POST['ids'];
            $ids=explode(',',$values);

            foreach($ids as $id){
                $model=$this->loadModel($id);
               $model->groupByOperation=strtotime(date('Y-m-d'));
            }

            $res=array('ok'=>true,'suma'=>number_format($suma,2));

            echo CJSON::encode($res);
            Yii::app()->end();

        }


    }

    public function actionSumaOperations(){

        $res=array('ok'=>false);
        $suma=0;

        if(Yii::app()->request->isPostRequest){

            $values=$_POST['ids'];
            $ids=explode(',',$values);

            foreach($ids as $id){
                $model=$this->loadModel($id);
                $commission=$model->vat_commission+$model->commission_fee;
                $commission=$model->deposit-$commission;
                $suma=$suma+$commission;
            }

            $res=array('ok'=>true,'suma'=>number_format($suma,2));

            echo CJSON::encode($res);
            Yii::app()->end();

        }
    }

    public function actionSaldos($accountId,$accountType){

        $botones=Yii::app()->quoteUtil->menuAccounts();
        Yii::import('bootstrap.widgets.TbForm');

        switch($accountType){

            case 1: //cheques

                $filter=new Operations('search');
                $filter->unsetAttributes();

                $Formfilter = TbForm::createForm($filter->getFilter(),$filter,
                    array('htmlOptions'=>array('class'=>'well'),
                        'type'=>'inline',
                    )
                );

                if(isset($_GET['Operations'])) {
                    $filter->attributes=$_GET['Operations'];
                }

                if(isset($_GET['Operations']['inicio']) && isset($_GET['Operations']['fin'])) {

                    $filter->inicio=$_GET['Operations']['inicio'];
                    $filter->fin=$_GET['Operations']['fin'];
                    Yii::app()->getSession()->add('dateStart',$_GET['Operations']['inicio']);
                    Yii::app()->getSession()->add('dateEnd',$_GET['Operations']['fin']);
                }

            break;

            case 2: //intercuenta

                $filter=new IntercuentaOperations('search');
                $filter->unsetAttributes();

                $Formfilter = TbForm::createForm($filter->getFilter(),$filter,
                    array('htmlOptions'=>array('class'=>'well'),
                        'type'=>'inline',
                    )
                );

                if(isset($_GET['IntercuentaOperations'])) {
                    $filter->attributes=$_GET['IntercuentaOperations'];
                }

                if(isset($_GET['IntercuentaOperations']['inicio']) && isset($_GET['IntercuentaOperations']['fin'])) {

                    $filter->inicio=$_GET['IntercuentaOperations']['inicio'];
                    $filter->fin=$_GET['IntercuentaOperations']['fin'];
                    Yii::app()->getSession()->add('dateStart',$_GET['IntercuentaOperations']['inicio']);
                    Yii::app()->getSession()->add('dateEnd',$_GET['IntercuentaOperations']['fin']);
                }

                break;

            case 3: //tarjeta debito

                $filter=new DebitOperations('search');
                $filter->unsetAttributes();

                $Formfilter = TbForm::createForm($filter->getFilter(),$filter,
                    array('htmlOptions'=>array('class'=>'well'),
                        'type'=>'inline',
                    )
                );

                if(isset($_GET['DebitOperations'])) {
                    $filter->attributes=$_GET['DebitOperations'];
                }

                if(isset($_GET['DebitOperations']['inicio']) && isset($_GET['DebitOperations']['fin'])) {

                    $filter->inicio=$_GET['DebitOperations']['inicio'];
                    $filter->fin=$_GET['DebitOperations']['fin'];
                    Yii::app()->getSession()->add('dateStart',$_GET['DebitOperations']['inicio']);
                    Yii::app()->getSession()->add('dateEnd',$_GET['DebitOperations']['fin']);
                }

                break;

            case 4: //tarjeta credito

                $filter=new CreditOperations('search');
                $filter->unsetAttributes();

                $Formfilter = TbForm::createForm($filter->getFilter(),$filter,
                    array('htmlOptions'=>array('class'=>'well'),
                        'type'=>'inline',
                    )
                );

                if(isset($_GET['CreditOperations'])) {
                    $filter->attributes=$_GET['CreditOperations'];
                }

                if(isset($_GET['CreditOperations']['inicio']) && isset($_GET['CreditOperations']['fin'])) {

                    $filter->inicio=$_GET['CreditOperations']['inicio'];
                    $filter->fin=$_GET['CreditOperations']['fin'];
                    Yii::app()->getSession()->add('dateStart',$_GET['CreditOperations']['inicio']);
                    Yii::app()->getSession()->add('dateEnd',$_GET['CreditOperations']['fin']);
                }

                break;

            case 4: //tarjeta credito

                $filter=new CreditOperations('search');
                $filter->unsetAttributes();

                $Formfilter = TbForm::createForm($filter->getFilter(),$filter,
                    array('htmlOptions'=>array('class'=>'well'),
                        'type'=>'inline',
                    )
                );

                if(isset($_GET['CreditOperations'])) {
                    $filter->attributes=$_GET['CreditOperations'];
                }

                if(isset($_GET['CreditOperations']['inicio']) && isset($_GET['CreditOperations']['fin'])) {

                    $filter->inicio=$_GET['CreditOperations']['inicio'];
                    $filter->fin=$_GET['CreditOperations']['fin'];
                    Yii::app()->getSession()->add('dateStart',$_GET['CreditOperations']['inicio']);
                    Yii::app()->getSession()->add('dateEnd',$_GET['CreditOperations']['fin']);
                }

                break;

        }


       $accountTypes=AccountTypes::model()->findByPk($accountType);
       $account=BankAccounts::model()->accountByPk($accountId);

       $display=$accountTypes->tipe.'-'.$account;

        $this->render('saldos',array(
            'Formfilter'=>$Formfilter,
            'botones'=>$botones,
            'dataProvider'=>$filter,
            'display'=>$display,
            'accountId'=>$accountId,
            'accountType'=>$accountType
        ));



    }

    public function actionGetOperation(){

            $res=array('ok'=>false);

            if(Yii::app()->request->isPostRequest){

                $operationId=(int)$_POST['operationId'];

                $model=$this->loadModel($operationId);

                $res=array('ok'=>true,'price'=>$model->deposit);

                echo CJSON::encode($res);
                Yii::app()->end();

            }

    }

    public function actionCancel($id){

        $res=array('ok'=>false);

        if(Yii::app()->request->isPostRequest){
            $model=$this->loadModel($id);
            $account=BankAccounts::model()->findByPk($model->account_id);

            $saldoCuenta=$account->initial_balance+$model->retirement;
            $saldoBalance=$model->balance+$model->retirement;

            if($model->payment_type==6 && $model->iscancelled==0){
                $account->initial_balance=$saldoCuenta;
                $model->balance=$saldoBalance;
                $model->released=Yii::t('mx','CANCELLED');
                $model->concept=Yii::t('mx','CANCELLED');
                $model->bank_concept=Yii::t('mx','CANCELLED');
                $model->iscancelled=1;

                if($account->save() && $model->save()){
                    $res=array('ok'=>true);
                }

            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }

    }

    public function actionTransfer($accountId,$accountType){

        switch($accountType){
            case 1:

                $model=new Operations;
                $modelDestination= new Operations;

                if(isset($_POST['Operations'])){

                    $model->attributes=$_POST['Operations'];
                    $destinationAccountId=(int)$_POST['destinationAccount'];

                    $balanceSource=BankAccounts::model()->consultRetirement($accountId,$model->retirement);
                    $balanceDestination=BankAccounts::model()->consultDeposit($destinationAccountId,$model->retirement);

                    $bankAccountSource=BankAccounts::model()->accountByPk($accountId);
                    $bankAccountDestination=BankAccounts::model()->accountByPk($destinationAccountId);

                    $model->payment_type=5;
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->released=$bankAccountDestination;
                    $model->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountDestination;
                    $model->person='------';
                    $model->balance=$balanceSource;

                    $modelDestination->payment_type=5;
                    $modelDestination->account_id=$destinationAccountId;
                    $modelDestination->cheq='TRA';
                    $modelDestination->datex=$model->datex;
                    $modelDestination->released=$bankAccountDestination;
                    $modelDestination->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountSource;
                    $modelDestination->person='------';
                    $modelDestination->deposit=$model->retirement;
                    $modelDestination->balance=$balanceDestination;


                    if($model->save() && $modelDestination->save()){

                        Yii::app()->quoteUtil->retirementAccount($accountId,$model->retirement);
                        Yii::app()->quoteUtil->depositAccount($destinationAccountId,$model->retirement);

                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }

                }

            break;

            case 2:

                $model=new IntercuentaOperations;
                $modelDestination= new IntercuentaOperations;

                if(isset($_POST['IntercuentaOperations'])){

                    $model->attributes=$_POST['IntercuentaOperations'];
                    $destinationAccountId=(int)$_POST['destinationAccount'];

                    $balanceSource=BankAccounts::model()->consultRetirement($accountId,$model->retirement);
                    $balanceDestination=BankAccounts::model()->consultDeposit($destinationAccountId,$model->retirement);

                    $bankAccountSource=BankAccounts::model()->accountByPk($accountId);
                    $bankAccountDestination=BankAccounts::model()->accountByPk($destinationAccountId);

                    $model->payment_type=5;
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->released=$bankAccountDestination;
                    $model->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountDestination;
                    $model->person='------';
                    $model->balance=$balanceSource;

                    $modelDestination->payment_type=5;
                    $modelDestination->account_id=$destinationAccountId;
                    $modelDestination->cheq='TRA';
                    $modelDestination->datex=$model->datex;
                    $modelDestination->released=$bankAccountDestination;
                    $modelDestination->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountSource;
                    $modelDestination->person='------';
                    $modelDestination->deposit=$model->retirement;
                    $modelDestination->balance=$balanceDestination;


                    if($model->save() && $modelDestination->save()){

                        Yii::app()->quoteUtil->retirementAccount($accountId,$model->retirement);
                        Yii::app()->quoteUtil->depositAccount($destinationAccountId,$model->retirement);

                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }

                }

            break;

            case 3:

                $model=new DebitOperations;
                $modelDestination= new DebitOperations;

                if(isset($_POST['DebitOperations'])){

                    $model->attributes=$_POST['DebitOperations'];
                    $destinationAccountId=(int)$_POST['destinationAccount'];

                    $balanceSource=BankAccounts::model()->consultRetirement($accountId,$model->retirement);
                    $balanceDestination=BankAccounts::model()->consultDeposit($destinationAccountId,$model->retirement);

                    $bankAccountSource=BankAccounts::model()->accountByPk($accountId);
                    $bankAccountDestination=BankAccounts::model()->accountByPk($destinationAccountId);

                    $model->payment_type=5;
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->released=$bankAccountDestination;
                    $model->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountDestination;
                    $model->person='------';
                    $model->balance=$balanceSource;

                    $modelDestination->payment_type=5;
                    $modelDestination->account_id=$destinationAccountId;
                    $modelDestination->cheq='TRA';
                    $modelDestination->datex=$model->datex;
                    $modelDestination->released=$bankAccountDestination;
                    $modelDestination->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountSource;
                    $modelDestination->person='------';
                    $modelDestination->deposit=$model->retirement;
                    $modelDestination->balance=$balanceDestination;


                    if($model->save() && $modelDestination->save()){

                        Yii::app()->quoteUtil->retirementAccount($accountId,$model->retirement);
                        Yii::app()->quoteUtil->depositAccount($destinationAccountId,$model->retirement);

                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 4:

                $model=new CreditOperations;
                $modelDestination= new CreditOperations;

                if(isset($_POST['CreditOperations'])){

                    $model->attributes=$_POST['CreditOperations'];
                    $destinationAccountId=(int)$_POST['destinationAccount'];

                    $balanceSource=BankAccounts::model()->consultRetirement($accountId,$model->retirement);
                    $balanceDestination=BankAccounts::model()->consultDeposit($destinationAccountId,$model->retirement);

                    $bankAccountSource=BankAccounts::model()->accountByPk($accountId);
                    $bankAccountDestination=BankAccounts::model()->accountByPk($destinationAccountId);

                    $model->payment_type=5;
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->released=$bankAccountDestination;
                    $model->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountDestination;
                    $model->person='------';
                    $model->balance=$balanceSource;

                    $modelDestination->payment_type=5;
                    $modelDestination->account_id=$destinationAccountId;
                    $modelDestination->cheq='TRA';
                    $modelDestination->datex=$model->datex;
                    $modelDestination->released=$bankAccountDestination;
                    $modelDestination->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountSource;
                    $modelDestination->person='------';
                    $modelDestination->deposit=$model->retirement;
                    $modelDestination->balance=$balanceDestination;


                    if($model->save() && $modelDestination->save()){

                        Yii::app()->quoteUtil->retirementAccount($accountId,$model->retirement);
                        Yii::app()->quoteUtil->depositAccount($destinationAccountId,$model->retirement);

                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 5:

                $model=new InvestmentOperations;
                $modelDestination= new InvestmentOperations;

                if(isset($_POST['InvestmentOperations'])){

                    $model->attributes=$_POST['InvestmentOperations'];
                    $destinationAccountId=(int)$_POST['destinationAccount'];

                    $balanceSource=BankAccounts::model()->consultRetirement($accountId,$model->retirement);
                    $balanceDestination=BankAccounts::model()->consultDeposit($destinationAccountId,$model->retirement);

                    $bankAccountSource=BankAccounts::model()->accountByPk($accountId);
                    $bankAccountDestination=BankAccounts::model()->accountByPk($destinationAccountId);

                    $model->payment_type=5;
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->released=$bankAccountDestination;
                    $model->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountDestination;
                    $model->person='------';
                    $model->balance=$balanceSource;

                    $modelDestination->payment_type=5;
                    $modelDestination->account_id=$destinationAccountId;
                    $modelDestination->cheq='TRA';
                    $modelDestination->datex=$model->datex;
                    $modelDestination->released=$bankAccountDestination;
                    $modelDestination->concept=Yii::t('mx','INTERACCOUNT TRANSFER').' '.$bankAccountSource;
                    $modelDestination->person='------';
                    $modelDestination->deposit=$model->retirement;
                    $modelDestination->balance=$balanceDestination;


                    if($model->save() && $modelDestination->save()){

                        Yii::app()->quoteUtil->retirementAccount($accountId,$model->retirement);
                        Yii::app()->quoteUtil->depositAccount($destinationAccountId,$model->retirement);

                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

        }

        $accountTypes=AccountTypes::model()->findByPk($accountType);
        $bankAccount=BankAccounts::model()->accountByPk($accountId);

        $display=$accountTypes->tipe.'-'.$bankAccount;

        $this->render('transfer',array(
            'model'=>$model,
            'display'=>$display
        ));

    }

    public function actionPayment($accountId,$accountType){


        Yii::import('bootstrap.widgets.TbForm');
        $conceptPayments=new ConceptPayments;
        $numcheques=0;

        $Fconcept= TbForm::createForm($conceptPayments->formConcept(),$conceptPayments,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );


        switch($accountType){
            case 1:
                $model=new Operations;

                if(isset($_POST['Operations'])){

                    $account=BankAccounts::model()->findByPk($accountId);

                    $model->attributes=$_POST['Operations'];
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->person='------';

                    $providerId=(int)$_POST['Operations']['released'];

                    if(!empty($providerId)){
                        $provider=Providers::model()->findByPk($providerId);
                        $model->released=$provider->company;
                    }

                    $balance=$account->initial_balance-$model->retirement;
                    $account->initial_balance=$balance;
                    $model->balance=$balance;

                    if($model->payment_type==6){

                        $numcheques=BankAccounts::model()->numerosCheque($accountId);

                        $model->cheq=$account->consecutive;
                        $account->consecutive=$account->consecutive+1;

                    }


                    if(!empty($_POST['name'])) {
                        $model->released=$_POST['name'];
                    }

                    if($model->person=="") $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="") $model->bank_concept=Yii::t('mx','PENDING');

                    if($numcheques > 0){
                        $model->save();
                        $account->save();
                        Yii::app()->user->setFlash('success','Success! numero de cheques disponibles: '.$numcheques);
                        $this->redirect(array('index'));
                    }else{
                        Yii::app()->user->setFlash('error','error! No hay cheques disponibles');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 2:
                $model=new IntercuentaOperations;

                if(isset($_POST['IntercuentaOperations'])){

                    $account=BankAccounts::model()->findByPk($accountId);

                    $model->attributes=$_POST['IntercuentaOperations'];
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->person='------';

                    $providerId=(int)$_POST['Operations']['released'];

                    if(!empty($providerId)){
                        $provider=Providers::model()->findByPk($providerId);
                        $model->released=$provider->company;
                    }

                    $balance=$account->initial_balance-$model->retirement;
                    $account->initial_balance=$balance;
                    $model->balance=$balance;

                    if($model->payment_type==6){
                        $model->cheq=$account->consecutive;
                        $account->consecutive=$account->consecutive+1;
                    }

                    if(!empty($_POST['name'])) {
                        $model->released=$_POST['name'];
                    }

                    if($model->person=="") $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="") $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }


            break;

            case 3:
                $model=new DebitOperations;

                if(isset($_POST['DebitOperations'])){

                    $account=BankAccounts::model()->findByPk($accountId);

                    $model->attributes=$_POST['DebitOperations'];
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->person='------';

                    $providerId=(int)$_POST['Operations']['released'];

                    if(!empty($providerId)){
                        $provider=Providers::model()->findByPk($providerId);
                        $model->released=$provider->company;
                    }

                    $balance=$account->initial_balance-$model->retirement;
                    $account->initial_balance=$balance;
                    $model->balance=$balance;

                    if($model->payment_type==6){
                        $model->cheq=$account->consecutive;
                        $account->consecutive=$account->consecutive+1;
                    }

                    if(!empty($_POST['name'])) {
                        $model->released=$_POST['name'];
                    }

                    if($model->person=="") $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="") $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 4:
                $model=new CreditOperations;

                if(isset($_POST['CreditOperations'])){

                    $account=BankAccounts::model()->findByPk($accountId);

                    $model->attributes=$_POST['CreditOperations'];
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->person='------';

                    $providerId=(int)$_POST['Operations']['released'];

                    if(!empty($providerId)){
                        $provider=Providers::model()->findByPk($providerId);
                        $model->released=$provider->company;
                    }

                    $balance=$account->initial_balance-$model->retirement;
                    $account->initial_balance=$balance;
                    $model->balance=$balance;

                    if($model->payment_type==6){
                        $model->cheq=$account->consecutive;
                        $account->consecutive=$account->consecutive+1;
                    }

                    if(!empty($_POST['name'])) {
                        $model->released=$_POST['name'];
                    }

                    if($model->person=="") $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="") $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 5:
                $model=new InvestmentOperations;

                if(isset($_POST['InvestmentOperations'])){

                    $account=BankAccounts::model()->findByPk($accountId);

                    $model->attributes=$_POST['InvestmentOperations'];
                    $model->account_id=$accountId;
                    $model->cheq='TRA';
                    $model->person='------';

                    $providerId=(int)$_POST['Operations']['released'];

                    if(!empty($providerId)){
                        $provider=Providers::model()->findByPk($providerId);
                        $model->released=$provider->company;
                    }

                    $balance=$account->initial_balance-$model->retirement;
                    $account->initial_balance=$balance;
                    $model->balance=$balance;

                    if($model->payment_type==6){
                        $model->cheq=$account->consecutive;
                        $account->consecutive=$account->consecutive+1;
                    }

                    if(!empty($_POST['name'])) {
                        $model->released=$_POST['name'];
                    }

                    if($model->person=="") $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="") $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;


        }

        $accountTypes=AccountTypes::model()->findByPk($accountType);
        $bankAccount=BankAccounts::model()->accountByPk($accountId);

        $display=$accountTypes->tipe.'-'.$bankAccount;

        $criteria=new CDbCriteria;
        $criteria->condition = 'provider_id=:providerId';
        $criteria->params = array(':providerId'=>0);

        $critConcept=new CDbCriteria;
        $critConcept->condition = 'provider_id=:providerId';
        $critConcept->params = array(':providerId'=>0);


        if(isset($_GET['provider_id'])){
            $providerId=(int)$_GET['provider_id'];

            $criteria=new CDbCriteria;
            $criteria->condition = 'provider_id=:providerId and isactive=1';
            $criteria->params = array(':providerId'=>$providerId);

            $critConcept=new CDbCriteria;
            $critConcept->condition = 'provider_id=:providerId';
            $critConcept->params = array(':providerId'=>$providerId);

        }

        $invoice= new CActiveDataProvider('DirectInvoice', array(
            'keyAttribute'=>'total',
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));

        $concepts= new CActiveDataProvider('ConceptPayments', array(
            'keyAttribute'=>'concept',
            'criteria'=>$critConcept,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));


        $this->render('payment',array(
            'model'=>$model,
            'display'=>$display,
            'invoice'=>$invoice,
            'concepts'=>$concepts,
            'Fconcept'=>$Fconcept,
        ));
    }

    public function actionGetInvoices(){

        if(Yii::app()->request->isPostRequest){

            /*$criteria=new CDbCriteria;
            $criteria->condition = 'provider_id=:providerId';
            $criteria->params = array(':providerId'=>$_POST['provider_id']);

            $invoice= new CActiveDataProvider('DirectInvoice', array(
                'keyAttribute'=>'id',
                'criteria'=>$criteria,
                'pagination'=>array(
                    'pageSize'=>Yii::app()->params['pagination']
                ),
            ));*/

            $data=DirectInvoice::model()->findByPk((int)$_POST['provider_id']);

            $data=new CArrayDataProvider($data);

            echo CJSON::encode($data);

            Yii::app()->end();


        }

    }

    public function actionDeposit($accountId,$accountType){

        switch($accountType){
            case 1:

                $model=new Operations;

                if(isset($_POST['Operations'])){

                    $model->attributes=$_POST['Operations'];

                    $account=BankAccounts::model()->findByPk($accountId);

                    $balance=$account->initial_balance+$model->deposit;
                    $account->initial_balance=$balance;

                    $model->account_id=$accountId;
                    $model->balance=$balance;
                    $model->cheq='DEP';
                    $model->released=BankAccounts::model()->accountByPk($accountId);

                    $model->bank_concept=$model->bank_concept." #".$model->n_operation;

                    if($model->concept=="")         $model->concept=Yii::t('mx','PENDING FOR BILLING');
                    if($model->person=="")          $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="")    $model->bank_concept=Yii::t('mx','PENDING');


                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 2:

                $model=new IntercuentaOperations();

                if(isset($_POST['IntercuentaOperations'])){

                    $model->attributes=$_POST['IntercuentaOperations'];

                    $account=BankAccounts::model()->findByPk($accountId);
                    $balance=$account->initial_balance+$model->deposit;
                    $account->initial_balance=$balance;

                    $model->account_id=$accountId;
                    $model->balance=$balance;
                    $model->cheq='DEP';
                    $model->released=BankAccounts::model()->accountByPk($accountId);

                    if($model->concept=="")         $model->concept=Yii::t('mx','PENDING FOR BILLING');
                    if($model->person=="")          $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="")    $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 3:

                $model=new DebitOperations();

                if(isset($_POST['DebitOperations'])){

                    $model->attributes=$_POST['DebitOperations'];

                    $account=BankAccounts::model()->findByPk($accountId);


                    $vatCommission=$_POST['DebitOperations']['vat_commission'];
                    $commissionFee=$_POST['DebitOperations']['commission_fee'];
                    $comision=$vatCommission+$commissionFee;

                    $balance=$account->initial_balance+$model->deposit-$comision;
                    $account->initial_balance=$balance;

                    $model->account_id=$accountId;
                    $model->balance=$balance;
                    $model->cheq='DEP';
                    $model->released=BankAccounts::model()->accountByPk($accountId);

                    $model->vat_commission=$vatCommission;
                    $model->commission_fee=$commissionFee;

                    if($model->concept=="")         $model->concept=Yii::t('mx','PENDING FOR BILLING');
                    if($model->person=="")          $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="")    $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 4:

                $model=new CreditOperations();

                if(isset($_POST['CreditOperations'])){

                    $model->attributes=$_POST['CreditOperations'];

                    $account=BankAccounts::model()->findByPk($accountId);

                    $vatCommission=$_POST['DebitOperations']['vat_commission'];
                    $commissionFee=$_POST['DebitOperations']['commission_fee'];
                    $comision=$vatCommission+$commissionFee;

                    $balance=$account->initial_balance+$model->deposit-$comision;
                    $account->initial_balance=$balance;

                    $model->account_id=$accountId;
                    $model->balance=$balance;
                    $model->cheq='DEP';
                    $model->released=BankAccounts::model()->accountByPk($accountId);

                    $model->vat_commission=$vatCommission;
                    $model->commission_fee=$commissionFee;

                    if($model->concept=="")         $model->concept=Yii::t('mx','PENDING FOR BILLING');
                    if($model->person=="")          $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="")    $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

            case 5:

                $model=new InvestmentOperations();

                if(isset($_POST['InvestmentOperations'])){

                    $model->attributes=$_POST['InvestmentOperations'];

                    $account=BankAccounts::model()->findByPk($accountId);
                    $balance=$account->initial_balance+$model->deposit;
                    $account->initial_balance=$balance;

                    $model->account_id=$accountId;
                    $model->balance=$balance;
                    $model->cheq='DEP';
                    $model->released=BankAccounts::model()->accountByPk($accountId);

                    if($model->concept=="")         $model->concept=Yii::t('mx','PENDING FOR BILLING');
                    if($model->person=="")          $model->person=Yii::t('mx','PENDING');
                    if($model->bank_concept=="")    $model->bank_concept=Yii::t('mx','PENDING');

                    if($model->save()){
                        $account->save();
                        Yii::app()->user->setFlash('success','Success');
                        $this->redirect(array('index'));
                    }
                }

            break;

        }

        $accountTypes=AccountTypes::model()->findByPk($accountType);
        $bankAccount=BankAccounts::model()->accountByPk($accountId);

        $display=$accountTypes->tipe.'-'.$bankAccount;


        $this->render('deposit',array(
            'model'=>$model,
            'display'=>$display
        ));
    }

	public function actionView($id)
	{
        $model=$this->loadModel($id);

        $this->renderPartial('view',array(
            'model'=>$model,
        ));

	}

	public function actionCreate()
	{
		$model=new Operations;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Operations']))
		{
			$model->attributes=$_POST['Operations'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Operations']))
		{
			$model->attributes=$_POST['Operations'];

            if(!empty($_POST['name'])) $model->person=$_POST['name'];

            if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{

            $operation=$this->loadModel($id);

            switch($operation->payment_type){
                case 2:
                    $account=BankAccounts::model()->findByPk($operation->account_id);
                    $saldoCuenta=$account->initial_balance-$operation->retirement;
                    $account->initial_balance=$saldoCuenta;
                    $account->save();
                break;

                case 6:
                    $account=BankAccounts::model()->findByPk($operation->account_id);
                    $saldoCuenta=$account->initial_balance+$operation->retirement;
                    $account->initial_balance=$saldoCuenta;
                    $account->save();
                break;


            }


			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{

        $botones=Yii::app()->quoteUtil->menuAccounts();

        $this->render('index',array(
            'botones'=>$botones,
        ));

	}

    public function actionExportBalanceToPdf()
    {

        $data=Yii::app()->getSession()->get('BalanceToPdf');
        $data->pagination= false;

        $this->render('_ajaxContent',array(
            'table'=>Yii::app()->quoteUtil->ExportBalance($data->getData()),
        ));

        Yii::app()->getSession()->remove('BalanceToPdf');

    }

    public function actionExportPdfToAccountant(){

        $data=Yii::app()->getSession()->get('BalanceToPdf');
        $data->pagination= false;

        $this->render('_ajaxContent',array(
            'table'=>Yii::app()->quoteUtil->ExportPdfToAccountant($data->getData()),
        ));

        Yii::app()->getSession()->remove('BalanceToPdf');

    }

	public function loadModel($id)
	{
		$model=Operations::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='operations-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
