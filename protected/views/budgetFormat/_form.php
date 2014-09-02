<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'budget-format-form',
	'enableAjaxValidation'=>false,
)); ?>


<?php

$pricesForm = array(

    'elements'=>array(
        'orden'=>array(
            'type'=>'text',
            'label'=>Yii::t('mx','Order'),
            'class'=>'span3'
        ),
        'name'=>array(
            'type'=>'dropdownlist',
            'label'=>Yii::t('mx','Name'),
            'items'=>Policies::model()->listAll(),
            'prompt'=>Yii::t('mx','Select'),
        ),
    ));

?>


    <p class="help-block"><?php echo Yii::t('mx','Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('mx','are required');?>.
    </p>

	<?php echo $form->errorSummary($model); ?>

    <?php echo $form->dropDownListRow($model,'budget',Rates::model()->listServiceType(),array(
        'class'=>'span5',
        'maxlength'=>150,
        'prompt'=>Yii::t('mx','Select'),
    ));
    ?>


    <?php 	$this->widget('ext.multimodelform.MultiModelForm',array(
        'id' => 'id_member',
        'formConfig' => $pricesForm,
        'model' =>$items,
        'tableView' => true,
        'validatedItems' => $validatedMembers,
        'removeText' =>Yii::t('mx','Remove'),
        'removeConfirm'=>Yii::t('mx','Delete this item?'),
        'addItemText'=>Yii::t('mx','Add Item'),
        //'tableView'=>true,
        'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
        'data' => $items->findAll('budget_format_id=:groupId', array(':groupId'=>$model->id)),
        'showErrorSummary'=>true
    ));
    ?>

    <?php

   /* echo $form->select2Row($model, 'policies', array(
        'asDropDownList' => false,
        'data' => Policies::model()->listAll(),
        'options' => array(
            'multiple'=>true,
            'tags'=>'['.$model->policies.']',
            'placeholder' => "select",
            'width' => '100%',
            'closeOnSelect' => true,
            //'onSortStart'=>true,
            //'minimumInputLength'=>1,
            'initSelection' => "js:function (element, callback) {
                            var data = [];
                            $(element.val().split(',')).each(function () {
                                data.push({id: this, text: this});
                            });
                            callback(data);
                        }",
            'ajax' => array(
                'url' => Yii::app()->createUrl('policies/getData'),
                'dataType' => 'json',
                'data' => 'js:function(term,page) { if(term && term.length){ return { zustelladresse: term };} }',
                'results' => 'js:function(data,page) { return {results: data}; }',
            ),

        )));
*/

   /* $this->widget('bootstrap.widgets.TbSelect2',array(
            'id'=>'politicass',
            'model'=>$model,
            'attribute'=>'policies',
            'val' =>'['.$model->policies.']',
            'data' => Policies::model()->listAll(),
            'asDropDownList' => true,
            'options' => array(
                'tokenSeparators' => array(',', ' '),
                'width'=>'100%',
            ),
            'events'=>array(
                'sortable'=> array(
                    'containment'=> 'parent',
                    'start'=> 'function() { $("#politicass").select2("onSortStart"); }',
                    'update'=> 'function() { $("#politicass").select2("onSortEnd"); }'
                ),
            ),
            'htmlOptions' => array(
                'multiple' => 'multiple',
                'placeholder' => Yii::t('mx','Select'),
            ),
        )
    );
*/

    ?>

<div class="form-actions">
    <?php  $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'=>'submit',
        'type'=>'primary',
        'encodeLabel'=>false,
        'label'=>$model->isNewRecord ? '<i class="icon-plus icon-white"></i> '.Yii::t('mx','Create') : '<i class="icon-ok icon-white"></i> '.Yii::t('mx','Save'),
    )); ?>
</div>


<?php $this->endWidget(); ?>
