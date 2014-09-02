<?php

class ArticlesController extends Controller
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
            array('CrugeAccessControlFilter'),
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
				'actions'=>array('create','update','index','view','delete','getPrice','getArticle',
                                'getAttributesArticle','getArticleDescription','saveArticle'),
				'users'=>array('@'),
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

    public function actionSaveArticle(){

        $res=array('ok'=>false,'msg'=>'Error');
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);
        $lista=array();

        if(Yii::app()->request->isPostRequest){

            if(!empty($_POST['idx'])){

                $id=(int)$_POST['idx'];

                $article=Articles::model()->findByPk($id);

                $price=new HistoryPrices;
                $price->article_id=$article->id;
                $price->datex=date('Y-m-d');
                $price->price=$article->price;
                $price->save();

                $article->code_invoice=$_POST['code_invoicex'];
                $article->code_store=$_POST['code_storex'];
                $article->code=$_POST['codex'];
                $article->color=$_POST['colorx'];
                $article->measure=$_POST['measurex'];
                $article->name_article=$_POST['name_articlex'];
                $article->name_invoice=$_POST['name_invoicex'];
                $article->name_store=$_POST['name_storex'];
                $article->presentation=$_POST['presentationx'];
                $article->price=$_POST['pricex'];
                $article->quantity=$_POST['quantityx'];
                $article->unit_measure_id=$_POST['unit_measure_idx'];

                if($article->save()){
                    $res=array('ok'=>true,'msg'=>'Success');
                }
            }
            else{
                    $article=new Articles;

                    $provider=(int)$_POST['DirectInvoice']['provider_id'];

                    $article->provider_id=$provider;
                    $article->code_invoice=$_POST['code_invoicex'];
                    $article->code_store=$_POST['code_storex'];
                    $article->code=$_POST['codex'];
                    $article->color=$_POST['colorx'];
                    $article->measure=$_POST['measurex'];
                    $article->name_article=$_POST['name_articlex'];
                    $article->name_invoice=$_POST['name_invoicex'];
                    $article->name_store=$_POST['name_storex'];
                    $article->presentation=$_POST['presentationx'];
                    $article->price=$_POST['pricex'];
                    $article->quantity=$_POST['quantityx'];
                    $article->unit_measure_id=$_POST['unit_measure_idx'];

                    $date_price=date("Y-M-d");
                    $article->date_price=Yii::app()->quoteUtil->toSpanishDate($date_price);

                    if($article->save()){

                        $data=Articles::model()->findAll(
                            array('condition'=>'provider_id=:providerId',
                                'params'=>array('providerId'=>$provider)
                            )
                        );

                        if($data){
                            foreach($data as $item){
                                $value=$item->name_article.' - '.$item->unitmeasure->unit.' - '.$item->measure.' - '.$item->presentation;
                                $options.=CHtml::tag('option', array('value'=>$item->id),CHtml::encode($value),true);
                            }
                        }

                        $res=array('ok'=>true,'msg'=>'Success','articles'=>$options);

                    }else{
                        $validate= CActiveForm::validate($article);
                        $res=array('ok'=>true,'msg'=>$validate);
                    }
            }



            echo CJSON::encode($res);
            Yii::app()->end();

        }


    }


    public function actionGetArticleDescription(){

        $res=array('ok'=>false,'articles'=>null);
        $options=CHtml::tag('option', array('value'=>''),CHtml::encode(Yii::t('mx','Select')),true);
        $lista=array();

        if(Yii::app()->request->isPostRequest){

            $providerId=(int)$_POST['provider'];

            $data=Articles::model()->findAll(
                array('condition'=>'provider_id=:providerId',
                    'params'=>array('providerId'=>$providerId)
                )
            );

            if($data){
                foreach($data as $item){
                    $value=$item->name_article.' - '.$item->unitmeasure->unit.' - '.$item->measure.' - '.$item->presentation;
                    $options.=CHtml::tag('option', array('value'=>$item->id),CHtml::encode($value),true);
                }
            }

            if($options) $res=array('ok'=>true,'articles'=>$options);


            echo CJSON::encode($res);
            Yii::app()->end();

        }

    }

    public function actionGetAttributesArticle(){

        if(Yii::app()->request->isAjaxRequest){

            $article=$_POST['articleId'];

            $criteria=array(
                'condition'=>'id=:article',
                'params'=>array(':article'=>$article)
            );

            $articles=Articles::model()->find($criteria);
        }

        echo CJSON::encode($articles);
        Yii::app()->end();

    }

    public function actionGetArticle(){

        $res=array('ok'=>false,'article'=>null);

        if(Yii::app()->request->isPostRequest){

            $articleId=(int)$_POST['articleId'];

            $data=Subitems::model()->find(
                array('condition'=>'article_id=:articleId',
                    'params'=>array('articleId'=>$articleId)
                )
            );

            if($data) $res=array('ok'=>true,'price'=>$data->price);

            echo CJSON::encode($res);
            Yii::app()->end();

        }

    }

    public function actionGetPrice(){

        $res=array('ok'=>false,'price'=>null);

        if(Yii::app()->request->isPostRequest){

            $articleId=(int)$_POST['articleId'];

            $data=Subitems::model()->find(
                array('condition'=>'article_id=:articleId',
                    'params'=>array('articleId'=>$articleId)
                )
            );

            if($data) $res=array('ok'=>true,'price'=>$data->price);

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
        Yii::import('ext.jqrelcopy.JQRelcopy');

		$items=new Articles;

        if(isset($_POST['Articles']))
        {
            $tope=count($_POST['Articles']['code']);

            for($i=0;$i<$tope;$i++){
                $data=array();

                foreach ($_POST['Articles'] as $id=>$values){
                    if(!is_array($values)){
                        $anexo=array($id=>$values);
                        $data=array_merge($data,$anexo);
                    }else{
                        $anexo=array($id=>$values[$i]);
                        $data=array_merge($data,$anexo);
                    }
                }

                $item=new Articles;
                $item->attributes=$data;
                $item->provider_id=$_POST['Articles']['provider_id'];
                $item->name_article=$_POST['Articles']['name_article'];
                $item->name_store=$_POST['Articles']['name_store'];
                $item->name_invoice=$_POST['Articles']['name_invoice'];

                $price=(int)$_POST['Articles']['price'];
                $quantity=(int)$_POST['Articles']['quantity'];

                $item->unit_price=($price/$quantity);

                $item->save();

            }

            Yii::app()->user->setFlash('success','Success');
            $this->redirect(array('index'));

        }


        $this->render('create',array(
            'items'=>$items,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
    public function getItemsToUpdate($id) {

        $list = Articles::model()->findAll(array(
            'condition'=>'id=:articleId',
            'params'=>array(
                'articleId'=>$id
            )
        ));

        $items=array();

        if (isset($list)) {

            foreach ($list as $item) {
                $items[] = $item;
            }
        }
        return $items;
    }

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $tempImage=$model->image;
        $image=NULL;

        if(isset($_POST['Articles']))
        {

            $price=new HistoryPrices;
            $price->article_id=$model->id;
            $price->datex=date('Y-m-d');
            $price->price=$model->price;
            $price->save();

            $model->attributes=$_POST['Articles'];

            $image=CUploadedFile::getInstance($model,'image');
            $model->image=($image !=NULL) ? $model->id.'.'.$image->getExtensionName() : $tempImage;


            $price=$model->price;
            $quantity=$model->quantity;

            $model->unit_price=$price/$quantity;

            if($model->save()){

                if($image !=NULL) $image->saveAs(Yii::getPathOfAlias('webroot')."/images/articles/".$model->image);

                $imagenRedimensionada = Yii::app()->quoteUtil->resizeImage(Yii::getPathOfAlias('webroot')."/images/articles/".$model->image,500,600);
                imagejpeg($imagenRedimensionada,Yii::getPathOfAlias('webroot')."/images/articles/".$model->image,100);


                Yii::app()->user->setFlash('success','Success');
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
        $model=new Articles('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Articles']))
        $model->attributes=$_GET['Articles'];

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
		$model=Articles::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='articles-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
