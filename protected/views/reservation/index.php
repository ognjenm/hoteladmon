<?php
/**
 * Created by chinux.
 * Email: chinuxe@gmail.com
 * Date: 9/23/13
 * Time: 2:42 PM
 */
?>



<?php
$this->breadcrumbs=array(
    Yii::t('mx','Reservations')=>array('index'),
    Yii::t('mx','Manage'),
);

$this->menu=array(
    array('label'=>Yii::t('mx', 'Refresh'),'icon'=>'icon-refresh','url'=>array('index')),
    array('label'=>Yii::t('mx','Reservation'),'icon'=>'icon-check','url'=>array('create')),
    //array('label'=>Yii::t('mx', 'Traditional Calendar'),'icon'=>'icon-calendar','url'=>array('cabanaCalendar')),
    //array('label'=>Yii::t('mx', 'Camped calendar and day pass'),'icon'=>'icon-calendar','url'=>array('campedCalendar')),
    //array('label'=>Yii::t('mx', 'Calendar Per Cabana'),'icon'=>'icon-calendar','url'=>array('overviewCalendar')),
    array('label'=>Yii::t('mx', 'Export To Pdf'),'icon'=>'icon-file','url'=>array('exportPdf')),

);

$this->pageSubTitle=Yii::t('mx','Manage');
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

Yii::app()->clientScript->registerScript('search', "

    $('#filterForm').submit(function(){
        $('#reservations-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });

     $('#filter-button').click(function(){
            $('.filter').toggle();
            return false;
     });

     /*$('#linkpayment').click(function(){
            $('#payment-modal').modal();
            return false;
     });*/

    $('.filters').hide();


");

?>

<?php

$this->renderPartial('_reservations', array(
    'customers' => $customers,
    'formFilter'=>$formFilter,
));

?>


<script type="text/javascript" charset="utf-8">

    jQuery('#Payments_datex').datepicker({'format':'yyyy-M-dd','autoclose':true,'showAnim':'fold','language':'es','weekStart':0});


    var url = "<?php echo $this->createUrl('payments/create'); ?>";

    function payments(id){

        $.ajax({
            url: url,
            data: { reservation_id: id  },
            type: "POST",
            beforeSend: function() {
                $("#maindiv").addClass("loading");
            }
        })
        .done(function(data) {$("#payment-modal .modal-body p").html(data); $("#payment-modal").modal(); })
        .fail(function() { alert( "error" ); })
        .always(function() {$("#maindiv").removeClass("loading"); });
    }

    function charges(id){
        $.ajax({
            url: url,
            data: { customer_reservation_id: id  },
            type: "POST",
            beforeSend: function() {
                $("#maindiv").addClass("loading");
            }
        })

            .done(function(data) {$("#payment-modal .modal-body p").html(data); $("#payment-modal").modal(); })
            .fail(function() { alert( "error" ); })
            .always(function() {$("#maindiv").removeClass("loading"); });
    }


</script>




