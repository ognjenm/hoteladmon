<?php


    Yii::app()->clientScript->registerScript('search', "

          $('#payment-button').click(function(){
                $('#payment-modal').modal();
                return false;
          });

          $('#history-button').click(function(){
                $('#customerHistory').modal();
                return false;
          });


          $('#createFormats-button').click(function(){
                $('#createFormats').modal();
                return false;
          });


          $('#createBudget-button').click(function(){
                $('#createBudget').modal();
                return false;
          });

          $('#CustomerEdit-button').click(function(){
                $('#CustomerEdit').modal();
                return false;
          });

          $('#CustomerCreated-button').click(function(){
                $('#CustomerCreated').modal();
                return false;
          });

         $('#ReservationEdit').click(function(){
                $('.update').toggle();
                $('#tablas').hide();
                return false;
         });

         $('#Reservation-History-Button').click(function(){
                $('#Reservation-History-modal').modal();
                return false;
         });

          $('#Reservation-Create-Button').click(function(){
                $('#Reservation-Create-Modal').modal();
                return false;
         });


         $('#cancel-button').click(function(){
                $('.update').hide();
                $('#tablas').toggle();
                return false;
         });

    ");

    $this->breadcrumbs=array(
        Yii::t('mx','Reservations')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),

    );

    $this->pageSubTitle=Yii::t('mx','View');
    $this->pageIcon='icon-list-alt';

    echo CHtml::script('function alertIds(newElem,sourceElem){
            var newOption=newElem.attr("id");
            $("#"+newOption).prop("selectedIndex",0);
        }'
    );

?>

<div class="row-fluid">
    <div class="span6">

        <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'Customer'),
            'headerIcon' => 'icon-user',
            'htmlOptions' => array('class'=>'bootstrap-widget-table'),
            'htmlContentOptions'=>array('class'=>'box-content nopadding'),
            'headerButtons' => array(
                array(
                    'id'=>'CustomerEdit-button',
                    'class' => 'bootstrap.widgets.TbButton',
                    'type' => 'primary',
                    'label'=>Yii::t('mx','Edit'),
                    //'url'=>array('/customers/update','id'=>$customer->id),
                    'icon'=>'icon-edit'
                ),
                array(
                    'id'=>'history-button',
                    'class' =>'bootstrap.widgets.TbButton',
                    'type' =>'primary',
                    'label'=>Yii::t('mx','History'),
                    'url'=>'',
                    'icon'=>'icon-th-list'
                )
            )

        ));?>

        <?php   $this->widget('bootstrap.widgets.TbDetailView',array(
                'data'=>$customer,
                'attributes'=>array(
                    'id',
                    'email',
                    'alternative_email',
                    'first_name',
                    'last_name',
                    'country',
                    'state',
                    'city',
                    array(
                        'name'=>Yii::t('mx','Home Phone'),
                        'value'=>$customer->international_code1.' '.$customer->home_phone
                    ),
                    array(
                        'name'=>Yii::t('mx','Work Phone'),
                        'value'=>$customer->international_code2.' '.$customer->work_phone
                    ),
                    array(
                        'name'=>Yii::t('mx','Cell Phone'),
                        'value'=>$customer->international_code3.' '.$customer->cell_phone
                    ),
                ),
            ));

        ?>

        <?php $this->endWidget();?>
    </div>
    <div class="span6">

     <?php if($poll){ ?>
        <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'Sales Agents'),
            'headerIcon' => 'icon-user',
            'htmlOptions' => array('class'=>'bootstrap-widget-table'),
            'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        ));?>

        <?php $this->widget('bootstrap.widgets.TbDetailView',array(
                'data'=>$poll,
                'attributes'=>array(
                    'medio',
                    array(
                        'name'=>Yii::t('mx','Sales Agent'),
                        'value'=>($poll->sales_agent_id !='') ? $poll->salesAgent->name :  $poll->reservationChannel->name
                    ),
                    array(
                        'name'=>Yii::t('mx','Commission'),
                        'value'=>($poll->sales_agent_id !='') ? $poll->salesAgent->commission.'%' : $poll->reservationChannel->commission.'%'
                    )
                ),
            ));
        ?>

        <?php $this->endWidget();?>
        <?php } ?>
        
    </div>
