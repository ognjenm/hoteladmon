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
$cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_tooltip.js');
$cs->registerCssFile($assets.'/dhtmlxscheduler.css');

$this->breadcrumbs=array(
    Yii::t('mx','Reservations')=>array('index'),
    Yii::t('mx','Manage'),
);

$this->menu=array(
    array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('/site/index')),
    array('label'=>Yii::t('mx','Reservation'),'icon'=>'icon-check','url'=>array('create')),
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
<table border="0" cellpadding="1" cellspacing="1" style="width: 600px;">
    <caption><?php echo Yii::t('mx','Colores de estados'); ?></caption>
    <tbody>
    <tr>
        <td><span class="dhx_cal_event_line event_AVAILABLE"><?php echo Yii::t('mx','AVAILABLE'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:darkblue;"><?php echo Yii::t('mx','BUDGET-SUBMITED'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:orange;"><?php echo Yii::t('mx','PRE-RESERVED'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:limegreen;"><?php echo Yii::t('mx','RESERVED-PENDING'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:darkgreen;"><?php echo Yii::t('mx','RESERVED'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:#8b0000;"><?php echo Yii::t('mx','CANCELLED'); ?></span></span></td>
    </tr>
    <tr>
        <td><span style="color:#FFFFFF;"><span style="background-color:red;"><?php echo Yii::t('mx','NO-SHOW'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:green;"><?php echo Yii::t('mx','OCCUPIED'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:green;"><?php echo Yii::t('mx','ARRIVAL'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:green;"><?php echo Yii::t('mx','CHECKIN'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:dodgerblue;"><?php echo Yii::t('mx','CHECKOUT'); ?></span></span></td>
        <td><span style="color:#FFFFFF;"><span style="background-color:red;"><?php echo Yii::t('mx','DIRTY'); ?></span></span></td>
    </tr>
    </tbody>
</table>


<div id="scheduler_cabanas" class="dhx_cal_container" style='width:100%; height:450px;'>
    <div class="dhx_cal_navline">
        <div class="dhx_cal_prev_button">&nbsp;</div>
        <div class="dhx_cal_next_button">&nbsp;</div>
        <div class="dhx_cal_today_button"></div>
        <div class="dhx_cal_date"></div>
        <div class="dhx_cal_tab" name="day_tab" style="right:204px;"></div>
        <div class="dhx_cal_tab" name="week_tab" style="right:140px;"></div>
        <div class="dhx_cal_tab" name="agenda_tab" style="right:280px;"></div>
        <div class="dhx_cal_tab" name="month_tab" style="right:76px;"></div>
    </div>
    <div class="dhx_cal_header"></div>
    <div class="dhx_cal_data"></div>
</div>

<script type="text/javascript" charset="utf-8">

    var url = "<?php echo $this->createUrl('scheduler_cabana'); ?>";

    scheduler.config.container_autoresize = true;
    scheduler.config.xml_date="%Y-%m-%d %H:%i";
    scheduler.config.multi_day = true;
    scheduler.config.show_loading=true;
    scheduler.config.touch = "force";
    scheduler.config.first_hour = 9;
    scheduler.config.time_step = 30;
    scheduler.config.dblclick_create = false;
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
     return "<b>Tipo de reservacion:</b> "+ev.type_reservation+"<br/><b>Check In:</b> "+scheduler.templates.tooltip_date_format(start)+"<br/><b>Check Out:</b> "+scheduler.templates.tooltip_date_format(end);
    };

    scheduler.init("scheduler_cabanas",null,"month");
    scheduler.load(url);


</script>






