<?php
/**
 * Created by PhpStorm.
 * User: cocoaventura
 * Date: 25/04/14
 * Time: 16:52
 */

class PaymentTime extends CFormModel{
    public $llega;
    public $disponibilidad;
    public $dias;
    public $tipoDePago;
    public $diasRealPago;
    public $fecha;
    public $hora;

    public function rules()
    {
        return array(
            // name, email, subject and body are required
            array('llega, disponibilidd, dias, fecha, hora', 'required'),
            // email has to be a valid email address

        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels()
    {
        return array(
            'llega'=>'Llega en',
            'disponibilidad'=>'% de disponibilidad',
            'dias'=>'Dias para pagar',
            'tipoDePago'=>'Tipo de pago',
            'diasRealPago'=>'Dias reales de pago',
            'fecha'=>'Fecha',
            'hora'=>'Hora'
        );
    }

} 