</div>


<div class="update" style="display: none">

    <?php echo $form->renderBegin();

    $formConfig=Reservation::model()->getFormUpdate();
    $data=$reservation->findAll('customer_reservation_id=:groupId', array(':groupId'=>$customerReservation->id));

    $this->widget('ext.multimodelform.MultiModelForm',array(
            'id' => 'id_member',
            'formConfig' =>$formConfig,
            'model' =>$reservation,
            'tableView' => true,
            'validatedItems' => $validatedItems,
            'removeText' =>Yii::t('mx','Remove'),
            'removeConfirm'=>Yii::t('mx','Delete this item?'),
            'addItemText'=>Yii::t('mx','Add'),
            'addItemAsButton'=>true,
            'tableView'=>true,
            'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
            'data' => $data,
            'hideCopyTemplate'=>true,
            'clearInputs'=>false,
            //'options'=>array('clearInputs'=>false),
            'jsAfterNewId' => MultiModelForm::afterNewIdDateTimePicker($formConfig['elements']['checkin'],$formConfig['elements']['checkout']),
            'jsAfterCloneCallback'=>'alertIds'
        ));
    ?>

    <?php echo CHtml::label(Yii::t('mx','Why customer requested this change?'),'because') ?>
    <?php echo CHtml::textArea('because','',array('class'=>'span12')); ?>
    <span class="help-block error" id="required-because" style="display: none;"><?php echo Yii::t('mx','This Field Cannot Be Blank'); ?></span>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'ajaxSubmit',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>Yii::t('mx','Save'),
            'icon'=>'icon-money',
            'url'=>Yii::app()->createUrl('/reservation/update',array('customerReservationId'=>$customerReservation->id)),
            'ajaxOptions' => array(
                'type'=>'post',
                'dataType'=>'json',
                'beforeSend' => 'function() {$(".update").addClass("saving");  }',
                'complete' => 'function() { $(".update").removeClass("saving"); }',
                'success' =>'function(data){
                            if(data.ok==true) window.location.reload();
                            else $("#required-because").show();
                }',
            ),
        )); ?>

        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'id'=>'cancel-button',
            'type'=>'primary',
            'encodeLabel'=>false,
            'label'=>Yii::t('mx','Cancel'),

        )); ?>

    </div>


     <?php echo $form->renderEnd(); ?>


</div>

<div class="newTable"></div>

<div id="tablas">
    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Reservation Id').': '.$customerReservation->id,
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'id'=>'ReservationEdit',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Edit'),
                //'url'=>array('/customers/update','id'=>$customer->id),
                'icon'=>'icon-edit'
            ),
            array(
                'id'=>'Reservation-History-Button',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','History'),
                'url'=>'',
                'icon'=>'icon-th-list'
            ),

            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'primary',
                'buttons' => array(
                    array('label' => Yii::t('mx','Operations'), 'url' => '#'),
                    array(
                        'items' => array(
                            array('label' => Yii::t('mx','Create Budget'), 'url' => '#',
                                'linkOptions' => array(
                                    'id'=>'createBudget-button',
                                ),
                            ),
                            '---',
                            array('label' => Yii::t('mx','Create Formats'), 'url' => '#',
                                'linkOptions' => array(
                                    'id'=>'createFormats-button',
                                ),
                            ),
                            '---',
                            array('label' => Yii::t('mx','Charges And Payments'), 'url' => array('/payments/index','id'=>$customerReservation->id)),
                        )
                    ),
                )
            ),
        )

    ));?>
            <?php
                if($customerReservation->see_discount==true) echo Yii::app()->quoteUtil->getTableCotizacion($model,true);  //true habilita el renglon de estatus
                if($customerReservation->see_discount==false) echo Yii::app()->quoteUtil->getCotizacionNoDiscount($model,true); //true habilita el renglon de estatus
            ?>

    <?php $this->endWidget();?>
</div>



