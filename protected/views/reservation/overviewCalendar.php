<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 7/01/14
 * Time: 12:05
 */
?>

<?php
    $dhtmlx=Yii::getPathOfAlias('ext.dhtmlx.scheduler.assets');
    $assets =Yii::app()->assetManager->publish($dhtmlx);
    $lenguaje=substr(Yii::app()->getLanguage(), 0, 2);

    $cs = Yii::app()->getClientScript();
    $cs->registerScriptFile($assets.'/dhtmlxscheduler.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_container_autoresize.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_agenda_view.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_minical.js');
    $cs->registerScriptFile($assets.'/locale/locale_'.$lenguaje.'.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_timeline.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_treetimeline.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_pdf.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_active_links.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_tooltip.js');
    $cs->registerCssFile($assets.'/dhtmlxscheduler.css');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_limit.js');
    $cs->registerCssFile($assets.'/dhtmlxscheduler_flat.css');

    $this->breadcrumbs=array(
        Yii::t('mx','Reservations')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('/site/index')),
        array('label'=>Yii::t('mx','Reservation'),'icon'=>'icon-check','url'=>array('create')),
        array('label'=>Yii::t('mx','Monthly report'),'icon'=>'icon-calendar','url'=>array('monthlyReport')),
    );

    $this->pageSubTitle=Yii::t('mx','Reservations');
    $this->pageIcon='icon-cogs';


    if(Yii::app()->user->hasFlash('success')):
        Yii::app()->user->setFlash('success', '<strong>done!</strong> '.Yii::app()->user->getFlash('success'));
    endif;

    $this->widget('bootstrap.widgets.TbAlert', array(
        'block'=>true,
        'fade'=>true,
        'closeText'=>'×',
        'alerts'=>array(
            'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'×'),
        ),
    ));

?>

