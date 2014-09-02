<?php

class InvoicesController extends Controller
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
            array('CrugeAccessControlFilter'),  // perform access control for CRUD operations
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
				'actions'=>array('create','update','index','view','delete'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $invoice=$this->loadModel($id);
        $expide=Settings::model()->find();
        $billTo=TaxInformation::model()->findByPk($invoice->bill_id);

        $criteria=array(
            'condition'=>'invoice_id=:invoiceId',
            'params'=>array(
                'invoiceId'=>$invoice->id
            )
        );

        $itemsIvoice=ItemsInvoice::model()->findAll($criteria);

		$this->render('view',array(
			'invoice'=>$invoice,
            'expide'=>$expide,
            'billTo'=>$billTo,
            'itemsIvoice'=>$itemsIvoice
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        $c=0;
        Yii::import('ext.multimodelform.MultiModelForm');

        $model=new Invoices;
        $items=new ItemsInvoice;
        $validatedMembers = array();
        $aux=array();
        $models=array();
        $import=0;
        $totalImport=0;

        $operations=new CActiveDataProvider('Operations',array (
                'criteria' => array (
                    'condition' => 'concept=:concept', 'order'=>'datex DESC',
                    'params'=>array('concept'=>'PENDIENTE POR FACTURAR')
                ))
        );


		if(isset($_POST['Invoices']))
		{
			$model->attributes=$_POST['Invoices'];

            $tope=count($_POST['ItemsInvoice']['operation_id']);

            for($i=0;$i<$tope;$i++){

                foreach($_POST['ItemsInvoice'] as $idx => $value){ $aux=array_merge($aux,array($idx=>$value[$i])); }

                $import=(int)$aux['quantity']*$aux['unit_price'];
                $totalImport+=$import;
                $aux=array_merge($aux,array('import'=>$import));
                $models[]=$aux;
                $aux=array();

            }

            $model->subtotal=$totalImport;
            $model->tax=($model->subtotal*16)/100;
            $model->total=$model->subtotal+$model->tax;

			if($model->save()){

                foreach($models as $itemsInvoice){
                    $items=new ItemsInvoice;
                    $items->attributes=$itemsInvoice;
                    $items->invoice_id=$model->id;
                    $items->save();
                }

                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));

            }

		}

		$this->render('create',array(
			'model'=>$model,
            'items'=>$items,
            'validatedMembers' => $validatedMembers,
            'operations'=>$operations
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Invoices']))
		{
			$model->attributes=$_POST['Invoices'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
        $model=new Invoices('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Invoices']))
        $model->attributes=$_GET['Invoices'];

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
		$model=Invoices::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='invoices-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
