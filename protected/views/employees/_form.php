<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'providers-form',
	'enableAjaxValidation'=>false,
    'type'=>'horizontal'
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>
    <br>

    <?php echo $form->errorSummary($model); ?>

<?php echo CHtml::label(Yii::t('mx','User'),'',array()); ?>

    <?php $this->widget('bootstrap.widgets.TbSelect2', array(
        'model'=>$model,
        'attribute'=>'user_id',
        'data' =>CrugeUser1::model()-> listUserName(),
        'options' => array(
            'allowClear' => true,
        ),
        'htmlOptions' => array(
            'placeholder' =>Yii::t('mx','Select'),
        ),
    ));
    ?>


    <?php $this->widget('bootstrap.widgets.TbTabs',
            array(  'id'=>'wizardReservation',
                'type' => 'tabs',
                'tabs' => array(
                    array('label' => Yii::t('mx','General Information'),'content' =>$this->renderPartial('_general', array('model'=>$model,'form'=>$form),true),'active' => true),
                    array('label' => Yii::t('mx','Phone Numbers'),'content' =>$this->renderPartial('_phoneNumbers', array('model'=>$model,'form'=>$form),true)),
                    array('label' => Yii::t('mx','Coordinates'),'content' =>$this->renderPartial('_coordinates', array('model'=>$model,'form'=>$form,'zones'=>$zones),true)),
                    array('label' => Yii::t('mx','Tax Information'),'content' =>$this->renderPartial('_taxInformation', array('model'=>$model,'form'=>$form),true)),
                    array('label' => Yii::t('mx','Home Address and branches'),'content' =>$this->renderPartial('_addresses', array('model'=>$model,'form'=>$form),true)),

                    array('label' => Yii::t('mx','Personal Information'),'content' =>$this->renderPartial('_personal', array('model'=>$model,'form'=>$form),true)),
                    array('label' => Yii::t('mx','Work Information'),'content' =>$this->renderPartial('_work', array('model'=>$model,'form'=>$form),true)),

                ),
            )
        );
    ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus' : 'icon-ok',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>






<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-zones')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-map-marker"></i> <?php echo Yii::t('mx','New Zone'); ?></h4>
</div>

<div class="modal-body"><?php echo $zones->render(); ?></div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>
