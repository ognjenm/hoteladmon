<?php

class GroupsController extends Controller
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
				'actions'=>array('create','update','index','view','delete','DeleteEmployee'),
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

        $employees=GroupAssignment::model()->findAll(array(
            'condition'=>'group_id=:groupId',
            'params'=>array('groupId'=>$id)
        ));

        $dataProviderEmployees=new CArrayDataProvider($employees,array(
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            )
        ));


		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'employees'=>$dataProviderEmployees
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Groups;
        $items=new GroupAssignment;
        $validatedMembers = array();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
			if($model->save()){

                $masterValues = array ('group_id'=>$model->id);

                if (MultiModelForm::save($items,$validatedMembers,$deleteMembers,$masterValues)){
                    Yii::app()->user->setFlash('success','Success');
                    $this->redirect(array('view','id'=>$model->id));
                }

                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }

		}

		$this->render('create',array(
            'model'=>$model,
            'items'=>$items,
            'validatedMembers' => $validatedMembers,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        Yii::import('ext.multimodelform.MultiModelForm');
		$model=$this->loadModel($id);
        $items=new GroupAssignment;
        $validatedMembers = array();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
            $masterValues = array ('group_id'=>$model->id);

			if($model->save()){

                if(MultiModelForm::save($items,$validatedMembers,$deleteMembers,$masterValues)){
                    Yii::app()->user->setFlash('success','Success');
                    $this->redirect(array('view','id'=>$model->id));
                }

                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
            }

		}

		$this->render('update',array(
            'model'=>$model,
            'items'=>$items,
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

           try{
                $this->loadModel($id)->delete();
            }catch (CDbException $e){
               if($e->errorInfo[1] == 1451) throw new CHttpException(400, Yii::t('mx','Please. Delete first employees of this group'));
               else throw $e;
            }

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


    public function actionDeleteEmployee($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $assingment=GroupAssignment::model()->findByPk($id);
            $assingment->delete();

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
        $model=new Groups('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Groups']))
        $model->attributes=$_GET['Groups'];

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
		$model=Groups::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='groups-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
