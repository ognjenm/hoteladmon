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

?>

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

    <?php $this->widget('bootstrap.widgets.TbDetailView',array(
        'data'=>$customer,
        'attributes'=>array(
            'id',
            'email',
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
            'tableView'=>true,
            'tableHtmlOptions'=>array('class'=>'items table table-hover table-condensed'),
            'data' => $data,
            'hideCopyTemplate'=>true,
            'options'=>array('clearInputs'=>false),
            'jsAfterNewId' => MultiModelForm::afterNewIdDateTimePicker($formConfig['elements']['checkin']),
            'jsBeforeClone'=>$formConfig,
            'jsAfterNewId' => MultiModelForm::afterNewIdDateTimePicker($formConfig['elements']['checkout']),
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
            'url'=>Yii::app()->createUrl('/reservation/update'),
            'ajaxOptions' => array(
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
        'title' => Yii::t('mx', 'Reservations'),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'id'=>'ReservationEdit',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Edit'),
                'url'=>array('/customers/update','id'=>$customer->id),
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
                'id'=>'createBudget-button',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Create Budget'),
                'icon'=>'icon-th-list'
            ),
            array(
                'id'=>'createFormats-button',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Create Formats'),
                'icon'=>'icon-th-list'
            ),
          /*  array(
                'id'=>'payment-button',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Payments'),
                'icon'=>'icon-th-list'
            ),
            array(
                'id'=>'payment-button',
                'class' => 'bootstrap.widgets.TbButton',
                'type' => 'primary',
                'label'=>Yii::t('mx','Charges'),
                'icon'=>'icon-th-list'
            )*/

        )

    ));?>

            <?php
                if($customerReservation->see_discount==true) echo Yii::app()->quoteUtil->getTableCotizacion($model);
                if($customerReservation->see_discount==false) echo Yii::app()->quoteUtil->getCotizacionNoDiscount($model);
            ?>

    <?php $this->endWidget();?>
</div>


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
                'class'=>'span12'
            ));
    ?>

    <?php echo CHtml::label(Yii::t('mx','Respuesta al cliente'),'response'); ?>
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
        <?php //echo CHtml::label(Yii::t('mx','Format'),'format'); ?>
        <?php /*echo CHtml::dropDownList('formatId','',EmailFormats::model()->listAll(),
            array(
                'prompt'=>Yii::t('mx','Select'),
                'class'=>'span12'
            ));*/
        ?>

        <?php echo CHtml::label(Yii::t('mx','Respuesta al cliente'),'response'); ?>
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

    $this->widget('bootstrap.widgets.TbExtendedGridView',array(
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
                'value'=>'$data->users->username'
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
                'value'=>'$data->users->username'
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
                'value'=>'$data->users->username'
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


