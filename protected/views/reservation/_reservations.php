<?php
/**
 * Created by chinux.
 * Email: chinuxe@gmail.com
 * Date: 9/23/13
 * Time: 2:43 PM
 */
 ?>

<style type="text/css">
    /*<![CDATA[*/
    @media
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

        /* Force table to not be like tables anymore */
        #reservations-grid table,#reservations-grid thead,#reservations-grid tbody,#reservations-grid th,#reservations-grid td,#reservations-grid tr {
            display: block;
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        #reservations-grid thead tr {
            position: absolute;
            top: -9999px;
            left: -9999px;
        }

        #reservations-grid tr { border: 1px solid #ccc; }

        #reservations-grid td {
            /* Behave  like a "row" */
            border: none;
            border-bottom: 1px solid #eee;
            position: relative;
            padding-left: 50%;
        }

        #reservations-grid td:before {
            /* Now like a table header */
            position: absolute;
            /* Top/left values mimic padding */
            top: 6px;
            left: 6px;
            width: 45%;
            padding-right: 10px;
            white-space: nowrap;
        }
        .grid-view .button-column {
            text-align: left;
            width:auto;
        }
        /*
        Label the data
        */

       #reservations-grid td:nth-of-type(1):before { content: 'Cabaña'; }
        #reservations-grid td:nth-of-type(2):before { content: 'Fecha Entrada'; }
        #reservations-grid td:nth-of-type(3):before { content: 'Hora De Entrada'; }
        #reservations-grid td:nth-of-type(4):before { content: 'Fecha Salida'; }
        #reservations-grid td:nth-of-type(5):before { content: 'Hora De Salida'; }
        #reservations-grid td:nth-of-type(6):before { content: 'Estado'; }
        #reservations-grid td:nth-of-type(7):before { content: 'Adultos'; }
        #reservations-grid td:nth-of-type(8):before { content: 'Niños'; }
        #reservations-grid td:nth-of-type(9):before { content: 'Mascotas'; }
        #reservations-grid td:nth-of-type(10):before { content: '# Noches'; }
        #reservations-grid td:nth-of-type(11):before { content: '# Noches Ta'; }
        #reservations-grid td:nth-of-type(12):before { content: '# Noches Tb'; }
        #reservations-grid td:nth-of-type(13):before { content: 'Precio x Noche Ta'; }
        #reservations-grid td:nth-of-type(14):before { content: 'Precio x Noche Tb'; }
        #reservations-grid td:nth-of-type(15):before { content: 'Price Early Check In'; }
        #reservations-grid td:nth-of-type(16):before { content: 'Price Late Check Out'; }
        #reservations-grid td:nth-of-type(17):before { content: 'Precio'; }


    }
    /*]]>*/
</style>

<div class="filter" style="display:none">
    <?php echo $formFilter->render(); ?>
</div>

<div class="inner" id="reservation-grid-inner">

    <?php $this->beginWidget('bootstrap.widgets.TbBox', array(
        'title' => Yii::t('mx', 'Reservations'),
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
            ),
            /*array(
                'class' => 'bootstrap.widgets.TbButton',
                'label'=>Yii::t('mx','Filter'),
                'type'=>'primary',
                'size'=>'large',
                'id'=>'filter-button',
                'htmlOptions' => array('class'=>'bootstrap-widget-table'),
            ),*/
        )

    ));?>

    <?php

    echo Yii::app()->quoteUtil->reservationTable();

?>

<?php $this->endWidget();?>


</div>











