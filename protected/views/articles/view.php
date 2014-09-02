    <?php

    $this->breadcrumbs=array(
        Yii::t('mx','Articles')=>array('index'),
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

    <div class="row-fluid">
        <div class="span6">
            <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
                'title' => Yii::t('mx', 'Details'),
                'headerIcon' => 'icon-th-list',
                'htmlOptions' => array('class'=>'bootstrap-widget-table'),
                'htmlContentOptions'=>array('class'=>'box-content nopadding'),
            ));
            ?>


            <div class="span-12">
                <div class="thumbnail">
                    <?php
                    if($model->image !=null){
                        echo CHtml::image(Yii::app()->baseUrl."/images/articles/".$model->image,$model->name_article,array('width'=>'200px','height'=>'300px'));
                    }else{
                        echo CHtml::image(Yii::app()->baseUrl."/images/articles/noImageAvailable.jpg",Yii::t('mx','Image No available'),array('width'=>'200px','height'=>'300px'));
                    }

                    ?>
                </div>
            </div>

            <?php $this->widget('bootstrap.widgets.TbDetailView',array(
                'data'=>$model,
                'attributes'=>array(
                    'id',
                    array(
                        'name'=> 'provider_id',
                        'value'=>$model->provider->company
                    ),
                    'name_article',
                    'name_store',
                    'name_invoice',
                    'code',
                    'code_store',
                    'code_invoice',
                    'quantity',
                    array(
                        'name'=>'unit_measure_id',
                        'value'=>$model->unitmeasure->unit
                    ),
                    'measure',
                    'price',
                    'unit_price',
                    'date_price',
                    'presentation',
                    'color',
                    'barcode',
                ),
            )); ?>

            <?php $this->endWidget();?>
        </div>
        <div class="span6">
            <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
                'title' => Yii::t('mx', 'Invoices'),
                'headerIcon' => 'icon-th-list',
                'htmlOptions' => array('class'=>'bootstrap-widget-table'),
                'htmlContentOptions'=>array('class'=>'box-content nopadding'),
            ));
            ?>
                    <?php $this->widget('bootstrap.widgets.TbExtendedGridView',array(
                        'id'=>'banks-grid',
                        'type' => 'hover condensed',
                        'emptyText' => Yii::t('mx','There are no data to display'),
                        'showTableOnEmpty' => false,
                        'summaryText' => '<strong>'.Yii::t('mx','Banks').': {count}</strong>',
                        'template' => '{items}{pager}',
                        'responsiveTable' => true,
                        'enablePagination'=>true,
                        'dataProvider'=>$provider,
                        'columns'=>array(
                            'datex',
                            'n_invoice',
                            array(
                                'class'=>'bootstrap.widgets.TbButtonColumn',
                                'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                                'headerHtmlOptions' => array('style' => 'width:150px;'),
                                'header'=>Yii::t('mx','Actions'),
                                'template'=>'{view}',
                                'buttons'=>array(
                                    'view'=>array(
                                        'label'=>Yii::t('mx','View'),
                                        'icon'=>'icon-eye-open',
                                        'url'=>'Yii::app()->createUrl("/directInvoice/view", array("id"=>$data->id))'
                                    ),
                                )
                            ),
                        ),
                    ));
                    ?>
            <?php $this->endWidget();?>

        </div>
    </div>


