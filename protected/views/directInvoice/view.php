<?php

    $this->breadcrumbs=array(
        Yii::t('mx','Direct Invoice')=>array('index'),
         Yii::t('mx','View'),
    );

    $this->menu=array(
        array('label'=>Yii::t('mx', 'Back'),'icon'=>'icon-chevron-left','url'=>array('index')),
        array('label'=>Yii::t('mx','Create'),'icon'=>'icon-plus','url'=>array('create')),
        //array('label'=>Yii::t('mx','Update'),'icon'=>'icon-pencil','url'=>array('update','id'=>$invoice->id)),
        array('label'=>Yii::t('mx','Delete'),'icon'=>'icon-remove','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$invoice->id),'confirm'=>Yii::t('mx','Are you sure you want to delete this item?'))),
    );


    $this->pageSubTitle=Yii::t('mx','View');
    $this->pageIcon='icon-list-alt';


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

    $subtotal=0;

?>

    <div class="row-fluid">
        <div class="span12">
            <div class="box">
                <div class="box-title">
                    <h3>
                        <i class="icon-money"></i>
                        <?php echo Yii::t('mx','Invoice'); ?>
                    </h3>
                </div>
                <div class="box-content">


                    <div class="invoice-info">


                        <div class="invoice-to">

                            <strong><?php echo $expide->company; ?></strong><br>
                            <?php echo $expide->rfc; ?><br>
                            <address>
                                <?php echo $expide->work_street.' '.$expide->outside_number; ?><br>
                                <?php echo $expide->work_neighborhood.' CP. '.$expide->work_zip; ?><br>
                                <?php echo $expide->work_city.' '.$expide->work_region.' '.$expide->work_country; ?><br>
                                <abbr title="Phone">Phone:</abbr> <?php echo $expide->telephone_work1; ?> <br>
                                <abbr title="Fax">Fax:</abbr> <?php echo $expide->fax_work; ?>
                            </address>
                        </div>
                        <div class="invoice-infos">
                            <table>
                                <tr>
                                    <th><?php echo Yii::t('mx','Date'); ?></th>
                                    <td><?php echo $invoice->datex; ?></td>
                                </tr>
                                <tr>
                                    <th><?php echo Yii::t('mx','Invoice'); ?>#:</th>
                                    <td><?php echo $invoice->n_invoice; ?></td>
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
                                <strong><?php echo Yii::t('mx','Lugar de Expedicion'); ?>: </strong><?php echo $expide->work_street.' Nº '.$expide->outside_number.' '.$expide->work_neighborhood.' '.$expide->work_city.' '.$expide->work_region.' CP. '.$expide->work_zip; ?><br>
                                <strong><?php echo Yii::t('mx','Forma de pago'); ?>: </strong>Pago en una sola exhibicion<br>
                                <strong><?php echo Yii::t('mx','Metodo de Pago'); ?>: </strong>Efectivo<br>

                            </td>
                            <td>

                                <strong><?php echo Yii::t('mx','Fecha de expedicion'); ?>: </strong><?php echo $invoice->datex; ?><br>
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
                            <th><?php echo Yii::t('mx','Code'); ?></th>
                            <th><?php echo Yii::t('mx','Description'); ?></th>
                            <th><?php echo Yii::t('mx','Price'); ?></th>
                            <th><?php echo Yii::t('mx','Amount'); ?></th>
                            <th><?php echo Yii::t('mx','Discount'); ?></th>
                            <th><?php echo Yii::t('mx','Subtotal'); ?></th>
                            <th><?php echo Yii::t('mx','VAT'); ?></th>
                            <th><?php echo Yii::t('mx','IEPS'); ?></th>
                            <th><?php echo Yii::t('mx','Retention VAT'); ?></th>
                            <th><?php echo Yii::t('mx','Retention ISR'); ?></th>
                            <th  class='tr'><?php echo Yii::t('mx','Total'); ?></th>

                        </tr>
                        </thead>
                        <tbody>

                        <?php foreach($itemsIvoice as $item): ?>

                            <tr>
                                <td><?php echo $item->quantity; ?></td>
                                <td><?php echo $item->article->unitmeasure->unit; ?></td>
                                <td><?php echo $item->article->code_invoice; ?></td>
                                <td><?php echo $item->article->presentation; ?></td>
                                <td>$<?php echo number_format($item->price,2); ?></td>
                                <td>$<?php echo number_format($item->amount,2); ?></td>
                                <td>$<?php echo number_format($item->discount,2); ?></td>
                                <td>$<?php echo number_format($item->subtotal,2); ?></td>
                                <td>$<?php echo number_format($item->vat,2); ?></td>
                                <td>$<?php echo number_format($item->ieps,2); ?></td>
                                <td>$<?php echo number_format($item->retiva,2); ?></td>
                                <td>$<?php echo number_format($item->retisr,2); ?></td>
                                <td class='total'>$<?php echo number_format($item->total,2); ?></td>
                            </tr>
                        <?php endforeach; ?>

                        <tr>
                            <td colspan="12"></td>
                            <td class='taxes'>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Amount'); ?></span>
                                    <span>$<?php echo number_format($invoice->amount,2); ?></span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Discount'); ?></span>
                                    <span>$<?php echo number_format($invoice->discount,2); ?></span>
                                </p>

                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Subtotal'); ?></span>
                                    <span>$<?php echo number_format($invoice->subtotal,2); ?></span>
                                </p>

                                <p>
                                    <span class="light"><?php echo Yii::t('mx','VAT'); ?></span>
                                    <span>$<?php
                                        echo number_format($invoice->vat,2); ?>
                                    </span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','IEPS'); ?></span>
                                    <span>$<?php
                                        echo number_format($invoice->ieps,2); ?>
                                    </span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Retention IVA'); ?></span>
                                    <span>$<?php
                                        echo number_format($invoice->retiva,2); ?>
                                    </span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Retention ISR'); ?></span>
                                    <span>$<?php
                                        echo number_format($invoice->retisr,2); ?>
                                    </span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Other'); ?></span>
                                    <span>$<?php
                                        echo number_format($invoice->other,2); ?>
                                    </span>
                                </p>
                                <p>
                                    <span class="light"><?php echo Yii::t('mx','Total'); ?></span>
													<span class="totalprice">
														$<?php echo number_format($invoice->total,2); ?>
													</span>
                                </p>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <strong>
                        <?php echo Yii::app()->quoteUtil->numtoletras($invoice->total); ?>
                    </strong>

                </div>
            </div>
        </div>
    </div>

            <?php /*$this->widget('bootstrap.widgets.TbDetailView',array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                'petty_cash_id',
                'n_invoice',
                'amount',
                'datex',
                'isactive',
                'isinvoice',
            ),
            ));*/
            ?>