<?php

    if($activities){

        $this->beginWidget('bootstrap.widgets.TbBox', array(
            'title' => Yii::t('mx', 'ACTIVITIES,PACKAGES,FOOD AND OTHERS'),
            'headerIcon' => 'icon-user',
            'htmlOptions' => array('class'=>'bootstrap-widget-table'),
            'htmlContentOptions'=>array('class'=>'box-content nopadding'),
            'headerButtons' => array(
                array(
                    'id'=>'buttonReportSupplier',
                    'class' => 'bootstrap.widgets.TbButton',
                    'type' => 'primary',
                    'label'=>Yii::t('mx','Report Supplier'),
                    'icon'=>'icon-edit',
                    'htmlOptions' => array(
                        'data-toggle' => 'modal',
                        'data-target' => '#reportActivitiesModal',
                    ),
                ),
            )
        ));

            echo $activities;

        $this->endWidget();
    }


?>



<!-- Formulario para envio de formatos !-->


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'createFormats')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Create Formats'); ?></h4>
</div>

<div class="modal-body">
    <?php $form2=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'response-form',
        'enableAjaxValidation'=>false,
        'action'=>array('/reservation/emailFormats','id'=>$customerReservation->id)
    )); ?>
    <?php echo CHtml::label(Yii::t('mx','Format'),'format'); ?>
    <?php echo CHtml::dropDownList('formatId','',EmailFormats::model()->listAll(),
            array(
                'prompt'=>Yii::t('mx','Select'),
                'class'=>'span12',
                'onchange'=>'
                    if($(this).val()==1){
                        $("#divbank").show();
                    }else{
                        $("#divbank").hide();
                    }
                '
            ));
    ?>


    <div id="divbank" style="display: none">
        <?php echo CHtml::label(Yii::t('mx','Bank'),'bank'); ?>
        <?php echo CHtml::dropDownList('bankId','',BankAccounts::model()->listAll(),
            array(
                'prompt'=>Yii::t('mx','Select'),
                'class'=>'span12',
            ));
        ?>
    </div>

    <?php echo CHtml::label(Yii::t('mx','Space to answer customer questions'),'response'); ?>
    <?php echo CHtml::textArea('response','',array('rows'=>5,'class'=>'span12')); ?>

    <div class="form-actions">
        <?php  $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'label'=>Yii::t('mx','Create'),
            'type' => 'primary',
            'icon'=>'icon-ok',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>
</div>

<div class="modal-footer">


    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>


<!-- Formulario para la cotizacion !-->


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'createBudget')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Create Budget'); ?></h4>
</div>

<div class="modal-body">
    <?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
        'id'=>'response-form',
        'enableAjaxValidation'=>false,
        'action'=>array('/reservation/budget','id'=>$customerReservation->id)
    )); ?>

        <?php echo CHtml::hiddenField('formatId',2); ?>
        <?php //echo CHtml::label(Yii::t('mx','Format'),'format'); ?>
        <?php /*echo CHtml::dropDownList('formatId','',EmailFormats::model()->listAll(),
            array(
                'prompt'=>Yii::t('mx','Select'),
                'class'=>'span12'
            ));*/
        ?>

        <?php echo CHtml::label(Yii::t('mx','Space to answer customer questions'),'response'); ?>
        <?php echo CHtml::textArea('response','',array('rows'=>5,'class'=>'span12')); ?>

        <div class="form-actions">
            <?php  $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType'=>'submit',
                'label'=>Yii::t('mx','Create'),
                'type' => 'primary',
                'icon'=>'icon-ok',
            )); ?>
        </div>

    <?php $this->endWidget(); ?>
</div>

<div class="modal-footer">


    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>

<!-- Formulario para editar el cliente !-->


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'CustomerEdit')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Customer Edit'); ?></h4>
</div>

<div id="messages-customer" class="modal-body">
    <?php echo $this->renderPartial('_customer', array('customerForm'=>$customerForm,'action'=>'UPDATE'),true) ?>
</div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>


<!-- aqui empieda el historial del cliente !-->


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'customerHistory')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Customer History'); ?></h4>
</div>

<div class="modal-body">
    <?php

    $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id'=>'Customer-History',
        'type' => 'hover condensed striped',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Customer History').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$customerHistory,
        'columns'=>array(
            'field',
            'old_value',
            'new_value',
            'stamp',
            array(
                'name'=>'user_id',
                'value'=>'$data->users->username'
            ),
        ),
    ));
    ?>
