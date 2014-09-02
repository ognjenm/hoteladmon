<?php

class BraceletsHistoryController extends Controller
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
				'actions'=>array('create','update','index','view','delete','transfer','buy'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}


    public function actionBuy()
    {
        $model=new BraceletsHistory;


        if(isset($_POST['BraceletsHistory']))
        {
            $assignmentId=(int)$_POST['BraceletsHistory']['assignment_id'];
            $sourceData=Assignment::model()->findByPk($assignmentId);

            $model->attributes=$_POST['BraceletsHistory'];
            $model->assignment_id=$sourceData->id;
            $model->operation="COMPRA";
            $model->register='COMPRA';
            $model->existence=$sourceData->balance;
            $model->movement="+".$model->quantity;
            $model->balance=$model->existence+$model->quantity;

            $sourceData->balance=$model->balance;
            $sourceData->date_assignment=$model->datex;

            if($model->save() && $sourceData->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('assignment/view','id'=>$sourceData->id));
            }

        }

        $this->render('buy',array(
            'model'=>$model,
        ));
    }

    public function actionTransfer()
    {
        $model=new BraceletsHistory;


        if(isset($_POST['BraceletsHistory']))
        {
            $assignmentId=(int)$_POST['BraceletsHistory']['assignment_id'];
            $sourceData=Assignment::model()->findByPk($assignmentId);
            $sourceEmployee=Employees::model()->findByPk($sourceData->employeed_id);

            $employeId=(int)$_POST['BraceletsHistory']['employeed_id'];
            $destinationEmployee=Employees::model()->findByPk($employeId);

            $model->attributes=$_POST['BraceletsHistory'];
            $model->assignment_id=$sourceData->id;
            $model->operation="TRANSFERENCIA";
            $model->register='Para: '.$destinationEmployee->names;
            $model->existence=$sourceData->balance;
            $model->movement="-".$model->quantity;
            $model->balance=$model->existence-$model->quantity;
            $sourceData->balance=$model->balance;
            $sourceData->date_assignment=$model->datex;

            $destinationData1=Assignment::model()->find(
                'employeed_id=:EmployeedId and bracelet_id=:braceletId',
                array(
                    'EmployeedId'=>(int)$destinationEmployee->id,
                    'braceletId'=>(int)$sourceData->bracelet_id
                )
            );

            if(!$destinationData1){
                $assignment=new Assignment;
                $assignment->initial_amount=$model->quantity;
                $assignment->employeed_id=$destinationEmployee->id;
                $assignment->bracelet_id=$sourceData->bracelet_id;
                $date=Yii::app()->quoteUtil->ToSpanishDateFromFormatdMyyyy(date('d-M-Y'));
                $assignment->date_assignment=$date;
                $assignment->save();

            }

            $destinationData=Assignment::model()->find(
                'employeed_id=:EmployeedId and bracelet_id=:braceletId',
                array(
                    'EmployeedId'=>(int)$destinationEmployee->id,
                    'braceletId'=>(int)$sourceData->bracelet_id
                )
            );


            $destination= new BraceletsHistory;
            $destination->assignment_id=$destinationData->id;
            $destination->operation="TRANSFERENCIA";
            $destination->quantity=$model->quantity;
            $destination->datex=$model->datex;
            $destination->register='De: '.$sourceEmployee->names;
            $destination->existence=$destinationData->balance;
            $destination->movement="+".$destination->quantity;
            $destination->balance=$destination->existence+$destination->quantity;
            $destinationData->balance=$destination->balance;
            $destinationData->date_assignment=$model->datex;


            if($model->save() && $sourceData->save() && $destination->save() && $destinationData->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('assignment/view','id'=>$sourceData->id));
            }

        }

        $this->render('transfer',array(
            'model'=>$model,
        ));
    }
	public function actionCreate()
	{
        Yii::import('ext.multimodelform.MultiModelForm');

        $validatedMembers = array();

        $model=new BraceletsHistory;

        $ok=false;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BraceletsHistory']))
		{
            $assignmentId=(int)$_POST['BraceletsHistory']['assignment_id'];
            $assignment=Assignment::model()->findByPk($assignmentId);

			$model->attributes=$_POST['BraceletsHistory'];
            $assignmentId=(int)$assignmentId;
            $sourceData=Assignment::model()->findByPk($assignmentId);

            $tope=count($_POST['BraceletsHistory']['quantity']);

            for($i=0;$i<$tope;$i++){

                $data=array();

                foreach($_POST['BraceletsHistory'] as $id=>$values){
                    if(is_array($values)){
                        $anexo=array($id=>$values[$i]);
                        $data=array_merge($data,$anexo);
                    }
                }

                $items= new BraceletsHistory;
                $items->attributes=$data;
                $items->assignment_id=$assignmentId;
                $items->operation='VENTA';

                if($items->register!=4){
                    $typesReport=TypesReport::model()->findByPk($items->register);

                    $folio=$items->folio;
                    $register=$typesReport->tipe.$folio;

                    $typesReport->folio=(int)$folio+1;
                    $typesReport->save();

                    $items->register=$register;
                }else{
                    $items->register=$items->folio;
                }

                $items->existence=$sourceData->balance;
                $items->movement="-".$data['quantity'];
                $items->balance=$items->existence-$items->quantity;
                $sourceData->balance=$items->balance;
                $sourceData->date_assignment=date('Y-m-d');

                if( $items->save() &&  $sourceData->save()) $ok=true;

            }

            if($ok==true){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('assignment/view','id'=>$assignmentId));
            }
		}

		$this->render('create',array(
			'model'=>$model,
            'validatedMembers' => $validatedMembers,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id,$asigmentId)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BraceletsHistory']))
		{
			$model->attributes=$_POST['BraceletsHistory'];
			if($model->save())
                Yii::app()->user->setFlash('success','Success');
				$this->redirect(array('assignment/view','id'=>$asigmentId));
		}

		$this->render('update',array(
			'model'=>$model,
            'asigmentId'=>$asigmentId
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
            $history=$this->loadModel($id);
			// we only allow deletion via POST request
            $assigment=Assignment::model()->findByPk($history->assignment_id);


            if($history->operation=='COMPRA') $assigment->balance=$assigment->balance-$history->quantity;
            if($history->operation=='VENTA') $assigment->balance=$assigment->balance+$history->quantity;
            if($history->operation=='TRANSFERENCIA'){

                $pos =  strpos($history->movement,'+');

                if($pos !== FALSE){
                    $assigment->balance=$assigment->balance-$history->quantity;

                    $braceletId=$assigment->bracelet_id;
                    $employee=explode(' ',$history->register);
                    $employeeId=Employees::model()->find(
                        array(
                            'condition'=>'names=:names',
                            'params'=>array('names'=>$employee[1])
                        )
                    );

                    $newBalance=Assignment::model()->find(array(
                        'condition'=>'employeed_id=:employeeId and bracelet_id=:braceletId',
                        'params'=>array('employeeId'=>$employeeId->id,'braceletId'=>$braceletId)
                    ));

                    $newBalance->balance=$newBalance->balance+$history->quantity;

                    $employeSource=Employees::model()->findByPk($assigment->employeed_id);

                    $newHistory= new BraceletsHistory;
                    $newHistory->assignment_id=$newBalance->id;
                    $newHistory->operation="TRANSFERENCIA";
                    $newHistory->quantity=$history->quantity;
                    $newHistory->register='TRANSFERENCIA PARA: '.$employeSource->names.' CANCELADO';
                    $date=Yii::app()->quoteUtil->ToSpanishDateFromFormatdMyyyy(date('d-M-Y'));
                    $newHistory->datex=$date;
                    $newHistory->movement="+".$history->quantity;
                    $newHistory->balance=$newBalance->balance;

                    $newBalance->save();
                    $newHistory->save();

                }
            }

            if($history->operation=='TRANSFERENCIA'){

                $pos = strpos($history->movement,'-');
                if($pos !== FALSE){
                    $assigment->balance=$assigment->balance+$history->quantity;

                    $braceletId=$assigment->bracelet_id;
                    $employee=explode(' ',$history->register);
                    $employeeId=Employees::model()->find(
                        array(
                            'condition'=>'names=:names',
                            'params'=>array('names'=>$employee[1])
                        )
                    );

                    $newBalance=Assignment::model()->find(array(
                        'condition'=>'employeed_id=:employeeId and bracelet_id=:braceletId',
                        'params'=>array('employeeId'=>$employeeId->id,'braceletId'=>$braceletId)
                    ));

                    $newBalance->balance=$newBalance->balance-$history->quantity;

                    $employeesource=Employees::model()->findByPk($assigment->employeed_id);

                    $newHistory= new BraceletsHistory;
                    $newHistory->assignment_id=$newBalance->id;
                    $newHistory->operation="TRANSFERENCIA";
                    $newHistory->quantity=$history->quantity;
                    $newHistory->register='TRANSFERENCIA DE: '.$employeesource->names.' CANCELADO';
                    $date=Yii::app()->quoteUtil->ToSpanishDateFromFormatdMyyyy(date('d-M-Y'));
                    $newHistory->datex=$date;
                    $newHistory->movement="-".$history->quantity;

                    $newBalance->save();
                    $newHistory->save();

                }
            }

            if( $history->delete() && $assigment->save()){
                echo '<div class="alert in alert-block fade alert-success">
                            <a href="#" class="close" data-dismiss="alert">×</a>
                            <strong>done!</strong>
                               '.Yii::t('mx','Success').'
                        </div>';
            }



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
        $model=new BraceletsHistory('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['BraceletsHistory']))
        $model->attributes=$_GET['BraceletsHistory'];

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
		$model=BraceletsHistory::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='bracelets-history-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}


}
