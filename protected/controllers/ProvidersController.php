<?php

class ProvidersController extends Controller
{

	public $layout='//layouts/column2';

    public function filters()
    {
        return array(
            array('CrugeAccessControlFilter'),  // perform access control for CRUD operations
        );
    }

	public function accessRules()
	{
		return array(

			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','index','view','delete','export','exportAll','import','getProvider','getFullName','getSuffix','getProviderDescription'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionGetProviderDescription(){

        $options=CHtml::tag('option', array('value'=>''),Yii::t('mx','Select'),true);

        if(Yii::app()->request->isAjaxRequest){

            if (isset($_POST['article_id'])) {

                $articleId=(int)$_POST['article_id'];
                $provider_id=Articles::model()->findByPk($articleId);

                $provider=Providers::model()->findByPk($provider_id->provider_id);

                if($provider){
                    $empresa="";
                    $empresa.=$provider->company != "" ? $provider->company." - " : "";
                    $empresa.=$provider->first_name != "" ? $provider->first_name." " : "";
                    $empresa.=$provider->middle_name != "" ? $provider->middle_name." " : "";
                    $empresa.=$provider->last_name != "" ? $provider->last_name." - " : "";
                    $empresa.=$provider->suffix != "" ? $provider->suffix : "";

                    $options=CHtml::tag('option', array('value'=>$provider->id),CHtml::encode($empresa),true);

                }


            }

            echo $options;
            Yii::app()->end();
        }
    }

    public function actionGetSuffix() {

        $res =array();
        if (isset($_GET['term'])) {
            $qtxt ="SELECT suffix FROM providers WHERE suffix LIKE :word1";
            $command =Yii::app()->db->createCommand($qtxt);
            $command->bindValue(":word1", "%".$_GET['term']."%", PDO::PARAM_STR);
            $res =$command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }

    public function actionGetProvider() {

        $res =array();
        if (isset($_GET['term'])) {
            $qtxt ="SELECT company FROM providers WHERE company LIKE :word1";
            $command =Yii::app()->db->createCommand($qtxt);
            $command->bindValue(":word1", "%".$_GET['term']."%", PDO::PARAM_STR);
            $res =$command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }

    public function actionGetFullName() {

        $res =array();
        if (isset($_GET['term'])) {
            $qtxt ="SELECT concat(first_name,' ',middle_name,' ',last_name) FROM providers WHERE concat(first_name,' ',middle_name,' ',last_name) LIKE :word1";
            $command =Yii::app()->db->createCommand($qtxt);
            $command->bindValue(":word1", "%".$_GET['term']."%", PDO::PARAM_STR);
            $res =$command->queryColumn();
        }

        echo CJSON::encode($res);
        Yii::app()->end();

    }

    public function actionImport(){

        $vcard=new File;
        $path=Yii::getPathOfAlias('webroot')."/vcard/";

        if(isset($_POST['File'])){

            $vcard->attributes = $_POST['File'];
            $vcard->filex=CUploadedFile::getInstance($vcard,'filex');
            $vcard->filex->saveAs($path.$vcard->filex);

            if($vcard->validate()){

                Yii::app()->VcardImport->importVcard($path.$vcard->filex);

                Yii::app()->user->setFlash('success','Import Succefully...');
                $this->redirect(array('index'));
            }

        }

        $this->render('import',array(
            'vcard'=>$vcard
        ));

    }

    public function actionExport($id){

       $provider=$this->loadModel($id);

       Yii::app()->vCard->setData($provider);
       Yii::app()->vCard->generateCardOutput();
       Yii::app()->vCard->writeCardFile();
       Yii::app()->vCard->downloadCardFile();

    }

    public function actionExportAll(){

        $provider=Providers::model()->findAll();
        Yii::app()->vCard->generateCardOutputAll($provider);
        Yii::app()->vCard->writeCardFile();
        Yii::app()->vCard->downloadCardFile();

    }

	public function actionView($id)
	{
        $model=$this->loadModel($id);

        $providersHistory=new CActiveDataProvider('AuditProviders',array (
                'criteria' => array (
                    'condition' => 'provider_id=:ProviderId and action!="SET"', 'order'=>'stamp DESC',
                    'params'=>array('ProviderId'=>$model->id)
                ))
        );

		$this->render('view',array(
			'model'=>$model,
            'providersHistory'=>$providersHistory
		));
	}

	public function actionCreate()
	{
        Yii::import('bootstrap.widgets.TbForm');
		$model=new Providers;
        $zon=new Zones;

        $zones= TbForm::createForm($zon->getForm(),$zon,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'vertical',
            )
        );

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Providers']))
		{
			$model->attributes=$_POST['Providers'];

            if($model->n_degrees !=0  && $model->n_minuts!=0 && $model->n_seconds !=0 && $model->w_degrees !=0  && $model->w_minuts!=0 && $model->w_seconds !=0){
                $model->latitude=Yii::app()->quoteUtil->convertToLatitude($model->n_degrees,$model->n_minuts,$model->n_seconds);
                $model->longitude=Yii::app()->quoteUtil->convertToLongitude($model->w_degrees,$model->w_minuts,$model->w_seconds);
            }

			if($model->save()){
                Yii::app()->user->setFlash('success','Success');
                $this->redirect(array('view','id'=>$model->id));
            }

		}

		$this->render('create',array(
			'model'=>$model,
            'zones'=>$zones
		));
	}

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

		if(isset($_POST['Providers']))
		{
			$model->attributes=$_POST['Providers'];

            if($model->n_degrees !=0  && $model->n_minuts!=0 && $model->n_seconds !=0 && $model->w_degrees !=0  && $model->w_minuts!=0 && $model->w_seconds !=0){
                $model->latitude=Yii::app()->quoteUtil->convertToLatitude($model->n_degrees,$model->n_minuts,$model->n_seconds);
                $model->longitude=Yii::app()->quoteUtil->convertToLongitude($model->w_degrees,$model->w_minuts,$model->w_seconds);
            }

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

	public function actionIndex()
	{
        Yii::import('bootstrap.widgets.TbForm');

        $model=new Providers('search');
        $model->unsetAttributes();  // clear any default values

        $formFilter = TbForm::createForm($model->getFormFilter(),$model,
            array('htmlOptions'=>array('class'=>'well'),
                'type'=>'inline',
            )
        );

        if(isset($_GET['Providers']))
        $model->attributes=$_GET['Providers'];

        $this->render('index',array(
            'model'=>$model,
            'formFilter'=>$formFilter
        ));

	}

	public function loadModel($id)
	{
		$model=Providers::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='providers-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
