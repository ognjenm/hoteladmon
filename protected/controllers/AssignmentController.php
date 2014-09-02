<?php

class AssignmentController extends Controller
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
				'actions'=>array('create','update','index','view','delete','minimum','editMinimus','reports'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


    public function actionReports(){

        if(isset($_POST['balance']))
        {
            $employee=(int)$_POST['employee'];
            $balance=(int)$_POST['balance'];

            $limit=($_POST['registers'] !=null ) ? (int)$_POST['registers'] : 10;

            $connection=Yii::app()->db;

            if(!empty($_POST['employee']) && !empty($_POST['balance'])){

                if((int)$_POST['balance'] ==1){
                    $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id where
                        assignment.employeed_id=:employeeId and assignment.balance=0 order by assignment.employeed_id";
                }
                if((int)$_POST['balance'] ==2){
                    $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id where
                        assignment.employeed_id=:employeeId and assignment.balance<0 order by assignment.employeed_id";
                }
                if((int)$_POST['balance'] ==3){
                    $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id where
                        assignment.employeed_id=:employeeId order by assignment.employeed_id";
                }

                $command=$connection->createCommand($sql);
                $command->bindValue("employeeId", $employee , PDO::PARAM_INT);
            }

            if(empty($_POST['employee']) && !empty($_POST['balance'])){

                if((int)$_POST['balance'] ==1){
                    $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id where
                    assignment.balance=0 order by assignment.employeed_id";
                }
                if((int)$_POST['balance'] ==2){
                    $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id where
                    assignment.balance<0 order by assignment.employeed_id";
                }
                if((int)$_POST['balance'] ==3){
                    $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id
                    order by assignment.employeed_id";
                }

                $command=$connection->createCommand($sql);
            }

            if(empty($_POST['employee']) && empty($_POST['balance'])){

                $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id order by assignment.employeed_id";
                $command=$connection->createCommand($sql);
            }

            if(!empty($_POST['employee']) && empty($_POST['balance'])){

                $sql="SELECT assignment.id,assignment.balance,assignment.bracelet_id,employees.names FROM assignment inner join employees on assignment.employeed_id=employees.id where
                        assignment.employeed_id=:employeeId order by assignment.employeed_id";

                $command=$connection->createCommand($sql);
                $command->bindValue("employeeId", $employee , PDO::PARAM_INT);
            }

        $result=$command->queryAll();

        Yii::app()->quoteUtil->reportsBalance($result,$limit);

        unset($connection);
        unset($command);
        unset($result);

        }

        $this->render('reports',array());
    }

    public function actionEditMinimus(){

        $r = Yii::app()->getRequest();

        if($r->getParam('editable')){

            echo $r->getParam('value');

            Yii::app()->end();
        }

        $usoId=$r->getParam('pk');

        $assignment=Assignment::model()->findByPk($usoId);
        $bracelets=Bracelets::model()->findByPk($assignment->bracelet_id);

        $listabracelets=Bracelets::model()->findAll(array(
            'condition'=>'use_id=:useId',
            'params'=>array('useId'=>$bracelets->use_id)
        ));

        foreach($listabracelets as $item){

            $update=Assignment::model()->find(
                array(
                    'condition'=>'employeed_id=:employeeId and bracelet_id=:braceletId',
                    'params'=>array('employeeId'=>$assignment->employeed_id,'braceletId'=>$item->id)
                )
            );

            $update->minimum_balance=$r->getParam('value');
            $update->save();


        }

    }
    public function actionMinimum(){

        $arrayDataProvider=new CActiveDataProvider('Assignment', array(
            'sort'=>array(
                'defaultOrder'=>array(
                    'employeed_id'=>CSort::SORT_ASC,
                )
            ),
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['pagination']
            ),
        ));

        $this->render('minimus',array(
            'model'=>$arrayDataProvider,
        ));

    }

	public function actionView($id){

        $aux=0;
        $lista=array();


       $braceletsHistory=BraceletsHistory::model()->findAll(
            array(
                'condition' => 'assignment_id=:assignmentId',
                'params'=>array('assignmentId'=>$id),
                'order'=>'datex'
            )
        );

        foreach($braceletsHistory as $ix=>$item){
           $saldo=0;
           $lista[]=$item->attributes;

           if($item->operation=='COMPRA'){
               $saldo=$aux+$item->quantity;
               $lista[$ix]['balance']=$saldo;
                $aux=$saldo;
            }

           if($item->operation=='VENTA'){
               $saldo=$aux-$item->quantity;
               $lista[$ix]['balance']=$saldo;
               $aux=$saldo;
           }

           if($item->operation=='TRANSFERENCIA'){

               $pos =  strpos($item->movement,'+');

               if($pos !== FALSE){
                   $saldo=$aux+$item->quantity;
                   $lista[$ix]['balance']=$saldo;
                   $aux=$saldo;
               }
           }

            if($item->operation=='TRANSFERENCIA'){

                $pos = strpos($item->movement,'-');

                if($pos !== FALSE){
                    $saldo=$aux-$item->quantity;
                    $lista[$ix]['balance']=$saldo;
                    $aux=$saldo;
                }
            }
       }

        krsort($lista);

        $arrayDataProvider=new CArrayDataProvider($lista, array(
           'pagination'=>array(
               'pageSize'=>Yii::app()->params['pagination']
           ),
        ));

		$this->render('view',array(
			'model'=>$this->loadModel($id),
            'arrayDataProvider'=>$arrayDataProvider
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Assignment;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Assignment']))
		{
			$model->attributes=$_POST['Assignment'];
            $model->balance=$model->initial_amount;
			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('index'));
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

		if(isset($_POST['Assignment']))
		{
			$model->attributes=$_POST['Assignment'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('index'));
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $model=new Assignment('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Assignment']))
        $model->attributes=$_GET['Assignment'];


        $minimos=new Assignment('minimos');
        $minimos->unsetAttributes();  // clear any default values
        if(isset($_GET['Assignment']))
            $minimos->attributes=$_GET['Assignment'];



        $this->render('index',array(
            'model'=>$model,
            'minimos'=>$minimos
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
		$model=Assignment::model()->findByPk($id);

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
		if(isset($_POST['ajax']) && $_POST['ajax']==='assignment-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
