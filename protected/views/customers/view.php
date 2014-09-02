    <?php
$this->breadcrumbs=array(
        Yii::t('mx','Customers')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$model->id)),
        array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
    );


    $this->pageSubTitle=Yii::t('mx','View');
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

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Statistics'),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
    ));?>

        <?php echo $table; ?>

    <?php $this->endWidget();?>


    <?php $this->widget('bootstrap.widgets.TbDetailView',array(
            'data'=>$model,
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
                    'name'=>'international_code1',
                    'value'=>$model->international_code1." - ".$model->home_phone
                ),
                array(
                    'name'=>'international_code2',
                    'value'=>$model->international_code2." - ".$model->work_phone
                ),
                array(
                    'name'=>'international_code3',
                    'value'=>$model->international_code3." - ".$model->cell_phone
                ),
            ),
            )); ?>

    <fieldset>
        <legend><?php echo Yii::t('mx','Tax Information'); ?></legend>

            <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
                'id'=>'taxInformation-grid',
                'type' => 'hover condensed',
                'emptyText' => Yii::t('mx','There are no data to display'),
                'showTableOnEmpty' => false,
                'summaryText' => '<strong>'.Yii::t('mx','Tax Information').': {count}</strong>',
                'template' => '{items}{pager}',
                'responsiveTable' => true,
                'enablePagination'=>true,
                'dataProvider'=>$taxInformation,
                'columns'=>array(
                    'bill',
                    'rfc',
                    'company_name',

                    array(
                        'class'=>'bootstrap.widgets.TbButtonColumn',
                        'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                        'headerHtmlOptions' => array('style' => 'width:150px;'),
                        'header'=>Yii::t('mx','Actions'),
                        'template'=>'{view}{update}{delete}',
                        'buttons'=>array(

                            'view' => array(
                                'url'=>'Yii::app()->createUrl("taxInformation/view", array("id"=>$data->id))',
                                'options'=>array(
                                    'ajax'=>array(
                                        'type'=>'POST',
                                        'url'=>"js:$(this).attr('href')",
                                        'success'=>'function(data) {

                                                $("#taxInformation-modal .modal-body p").html(data);
                                                $("#taxInformation-modal").modal();

                                            }'
                                    ),
                                ),


                            ),

                            'update'=>array(
                                'url'=>'Yii::app()->createUrl("taxInformation/update", array("id"=>$data->id))',
                            ),
                            'delete'=>array(
                                'url'=>'Yii::app()->createUrl("taxInformation/delete", array("id"=>$data->id))',
                            )

                        )
                    ),
                ),
            ));

            ?>
    </fieldset>



    <?php $this->beginWidget('bootstrap.widgets.TbModal', array(
        'id' => 'taxInformation-modal',
        'autoOpen'=>false
    ));
    ?>

    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><?php echo Yii::t('mx','Tax Information'); ?></h4>
    </div>

    <div class="modal-body" id="messages">
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


