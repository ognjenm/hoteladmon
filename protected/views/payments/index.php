    <?php
$this->breadcrumbs=array(
        Yii::t('mx','Payments')=>array('index','id'=>$id),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('/reservation')),
        //array('label'=>Yii::t('mx','Payment'),'icon'=>'icon-plus','url'=>'#',),
        //array('label'=>Yii::t('mx','Charges'),'icon'=>'icon-minus','url'=>array('/charges/create','id'=>$id)),
    );

    $this->pageSubTitle=Yii::t('mx','Manage');
    $this->pageIcon='icon-cogs';

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


 <?php $this->renderPartial('_grid', array(
        'gridPayments' => $gridPayments,
        'customer'=>$customer,
        'gridCharges'=>$gridCharges,
        'totalcharges'=>$totalcharges,
        'totalpayments'=>$totalpayments,
        'importe'=>$importe,
    ));
 ?>



    <!-- Formulario para envio de pagos !-->


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array(
        'id' => 'payment-modal',
        'autoOpen'=>false
    ));
    ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><?php echo Yii::t('mx','Payments'); ?></h4>
    </div>

    <div class="modal-body" id="messages">
        <?php echo $formPayments->render(); ?>
    </div>

    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Cancel'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>
    </div>

    <?php $this->endWidget(); ?>



    <!-- Formulario para envio de cargos !-->


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array(
        'id' => 'charge-modal',
        'autoOpen'=>false
    ));
    ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><?php echo Yii::t('mx','Charges'); ?></h4>
    </div>

    <div class="modal-body" id="charges-messages">
        <?php echo $formCharges->render(); ?>
    </div>

    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Cancel'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>
    </div>

    <?php $this->endWidget(); ?>




    <!-- Formulario para mostrar detalles !-->


    <?php $this->beginWidget('bootstrap.widgets.TbModal', array(
        'id' => 'detail-modal',
        'autoOpen'=>false
    ));
    ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><?php echo Yii::t('mx','Details'); ?></h4>
    </div>

    <div class="modal-body" id="charges-messages">
    <p></p>
    </div>

    <div class="modal-footer">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Cancel'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>
    </div>

    <?php $this->endWidget(); ?>











