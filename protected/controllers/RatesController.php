<?php

class RatesController extends Controller
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
				'actions'=>array('create','update','clone','index','view','admin','delete'),
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

        $prices=Prices::model()->findAll(array(
           'condition'=>'rate_id=:rateId',
            'params'=>array('rateId'=>$id)
        ));

        $prices2=new CArrayDataProvider($prices);

		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'prices'=>$prices2
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::import('ext.multimodelform.MultiModelForm');

        $model=new Rates;
        $prices = new Prices;
        $validatedMembers = array();

		if(isset($_POST['Rates']))
		{
			$model->attributes=$_POST['Rates'];

			if($model->save()){

                $masterValues = array ('rate_id'=>$model->id);

                if (MultiModelForm::save($prices,$validatedMembers,$deleteMembers,$masterValues)){

                    Yii::app()->user->setFlash('success','Success');
                    $this->redirect(array('view','id'=>$model->id));

                }

            }

		}

		$this->render('create',array(
			'model'=>$model,
            'prices'=>$prices,
            'validatedMembers' => $validatedMembers,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id){
        Yii::import('ext.multimodelform.MultiModelForm');

        $model=$this->loadModel($id);
        $prices = new Prices;
        $validatedMembers = array();

		if(isset($_POST['Rates']))
		{
            $masterValues = array ('rate_id'=>$model->id);

            $model->attributes=$_POST['Rates'];

			if(MultiModelForm::save($prices,$validatedMembers,$deleteMembers,$masterValues) && $model->save()){

                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));

            }

		}

		$this->render('update',array(
			'model'=>$model,
            'prices'=>$prices,
            'validatedMembers' => $validatedMembers,
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
        $model=new Rates('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Rates']))
        $model->attributes=$_GET['Rates'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}

    public function actionClone($ids){

        if(isset($_POST['Rooms']['destination'])){

            $sourceids = explode(',',$ids);

            foreach($_POST['Rooms']['destination'] as $room_id):

                $countDestination=Rates::model()->count('room_id=:roomid',array(':roomid'=>$room_id));

                if($countDestination==0){

                    foreach($sourceids as $id):

                        $source=Rates::model()->findByPk($id);

                        $destination=new Rates;
                        $destination->room_id=$room_id;
                        $destination->season=$source->season;
                        $destination->type_reservation_id=$source->type_reservation_id;
                        $destination->price=$source->price;
                        $destination->pax=$source->pax;

                        $destination->save();

                    endforeach;

                }
                else{

                    Rates::model()->deleteAll('room_id=:roomid',array(':roomid'=>$room_id));

                    foreach($sourceids as $id):

                        $source=DomainsBanners::model()->findByPk($id);

                        $destination=new Rates;
                        $destination->room_id=$room_id;
                        $destination->season=$source->season;
                        $destination->type_reservation_id=$source->type_reservation_id;
                        $destination->price=$source->price;
                        $destination->pax=$source->pax;

                        $destination->save();

                    endforeach;
                }

            endforeach;


            Yii::app()->user->setFlash('success','success');
        }

        $this->render('clone',array());
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
		$model=Rates::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='rates-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
