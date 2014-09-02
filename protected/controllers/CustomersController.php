<?php

class CustomersController extends Controller
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

			array('allow', // allow authenticated user to perform actions
				'actions'=>array('create','update','index','view','admin','delete','getEmail','customersHistory'),
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

    public function actionCustomersHistory(){

        $model=new AuditTrail('customers');
        $model->unsetAttributes();	// clear any default values
        if(isset($_GET['AuditTrail'])) {
            $model->attributes=$_GET['AuditTrail'];
        }
        $this->render('customers',array(
            'model'=>$model,
        ));

    }
    public function actionGetEmail(){

        if(Yii::app()->request->isAjaxRequest){

            $email=$_POST['email'];

            $criteria=array(
                'condition'=>'email=:email',
                'params'=>array(':email'=>$email)
            );

            $customer=Customers::model()->find($criteria);
        }

        echo CJSON::encode($customer);
        Yii::app()->end();

    }

	public function actionView($id)
	{

        $taxInformation=new CActiveDataProvider('TaxInformation',array (
                'criteria' => array (
                    'condition' => 'customer_id=:customerId', 'order'=>'bill',
                    'params'=>array('customerId'=>$id)
                ))
        );


        $budget= Reservation::model()->with(array(
            'customerReservation'=>array(
                'together'=>false,
                'joinType'=>'INNER JOIN',
            ),
        ))->count(array(
                'condition'=>'customer_id=:customerId and statux=2',
                'params'=>array('customerId'=>$id)
        ));

        $reservation= Reservation::model()->with(array(
            'customerReservation'=>array(
                'together'=>false,
                'joinType'=>'INNER JOIN',
            ),
        ))->count(array(
                'condition'=>'customer_id=:customerId and statux=5',
                'params'=>array('customerId'=>$id)
        ));

        $canceled= Reservation::model()->with(array(
            'customerReservation'=>array(
                'together'=>false,
                'joinType'=>'INNER JOIN',
            ),
        ))->count(array(
                'condition'=>'customer_id=:customerId and statux=6',
                'params'=>array('customerId'=>$id)
        ));

        $table='<table class="items table table-hover table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th>'.Yii::t('mx','Budget').'</th>
                            <th>'.Yii::t('mx','Reserved').'</th>
                            <th>'.Yii::t('mx','Canceled').'</th>
                        </tr>
                    <thead>
                    <tbody>
                        <tr>
                            <td>'.$budget.'</td>
                            <td>'.$reservation.'</td>
                            <td>'.$canceled.'</td>
                        </tr>
                    </tbody>
                </table>';


		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'taxInformation'=>$taxInformation,
            'table'=>$table
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Customers;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Customers']))
		{
			$model->attributes=$_POST['Customers'];
			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
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
        $res=array('ok'=>false);
        $model=$this->loadModel($id);

        if(Yii::app()->request->isAjaxRequest){

            if(isset($_POST['Customers'])){
                $model->attributes=$_POST['Customers'];
                if($model->save()) $res=array('ok'=>true);
                else $res=array('ok'=>false,'error'=>$model->getErrors());

                echo CJSON::encode($res);
                Yii::app()->end();
            }

        }else{

            if(isset($_POST['Customers'])){
                $model->attributes=$_POST['Customers'];
                if($model->save()) Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }


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
        $model=new Customers('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Customers']))
        $model->attributes=$_GET['Customers'];

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
		$model=Customers::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='customers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
