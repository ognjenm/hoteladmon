<?php

class PurchaseOrderController extends Controller
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

        $purchaseOrder=PurchaseOrder::model()->with(array(
            'purchaseOrderProvider'=>array(
                'together'=>true,
                'joinType'=>'INNER JOIN',
            ),
        ))->findByPk($id);

        $date=date('Y-M-d');
        $date=Yii::app()->quoteUtil->toSpanishDateDescription($date);

        $table=Yii::app()->quoteUtil->reportHeader($date).'
            <p style="text-align:right">
                <span style="font-size:14px">
                    <strong><span style="font-family:arial,helvetica,sans-serif">Orden de compra</span></strong>
                </span>
            </p>
            <table class="items table table-condensed">
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

        foreach($purchaseOrder->purchaseOrderProvider as $item){

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

            $articles=PurchaseOrderItems::model()->findAll(array(
                'condition'=>'purchase_order_provider_id=:providerId',
                'params'=>array('providerId'=>$item->id)
            ));

            $numArticles=PurchaseOrderItems::model()->count(array(
                'condition'=>'purchase_order_provider_id=:providerId',
                'params'=>array('providerId'=>$item->id)
            ));

            $articlescont=0;

            if($articles){
                foreach($articles as $articleItem){
                    $table.='
                        <tr>
                            <td>'.$articleItem->quantity.'</td>
                            <td>'.$articleItem->article->unitmeasure->unit.'</td>
                            <td>'.$articleItem->article->name_store.'</td>
                            <td>'.$articleItem->article->name_invoice.'</td>
                            <td>'.$articleItem->article->name_article.'</td>
                            <td>'.$articleItem->article->code_store.'</td>
                            <td>'.$articleItem->article->code_invoice.'</td>
                            <td>'.$articleItem->article->color.'</td>
                            <td>'.$articleItem->article->presentation.'</td>
                            <td>$'.number_format($articleItem->price,2).'</td>
                            <td>$'.number_format($articleItem->amount,2).'</td>
                        </tr>';
                    $articlescont++;
                }
            }

            if($numArticles == $articlescont){
                    if($item->note !=""){
                        $table.='
                         <tr>
                            <td><h3  style="text-align: right;">Nota:</h3></td>
                            <td colspan="10" rowspan="1">'.$item->note.'</td>
                        </tr>';
                    }
            }

            $counter++;
            $total+=$item->total;

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

    public function actionCreate(){
        Yii::import('bootstrap.widgets.TbForm');
        $model=new PurchaseOrder;
        $items=new PurchaseOrderItems;
        $res=array('ok'=>false);
        $totalAmount=0;

        $form = TbForm::createForm($model->getFormFilter(),$model,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );

        $formArticle = TbForm::createForm($model->getFormFilterArticle(),$model,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['purchaseOrder'])){


                $purchaseOrder=new PurchaseOrder;
                $purchaseOrder->user_id=Yii::app()->user->id;
                $purchaseOrder->datex=date('Y-m-d');
                $purchaseOrder->save();

                foreach($_POST['purchaseOrder'] as $order){

                    $purchaseOrderProvider=new PurchaseOrderProvider;
                    $purchaseOrderProvider->purchase_order_id=$purchaseOrder->id;
                    $purchaseOrderProvider->provider_id=(int)$order['provider'];


                    if($purchaseOrderProvider->save() && isset($order['items'])){
                        foreach($order['items'] as $articles){

                            $orderItems=new PurchaseOrderItems;
                            $orderItems->purchase_order_provider_id=$purchaseOrderProvider->id;
                            $orderItems->article_id=(int)$articles['ITEM_ARTICLE_ID'];
                            $orderItems->quantity=$articles['ITEM_QUANTITY'];
                            $orderItems->price=$articles['ITEM_PRICE'];

                            $amount=$orderItems->quantity*$orderItems->price;
                            $totalAmount+=$amount;
                            $orderItems->amount=$amount;
                            $orderItems->save();
                        }

                        $purchaseOrderProvider->total=$totalAmount;
                        $purchaseOrderProvider->save();
                        $totalAmount=0;

                    }

                    if(isset($order['notas'])){
                        foreach($order['notas'] as $nota){

                            $purchaseOrderProvider=new PurchaseOrderProvider;
                            $purchaseOrderProvider->purchase_order_id=$purchaseOrder->id;
                            $purchaseOrderProvider->provider_id=(int)$order['provider'];
                            $purchaseOrderProvider->note=$nota["nota"];
                            $purchaseOrderProvider->total=0;
                            $purchaseOrderProvider->save();
                        }
                    }

                    $res=array('ok'=>true,'url'=>$this->createUrl('/purchaseOrder/view',array('id'=>$purchaseOrder->id)));
                }


            }

            echo CJSON::encode($res);
            Yii::app()->end();
        }


        $this->render('create',array(
            'model'=>$model,
            'items'=>$items,
            'form'=>$form,
            'formArticle'=>$formArticle
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
