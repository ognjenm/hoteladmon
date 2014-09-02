<?php

class SiteController extends Controller
{
    public $layout='//layouts/column2';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}


    public function actionLogin2()
    {
        $model = new LoginForm;
        $form = new CForm('application.views.site.loginForm', $model);
        if($form->submitted('login') && $form->validate())
            $this->redirect(array('site/index'));
        else
            $this->render('login2', array('form'=>$form));
    }


	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{

        Yii::import('bootstrap.widgets.TbForm');

        $userId=Yii::app()->user->id;
        $lista=array();
        $listaGroup=array();

        if(!Yii::app()->user->isSuperAdmin){

            $employee=Employees::model()->find(
                array(
                    'condition'=>'user_id=:userId',
                    'params'=>array('userId'=>$userId)
                )
            );

            $tasks = Yii::app()->db->createCommand()
                ->select("tasks.*")
                ->from('tasks')
                ->join('group_assignment','tasks.group_assigned_id =group_assignment.group_id')
                ->where('status!=1 and isgroup=1 and group_assignment.employee_id=:employeeId',array(':employeeId'=>$employee->id))
                ->queryAll();

            if($tasks){
                foreach($tasks as $itemx){
                    $users=explode(',',$itemx['accepted_users']);
                    if(!in_array($userId,$users)){
                        $listaGroup[]=$itemx;
                    }
                }

                $lista=array_merge($lista,$listaGroup);
            }

            $tasks2 = Yii::app()->db->createCommand()
                ->select('tasks.*')
                ->from('tasks')
                ->where('status in (4,2) and isgroup=0 and employee_id=:employeeId',array(':employeeId'=>$employee->id))
                ->queryAll();

            if($tasks2){
                $lista=array_merge($lista,$tasks2);
            }

        }

        $dataProvider=new CArrayDataProvider($lista);

        $pettycash=PettyCash::model()->find(array(
            'condition'=>'user_id=:userId and isconfirmed=0',
            'params'=>array('userId'=>$userId)
        ));





		$this->render('index',array(
                'dataProvider'=>$dataProvider,
            )
        );

	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
        Yii::import('ext.jqrelcopy.JQRelcopy');

		$model=new PaymentTime;
        $data=array();
        $diasReales=array();
        $counter=0;
        $res=array('tabla'=>'');

    if(Yii::app()->request->isAjaxRequest){
		if(isset($_POST['PaymentTime']))
		{

            $tope=count($_POST['PaymentTime']['llega']);
            $datos=array();
            $newdates=array();

            for($i=0;$i<$tope;$i++){
                $data=array();

                foreach ($_POST['PaymentTime'] as $id=>$values){
                    $anexo=array($id=>$values[$i]);
                    $data=array_merge($data,$anexo);
                }

                $datos[]=$data;
            }

            foreach($datos as $item){

                $diadelasemana=Yii::app()->quoteUtil->diaSemana($item['fecha']);
                $diasReales=Yii::app()->quoteUtil->getdiasReales($diadelasemana,$item['dias'],$item['hora'],$item['disponibilidad']);

                if((int)$diasReales['dias']<1)
                    $tipodepago="TARJETA";
                else $tipodepago="DEPOSITO";

                $time = new DateTime($item['fecha']);

                $newdates[]=array(
                    'fecha'=>$item['fecha'],
                    'hora'=>$item['hora'],
                    'llega'=>$item['llega'],
                    'disponibilidad'=>$item['disponibilidad'],
                    'dias'=>$item['dias'],
                    'diasSemana'=>$diasReales['diasSemana'],
                    'diasRealPago'=>$diasReales['dias'],
                    'resdisp'=>$diasReales['disp'],
                    'tipopago'=>$tipodepago
                );
            }

            $table='<table class="items table table-hover table-condensed table-bordered">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Llega</th>
                            <th>% disponibilidad</th>
                            <th>Dias para pagar</th>
                            <th>Dias de la semana</th>
                            <th>Dias reales de pago</th>
                            <th>disponibilidad requerida</th>
                            <th>Tipo de pago</th>
                        </tr>
                    <thead>
                <tbody>
                    <tr>
            ';

            foreach($newdates as $data){

                $table.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $table.='
                            <td>'.$data['fecha'].'</td>
                            <td>'.$data['hora'].'</td>
                            <td>'.$data['llega'].'</td>
                            <td>'.$data['disponibilidad'].'</td>
                            <td>'.$data['dias'].'</td>
                            <td>'.$data['diasSemana'].'</td>
                            <td>'.$data['diasRealPago'].'</td>
                            <td>'.$data['resdisp'].'</td>
                            <td>'.$data['tipopago'].'</td>
                        </tr>';
                $counter++;
            }

            $table.='</tbody></table>';
            $res=array('tabla'=>$table);
            echo CJSON::encode($res);
            Yii::app()->end();
		}
    }

		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}