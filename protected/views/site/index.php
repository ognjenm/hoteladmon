<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;

/*$this->breadcrumbs=array(
    Yii::t('mx','Home'),
);
*/

$this->pageSubTitle=Yii::t('mx','Dashboard');
$this->pageIcon='icon-home';
$url=$this->createUrl('/tasks/accept');

    Yii::app()->clientScript->registerScript('search', "

     $('#linkTask').click(function(){
        $('#modal-task').modal();
        return false;
     });

      $('#button-accept').click(function(){

        var tasksid=$.fn.yiiGridView.getChecked('task-grid','chk').toString();

        $.ajax({
            url:'$url',
            data: { id: tasksid  },
            dataType:'json',
            type: 'POST',
            beforeSend: function() { $('.modal-header').addClass('saving'); }
        })

        .done(function(data) {
            if(data.ok==true) window.location=data.redirect;
            else  bootbox.alert(data.message);
        })

        .fail(function() { bootbox.alert('Error');  })
        .always(function() { $('.modal-header').removeClass('saving'); });

     });

    ");

?>

<div class="row-fluid">
    <div class="span12">

        <ul class="tiles">

            <li class="blue">
                <a href="<?php echo $this->createUrl('/reservation/create'); ?>">
                    <span><i class="icon-ok"></i></span>
                    <span class='name'><?php echo Yii::t('mx','Booking'); ?></span>
                </a>
            </li>
            <li class="red">
                <a href="<?php echo $this->createUrl('/reservation'); ?>">
                    <span class='count'><i class="icon-th-list"></i></span>
                    <span class='name'><?php echo Yii::t('mx','Reservations'); ?></span>
                </a>
            </li>

            <?php if(Yii::app()->user->isSuperAdmin){ ?>

            <li class="darkblue">
                <a href="<?php echo $this->createUrl('/site/contact'); ?>">
                    <span><i class="icon-ok"></i></span>
                    <span class='name'>calculadora de pagos</span>
                </a>
            </li>

            <?php } ?>

            <?php $counttask=($dataProvider !=null ) ? $dataProvider->getItemCount() : 0; ?>



            <li class="teal">
                <a href="#" id="linkTask">
                    <span><i class="icon-th-list"></i><?php echo $counttask; ?></span>
                    <span class='name'><?php echo Yii::t('mx','New Task'); ?></span>
                </a>
            </li>

            <?php if(Yii::app()->user->isSuperAdmin){ ?>
            <li class="orange">
                <a href="<?php echo $this->createUrl('/settings/update',array('id'=>1)); ?>">
                    <span><i class="icon-cogs"></i></span>
                    <span class='name'><?php echo Yii::t('mx','Settings'); ?></span>
                </a>
            </li>
            <li class="brown long">
                    <a href="<?php echo $this->createUrl('/reservation/overviewCalendar'); ?>">
                        <span class='count'><i class="icon-calendar"></i></span>
                        <span class='name'><?php echo Yii::t('mx','Calendar Per Cabana'); ?></span>
                    </a>
            </li>
            <?php } ?>
            <li class="lime long">
                <a href="<?php echo $this->createUrl('/reservation/cabanaCalendar'); ?>">
                    <span class='count'><i class="icon-calendar"></i></span>
                    <span class='name'><?php echo Yii::t('mx','Traditional Calendar')." ".Yii::t('mx','Cabanas'); ?></span>
                </a>
            </li>
            <li class="green long">
                <a href="<?php echo $this->createUrl('/reservation/campedCalendar'); ?>">
                    <span class='count'><i class="icon-calendar"></i></span>
                    <span class='name'><?php echo Yii::t('mx','Traditional Calendar')." ".Yii::t('mx','Camped And Daypass'); ?></span>
                </a>
            </li>

            <li class="pink long">
                <a href="<?php echo $this->createUrl('/newCustomerInformation'); ?>">
                    <span><i class="icon-group"></i></i><?php echo $newCustomerInformation; ?></span>
                    <span class='name'><?php echo Yii::t('mx','New Customer Information'); ?></span>
                </a>
            </li>

            <li class="magenta">
                <a href="#">
                    <span><i class="icon-signout"></i></span>
                    <span class='name'><?php echo Yii::t('mx','Sign Out'); ?></span>
                </a>
            </li>

        </ul>
    </div>
</div>

<br>
<br>
<br>

<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id' => 'modal-task')); ?>
    <div class="modal-header">
        <a class="close" data-dismiss="modal">
            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/close_green.png'); ?>
        </a>
        <h4><i class="icon-th-list"></i> <?php echo Yii::t('mx','New Task'); ?></h4>
    </div>

    <div class="modal-body">
        <?php $this->widget('bootstrap.widgets.TbGridView',array(
            'id'=>'task-grid',
            'type' => 'hover condensed',
            'emptyText' => Yii::t('mx','No assigned tasks for today'),
            'showTableOnEmpty' => false,
            'summaryText' => '<strong>'.Yii::t('mx','Task').': {count}</strong>',
            'template' => '{items}{pager}',
            'responsiveTable' => true,
            'enablePagination'=>true,
            'dataProvider'=>$dataProvider,
            'selectableRows'=>2,
            'pager' => array(
                'class' => 'bootstrap.widgets.TbPager',
                'displayFirstAndLast' => true,
            ),
            'columns'=>array(
                array(
                    'id'=>'chk',
                    'class'=>'CCheckBoxColumn',
                ),
                array(
                    'name'=>Yii::t('mx','Task'),
                    'value'=>'$data["name"]'
                ),
                array(
                    'name'=>Yii::t('mx','Date Due'),
                    'value'=>'date("d-M-Y",strtotime($data["date_due"]))'
                ),
            ),
        ));
        ?>

    </div>

    <div class="modal-footer">

        <?php if($counttask==0){

        if(Yii::app()->user->isSuperAdmin){
            $this->widget('bootstrap.widgets.TbButton', array(
                'id'=>'button-ok',
                'buttonType'=>'linkButton',
                'type'=>'primary',
                'icon'=>'icon-ok',
                'label'=>Yii::t('mx','Accept'),
                'url'=>Yii::app()->createUrl("/tasks")
            ));
        }else{

            $this->widget('bootstrap.widgets.TbButton', array(
                'id'=>'button-ok',
                'buttonType'=>'linkButton',
                'type'=>'primary',
                'icon'=>'icon-ok',
                'label'=>Yii::t('mx','Accept'),
                'url'=>Yii::app()->createUrl("/tasks/myTasks")
            ));

        }

        }else {

            $this->widget('bootstrap.widgets.TbButton', array(
                'id'=>'button-accept',
                'buttonType'=>'button',
                'type'=>'primary',
                'icon'=>'icon-ok',
                'label'=>Yii::t('mx','Accept'),
            ));

        }
         ?>

        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'label' => Yii::t('mx','Return'),
            'url' => '#',
            'htmlOptions' => array('data-dismiss' => 'modal'),
        )); ?>

    </div>
<?php $this->endWidget(); ?>


