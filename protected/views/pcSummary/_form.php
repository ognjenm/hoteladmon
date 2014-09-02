<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'pc-summary-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

    <?php echo $form->errorSummary($model); ?>


    <?php echo $form->datepickerRow($model, 'datex',array(
        'placeholder'=>Yii::t('mx','Date'),
        'prepend'=>'<i class="icon-calendar"></i>',
        'options'=>array('format'=>'yyyy-mm-dd'),
    ));
    ?>

    <?php echo $form->textFieldRow($model,'n_invoice',array()); ?>

    <?php /*echo $form->select2Row($model, 'provider_id',
            array(
                'data' => Providers::model()->listAll(),
                'options' => array(
                    'placeholder' =>Yii::t('mx','Select'),
                    'allowClear' => true,
                ),
                'ajax' => array(
                    'type'=>'POST',
                    'data'=>array('providerId'=>'js:this.value'),
                    'url'=>Yii::app()->createUrl('articles/getArticles'),
                    'update'=>'#PcSummary_article_id'
                )
            )
        );*/

    ?>

    <?php echo $form->select2Row($model, 'article_id',
        array(
            'data' => Articles::model()->listAll(),
            'options' => array(
                'placeholder' =>Yii::t('mx','Select'),
                'allowClear' => true,
                //'width' => '40%',
            ),
            'ajax' => array(
                'url' => Yii::app()->createUrl('articles/getPrice'),
                'type'=>'POST',
                'dataType'=>'json',
                'data'=>array('articleId'=>'js:this.value'),
                //'beforeSend' => 'function() {  $("#messages").addClass("saving"); }',
                //'complete' => 'function() { $("#messages").removeClass("saving"); }',
                'success' =>'function(data){ $("#price").val(data.price); }',

            ),
        )
    );

    ?>


	<?php echo $form->textFieldRow($model,'price',array(
        //'class'=>'span5',
        'maxlength'=>10,
        'id'=>'price',
        'prepend'=>'$',
        'readonly'=>'readonly'
    )); ?>


    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'icon'=>'icon-ok icon-white',
        'label'=>Yii::t('mx','New Price'),
        'htmlOptions' => array(
            'data-toggle' => 'modal',
            'data-target' => '#modal-newPrice',
            'onclick'=>'$("#articleId").val($("#PcSummary_article_id").val())'
        ),
    )); ?>


    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'icon'=>$model->isNewRecord ? 'icon-plus icon-white' : 'icon-ok icon-white',
            'label'=>$model->isNewRecord ? Yii::t('mx','Create') : Yii::t('mx','Save'),
        )); ?>
    </div>


<?php $this->endWidget(); ?>