</div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'id'=>'CustomerCreated-button',
        'encodeLabel'=>false,
        'label'=>Yii::t('mx','First Contact'),

    ));  ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>


<!-- aqui empieda el modal de creacion del cliente !-->


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'CustomerCreated')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','First Contact'); ?></h4>
</div>

<div class="modal-body">
    <?php

    $this->widget('bootstrap.widgets.TbGridView',array(
        'id'=>'First-Contact',
        'type' => 'hover condensed striped',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','First Contact').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$customerCreated,
        'columns'=>array(
            'field',
            'new_value',
            'stamp',
            array(
                'name'=>'user_id',
                'value'=>'$data->users["username"]'
            ),
        ),
    ));
    ?>
</div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>

</div>
<?php $this->endWidget(); ?>

<!-- aqui empieda el historial de reservacion !-->


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'Reservation-History-modal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Reservation History'); ?></h4>
</div>

<div class="modal-body">

    <?php

   $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id'=>'reservation-History',
        'type' => 'hover condensed striped',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','History').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$reservationHistory,
        'rowCssClassExpression'=>'$data->color',
        'columns'=>array(
            'field',
            'old_value',
            'new_value',
            'stamp',
            array(
                'name'=>'user_id',
                'value'=>'$data->users["username"]'
            ),
        ),
    ));
    ?>
</div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'id'=>'Reservation-Create-Button',
        'encodeLabel'=>false,
        'label'=>Yii::t('mx','Created'),

    ));  ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>


</div>
<?php $this->endWidget(); ?>


<!-- aqui empieda la parte cuando fue creado por primera vez la reservacion !-->



<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'Reservation-Create-Modal')); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">
        <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
    </a>
    <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Created'); ?></h4>
</div>

<div class="modal-body">

    <?php

    $this->widget('bootstrap.widgets.TbExtendedGridView',array(
        'id'=>'reservation-Created',
        'type' => 'hover condensed striped',
        'emptyText' => Yii::t('mx','There are no data to display'),
        'showTableOnEmpty' => false,
        'summaryText' => '<strong>'.Yii::t('mx','Created').': {count}</strong>',
        'template' => '{items}{pager}',
        'responsiveTable' => true,
        'enablePagination'=>true,
        'dataProvider'=>$reservationCreate,
        'columns'=>array(
            'field',
            'old_value',
            'new_value',
            'stamp',
            array(
                'name'=>'user_id',
                'value'=>'$data->users["username"]'
            ),
        ),
    ));
    ?>

</div>

<div class="modal-footer">

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label' => Yii::t('mx','Return'),
        'url' => '#',
        'htmlOptions' => array('data-dismiss' => 'modal'),
    )); ?>


</div>
<?php $this->endWidget(); ?>




<?php $this->beginWidget('bootstrap.widgets.TbModal', array(
    'id' => 'reportActivitiesModal',
    'htmlOptions' => array('style' => 'width: 650px;')
)); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-user"></i> <?php echo Yii::t('mx','Report Supplier'); ?></h4>
    </div>

    <div class="modal-body">
        <?php $this->widget('bootstrap.widgets.TbCKEditor',array(
                'name'=>'ckeditor',
                'value'=>$reportSupplier,
                'editorOptions'=>array(
                    'contentsCss'=> Yii::app()->theme->baseUrl.'/css/table.css',
                    'toolbar'=>"js:[
                        { name: 'document',     items: ['Print'] },
                        { name: 'clipboard',    items: [ 'Cut', 'Copy', 'Paste'] },
                        { name: 'editing',      items: ['SelectAll'] },
                        { name: 'basicstyles',  items: [ 'Bold', 'Italic', 'Underline'] },
                        { name: 'paragraph',    items: [ 'NumberedList', 'BulletedList', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                        { name: 'insert',       items: [ 'Table'] },
                        { name: 'styles',       items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                        { name: 'tools',        items: [ 'Maximize'] },

                    ]"
                ),
            ));
        ?>
    </div>

    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Return'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>
    </div>
<?php $this->endWidget(); ?>

