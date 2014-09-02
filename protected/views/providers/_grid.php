<?php $provider = $model->search(); ?>
<div class="inner" id="providers-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Providers'),
        'headerIcon' => 'icon-th-list',
        'htmlOptions' => array('class'=>'bootstrap-widget-table'),
        'htmlContentOptions'=>array('class'=>'box-content nopadding'),
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'primary',
                'buttons' => array(
                    array('label' =>Yii::t('mx','Operations'), 'items' => $this->menu)
                )
            )
        )

    ));?>

    <?php

    $url=$this->createUrl('/providers/getProvider');
    $url2=$this->createUrl('/providers/getFullName');
    $url3=$this->createUrl('/providers/getSuffix');

    ?>

        <?php $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'providers-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','There are no data to display'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Providers').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$provider,
            'filter'=>$model,
            'afterAjaxUpdate'=>"function(id,data){
                jQuery('#company').autocomplete({'showAnim':'fold','source':'".$url."'});
                jQuery('#full_name2').autocomplete({'showAnim':'fold','source':'".$url2."'});
                jQuery('#suffix').autocomplete({'showAnim':'fold','source':'".$url3."'});

                $('.popover-examples a').popover({
                    trigger : 'hover',
                    placement : 'top',
                    html : true
                });

            }",
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
                'lastPageLabel'=>Yii::t('mx','Last'),
                'firstPageLabel'=>Yii::t('mx','First'),
                //'maxButtonCount'=>5
            ),
            'columns'=>array(
                array(
                    'name'=>'company',
                    'value'=>'$data->company!=null ? $data->company : Yii::t("mx","Not set")',
                    'filter'=> $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                        'name'=>'company',
                        'source'=>$this->createUrl('/providers/getProvider'),
                        'options' => array(
                            'showAnim'=>'fold',
                        ),
                        'htmlOptions' => array(),
                    ),true),
                ),

                array(
                    'name'=>'full_name2',
                    'value'=>'$data->getFull_Name()',
                    'filter'=> $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'full_name2',
                            'source'=>$this->createUrl('/providers/getFullName'),
                            'options' => array(
                                'showAnim'=>'fold',
                            ),
                            'htmlOptions' => array(),
                        ),true),
                ),

                array(
                    'name'=>'suffix',
                    'value'=>'$data->suffix!=null ? $data->suffix : Yii::t("mx","Not set")',
                    'filter'=> $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                            'name'=>'suffix',
                            'source'=>$this->createUrl('/providers/getSuffix'),
                            'options' => array(
                                'showAnim'=>'fold',
                            ),
                            'htmlOptions' => array(),
                        ),true),
                ),
                array
                (
                    'header'=>Yii::t('mx','Emails And Phones'),
                    'value'=>'Providers::popover($data->id)',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'width: 100px')
                ),
                //'telephone_work1',
                //'email_work',
                array(
                    'name'=>'url_work',
                    'value'=>'Providers::popoverUrl($data->url_work)',
                    'type'=>'raw',
                    'htmlOptions'=>array('style'=>'width: 100px')
                ),

                array(
                    'class'=>'bootstrap.widgets.TbButtonColumn',
                    'deleteConfirmation' =>Yii::t('mx','Do you really want to delete this item?'),
                    'headerHtmlOptions' => array('style' => 'width:150px;'),
                    'header'=>Yii::t('mx','Actions'),
                    'template'=>'{view}{update}{export}',
                    'buttons'=>array(
                            'export' => array(
                                'label'=>Yii::t('mx','Export'),
                                'icon'=>'icon-upload-alt',
                                'url'=>'Yii::app()->createUrl("providers/export", array("id"=>$data->id))',
                            ),
                    )
                ),
            ),
        ));
        ?>

    <?php $this->endWidget();?>


</div>