<div class="well">
    <table border="0" cellpadding="1" cellspacing="1" style="width: 800px;">
        <tbody>
        <tr>
            <td><?php echo CHtml::checkBox('available',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_AVAILABLE"><?php echo Yii::t('mx','AVAILABLE'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('budget-submitted',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_BUDGET-SUBMITTED"><?php echo Yii::t('mx','BUDGET-SUBMITTED'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('pre-reserved',true,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_PRE-RESERVED"><?php echo Yii::t('mx','PRE-RESERVED'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('reserved-pending',true,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_RESERVED-PENDING"><?php echo Yii::t('mx','RESERVED-PENDING'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('reserved',true,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_RESERVED"><?php echo Yii::t('mx','RESERVED'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('canceled',true,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_CANCELLED"><?php echo Yii::t('mx','CANCELLED'); ?></span></span></td>
        </tr>
        <tr>
            <td><?php echo CHtml::checkBox('no-show',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_NO-SHOW"><?php echo Yii::t('mx','NO-SHOW'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('occupied',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_OCCUPIED"><?php echo Yii::t('mx','OCCUPIED'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('arrival',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_ARRIVAL"><?php echo Yii::t('mx','ARRIVAL'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('checkin',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_CHECKIN"><?php echo Yii::t('mx','CHECKIN'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('checkout',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_CHECKOUT"><?php echo Yii::t('mx','CHECKOUT'); ?></span></span></td>
            <td><?php echo CHtml::checkBox('dirty',false,array('onclick'=>'estatus()')); ?><span class="dhx_cal_event_line event_DIRTY"><?php echo Yii::t('mx','DIRTY'); ?></span></span></td>
        </tr>
        </tbody>
    </table>
</div>

<body onload="init();">
<div id="scheduler_here" class="dhx_cal_container" style='width:100%; height:100%;'>
    <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class='dhx_cal_export pdf' id='export_pdf' title='Export to PDF' onclick='scheduler.toPDF("<?php echo Yii::app()->baseUrl.'/scheduler-pdf/generate.php'; ?>", "fullcolor",false)'>&nbsp;</div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="timeline_tab" style="right:280px; width: 200px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
    </div>
    <div class="dhx_cal_header">
    </div>
    <div class="dhx_cal_data">
    </div>
</div>
</body>


<script type="text/javascript" charset="utf-8">

    function estatus()
    {
        var sList = "";

        $('input[type=checkbox]').each(function () {

            if(this.checked){
                var sThisVal=this.id;
                sList += (sList=="" ? sThisVal : "," + sThisVal);
            }

        });

        $.ajax({
            url: "<?php echo CController::createUrl('/reservation/schedulerOverview_update'); ?>",
            data: { estatus: sList },
            type: "POST",
            dataType: "json",
            beforeSend: function() {}
        })

            .done(function(data) {
                scheduler.clearAll();
                scheduler.parse(data.data,"json");
            })

            .fail(function(data) { bootbox.alert(data); })
            .always(function() { });

    }

        var rooms = <?php Rooms::model()->getRoomsJson(); ?>;
        var data = "<?php echo $this->createUrl('schedulerOverview'); ?>";
        var total=0;
        var abono=0;
        var saldo=0;
        var customer=0;
        var aux=0;

        scheduler.locale.labels.timeline_tab = "<?php echo Yii::t('mx','Calendar For Cabana'); ?>";
        scheduler.locale.labels.section_custom="Section";
        scheduler.config.details_on_create=true;
        scheduler.config.details_on_dblclick=true;
        scheduler.config.xml_date="%Y-%m-%d %H:%i";
        scheduler.config.multi_day = true;
        brief_mode = true;
        scheduler.config.active_link_view = "day";
        scheduler.skin="flat";

        scheduler.config.drag_resize= false;
        scheduler.config.drag_move = false;

        scheduler.createTimelineView({
            section_autoheight: false,
            name:	"timeline",
            x_unit:	"day",
            x_date:	"<a jump_to='"+"%d-%m-%Y %H:%i"+"' href='#'>"+"%d:%M"+"</a>",
            x_step:	1,
            x_size: 15,
            y_unit: rooms,
            y_property:	"section_id",
            render: "tree",
            folder_dy:20,
            dy:40
        });

        scheduler.attachEvent("onDblClick", function (id, e){});
        scheduler.attachEvent("onClick", function (id, e){

            $.ajax({
                url: "<?php echo CController::createUrl('/reservation/getCustomerId'); ?>",
                data: { idx: id },
                type: "POST",
                dataType: "json"
            })

            .done(function(data) { location.href='<?php echo $this->createUrl('/reservation/view')."&id="; ?>'+data.customerId; })
            .fail(function() { alert( "error" ); })

        });


        scheduler.templates.event_bar_text = function(start,end,ev){
            return ev.text+": "+ev.room;
        };

        scheduler.templates.event_class=function(start, end, event){
            if(event.statux) return "event_"+event.statux;
            return "";
        };

        scheduler.templates.tooltip_text = function(start, end,ev){

            aux=customer;
            customer=ev.customerReservationId;

            if(aux != customer){

                $.ajax({
                    url: "<?php echo CController::createUrl('/reservation/getInformation'); ?>",
                    data: { customerReservationId: ev.customerReservationId },
                    type: "POST",
                    dataType: "json",
                    beforeSend: function() {  }
                })

                    .done(function(data) {
                        total=data.total;
                        abono=data.abono;
                        saldo=data.saldo;
                    })

                    .fail(function(data) { alert(data); })
                    .always(function() { });

            }


            return  "<b>Cliente Id:</b> "+ev.customerReservationId+"<br/>" +
                    "<b>Cliente:</b> "+ev.text+"<br/>" +
                    "<b>Check In:</b> "+scheduler.templates.tooltip_date_format(start)+"<br/>" +
                    "<b>Check Out:</b> "+scheduler.templates.tooltip_date_format(end)+"<br/>" +
                    "<b>Total:</b>$"+total+"<br/>"+
                    "<b>Abono:</b>$"+abono+"<br/>"+
                    "<b>Saldo:</b>$"+saldo+"<br/>";
        };


        scheduler.init('scheduler_here',null,"timeline");
        scheduler.load(data,"json");
        //var dp = new dataProcessor(url);
        //dp.init(scheduler);


</script>






