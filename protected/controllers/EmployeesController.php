<?php

class EmployeesController extends Controller
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
				'actions'=>array('create','update','index','view','delete','getName','GetEmployees'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionGetEmployees(){
        $res=array('ok'=>false,'msg'=>Yii::t('mx','Error'));
        $lista="<ul>";

        if(Yii::app()->request->isPostRequest){

            if(isset($_POST['groupId'])){

                $groupId=(int)$_POST['groupId'];

                $criteria=array(
                    'condition'=>'group_id=:groupId',
                    'params'=>array('groupId'=>$groupId)
                );

                $groups=GroupAssignment::model()->with(array(
                    'employee'=>array(
                        'select'=>'first_name',
                        'together'=>false,
                        'joinType'=>'INNER JOIN',
                    ),

                ))->findAll($criteria);

                foreach($groups as $item){
                    $lista.="<li>".$item->employee->first_name."</li>";
                }

                $lista.="</ul>";
                $res=array('ok'=>true,'lista'=>$lista);

            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }
    }


    public function actionGetName(){

        $res=array('ok'=>false,'msg'=>Yii::t('mx','Error'));
        $ids=array();

        if(Yii::app()->request->isPostRequest){

            if(isset($_POST['ids'])){

                $ids=(int)$_POST['ids'];

                $employee=$this->loadModel($ids);

                if($employee) $res=array('ok'=>true,'msg'=>$ids);
            }

            echo CJSON::encode($res);
            Yii::app()->end();

        }
    }


	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
        Yii::import('bootstrap.widgets.TbForm');
		$model=new Employees;
        $zon=new Zones;

        $zones= TbForm::createForm($zon->getForm(),$zon,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Employees']))
		{
			$model->attributes=$_POST['Employees'];

			if($model->save()){

                $bracelets=Bracelets::model()->findAll();

                foreach($bracelets as $item):
                    $assigment=new Assignment;
                    $assigment->employeed_id=$model->id;
                    $assigment->bracelet_id=$item->id;
                    $assigment->date_assignment=date('Y-m-d');
                    $assigment->save();
                endforeach;


                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('create',array(
			'model'=>$model,
            'zones'=>$zones
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
        $zon=new Zones;

        $zones= TbForm::createForm($zon->getForm(),$zon,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Employees']))
		{
			$model->attributes=$_POST['Employees'];

			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('update',array(
			'model'=>$model,
            'zones'=>$zones
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

            //$this->loadModel($id)->delete();
            //$assigments=Assignment::model()->findAll('employeed_id=:employeedId',array('employeedId'=>$id));

            try{
                $this->loadModel($id)->delete();
                if(!isset($_GET['ajax']))
                    Yii::app()->user->setFlash('success','Normal - Deleted Successfully');
                else
                    echo '<div class="alert in alert-block fade alert-success">
                            <a href="#" class="close" data-dismiss="alert">×</a>
                            <strong>done!</strong>
                               '.Yii::t('mx','Success').'
                        </div>';

            }catch(CDbException $e){
                if(!isset($_GET['ajax']))
                    Yii::app()->user->setFlash('error','Normal - error message');
                else

                    echo '<div class="alert in alert-block fade alert-error">
                            <a href="#" class="close" data-dismiss="alert">×</a>
                            <strong>Error!</strong>
                                '.Yii::t('mx','Please. Remove dependencies. First movements, bracelets assigned, and finally this employee').'
                        </div>';

            }


			if(!isset($_GET['ajax'])){
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
            }

		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Employees('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Employees']))
        $model->attributes=$_GET['Employees'];

        $this->render('index',array(
        'model'=>$model,
        ));

	}




	public function loadModel($id)
	{
		$model=Employees::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employees-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
