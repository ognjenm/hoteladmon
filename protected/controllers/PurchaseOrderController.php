<?php

class PurchaseOrderController extends Controller
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
				'actions'=>array('create','update','index','view','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionView($id){

        $counter=0;
        $grupo=null;
        $total=0;
        $table=Yii::app()->quoteUtil->reportHeader().'
            <p style="text-align:right">
                <span style="font-size:14px">
                    <strong><span style="font-family:arial,helvetica,sans-serif">Orden de compra</span></strong>
                </span>
            </p>
            <table class="items table table-condensed table-striped">
                <thead>
                    <tr>
                        <th>'.Yii::t('mx','Quantity').'</th>
                        <th>'.Yii::t('mx','Unit Of Measure').'</th>
                        <th>'.Yii::t('mx','Name Store').'</th>
                        <th>'.Yii::t('mx','Name Invoice').'</th>
                        <th>'.Yii::t('mx','Name Article').'</th>
                        <th>'.Yii::t('mx','Code Store').'</th>
                        <th>'.Yii::t('mx','Code Invoice').'</th>
                        <th>'.Yii::t('mx','Color').'</th>
                        <th>'.Yii::t('mx','Presentation').'</th>
                        <th>'.Yii::t('mx','Price').'</th>
                        <th>'.Yii::t('mx','Total').'</th>
                    </tr>
                <thead>
            <tbody>
        ';

        $purchaseOrder=PurchaseOrder::model()->with(array(
            'purchaseOrderItems'=>array(
                'together'=>true,
                'joinType'=>'INNER JOIN',
            ),
        ))->findByPk($id);

        foreach($purchaseOrder->purchaseOrderItems as $item){

                $grupoant=$grupo;
                $grupo=$item->provider_id;
                $addressProvider=Providers::model()->fullAddress($item->provider_id);

                if($grupoant != $grupo){
                    if($grupo!=0){
                        $table.='
                        <tr>
                            <td colspan="11" align="center" bgcolor="#CCCCCC">
                            <br>
                                <strong>'.Providers::model()->CompanyByPk($item->provider_id).': </strong>.'.$addressProvider.'
                                <br>
                                <br>
                            </td>
                        </tr>';
                    }
                }


            if($item->article_id!=0 || $item->provider_id==0){

                if($item->provider_id!=0){

                    $table.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                    $table.='
                            <td>'.$item->quantity.'</td>
                            <td>'.$item->article->unitmeasure->unit.'</td>
                            <td>'.$item->article->name_store.'</td>
                            <td>'.$item->article->name_invoice.'</td>
                            <td>'.$item->article->name_article.'</td>
                            <td>'.$item->article->code_store.'</td>
                            <td>'.$item->article->code_invoice.'</td>
                            <td>'.$item->article->color.'</td>
                            <td>'.$item->article->presentation.'</td>
                            <td>'.$item->price.'</td>
                            <td>'.number_format($item->amount,2).'</td>
                        </tr>';
                }else{

                    $table.='
                            <tr>
                                <td colspan="11" align="center">
                                    '.$item->note.'
                                </td>
                            </tr>';
                }
            }

            $counter++;
            $total+=$item->amount;

        }

        $table.='</tbody>
                <tfoot>
                    <tr>
                        <td colspan="10" rowspan="1"><h3 style="text-align: right;">'.Yii::t('mx','Total').':</h3></td>
                        <td><h3  style="text-align: right;">'.'$'.number_format($total,2).' MX</h3></td>
                    </tr>
                </tfoot>
        </table>';

		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'table'=>$table,
		));

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::import('ext.jqrelcopy.JQRelcopy');
		$model=new PurchaseOrder;
        $items=new PurchaseOrderItems;
        $total=0;

		if(isset($_POST['PurchaseOrder']))
		{

			$model->attributes=$_POST['PurchaseOrder'];
            $model->user_id=Yii::app()->user->id;
            $model->datex=date('Y-m-d');

            $tope=count($_POST['PurchaseOrderItems']['provider_id']);

            for($i=0;$i<$tope;$i++){
                $data=array();

                foreach ($_POST['PurchaseOrderItems'] as $id=>$values){

                    if(!is_array($values)){
                        $anexo=array($id=>$values);
                        $data=array_merge($data,$anexo);
                    }else{
                        $anexo=array($id=>$values[$i]);
                        $data=array_merge($data,$anexo);
                    }
                }

               if($model->save()){
                    $lista=New PurchaseOrderItems;
                    $lista->attributes=$data;
                    $lista->purchase_order_id=$model->id;
                    $lista->amount=(int)$lista->quantity*$lista->price;
                    $total=$total+$lista->amount;
                    $lista->save();
                }

                $model->total=$total;
                $model->save();

            }

           Yii::app()->user->setFlash('success','Success');
           $this->redirect(array('view','id'=>$model->id));


		}

		$this->render('create',array(
			'model'=>$model,
            'items'=>$items
		));
	}


	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['PurchaseOrder']))
		{
			$model->attributes=$_POST['PurchaseOrder'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


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
        $model=new PurchaseOrder('search');
        $model->unsetAttributes();

        if(isset($_GET['PurchaseOrder'])){
            $model->attributes=$_GET['PurchaseOrder'];
        }

        $this->render('index',array(
            'model'=>$model,
        ));

	}

	public function loadModel($id)
	{
		$model=PurchaseOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchase-order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
