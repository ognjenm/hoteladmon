<?php

class TaxInformationController extends Controller
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
			'accessControl', // perform access control for CRUD operations
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
				'actions'=>array('create','update','getBillTo','index','view','delete'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionGetBillTo(){

        if(Yii::app()->request->isPostRequest){

            $lista=array();

            $customerId=$_POST['customerId'];

            $criteria=array(
                'condition'=>'customer_id=:customerId',
                'params'=>array('customerId'=>$customerId)
            );

            $data=TaxInformation::model()->findAll($criteria);

            $lista = CHtml::listData($data,'id','company_name');

            //foreach($data as $item) $lista[$item->id]=$item->first_name.' '.$item->last_name;

            echo "<option value=''>".Yii::t('mx','Select')."</option>";

            foreach($lista as $value=>$resident)
                echo CHtml::tag('option', array('value'=>$value),CHtml::encode($resident),true);
        }

    }

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->renderPartial('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model=new TaxInformation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TaxInformation']))
		{
			$model->attributes=$_POST['TaxInformation'];
            $model->customer_id=$id;

			if($model->save()){

                $customer=Customers::model()->findByPk($model->customer_id);
                $customer->is_billed=1;
                $customer->save();

                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('/customers'));
            }

		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['TaxInformation']))
		{
			$model->attributes=$_POST['TaxInformation'];
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('/customers'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new TaxInformation('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['TaxInformation']))
        $model->attributes=$_GET['TaxInformation'];

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
		$model=TaxInformation::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='tax-information-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
