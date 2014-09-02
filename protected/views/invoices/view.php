    <?php
$this->breadcrumbs=array(
        Yii::t('mx','Invoices')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$invoice->id)),
        array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$invoice->id),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
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
        <div class="span12">
            <div class="box">
                <div class="box-title">
                    <h3>
                        <i class="icon-money"></i>
                        Invoice
                    </h3>
                </div>
                <div class="box-content">


                    <div class="invoice-info">

                        <div class="invoice-from">
                            <?php echo CHtml::image(Yii::app()->theme->baseUrl.'/images/logo.jpg',Yii::app()->name,array('width'=>200,'height'=>100)) ?>
                        </div>
                        <div class="invoice-to">

                            <strong><?php echo $expide->company_name; ?></strong><br>
                            <?php echo $expide->rfc; ?><br>
                            <address>
                                <?php echo $expide->street.' '.$expide->outside_number; ?><br>
                                <?php echo $expide->neighborhood.' '.$expide->zipcode; ?><br>
                                <?php echo $expide->locality.' '.$expide->state.' '.$expide->country; ?><br>
                                <abbr title="Phone">Phone:</abbr> (125) 358123-581 <br>
                                <abbr title="Fax">Fax:</abbr> (125) 251656-222
                            </address>
                        </div>
                        <div class="invoice-infos">
                            <table>
                                <tr>
                                    <th>Date:</th>
                                    <td>Aug 06, 2012</td>
                                </tr>
                                <tr>
                                    <th>Invoice #:</th>
                                    <td>0001752188s</td>
                                </tr>
                                <tr>
                                    <th>Product:</th>
                                    <td>Service Hotline</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <table align="center" border="0" cellpadding="1" cellspacing="1" style="width: 100%;">
                        <tbody>
                        <tr>
                            <td>

                                <strong><?php echo $billTo->company_name; ?></strong><br>
                                <?php echo $billTo->rfc; ?><br>
                                <address>
                                    <?php echo $billTo->street.' '.$billTo->outside_number; ?><br>
                                    <?php echo $billTo->neighborhood.' '.$billTo->zipcode; ?><br>
                                    <?php echo $billTo->locality.' '.$billTo->state.' '.$billTo->country; ?><br>
                                </address>

                            </td>
                            <td>
                                <strong><?php echo Yii::t('mx','Regimen Fiscal'); ?>: </strong><?php echo $billTo->company_name; ?><br>
                                <strong><?php echo Yii::t('mx','Lugar de Expedicion'); ?>: </strong><?php echo $expide->locality.' '.$expide->state; ?><br>
                                <strong><?php echo Yii::t('mx','Forma de pago'); ?>: </strong>Pago en una sola exhibicion<br>
                                <strong><?php echo Yii::t('mx','Metodo de Pago'); ?>: </strong>Efectivo<br>

                            </td>
                            <td>

                                <strong><?php echo Yii::t('mx','Fecha de expedicion'); ?>: </strong><?php echo $invoice->date_expedition; ?><br>
                                <strong><?php echo Yii::t('mx','Clave de moneda'); ?>: </strong>MXN<br>

                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <br>


                    <table class="table table-striped table-invoice">
                        <thead>
                        <tr>
                            <th><?php echo Yii::t('mx','Quantity'); ?></th>
                            <th><?php echo Yii::t('mx','Unit'); ?></th>
                            <th><?php echo Yii::t('mx','Identification'); ?></th>
                            <th><?php echo Yii::t('mx','Description'); ?></th>
                            <th><?php echo Yii::t('mx','Unit Price'); ?></th>
                            <th class='tr'><?php echo Yii::t('mx','Import'); ?></th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($itemsIvoice as $item): ?>
                            <tr>
                                <td><?php echo $item->quantity; ?></td>
                                <td><?php echo $item->unit; ?></td>
                                <td><?php echo $item->identification; ?></td>
                                <td><?php echo $item->description; ?></td>
                                <td>$<?php echo $item->unit_price; ?></td>
                                <td class='total'>$<?php echo $item->import; ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td colspan="5"></td>
                            <td class='taxes'>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Subtotal'); ?></span>
                                    <span>$<?php echo $invoice->subtotal; ?></span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Tax'); ?>(16%)</span>
                                    <span>$<?php echo $invoice->tax; ?></span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Total'); ?></span>
													<span class="totalprice">
														$<?php echo $invoice->total; ?>
													</span>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <strong>
                        <?php $this->widget('ext.numerosALetras', array('valor'=>$invoice->total,'despues'=>'Pesos')); ?>
                    </strong>

                </div>
            </div>
        </div>
    </div>
