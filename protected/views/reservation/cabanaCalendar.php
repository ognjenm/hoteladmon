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
    //$cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_timeline.js');
    //$cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_treetimeline.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_pdf.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_active_links.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_tooltip.js');
    $cs->registerScriptFile($assets.'/ext/dhtmlxscheduler_limit.js');
    $cs->registerCssFile($assets.'/dhtmlxscheduler.css');
    $cs->registerCssFile($assets.'/dhtmlxscheduler_flat.css');


    $this->breadcrumbs=array(
        Yii::t('mx','Reservations')=>array('index'),
        Yii::t('mx','Manage'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx','Back'),'icon'=>'icon-chevron-left','url'=>array('/site/index')),
        array('label'=>Yii::t('mx','Reservation'),'icon'=>'icon-check','url'=>array('create')),
        array('label'=>Yii::t('mx','Daily Report'),'icon'=>'icon-calendar','url'=>array('dailyReport')),
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
            url: "<?php echo CController::createUrl('/reservation/scheduler_cabana_update'); ?>",
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


     var url = "<?php echo $this->createUrl('scheduler_cabana'); ?>";

     var total=0;
     var abono=0;
     var saldo=0;
     var customer=0;
     var aux=0;

     scheduler.templates.tooltip_date_format=scheduler.date.date_to_str("%Y-%m-%d %H:%i");
     scheduler.config.container_autoresize = true;
     scheduler.skin="flat";
     scheduler.config.xml_date="%Y-%m-%d %H:%i";
     scheduler.config.multi_day = true;
     scheduler.config.show_loading=true;
     scheduler.config.first_hour = 9;
     scheduler.config.time_step = 30;
     scheduler.config.dblclick_create = false;
     //scheduler.config.limit_time_select = true;
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


     $.ajax({
         url: "<?php echo CController::createUrl('/seasons/getSeasons'); ?>",
         dataType: "json",
         beforeSend: function() {}
     })

         .done(function(data) {

             if(data.ok==true){

                 data.seasons.forEach(function(item){

                     var anio=item.anio;
                     var mes=(item.mes-1);
                     var dia=item.dia;

                     var fecha=new Date(anio,mes,dia);
                     var commemoration=item.commemoration;

                     var options = {
                         //days: "fullweek",
                         start_date: fecha,
                         end_date: scheduler.date.add(fecha, 1, "day"),
                         //type: "default",
                         css: "holiday",
                         html: commemoration
                     };

                     scheduler.addMarkedTimespan(options);
                     //scheduler.markTimespan(options);

                 });
             }

         })

         .fail(function(data) { bootbox.alert(data); })
         .always(function() {});


     scheduler.init("scheduler_cabanas",null,"month");
     //scheduler.setLoadMode("month");
     scheduler.load(url,"json");
     scheduler.setCurrentView();






</script>






