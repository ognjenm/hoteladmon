<?php

$this->breadcrumbs=array(
    Yii::t('mx','Editing Profile')=>array('index'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('/site/index')),
);


$this->pageSubTitle=Yii::t('mx','Editing Profile');
$this->pageIcon='icon-list-alt';

if(Yii::app()->user->hasFlash('success')):
    Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
endif;

$this->widget('bootstrap.widgets.TbAlert', array(
    'block'=>true, // display a larger alert block?
    'fade'=>true, // use transitions?
    'closeText'=>'×', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'), // success, info, warning, error or danger
    ),
));

?>

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'crugestoreduser-form',
        'enableAjaxValidation'=>false,
        'enableClientValidation'=>false,
        //'type'=>'inline'
    )); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>


<div class="row-fluid">
    <div class="span6">
        <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'Account Data'),
            'headerIcon' => 'icon-th-list',
            'htmlOptions' => array('class'=>'box box-color'),
            'htmlContentOptions'=>array('class'=>'box-content'),
        ));?>

                <?php echo $form->textFieldRow($model,'username'); ?>
                <?php echo $form->error($model,'username'); ?>

                <?php echo $form->textFieldRow($model,'email'); ?>
                <?php echo $form->error($model,'email'); ?>

                <?php echo $form->textFieldRow($model,'newPassword',array('size'=>10)); ?>
                <?php echo $form->error($model,'newPassword'); ?>
                <script>
                    function fnSuccess(data){  $('#CrugeStoredUser_newPassword').val(data); }
                    function fnError(e){  alert("error: "+e.responseText); }
                </script>
                <?php echo CHtml::ajaxbutton(
                    CrugeTranslator::t("Generar una nueva clave")
                    ,Yii::app()->user->ui->ajaxGenerateNewPasswordUrl
                    ,array('success'=>new CJavaScriptExpression('fnSuccess'),
                        'error'=>new CJavaScriptExpression('fnError'))
                ); ?>

        <?php $this->endWidget();?>

    </div>

    <div class="span6">

        <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'Account Information'),
            'headerIcon' => 'icon-th-list',
            'htmlOptions' => array('class'=>'box box-color'),
            'htmlContentOptions'=>array('class'=>'box-content'),
        ));?>

        <?php echo $form->textFieldRow($model,'regdate',array(
                'readonly'=>'readonly',
                'value'=>Yii::app()->user->ui->formatDate($model->regdate),
            )
        ); ?>

        <?php /*echo $form->textFieldRow($model,'actdate',array(
                'readonly'=>'readonly',
                'value'=>Yii::app()->user->ui->formatDate($model->actdate),
            )
        );*/
         ?>

        <?php echo $form->textFieldRow($model,'logondate',array(
                'readonly'=>'readonly',
                'value'=>Yii::app()->user->ui->formatDate($model->logondate),
            )
        ); ?>

        <?php $this->endWidget();?>

    </div>
</div>




    <?php if(count($model->getFields()) > 0){

            $this->beginWidget('bootstrap.widgets.TbBox', array(
                'title' => Yii::t('mx', 'Profile'),
                'headerIcon' => 'icon-th-list',
                'htmlOptions' => array('class'=>'box box-color'),
                'htmlContentOptions'=>array('class'=>'box-content'),
            ));


                echo '<div class="control-group">';
                foreach($model->getFields() as $f){
                    echo "<div class='controls'>";
                    echo Yii::app()->user->um->getLabelField($f);
                    echo Yii::app()->user->um->getInputField($model,$f);
                    echo $form->error($model,$f->fieldname);
                    echo "</div>";
                }
                echo "</div>";
            $this->endWidget();
        }
    ?>



    <?php

    if($boolIsUserManagement)
        if(Yii::app()->user->checkAccess('edit-advanced-profile-features',__FILE__." linea ".__LINE__)){

            $this->beginWidget('bootstrap.widgets.TbBox', array(
                'title' => Yii::t('mx', 'Advanced Options'),
                'headerIcon' => 'icon-th-list',
                'htmlOptions' => array('class'=>'box box-color'),
                'htmlContentOptions'=>array('class'=>'box-content'),
            ));

                $this->renderPartial('_edit-advanced-profile-features',array('model'=>$model,'form'=>$form),false);

            $this->endWidget();

        }

    ?>


    <div class="actions">
        <?php Yii::app()->user->ui->tbutton("Guardar Cambios"); ?>
    </div>
<?php echo $form->errorSummary($model); ?>
<?php $this->endWidget(); ?>

