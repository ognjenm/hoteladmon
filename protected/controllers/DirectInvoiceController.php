<?php

class DirectInvoiceController extends Controller
{

	public $layout='//layouts/column2';

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
				'actions'=>array('create','update','index','view','delete','getArticle','sumaInvoices','poliza','history'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


    public function actionPoliza(){

        $res=array('ok'=>false,'url'=>null,'errors'=>null);

        if(Yii::app()->request->isPostRequest){

            $totalPoliza=0;
            $operationId=0;
            $quantity1=($_POST['DirectInvoiceItems']['quantity'] =='') ? 0 : (int)$_POST['DirectInvoiceItems']['quantity'];
            $quantity2=($_POST['DirectInvoiceItems']['quantity2']=='') ? 0 : (int)$_POST['DirectInvoiceItems']['quantity2'];
            $price1=($_POST['DirectInvoiceItems']['price']=='') ? 0 : $_POST['DirectInvoiceItems']['price'];
            $price2=($_POST['DirectInvoiceItems']['price2']=='') ? 0 : $_POST['DirectInvoiceItems']['price2'];

            $article1=$_POST['DirectInvoiceItems']['article1'];
            $article2=$_POST['DirectInvoiceItems']['article2'];

            $amount1=$quantity1*$price1;
            $amount2=$quantity2*$price2;
            $subtotal1=$amount1;
            $subtotal2=$amount2;
            $total1=$amount1;
            $total2=$amount2;
            $provider=(int)$_POST['DirectInvoiceItems']['provider1'];
            $grandTotal=$total1+$total2;
            $totalPoliza=$grandTotal;

            $user=Yii::app()->user->id;

            $invoicesId='';


            if($_POST['DirectInvoiceItems']['quantity']!='' || $_POST['DirectInvoiceItems']['quantity2']!=''){
                $directInvoice=new DirectInvoice;
                $directInvoice->n_invoice='S/N';
                $directInvoice->datex=date('d-M-Y');
                $directInvoice->provider_id=$provider;
                $directInvoice->user_id=$user;
                $directInvoice->amount=$grandTotal;
                $directInvoice->subtotal=$grandTotal;
                $directInvoice->total=$grandTotal;
                $directInvoice->document_type_id=1;
                $directInvoice->isactive=0;
                $directInvoice->save();

                $invoicesId=$directInvoice->id.',';

            }

            if($_POST['DirectInvoiceItems']['quantity']!=''){
                $directInvoiceItems=new DirectInvoiceItems;
                $directInvoiceItems->direct_invoice_id=$directInvoice->id;
                $directInvoiceItems->article_id=$article1;
                $directInvoiceItems->quantity=$quantity1;
                $directInvoiceItems->price=$price1;
                $directInvoiceItems->amount=$amount1;
                $directInvoiceItems->subtotal=$subtotal1;
                $directInvoiceItems->total=$total1;
                $directInvoiceItems->save();
            }

            if($_POST['DirectInvoiceItems']['quantity2']!=''){
                $directInvoiceItems2=new DirectInvoiceItems;
                $directInvoiceItems2->direct_invoice_id=$directInvoice->id;
                $directInvoiceItems2->article_id=$article2;
                $directInvoiceItems2->quantity=$quantity2;
                $directInvoiceItems2->price=$price2;
                $directInvoiceItems2->amount=$amount2;
                $directInvoiceItems2->subtotal=$subtotal2;
                $directInvoiceItems2->total=$total2;
                $directInvoiceItems2->save();
            }

            $invoices=explode(',',$_POST['invoice']);
            $invoicesId.=$_POST['invoice'];

            foreach($invoices as $id){
                $invoice=DirectInvoice::model()->findByPk($id);
                $invoice->isactive=0;
                $totalPoliza=$totalPoliza+$invoice->total;
                $invoice->save();

            }

            $accounId=(int)$_POST['Operations']['account_id'];
            $providerId=(int)$_POST['Operations']['released'];
            $authorized=(int)$_POST['Operations']['authorized'];
            $conceptId=(int)$_POST['Operations']['concept'];
            $paymentMethod=(int)$_POST['Operations']['typeCheq'];
            $forBeneficiaryAccount=$_POST['Operations']['abonoencuenta'];


            $account=BankAccounts::model()->findByPk($accounId);
            $balance=$account->initial_balance-$totalPoliza;
            $account->initial_balance=$balance;
            $account->consecutive=$account->consecutive+1;

            $released=Providers::model()->findByPk($providerId);
            $released=$released->company;
            $concept=ConceptPayments::model()->findByPk($conceptId);
            $concept=$concept->concept;


            switch($paymentMethod){
                case 1 : //CHEQUE DE CAJA
                    $operationId=Yii::app()->quoteUtil->registerAccountCheques(6,$accounId,$account->consecutive,date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;

                case 2: //CHEQUE NOMINATIVO
                    $operationId=Yii::app()->quoteUtil->registerAccountCheques(6,$accounId,$account->consecutive,date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;

                case 3: // TRANSFERENCIA ELECTRONICA A TERCEROS
                    $operationId=Yii::app()->quoteUtil->registerAccountCheques(5,$accounId,'TRA',date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;

                case 4: // TARJETA DEBITO
                    $operationId=Yii::app()->quoteUtil->registerAccountDebit(3,$accounId,'RET',date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;
                case 6: // TARJETA CREDITO
                    $operationId=Yii::app()->quoteUtil->registerAccountCredit(4,$accounId,'RET',date('d-M-Y'),$released,$concept,'-','',$totalPoliza,0,$balance);
                    break;
            }


            if(!is_array($operationId)){
                $poliza=new Polizas;
                $poliza->operation_id=$operationId;
                $poliza->invoice_ids=$invoicesId;
                $poliza->user_id=$user;
                $poliza->authorized_by=$authorized;
                $poliza->payment_type=$paymentMethod;
                $poliza->for_beneficiary_account=$forBeneficiaryAccount;

                if($poliza->save()){
                    $account->save();
                    $res=array('ok'=>true,'url'=>$this->createUrl('polizas/view',array('id'=>$poliza->id)));
                }else{

                    $res=array('ok'=>false,'url'=>null,'errors'=>$poliza->getErrors());
                }
            }

        }

        echo CJSON::encode($res);
        Yii::app()->end();



    }

	public function actionSumaInvoices(){

        $res=array('ok'=>false,'suma'=>0);
        $ids=array();
        $suma=0;
        $display='';
        $total=0;

        if(Yii::app()->request->isPostRequest){


            if(isset($_POST['ids'])){

                $values=$_POST['ids'];
                $adulto=(int)$_POST['adulto'];
                $estudiante=$_POST['estudiante'];
                $ids=explode(',',$values);

                foreach($ids as $id){
                    $invoice=DirectInvoice::model()->findByPk($id);
                    $suma=$suma+$invoice->total;
                }
            }

            $suma=$suma+$adulto+$estudiante;

            $display='<h2><strong>$'.number_format($suma,2).'</h2></strong>';

            $res=array('ok'=>true,'suma'=>$display);

            echo CJSON::encode($res);
            Yii::app()->end();
        }

    }

    public function actionGetArticle() {

        $res =array();
        if (isset($_GET['term'])) {
            $qtxt ="SELECT name_article FROM articles WHERE name_article LIKE :word1";
            $command =Yii::app()->db->createCommand($qtxt);
            $command->bindValue(":word1", "%".$_GET['term']."%", PDO::PARAM_STR);
            $res =$command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }


    public function actionView($id)
	{
        $invoice=$this->loadModel($id);
        $expide=Providers::model()->findByPk($invoice->provider_id);
        $indice=1;

        $billTo=Settings::model()->findByPk($indice);

        $itemsIvoice=DirectInvoiceItems::model()->findAll(array(
            'condition'=>'direct_invoice_id=:directInvoiceId',
            'params'=>array('directInvoiceId'=>$invoice->id)
        ));

		$this->render('view',array(
			'invoice'=>$invoice,
            'expide'=>$expide,
            'billTo'=>$billTo,
            'itemsIvoice'=>$itemsIvoice
		));
	}


	public function actionCreate($PolizaId=null)
	{
        Yii::import('ext.jqrelcopy.JQRelcopy');
		$model=new DirectInvoice;
        $items=new DirectInvoiceItems;
        $amount=0;
        $totalFacturas=0;


		if(isset($_POST['DirectInvoice']))
		{
			$model->attributes=$_POST['DirectInvoice'];

            $model->user_id=Yii::app()->user->id;
            $model->isactive=1;
            $model->discount=$_POST['DirectInvoice']['discount_sum'];
            $model->ieps=$_POST['DirectInvoice']['ieps_sum'];
            $model->retiva=$_POST['DirectInvoice']['retiva_sum'];
            $model->retisr=$_POST['DirectInvoice']['retisr_sum'];
            $model->vat=$_POST['DirectInvoice']['vat_sum'];
            $model->other=$_POST['DirectInvoice']['other_sum'];
            $model->total=$_POST['DirectInvoice']['grandTotal'];
            $model->amount=$_POST['DirectInvoice']['totalAmount'];
            $model->subtotal=$model->amount-$model->discount;

			if($model->save()){

                $tope=count($_POST['DirectInvoiceItems']['quantity']);

                for($i=0;$i<$tope;$i++){

                    $data=array();

                    foreach($_POST['DirectInvoiceItems'] as $id=>$values){
                        $anexo=array($id=>$values[$i]);
                        $data=array_merge($data,$anexo);
                    }

                    $item=new DirectInvoiceItems;
                    $item->attributes=$data;
                    $item->direct_invoice_id=$model->id;
                    $item->save();

                }

                if($PolizaId!=null){

                    $poliza=Polizas::model()->findByPk($PolizaId);

                    if($poliza->invoice_ids !="0"){
                        $invoices=$poliza->invoice_ids;
                        $invoices.=",".$model->id;
                        $poliza->invoice_ids=$invoices;

                    }else{
                            $poliza->invoice_ids=$model->id;
                    }

                    $poliza->save();

                }



                Yii::app()->user->setFlash('success','Success');
                //$this->redirect(array('view','id'=>$model->id));
            }

		}

        if($PolizaId!=null){
            $amount=Polizas::model()->findByPk($PolizaId);
            $totalFacturas=DirectInvoice::model()->getTotalInvoice($amount->invoice_ids);
            $amount=$amount->operations->retirement;

        }

		$this->render('create',array(
			'model'=>$model,
            'items'=>$items,
            'amount'=>$amount,
            'totalFacturas'=>$totalFacturas,
		));
	}

    public function getItemsToUpdate($id) {

        $list=DirectInvoiceItems::model()->with(array(
            'article'=>array(
                'select'=>'presentation',
                'together'=>false,
                'joinType'=>'INNER JOIN',

            ),
        ))->findAll(
            array(
                'condition'=>'direct_invoice_id=:directInvoiceId',
                'params'=>array('directInvoiceId'=>$id)
            )
        );


        $items=array();

        if (isset($list)) {

            foreach ($list as $item) {
                $items[] = $item;
            }
        }
        return $items;
    }


	public function actionUpdate($id)
	{
        Yii::import('ext.jqrelcopy.JQRelcopy');

		$model=$this->loadModel($id);
        $items= $this->getItemsToUpdate($model->id);

		if(isset($_POST['DirectInvoice']) && isset($_POST['DirectInvoiceItems']))
		{
			$model->attributes=$_POST['DirectInvoice'];

			if($model->save()){

                foreach($_POST['DirectInvoiceItems'] as $item){
                    $itemInvoice=DirectInvoiceItems::model()->findByPk($item['id']);
                    $itemInvoice->attributes=$item;
                    $itemInvoice->save();
                }

                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('update',array(
			'model'=>$model,
            'items'=>$items
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

        Yii::import('bootstrap.widgets.TbForm');
        $transporte=new DirectInvoiceItems;
        $search=new DirectInvoice;
        $conceptPayments=new ConceptPayments;

        $operations= new Operations;

        $Filter = TbForm::createForm($search->getFormFilter(),$search,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );


        $fTransporte = TbForm::createForm($transporte->getForm(),$transporte,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );

        $FconceptPayments= TbForm::createForm($conceptPayments->getForm(),$conceptPayments,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'horizontal',
            )
        );

        $fOperations= TbForm::createForm($operations->getForm(),$operations,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'horizontal',
            )
        );

        $FNoBill= TbForm::createForm($operations->getFormNoBill(),$operations,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'horizontal',
            )
        );



        $model=new DirectInvoice('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DirectInvoice']))
        $model->attributes=$_GET['DirectInvoice'];


        if(Yii::app()->request->isPostRequest){

            if(isset($_POST['DirectInvoice']['search'])){
                $model->attributes=$_POST['DirectInvoice']['search'];
            }
        }

        $this->render('index',array(
            'model'=>$model,
            'fTransporte'=>$fTransporte,
            'fOperations'=>$fOperations,
            'filter'=>$Filter,
            'FconceptPayments'=>$FconceptPayments,
            'FNoBill'=>$FNoBill
        ));

	}

    public function actionHistory()
    {

        $model=new DirectInvoice('history');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['DirectInvoice']))
            $model->attributes=$_GET['DirectInvoice'];


        if(Yii::app()->request->isPostRequest){

            if(isset($_POST['DirectInvoice']['search'])){
                $model->attributes=$_POST['DirectInvoice']['search'];
            }

        }

        $this->render('history',array(
            'model'=>$model,

        ));

    }

	public function loadModel($id)
	{
		$model=DirectInvoice::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='direct-invoice-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
