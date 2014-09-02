
<?php
$this->breadcrumbs=array(
	'Pc Summary'=>array('index'),
	Yii::t('mx','Create'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
);

$this->pageSubTitle=Yii::t('mx','Create');
$this->pageIcon='icon-ok';

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-newPrice')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-user"></i> <?php echo Yii::t('mx','New Price'); ?></h4>
    </div>

    <div class="modal-body">
        <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
            'id'=>'pc-summary-form',
            'enableAjaxValidation'=>false,
            'type'=>'inline'
        )); ?>

        <?php echo CHtml::hiddenField('articleId',''); ?>

        <div class="input-prepend">
            <span class="add-on">$</span>
            <?php echo CHtml::textField('newPrice',''); ?>
        </div>


            <?php  $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'ajaxSubmit',
                'type'=>'primary',
                'icon'=>'icon-ok icon-white',
                'label'=>Yii::t('mx','Save'),
                'url'=>Yii::app()->createUrl('/articles/newPrice'),
                'ajaxOptions' => array(
                    'type'=>'POST',
                    'dataType'=>'json',
                    'beforeSend' => 'function() { $("#messages").addClass("saving"); }',
                    'complete' => 'function() { $("#messages").removeClass("saving"); }',
                    'success' =>'function(data){
                            if(data.ok==true){
                                $("#price").val($("#newPrice").val());
                                $("#modal-newPrice").modal("hide");
                            }
                        }',
                ),
            )); ?>


        <?php $this->endWidget(); ?>

    </div>

    <div class="modal-footer">

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Return'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>

    </div>
<?php $this->endWidget(); ?>