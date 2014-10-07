<?php

class QuoteDetails extends CApplicationComponent{

    public $controllerId = "reservation";
    private $_controller = null;
    private $_module = null;

    public function init()
    {
        parent::init();
        $this->_module = Yii::app(); // si no se quiere usar como modulo, apuntar a app()
    }

    public function setModule(CModule $module)
    {
        $this->_module = $module;
    }

    protected function getController()
    {
        if ($this->_controller == null) {
            $this->_controller = new CController($this->controllerId, $this->_module);
            $this->_controller->layout = $this->controllerId;
        }
        return $this->_controller;
    }

    protected function render($viewname, $data = array())
    {
        return $this->getController()->renderPartial($viewname, $data, true);
    }

    public function toEnglishDateTime($date){

    $anio = substr($date,0,4);
    $mes   = substr($date, 5, 3);
    $dia = substr($date, 9,2);
    $hora=substr($date, 12,2);
    $minuto=substr($date, 15,2);

        switch ($mes) {
            case 'Ene': $mes='Jan';  break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar';  break;
            case 'Abr': $mes='Apr';  break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun';  break;
            case 'Jul': $mes='Jul'; break;
            case 'Ago': $mes='Aug'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dic': $mes='Dec'; break;
        }

        $fecha = $anio.'-'.$mes.'-'.$dia.' '.$hora.':'.$minuto;

        return $fecha;
    }

    public function toEnglishDateTime1($date){

        $dia = substr($date, 0,2);
        $mes   = substr($date, 3, 3);
        $anio = substr($date,7,4);
        $hora=substr($date, 12,2);
        $minuto=substr($date, 15,2);


        switch ($mes) {
            case 'Ene': $mes='Jan';  break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar';  break;
            case 'Abr': $mes='Apr';  break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun';  break;
            case 'Jul': $mes='Jul'; break;
            case 'Ago': $mes='Aug'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dic': $mes='Dec'; break;
        }

        $fecha = $anio.'-'.$mes.'-'.$dia.' '.$hora.':'.$minuto;

        return $fecha;
    }

    public function toSpanishDateTime($date){

        $anio = substr($date,0,4);
        $mes   = substr($date, 5, 3);
        $dia = substr($date, 9,2);
        $hora=substr($date, 12,2);
        $minuto=substr($date, 15,2);

        switch ($mes) {
            case 'Jan': $mes='Ene'; break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar'; break;
            case 'Apr': $mes='Abr'; break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun'; break;
            case 'Jul': $mes='Jul'; break;
            case 'Aug': $mes='Ago'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dec': $mes='Dic'; break;
        }

        $fecha = $anio.'-'.$mes.'-'.$dia.' '.$hora.':'.$minuto;

        return $fecha;
    }

    public function toSpanishDateTime1($date){

        $anio = substr($date,0,4);
        $mes   = substr($date, 5, 3);
        $dia = substr($date, 9,2);
        $hora=substr($date, 12,2);
        $minuto=substr($date, 15,2);

        switch ($mes) {
            case 'Jan': $mes='Ene'; break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar'; break;
            case 'Apr': $mes='Abr'; break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun'; break;
            case 'Jul': $mes='Jul'; break;
            case 'Aug': $mes='Ago'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dec': $mes='Dic'; break;
        }

        $fecha = $dia.'-'.$mes.'-'.$anio.' '.$hora.':'.$minuto;

        return $fecha;
    }


    public function toEnglishDate($date){

        $anio = substr($date,0,4);
        $mes   = substr($date, 5, 3);
        $dia = substr($date, 9,2);

        switch ($mes) {
            case 'Ene': $mes='Jan'; break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar'; break;
            case 'Abr': $mes='Apr'; break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun'; break;
            case 'Jul': $mes='Jul'; break;
            case 'Ago': $mes='Aug'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dic': $mes='Dec'; break;
        }

        $fecha = $anio.'-'.$mes.'-'.$dia;

        return $fecha;
    }

    public function ToEnglishDateFromFormatdMyyyy($date){


        $date=explode('-',$date);
        $anio = $date[2];
        $mes   = $date[1];
        $dia = $date[0];

        switch ($mes) {
            case 'Ene': $mes='Jan'; break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar'; break;
            case 'Abr': $mes='Apr'; break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun'; break;
            case 'Jul': $mes='Jul'; break;
            case 'Ago': $mes='Aug'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dic': $mes='Dec'; break;
        }

        $fecha = $anio.'-'.$mes.'-'.$dia;

        return $fecha;
    }

    public function ToSpanishDateFromFormatdMyyyy($date){

        $date=explode('-',$date);
        $anio = $date[2];
        $mes   = $date[1];
        $dia = $date[0];

        switch ($mes) {
            case 'Jan': $mes='Ene'; break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar'; break;
            case 'Apr': $mes='Abr'; break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun'; break;
            case 'Jul': $mes='Jul'; break;
            case 'Aug': $mes='Ago'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dec': $mes='Dic'; break;
        }

        $fecha = $anio.'-'.$mes.'-'.$dia;

        return $fecha;
    }


    public function toSpanishDate($date){

        $anio = substr($date,0,4);
        $mes   = substr($date, 5, 3);
        $dia = substr($date, 9,2);

        switch ($mes) {
            case 'Jan': $mes='Ene'; break;
            case 'Feb': $mes='Feb'; break;
            case 'Mar': $mes='Mar'; break;
            case 'Apr': $mes='Abr'; break;
            case 'May': $mes='May'; break;
            case 'Jun': $mes='Jun'; break;
            case 'Jul': $mes='Jul'; break;
            case 'Aug': $mes='Ago'; break;
            case 'Sep': $mes='Sep'; break;
            case 'Oct': $mes='Oct'; break;
            case 'Nov': $mes='Nov'; break;
            case 'Dec': $mes='Dic'; break;
        }

        $fecha = $anio.'-'.$mes.'-'.$dia;

        return $fecha;
    }

    public function toSpanishDateDescription($date){

        $anio = substr($date,0,4);
        $mes   = substr($date, 5, 3);
        $dia = substr($date, 9,2);

        switch ($mes) {
            case 'Jan': $mes='Enero'; break;
            case 'Feb': $mes='Febrero'; break;
            case 'Mar': $mes='Marzo'; break;
            case 'Apr': $mes='Abril'; break;
            case 'May': $mes='Mayo'; break;
            case 'Jun': $mes='Junio'; break;
            case 'Jul': $mes='Julio'; break;
            case 'Aug': $mes='Agosto'; break;
            case 'Sep': $mes='Septiembre'; break;
            case 'Oct': $mes='Octubre'; break;
            case 'Nov': $mes='Noviembre'; break;
            case 'Dec': $mes='Diciembre'; break;
        }

        $fecha = $dia.' de '.$mes.' del '.$anio;

        return $fecha;
    }


    public function conexion(){

        $dsn = Yii::app()->db->connectionString;
        $user=Yii::app()->db->username;
        $pass=Yii::app()->db->password;

        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION
        );

        try{
            $conexion = new PDO($dsn,$user,$pass,$options);

        }catch( PDOException $e){	echo "Error Connection"; }

        return $conexion;

    }

    public function pricePets($mascotas=0){

        $pricepets=0;
        if($mascotas > 2) $pricepets=100*($mascotas-2);

        return $pricepets;

    }

    public function getTotalDiscountCabanas($total=0){

        $discountCabana=CabanaDiscount::model()->getDiscount($total);
        if($discountCabana) $discountCabana=($total*$discountCabana->discount)/100;

        return $discountCabana;

    }

    public function getTotalPrice($models,$discount=false) {

        $totalPrice=0;
        $totalCabana=0;
        $totalCamping=0;
        $totalDaypass=0;
        $discountCabana=0;
        $discountCamping=0;
        $discountDaypass=0;
        $totalDiscount=0;
        $paxCamping=0;
        $paxDaypass=0;
        $grandTotal=0;

        foreach($models as $i):

            $item=(object)$i;

            if($item->service_type=="CABANA"){
                $totalCabana+=$item->price;
            }

            if($item->service_type=="TENT"){
                $paxCamping+=$item->totalpax;
                $totalCamping+=$item->price;
            }

            if($item->service_type=="CAMPED"){
                $paxCamping+=$item->totalpax;
                $totalCamping+=$item->price;
            }

            if($item->service_type=="DAYPASS"){
                $paxDaypass+=$item->totalpax;
                $totalDaypass+=$item->price;
            }

            $totalPrice+=$item->price;

        endforeach;

        $grandTotal=$totalPrice;

        if($discount==true){

            $discountCamping=CampedDiscount::model()->getDiscount($paxCamping);
            if($discountCamping)$discountCamping=($totalCamping*$discountCamping->discount)/100;

            $discountCabana=CabanaDiscount::model()->getDiscount($totalCabana);
            if($discountCabana) $discountCabana=($totalCabana*$discountCabana->discount)/100;

            $discountDaypass=CampedDiscount::model()->getDiscount($paxDaypass);
            if($discountDaypass) $discountDaypass=($totalDaypass*$discountDaypass->discount)/100;

            if($discountCamping != 0 or $discountCabana!=0 or $discountDaypass!=0){
                $totalDiscount=$discountCamping+$discountCabana+$discountDaypass;
            }

            $grandTotal=$totalPrice-$totalDiscount;
        }

        return $grandTotal;

    }

    public function getTableDiscount($models) {

        $totalPrice=0;
        $totalCabana=0;
        $totalCamping=0;
        $totalDaypass=0;
        $discountCabana=0;
        $discountCamping=0;
        $discountDaypass=0;
        $totalDiscount=0;
        $paxCamping=0;
        $paxDaypass=0;
        $footer='';
        $table='';


            foreach($models as $i):

                $item=(object)$i;

                if($item->service_type=="CABANA"){
                    $totalCabana+=$item->price;
                }

                if($item->service_type=="TENT"){
                    $paxCamping+=$item->totalpax;
                    $totalCamping+=$item->price;
                }

                if($item->service_type=="CAMPED"){
                    $paxCamping+=$item->totalpax;
                    $totalCamping+=$item->price;
                }

                if($item->service_type=="DAYPASS"){
                    $paxDaypass+=$item->totalpax;
                    $totalDaypass+=$item->price;
                }

                $totalPrice+=$item->price;

            endforeach;


                $discountCamping=CampedDiscount::model()->getDiscount($paxCamping);

                if($discountCamping){
                    $discountCamping=($totalCamping*$discountCamping->discount)/100;
                    $footer.='
                        <tr>
                            <td>'.Yii::t('mx','Camped Discount').'</td>
                            <td  style="text-align: right;">$ '.number_format($discountCamping,2).' MX</td>
                        </tr>
                    ';
                }

                $discountCabana=CabanaDiscount::model()->getDiscount($totalCabana);

                if($discountCabana){
                    $discountCabana=($totalCabana*$discountCabana->discount)/100;
                    $footer.='
                        <tr>
                            <td>'.Yii::t('mx','Cabana Discount').'</td>
                            <td style="text-align: right;">$ '.number_format($discountCabana,2).' MX</td>
                        </tr>
                    ';

                }

            $discountDaypass=CampedDiscount::model()->getDiscount($paxDaypass);


            if($discountDaypass){
                $discountDaypass=($totalDaypass*$discountDaypass->discount)/100;

                $footer.='
                <tr>
                    <td>'.Yii::t('mx','Day Pass Discount').'</td>
                        <td  style="text-align: right;">$ '.number_format($discountDaypass,2).' MX</td>
                    </tr>
                ';
            }

            if($discountCamping != 0 or $discountCabana!=0 or $discountDaypass!=0){
                $totalDiscount=$discountCamping+$discountCabana+$discountDaypass;
                $footer.='
                <tr>
                    <td>'.Yii::t('mx','Total Discount').'</td>
                    <td  style="text-align: right;">$ '.number_format($totalDiscount,2).' MX</td>
                </tr>
                ';
            }

            $table.='
                <table class="items table table-condensed" align="right" style="width: 40%">
                    <tbody>
                        <tr>
                            <td>'.Yii::t('mx','Subtotal').'</td>
                            <td  style="text-align: right;">$ '.number_format($totalPrice,2).' MX</td>
                        </tr>
                        '.$footer.'
                        <tr>
                            <td><h5>'.Yii::t('mx','Grand Total').':</h5></td>
                            <td><h5  style="text-align: right;">'.'$'.number_format(($totalPrice-$totalDiscount),2).' MX</h5></td>
                        </tr>
                    </tbody>
                </table>
            ';

        return $table;

    }


    public function getTableCotizacion($models,$status=false){

       $counter=0;
       $totalPrice=0;
       $totalCabana=0;
       $totalCamping=0;
       $totalDaypass=0;
       $discountCabana=0;
       $discountCamping=0;
       $discountDaypass=0;
       $totalDiscount=0;
       $paxCamping=0;
       $paxDaypass=0;
       $pricepets=0;
       $footer='';
       $tablaCananaAndTent=false;
       $tablaCamped=false;
       $tablaDayPasss=false;
       $allTables='';
       $tempAlta=false;
       $tempBaja=false;
       $ratesAdultsAlta=0;
       $ratesChildrenAlta=0;
       $ratesAdultsBaja=0;
       $ratesChildrenBaja=0;
       $tableStatus="";
       $valueStatus="";

       if($status==true) $tableStatus="<th>".Yii::t('mx','Status')."</th>";


        $tableCananaAndTent='
            <table class="items table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    '.$tableStatus.'
                    <th>'.Yii::t('mx','Room Type').'</th>
                    <th>'.Yii::t('mx','Check In').'</th>
                    <th>'.Yii::t('mx','Check In Time').'</th>
                    <th>'.Yii::t('mx','Check Out').'</th>
                    <th>'.Yii::t('mx','Check Out Time').'</th>

                    <th>'.Yii::t('mx','Adults').'</th>
                    <th>'.Yii::t('mx','Children').'</th>
                    <th>'.Yii::t('mx','Pets').'</th>

                    <th># '.Yii::t('mx','Nights').'</th>
                    <th># '.Yii::t('mx','Nights').' Ta</th>
                    <th># '.Yii::t('mx','Nights').' Tb</th>

                    <th>'.Yii::t('mx','Price x Night').' Ta</th>
                    <th>'.Yii::t('mx','Price x Night').' Tb</th>
                    <th>'.Yii::t('mx','Price x Night').' x '.Yii::t('mx','Pet').' Extra</th>

                    <th>'.Yii::t('mx','Price Early Check In').'</th>
                    <th>'.Yii::t('mx','Price Late Check Out').'</th>
                    <th>'.Yii::t('mx','Price').'</th>
                </tr>
            <thead>
            <tbody>
                <tr>
        ';

        $tableCamped='
            <table class="items table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    '.$tableStatus.'
                    <th>'.Yii::t('mx','Room Type').'</th>
                    <th>'.Yii::t('mx','Check In').'</th>
                    <th>'.Yii::t('mx','Check In Time').'</th>
                    <th>'.Yii::t('mx','Check Out').'</th>
                    <th>'.Yii::t('mx','Check Out Time').'</th>

                    <th>'.Yii::t('mx','Adults').'</th>
                    <th>'.Yii::t('mx','Children').'</th>
                    <th>'.Yii::t('mx','Pets').'</th>

                    <th># '.Yii::t('mx','Nights').'</th>
                    <th># '.Yii::t('mx','Nights').' Ta</th>
                    <th># '.Yii::t('mx','Nights').' Tb</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Night').' Ta</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Night').' Ta</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Night').' Tb</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Night').' Tb</th>
                    <th>'.Yii::t('mx','Price x Night').' x '.Yii::t('mx','Pet').' Extra</th>

                    <th>'.Yii::t('mx','Price Early Check In').'</th>
                    <th>'.Yii::t('mx','Price Late Check Out').'</th>
                    <th>'.Yii::t('mx','Price').'</th>
                </tr>
            <thead>
            <tbody>
                <tr>
        ';

        $tableDayPasss='
            <table class="items table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    '.$tableStatus.'
                    <th>'.Yii::t('mx','Room Type').'</th>
                    <th>'.Yii::t('mx','Check In').'</th>
                    <th>'.Yii::t('mx','Check In Time').'</th>
                    <th>'.Yii::t('mx','Check Out').'</th>
                    <th>'.Yii::t('mx','Check Out Time').'</th>

                    <th>'.Yii::t('mx','Adults').'</th>
                    <th>'.Yii::t('mx','Children').'</th>
                    <th>'.Yii::t('mx','Pets').'</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Day').' Ta</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Day').' Ta</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Day').' Tb</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Day').' Tb</th>
                    <th>'.Yii::t('mx','Price x Night').' x '.Yii::t('mx','Pet').' Extra</th>

                    <th>'.Yii::t('mx','Price Early Check In').'</th>
                    <th>'.Yii::t('mx','Price Late Check Out').'</th>
                    <th>'.Yii::t('mx','Price').'</th>
                </tr>
            <thead>
            <tbody>
                <tr>
        ';

        foreach($models as $i):

            $item=(object)$i;
            $inicio=strtotime($item->checkin);
            $fin=strtotime($item->checkout);

            //if($item->pets > 2) $pricepets=100*($item->pets-2);
            $mascotas=(int)$item->pets;
            $pricepets=Yii::app()->quoteUtil->pricePets($mascotas);

            for($x=$inicio;$x<$fin;$x+=86400):
                $day=date("d", $x);
                $month=date("m", $x);
                $temporada=CalendarSeason::model()->season($day,$month);
                if($temporada->tipe=='BAJA') $tempBaja=true;
                if($temporada->tipe=='ALTA') $tempAlta=true;
            endfor;

            $criteria=array(
                'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId',
                'params'=>array('serviceType'=>$item->service_type,'roomTypeId'=>$item->room_type_id)
            );

            $reservationType=Rates::model()->find($criteria);
            $reservationTypeId=$reservationType->typeReservation->id;


            if($tempAlta==true){
                $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'ALTA');
                $ratesAdultsAlta=$resultRates->adults;
                if($item->children != 0) $ratesChildrenAlta=$resultRates->children;
            }
            if($tempBaja==true){
                $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'BAJA');
                $ratesAdultsBaja=$resultRates->adults;
                if($item->children != 0) $ratesChildrenBaja=$resultRates->children;
            }

            if($item->service_type=="CABANA"){
                $totalCabana+=$item->price;
                $RoonType=Rooms::model()->getRoomType($item->room_id);
            }

            if($item->service_type=="TENT"){
                $RoonType=Rooms::model()->getRoomType($item->room_id);
                $paxCamping+=$item->totalpax;
                $totalCamping+=$item->price;
            }

            if($item->service_type=="CAMPED"){
                $RoonType=Yii::t('mx','Camped');
                $paxCamping+=$item->totalpax;
                $totalCamping+=$item->price;
            }

            if($item->service_type=="DAYPASS"){

                $day=date("d", $inicio);
                $month=date("m", $inicio);
                $temporada=CalendarSeason::model()->season($day,$month);

                if($temporada->tipe=='BAJA') $tempBaja=true;
                if($temporada->tipe=='ALTA') $tempAlta=true;

                if($tempAlta==true){
                    $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'ALTA');
                    $ratesAdultsAlta=$resultRates->adults;
                    $ratesChildrenAlta=$resultRates->children;
                }
                if($tempBaja==true){
                    $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'BAJA');
                    $ratesAdultsBaja=$resultRates->adults;
                    $ratesChildrenBaja=$resultRates->children;
                }

                $RoonType=Yii::t('mx','Daypass');
                $paxDaypass+=$item->totalpax;
                $totalDaypass+=$item->price;

            }

            if($status==true) $valueStatus='<td>'.Yii::t('mx',$item->statux).'</td>';

            if($item->service_type=="CABANA"){

                $tablaCananaAndTent=true;


                $tableCananaAndTent.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $tableCananaAndTent.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.$item->price_ta.'</td>
                        <td>$'.$item->price_tb.'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>$'.$item->price_early_checkin.'</td>
                        <td>$'.$item->price_late_checkout.'</td>
                        <td>$'.number_format($item->price,2).'</td>
                    </tr>';
            }

            if($item->service_type=="DAYPASS"){

                $tablaDayPasss=true;

                $tableDayPasss.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $tableDayPasss.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>$'.number_format($ratesAdultsAlta,2).'</td>
                        <td>$'.number_format($ratesChildrenAlta,2).'</td>

                        <td>$'.number_format($ratesAdultsBaja,2).'</td>
                        <td>$'.number_format($ratesChildrenBaja,2).'</td>

                        <td>$'.number_format($pricepets,2).'</td>

                        <td>$'.$item->price_early_checkin.'</td>
                        <td>$'.$item->price_late_checkout.'</td>
                        <td>$'.number_format($item->price,2).'</td>
                    </tr>';
            }


            if($item->service_type=="TENT"){

                if($item->service_type=="TENT" and $reservationTypeId==1){
                    $tablaCananaAndTent=true;
                    $tableCananaAndTent.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                    $tableCananaAndTent.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.$item->price_ta.'</td>
                        <td>$'.$item->price_tb.'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>$'.$item->price_early_checkin.'</td>
                        <td>$'.$item->price_late_checkout.'</td>
                        <td>$'.number_format($item->price,2).'</td>
                    </tr>';

                }elseif($item->service_type=="TENT" and $reservationTypeId==3){

                    $tablaCamped=true;

                    $tableCamped.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                    $tableCamped.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.number_format($ratesAdultsAlta,2).'</td>
                        <td>$'.number_format($ratesChildrenAlta,2).'</td>

                        <td>$'.number_format($ratesAdultsBaja,2).'</td>
                        <td>$'.number_format($ratesChildrenBaja,2).'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>'.$item->price_early_checkin.'</td>
                        <td>'.$item->price_late_checkout.'</td>
                        <td>'.number_format($item->price,2).'</td>
                    </tr>';
                }

            }

            if($item->service_type=="CAMPED"){
                $tablaCamped=true;

                $tableCamped.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $tableCamped.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.number_format($ratesAdultsAlta,2).'</td>
                        <td>$'.number_format($ratesChildrenAlta,2).'</td>

                        <td>$'.number_format($ratesAdultsBaja,2).'</td>
                        <td>$'.number_format($ratesChildrenBaja,2).'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>'.$item->price_early_checkin.'</td>
                        <td>'.$item->price_late_checkout.'</td>
                        <td>'.number_format($item->price,2).'</td>
                    </tr>';
            }




            $totalPrice+=$item->price;

            $counter++;

        endforeach;

        if($tablaCananaAndTent==true){
            $tableCananaAndTent.='</table>';
            $allTables.=$tableCananaAndTent;
        }

        if($tablaCamped==true){
            $tableCamped.='</table>';
            $allTables.=$tableCamped;
        }

        if($tablaDayPasss==true){
            $tableDayPasss.='</table>';
            $allTables.=$tableDayPasss;
        }

        $discountx=$this->getTableDiscount($models);

        return '<div class="row-fluid">
                        '.$allTables.$discountx.'
                    </fieldset>
               </div>';
    }

    public function getCotizacionNoDiscount($models,$status=false){

        $counter=0;
        $totalPrice=0;
        $totalCabana=0;
        $totalCamping=0;
        $totalDaypass=0;
        $discountCabana=0;
        $discountCamping=0;
        $discountDaypass=0;
        $totalDiscount=0;
        $paxCamping=0;
        $paxDaypass=0;
        $pricepets=0;
        $footer='';
        $tablaCananaAndTent=false;
        $tablaCamped=false;
        $tablaDayPasss=false;
        $allTables='';
        $tempAlta=false;
        $tempBaja=false;
        $ratesAdultsAlta=0;
        $ratesChildrenAlta=0;
        $ratesAdultsBaja=0;
        $ratesChildrenBaja=0;

        $tableStatus="";
        $valueStatus="";

        if($status==true) $tableStatus="<th>".Yii::t('mx','Status')."</th>";

        $tableCananaAndTent='
            <table class="items table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    '.$tableStatus.'
                    <th>'.Yii::t('mx','Room Type').'</th>
                    <th>'.Yii::t('mx','Check In').'</th>
                    <th>'.Yii::t('mx','Check In Time').'</th>
                    <th>'.Yii::t('mx','Check Out').'</th>
                    <th>'.Yii::t('mx','Check Out Time').'</th>

                    <th>'.Yii::t('mx','Adults').'</th>
                    <th>'.Yii::t('mx','Children').'</th>
                    <th>'.Yii::t('mx','Pets').'</th>

                    <th># '.Yii::t('mx','Nights').'</th>
                    <th># '.Yii::t('mx','Nights').' Ta</th>
                    <th># '.Yii::t('mx','Nights').' Tb</th>

                    <th>'.Yii::t('mx','Price x Night').' Ta</th>
                    <th>'.Yii::t('mx','Price x Night').' Tb</th>
                    <th>'.Yii::t('mx','Price x Night').' x '.Yii::t('mx','Pet').' Extra</th>

                    <th>'.Yii::t('mx','Price Early Check In').'</th>
                    <th>'.Yii::t('mx','Price Late Check Out').'</th>
                    <th>'.Yii::t('mx','Price').'</th>
                </tr>
            <thead>
            <tbody>
                <tr>
        ';

        $tableCamped='
            <table class="items table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    '.$tableStatus.'
                    <th>'.Yii::t('mx','Room Type').'</th>
                    <th>'.Yii::t('mx','Check In').'</th>
                    <th>'.Yii::t('mx','Check In Time').'</th>
                    <th>'.Yii::t('mx','Check Out').'</th>
                    <th>'.Yii::t('mx','Check Out Time').'</th>

                    <th>'.Yii::t('mx','Adults').'</th>
                    <th>'.Yii::t('mx','Children').'</th>
                    <th>'.Yii::t('mx','Pets').'</th>

                    <th># '.Yii::t('mx','Nights').'</th>
                    <th># '.Yii::t('mx','Nights').' Ta</th>
                    <th># '.Yii::t('mx','Nights').' Tb</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Night').' Ta</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Night').' Ta</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Night').' Tb</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Night').' Tb</th>

                    <th>'.Yii::t('mx','Price x Night').' x '.Yii::t('mx','Pet').' Extra</th>

                    <th>'.Yii::t('mx','Price Early Check In').'</th>
                    <th>'.Yii::t('mx','Price Late Check Out').'</th>
                    <th>'.Yii::t('mx','Price').'</th>
                </tr>
            <thead>
            <tbody>
                <tr>
        ';

        $tableDayPasss='
            <table class="items table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    '.$tableStatus.'
                    <th>'.Yii::t('mx','Room Type').'</th>
                    <th>'.Yii::t('mx','Check In').'</th>
                    <th>'.Yii::t('mx','Check In Time').'</th>
                    <th>'.Yii::t('mx','Check Out').'</th>
                    <th>'.Yii::t('mx','Check Out Time').'</th>

                    <th>'.Yii::t('mx','Adults').'</th>
                    <th>'.Yii::t('mx','Children').'</th>
                    <th>'.Yii::t('mx','Pets').'</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Day').' Ta</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Day').' Ta</th>

                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Adult').' x '.Yii::t('mx','Day').' Tb</th>
                    <th>'.Yii::t('mx','Price').' x '.Yii::t('mx','Child').' x '.Yii::t('mx','Day').' Tb</th>
                    <th>'.Yii::t('mx','Price x Night').' x '.Yii::t('mx','Pet').' Extra</th>

                    <th>'.Yii::t('mx','Price Early Check In').'</th>
                    <th>'.Yii::t('mx','Price Late Check Out').'</th>
                    <th>'.Yii::t('mx','Price').'</th>
                </tr>
            <thead>
            <tbody>
                <tr>
        ';

        foreach($models as $i):

            $item=(object)$i;
            $inicio=strtotime($item->checkin);
            $fin=strtotime($item->checkout);

            //if($item->pets > 2) $pricepets=100*($item->pets-2);
            $mascotas=(int)$item->pets;
            $pricepets=Yii::app()->quoteUtil->pricePets($mascotas);

            for($x=$inicio;$x<$fin;$x+=86400):
                $day=date("d", $x);
                $month=date("m", $x);
                $temporada=CalendarSeason::model()->season($day,$month);
                if($temporada->tipe=='BAJA') $tempBaja=true;
                if($temporada->tipe=='ALTA') $tempAlta=true;
            endfor;

            $criteria=array(
                'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId',
                'params'=>array('serviceType'=>$item->service_type,'roomTypeId'=>$item->room_type_id)
            );

            $reservationType=Rates::model()->find($criteria);
            $reservationTypeId=$reservationType->type_reservation_id;

            if($tempAlta==true){
                $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'ALTA');
                $ratesAdultsAlta=$resultRates->adults;
                if($item->children != 0) $ratesChildrenAlta=$resultRates->children;


            }
            if($tempBaja==true){
                $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'BAJA');
                $ratesAdultsBaja=$resultRates->adults;
                if($item->children != 0) $ratesChildrenBaja=$resultRates->children;

            }

            if($item->service_type=="CABANA"){
                $totalCabana+=$item->price;
                $RoonType=Rooms::model()->getRoomType($item->room_id);
            }

            if($item->service_type=="TENT"){
                $RoonType=Rooms::model()->getRoomType($item->room_id);
                $paxCamping+=$item->totalpax;
                $totalCamping+=$item->price;
            }

            if($item->service_type=="CAMPED"){
                $RoonType=Yii::t('mx','Camped');
                $paxCamping+=$item->totalpax;
                $totalCamping+=$item->price;
            }

            if($item->service_type=="DAYPASS"){

                $day=date("d", $inicio);
                $month=date("m", $inicio);
                $temporada=CalendarSeason::model()->season($day,$month);

                if($temporada->tipe=='BAJA') $tempBaja=true;
                if($temporada->tipe=='ALTA') $tempAlta=true;

                if($tempAlta==true){
                    $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'ALTA');
                    $ratesAdultsAlta=$resultRates->adults;
                    $ratesChildrenAlta=$resultRates->children;
                }
                if($tempBaja==true){
                    $resultRates= Rates::model()->getPricePerHeight($item->service_type,$item->room_type_id,$reservationTypeId,'BAJA');
                    $ratesAdultsBaja=$resultRates->adults;
                    $ratesChildrenBaja=$resultRates->children;
                }

                $RoonType=Yii::t('mx','Daypass');
                $paxDaypass+=$item->totalpax;
                $totalDaypass+=$item->price;

            }

            if($status==true) $valueStatus='<td>'.Yii::t('mx',$item->statux).'</td>';

            if($item->service_type=="CABANA"){

                $tablaCananaAndTent=true;

                $tableCananaAndTent.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $tableCananaAndTent.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.$item->price_ta.'</td>
                        <td>$'.$item->price_tb.'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>$'.$item->price_early_checkin.'</td>
                        <td>$'.$item->price_late_checkout.'</td>
                        <td>$'.number_format($item->price,2).'</td>
                    </tr>';
            }

            if($item->service_type=="TENT"){

                if($item->service_type=="TENT" and $reservationTypeId==1){
                    $tablaCananaAndTent=true;
                    $tableCananaAndTent.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                    $tableCananaAndTent.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.$item->price_ta.'</td>
                        <td>$'.$item->price_tb.'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>$'.$item->price_early_checkin.'</td>
                        <td>$'.$item->price_late_checkout.'</td>
                        <td>$'.number_format($item->price,2).'</td>
                    </tr>';

                }elseif($item->service_type=="TENT" and $reservationTypeId==3){

                    $tablaCamped=true;

                    $tableCamped.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                    $tableCamped.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.number_format($ratesAdultsAlta,2).'</td>
                        <td>$'.number_format($ratesChildrenAlta,2).'</td>

                        <td>$'.number_format($ratesAdultsBaja,2).'</td>
                        <td>$'.number_format($ratesChildrenBaja,2).'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>'.$item->price_early_checkin.'</td>
                        <td>'.$item->price_late_checkout.'</td>
                        <td>'.number_format($item->price,2).'</td>
                    </tr>';
                }

            }


            if($item->service_type=="CAMPED"){
                $tablaCamped=true;

                $tableCamped.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $tableCamped.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>'.$item->nights.'</td>
                        <td>'.$item->nigth_ta.'</td>
                        <td>'.$item->nigth_tb.'</td>

                        <td>$'.number_format($ratesAdultsAlta,2).'</td>
                        <td>$'.number_format($ratesChildrenAlta,2).'</td>

                        <td>$'.number_format($ratesAdultsBaja,2).'</td>
                        <td>$'.number_format($ratesChildrenBaja,2).'</td>
                        <td>$'.number_format($pricepets,2).'</td>

                        <td>'.$item->price_early_checkin.'</td>
                        <td>'.$item->price_late_checkout.'</td>
                        <td>'.number_format($item->price,2).'</td>
                    </tr>';
            }

            if($item->service_type=="DAYPASS"){

                $tablaDayPasss=true;

                $tableDayPasss.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $tableDayPasss.='
                        '.$valueStatus.'
                        <td>'.$RoonType.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkin))).'</td>
                        <td>'.$item->checkin_hour.' hrs.</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->checkout))).'</td>
                        <td>'.$item->checkout_hour.' hrs.</td>

                        <td>'.$item->adults.'</td>
                        <td>'.$item->children.'</td>
                        <td>'.$item->pets.'</td>

                        <td>$'.number_format($ratesAdultsAlta,2).'</td>
                        <td>$'.number_format($ratesChildrenAlta,2).'</td>

                        <td>$'.number_format($ratesAdultsBaja,2).'</td>
                        <td>$'.number_format($ratesChildrenBaja,2).'</td>

                        <td>$'.number_format($pricepets,2).'</td>

                        <td>$'.$item->price_early_checkin.'</td>
                        <td>$'.$item->price_late_checkout.'</td>
                        <td>$'.number_format($item->price,2).'</td>
                    </tr>';
            }

            $totalPrice+=$item->price;

            $counter++;

        endforeach;

        if($tablaCananaAndTent==true){
            $tableCananaAndTent.='</table>';
            $allTables.=$tableCananaAndTent;
        }

        if($tablaCamped==true){
            $tableCamped.='</table>';
            $allTables.=$tableCamped;
        }

        if($tablaDayPasss==true){
            $tableDayPasss.='</table>';
            $allTables.=$tableDayPasss;
        }

        return '<div class="row-fluid">
                        '.$allTables.'
                        <table class="items table table-hover table-condensed" align="right" style="width: 40%">
                            <tbody>
                                <tr>
                                    <td><h3>'.Yii::t('mx','Grand Total').':</h3></td>
                                    <td><h3 style="text-align: right;">'.'$'.number_format(($totalPrice),2).' MX</h3></td>
                                </tr>
                            </tbody>
                        </table>
               </div>';

    }

    public function getPeakSeason($checkin,$checkout){
        $inicio=strtotime($checkin);
        $fin=strtotime($checkout);
        $peakseason=0;

        for($i=$inicio;$i<$fin;$i+=86400):
            $day=date("d", $i);
            $month=date("m", $i);
            $temporada=CalendarSeason::model()->season($day,$month);
            if($temporada->tipe=="ALTA") $peakseason++;

        endfor;

        return $peakseason;

    }

    public function getLowSeason($checkin,$checkout){
        $inicio=strtotime($checkin);
        $fin=strtotime($checkout);
        $lowseason=0;

        for($i=$inicio;$i<$fin;$i+=86400):
            $day=date("d", $i);
            $month=date("m", $i);
            $temporada=CalendarSeason::model()->season($day,$month);
            if($temporada->tipe=="BAJA") $lowseason++;

        endfor;

        return $lowseason;
    }

    public function getPeakSeasonDayPass($checkin){

        $inicio=strtotime($checkin);
        $peakseason=0;
        $day=date("d", $inicio);
        $month=date("m", $inicio);
        $temporada=CalendarSeason::model()->season($day,$month);

        if($temporada->tipe=="ALTA") $peakseason++;

        return $peakseason;

    }

    public function getLowSeasonDayPass($checkin){

        $inicio=strtotime($checkin);
        $lowseason=0;
        $day=date("d", $inicio);
        $month=date("m", $inicio);
        $temporada=CalendarSeason::model()->season($day,$month);

        if($temporada->tipe=="BAJA") $lowseason++;

        return $lowseason;
    }

    public function getEarlyCheckin($checkinHour,$totalPax){

        $priceEarlyCheckin=0;

        $hora1 = strtotime($checkinHour);  //hora en que se registra el pax
        $hora2 = strtotime( "15:00" ); //hora en que sebe registrarse el pax

        if( $hora1 < $hora2 ) {
            $priceEarlyCheckin=50*$totalPax;
        }

        return $priceEarlyCheckin;

    }


    public function getLateCheckOut($checkoutHour,$totalPax){

        $priceLateCheckout=0;

        $hora1 = strtotime($checkoutHour); //hora en que sale el pax
        $hora2 = strtotime("13:00");  //hora en que sebe salir el pax

        if( $hora1 > $hora2 ) {
            $priceLateCheckout=50*$totalPax;
        }

        return $priceLateCheckout;

    }


    public function getPriceCabana($adults,$children,$service_type,$room_type_id,$nights,$season){

        $details=0;
        $pax=$adults;
        $price=0;

        if($children > 2) $pax=$adults+($children-2);

        $criteria=array(
            'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId',
            'params'=>array('serviceType'=>$service_type,'roomTypeId'=>$room_type_id)
        );

        $reservationType=Rates::model()->find($criteria);
        $reservationTypeId=$reservationType->typeReservation->id;

        if($nights > 0){
            $details=Rates::model()->getPricePerPax($service_type,$room_type_id,$reservationTypeId,$season,$pax);
            $price=$details->prices[0]->price;
        }

        return $price;

    }

    public function getPriceTent($adults,$children,$service_type,$room_type_id,$nights,$season){

        $priceAdults=0;
        $priceChildren=0;
        $pax=$adults;
        $price=0;

        $criteria=array(
            'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId',
            'params'=>array('serviceType'=>$service_type,'roomTypeId'=>$room_type_id)
        );

        $reservationType=Rates::model()->find($criteria);
        $reservationTypeId=$reservationType->typeReservation->id;

        if($reservationTypeId==1){

            if($children > 2) $pax=$adults+($children-2);

            if($nights > 0){
                $details=Rates::model()->getPricePerPax($service_type,$room_type_id,$reservationTypeId,$season,$pax);
                $price=$details->prices[0]->price;
            }

        }
        else{

            if($nights > 0){
                $details=Rates::model()->getPricePerHeight($service_type,$room_type_id,$reservationTypeId,$season);
                $priceAdults=$details->adults*$adults;
                $priceChildren=$details->children*$children;
                $price=$priceAdults+$priceChildren;
            }

        }


        return $price;
    }

    public function getPriceCamped($adults,$children,$service_type,$room_type_id,$nights,$season){

        $priceAdults=0;
        $priceChildren=0;
        $price=0;

        $criteria=array(
            'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId',
            'params'=>array('serviceType'=>$service_type,'roomTypeId'=>$room_type_id)
        );

        $reservationType=Rates::model()->find($criteria);
        $reservationTypeId=$reservationType->typeReservation->id;

        if($nights > 0){
            $details=Rates::model()->getPricePerHeight($service_type,$room_type_id,$reservationTypeId,$season);
            $priceAdults=$details->adults*$adults;
            $priceChildren=$details->children*$children;
            $price=$priceAdults+$priceChildren;
        }

        return $price;

    }


    public function getPriceDaypass($adults,$children,$service_type,$room_type_id,$season){

        $priceAdults=0;
        $priceChildren=0;
        $price=0;

        $criteria=array(
            'condition'=>'service_type=:serviceType and room_type_id=:roomTypeId',
            'params'=>array('serviceType'=>$service_type,'roomTypeId'=>$room_type_id)
        );

        $reservationType=Rates::model()->find($criteria);
        $reservationTypeId=$reservationType->typeReservation->id;

        $details=Rates::model()->getPricePerHeight($service_type,$room_type_id,$reservationTypeId,$season);
        $priceAdults=$details->adults*$adults;
        $priceChildren=$details->children*$children;
        $price=$priceAdults+$priceChildren;

        return $price;
    }


    public function nights($d_start,$d_end){

        $nights= (strtotime($d_start)-strtotime($d_end))/86400;
        $nights= abs($nights);
        $nights = floor($nights);

        return $nights;
    }


    public function checkAvailability($checkin,$checkout){

        $checkin= Yii::app()->quoteUtil->toEnglishDateTime($checkin);
        $checkout= Yii::app()->quoteUtil->toEnglishDateTime($checkout);

        $checkin=date("Y-m-d",strtotime($checkin));
        $checkout=date("Y-m-d",strtotime($checkout));

        //     1                 2           3              4                  5           6         7          8         9         10         11        12
        //'AVAILABLE','BUDGET-SUBMITED','PRE-RESERVED','RESERVED-PENDING','RESERVED','CANCELLED','NO-SHOW','OCCUPIED','ARRIVAL','CHECKIN','CHECKOUT','DIRTY',
        //  5, 8,9,10

        $roomids=array();

        $criteriaInside=array(
            'condition'=>':checkin>= checkin and :checkout<=checkout and (statux=5 or statux=8 or statux=9 or statux=10)',
            'params'=>array(':checkin'=>$checkin,':checkout'=>$checkout)
        );

        $inside=Reservation::model()->findAll($criteriaInside);

        foreach($inside as $item):
            array_push($roomids,$item->room_id);
        endforeach;

        $criteriaInclude=array(
            'condition'=>':checkin<= checkin and :checkout>=checkout and (statux=5 or statux=8 or statux=9 or statux=10)',
            'params'=>array(':checkin'=>$checkin,':checkout'=>$checkout)
        );
        $include=Reservation::model()->findAll($criteriaInclude);

        foreach($include as $item):
            array_push($roomids,$item->room_id);
        endforeach;

        /*$criteriaLeft=array(
            'condition'=>':checkin< checkin and :checkout<=checkout and (statux=2 or statux=5)',
            'params'=>array(':checkin'=>$checkin,':checkout'=>$checkout)
        );
        $left=Reservation::model()->findAll($criteriaLeft);

        foreach($left as $item):
            array_push($roomids,$item->room_id);
        endforeach;
*/

        /*$criteriaRight=array(
            'condition'=>':checkin>= checkin and :checkout > checkout and (statux=2 or statux=5)',
            'params'=>array(':checkin'=>$checkin,':checkout'=>$checkout)
        );

        $right=Reservation::model()->findAll($criteriaRight);

        foreach($right as $item):
            array_push($roomids,$item->room_id);
        endforeach;*/

        return $roomids;

    }

    public function reservationUpdate($attributes){

        $pricepets=0;
        $priceLateCheckout=0;
        $models=array();

        $reservation=Reservation::model()->findByPk($attributes['id']);
        $statux=$reservation->statux;
        $description=$reservation->description;
        $reservation->attributes= $attributes;
        $reservation->statux=$statux;
        $reservation->description=$description;

        $checkin= $this->toEnglishDateTime($attributes['checkin']);
        $checkout= $this->toEnglishDateTime($attributes['checkout']);

        $reservation->checkin_hour=date("H:i",strtotime($checkin));
        $reservation->checkout_hour=date("H:i",strtotime($checkout));

        $reservation->checkin=date("Y-m-d",strtotime($checkin));
        $reservation->checkout=date("Y-m-d",strtotime($checkout));

        $reservation->nights=$this->nights($reservation->checkin,$reservation->checkout);
        $reservation->totalpax=$attributes['adults']+$attributes['children'];

        $reservation->nigth_ta=$this->getPeakSeason($reservation->checkin,$reservation->checkout);
        $reservation->nigth_tb=$this->getLowSeason($reservation->checkin,$reservation->checkout);

        $reservation->price_early_checkin=$this->getEarlyCheckin($reservation->checkin_hour,$reservation->totalpax);
        $reservation->price_late_checkout=$this->getLateCheckOut($reservation->checkout_hour,$reservation->totalpax);

        if($attributes['pets'] > 2) $pricepets=100*($attributes['pets']-2);

        if($attributes['service_type']=="CABANA"){  //cotizacion para cabaña

            $reservation->room_id=$attributes['room_id'];

            if($reservation->nigth_tb > 0){
                $reservation->price_tb=$this->getPriceCabana(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    $reservation->nigth_tb,'BAJA'
                );
            }

            if($reservation->nigth_ta > 0){
                $reservation->price_ta=$this->getPriceCabana(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    $reservation->nigth_ta,'ALTA'
                );
            }
            $reservation->price=($reservation->price_tb*$reservation->nigth_tb)+($reservation->price_ta*$reservation->nigth_ta)+($pricepets*$reservation->nights)+$reservation->price_early_checkin+$reservation->price_late_checkout;

        }

        if($attributes['service_type']=="TENT"){   //cotizacion para casa de campaña

            $reservation->room_id=$attributes['room_id'];

            if($reservation->nigth_tb > 0){
                $reservation->price_tb=$this->getPriceTent(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    $reservation->nigth_tb,'BAJA'
                );
            }
            if($reservation->nigth_ta > 0){
                $reservation->price_ta=$this->getPriceTent(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    $reservation->nigth_ta,'ALTA'
                );
            }

            $reservation->price=($reservation->price_tb*$reservation->nigth_tb)+($reservation->price_ta*$reservation->nigth_ta)+($pricepets*$reservation->nights)+$reservation->price_early_checkin+$reservation->price_late_checkout;

        }

        if($attributes['service_type']=="CAMPED"){  //cotizacion acampado

            $reservation->room_id=0;

            if($reservation->nigth_tb > 0){
                $reservation->price_tb=$this->getPriceCamped(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    $reservation->nigth_tb,'BAJA'
                );
            }

            if($reservation->nigth_ta > 0){
                $reservation->price_ta=$this->getPriceCamped(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    $reservation->nigth_ta,'ALTA'
                );
            }

            $reservation->price=($reservation->price_tb*$reservation->nigth_tb)+($reservation->price_ta*$reservation->nigth_ta)+($pricepets*$reservation->nights)+$reservation->price_early_checkin+$reservation->price_late_checkout;

        }

        if($attributes['service_type']=="DAYPASS"){  //cotizacion admision al parque

            $reservation->nigth_ta=$this->getPeakSeasonDayPass($attributes['checkin']);
            $reservation->nigth_tb=$this->getLowSeasonDayPass($attributes['checkin']);

            $hora3 = strtotime($reservation->checkout_hour); //hora en que sale el pax
            $hora4 = strtotime("18:00");  //hora en que sebe salir el pax
            if( $hora3 > $hora4 ) $priceLateCheckout=50*$reservation->totalpax;

            $reservation->price_early_checkin=0;
            $reservation->price_late_checkout=$priceLateCheckout;
            $reservation->room_id=0;

            if($reservation->nigth_tb > 0){
                $reservation->price_ta=$this->getPriceDaypass(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    'ALTA'
                );
            }
            if($reservation->nigth_ta > 0){
                $reservation->price_tb=$this->getPriceDaypass(
                    $attributes['adults'],$attributes['children'],
                    $attributes['service_type'],$attributes['room_type_id'],
                    'BAJA'
                );
            }

            $reservation->price=$reservation->price_ta+$reservation->price_tb+$pricepets+$reservation->price_late_checkout;

        }

        $models=array_merge($reservation->attributes,array(
            'checkin_hour'=>$reservation->checkin_hour,
            'checkout_hour'=>$reservation->checkout_hour,
            'service_type'=>$reservation->service_type
        ));

        $reservation->checkin=$reservation->checkin.' '.$reservation->checkin_hour;
        $reservation->checkout=$reservation->checkout.' '.$reservation->checkout_hour;

        $reservation->save();

        return $models;

    }


    public function reservationAdd($attributes){

        $pricepets=0;
        $priceLateCheckout=0;

        foreach($attributes as $item){

            $reservation=new Reservation;
            $reservation->attributes= $item;
            $reservation->customer_reservation_id=$item['customer_reservation_id'];
            $reservation->statux=1;

            $checkin= $this->toEnglishDateTime($item['checkin']);
            $checkout= $this->toEnglishDateTime($item['checkout']);

            $reservation->checkin_hour=date("H:i",strtotime($checkin));
            $reservation->checkout_hour=date("H:i",strtotime($checkout));

            $reservation->checkin=date("Y-m-d",strtotime($checkin));
            $reservation->checkout=date("Y-m-d",strtotime($checkout));

            $reservation->nights=$this->nights($reservation->checkin,$reservation->checkout);
            $reservation->totalpax=$item['adults']+$item['children'];

            $reservation->nigth_ta=$this->getPeakSeason($reservation->checkin,$reservation->checkout);
            $reservation->nigth_tb=$this->getLowSeason($reservation->checkin,$reservation->checkout);

            $reservation->price_early_checkin=$this->getEarlyCheckin($reservation->checkin_hour,$reservation->totalpax);
            $reservation->price_late_checkout=$this->getLateCheckOut($reservation->checkout_hour,$reservation->totalpax);

            if($item['pets'] > 2) $pricepets=100*($item['pets']-2);

            if($item['service_type']=="CABANA"){  //cotizacion para cabaña

                $reservation->room_id=$item['room_id'];

                if($reservation->nigth_tb > 0){
                    $reservation->price_tb=$this->getPriceCabana(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        $reservation->nigth_tb,'BAJA'
                    );
                }

                if($reservation->nigth_ta > 0){
                    $reservation->price_ta=$this->getPriceCabana(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        $reservation->nigth_ta,'ALTA'
                    );
                }
                $reservation->price=($reservation->price_tb*$reservation->nigth_tb)+($reservation->price_ta*$reservation->nigth_ta)+($pricepets*$reservation->nights)+$reservation->price_early_checkin+$reservation->price_late_checkout;

            }

            if($item['service_type']=="TENT"){   //cotizacion para casa de campaña

                $reservation->room_id=$item['room_id'];

                if($reservation->nigth_tb > 0){
                    $reservation->price_tb=$this->getPriceTent(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        $reservation->nigth_tb,'BAJA'
                    );
                }

                if($reservation->nigth_ta > 0){
                    $reservation->price_ta=$this->getPriceTent(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        $reservation->nigth_ta,'ALTA'
                    );
                }

                $reservation->price=($reservation->price_tb*$reservation->nigth_tb)+($reservation->price_ta*$reservation->nigth_ta)+($pricepets*$reservation->nights)+$reservation->price_early_checkin+$reservation->price_late_checkout;

            }

            if($item['service_type']=="CAMPED"){  //cotizacion acampado

                $reservation->room_id=0;

                if($reservation->nigth_tb > 0){
                    $reservation->price_tb=$this->getPriceCamped(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        $reservation->nigth_tb,'BAJA'
                    );
                }

                if($reservation->nigth_ta > 0){
                    $reservation->price_ta=$this->getPriceCamped(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        $reservation->nigth_ta,'ALTA'
                    );
                }

                $reservation->price=($reservation->price_tb*$reservation->nigth_tb)+($reservation->price_ta*$reservation->nigth_ta)+($pricepets*$reservation->nights)+$reservation->price_early_checkin+$reservation->price_late_checkout;

            }

            if($item['service_type']=="DAYPASS"){  //cotizacion admision al parque

                $reservation->nigth_ta=$this->getPeakSeasonDayPass($item['checkin']);
                $reservation->nigth_tb=$this->getLowSeasonDayPass($item['checkin']);

                $hora3 = strtotime($reservation->checkout_hour); //hora en que sale el pax
                $hora4 = strtotime("18:00");  //hora en que sebe salir el pax
                if( $hora3 > $hora4 ) $priceLateCheckout=50*$reservation->totalpax;

                $reservation->price_early_checkin=0;
                $reservation->price_late_checkout=$priceLateCheckout;
                $reservation->room_id=0;

                if($reservation->nigth_tb > 0){
                    $reservation->price_ta=$this->getPriceDaypass(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        'ALTA'
                    );
                }
                if($reservation->nigth_ta > 0){
                    $reservation->price_tb=$this->getPriceDaypass(
                        $item['adults'],$item['children'],
                        $item['service_type'],$item['room_type_id'],
                        'BAJA'
                    );
                }

                $reservation->price=$reservation->price_ta+$reservation->price_tb+$pricepets+$reservation->price_late_checkout;

            }

            $reservation->checkin=$reservation->checkin.' '.$reservation->checkin_hour;
            $reservation->checkout=$reservation->checkout.' '.$reservation->checkout_hour;
            $reservation->description=1;

            $reservation->save();

        }

    }

    public function exportDailyReport(){

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/cocotheme/css/table.css');

        $footer = '<div align="center">'.Yii::t('mx','Page').' {PAGENO} </div>';
        $mpdf = Yii::app()->ePdf->mpdf();
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText('COCOAVENTURA');
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->SetHTMLHeader($this->reportHeader());
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$this->dailyReport())));
        $mpdf->Output('Reporte-Diario.pdf','D');
    }


    public function dailyReport($date=null){

        if($date==null){
            $fecha1=date('Y-m-d');
        }else{
            $fecha1=$this->ToEnglishDateFromFormatdMyyyy($date);
            $fecha1=date('Y-m-d',strtotime($fecha1));
        }

        $total=0;
        $adultos=0;
        $niños=0;
        $mascotas=0;
        $columnas=array();
        $counter=0;

        $sql="SELECT DISTINCT(customer_reservations.id) as customerId,customer_reservations.see_discount,customer_reservations.total,
        reservation.*,rooms.room,customers.first_name,customers.last_name,customers.country,customers.state
        FROM customer_reservations
        INNER JOIN reservation on customer_reservations.id=reservation.customer_reservation_id
        INNER JOIN customers on customer_reservations.customer_id=customers.id
        INNER JOIN rooms on reservation.room_id=rooms.id
        WHERE (reservation.statux=:estado or reservation.statux=:estado2 or reservation.statux=:estado3) and reservation.checkin like :date1 order by customer_reservations.id";


        //INNER JOIN payments on customer_reservations.id=payments.customer_reservation_id

        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $command->bindValue(":estado", 'RESERVED' , PDO::PARAM_STR);
        $command->bindValue(":estado2", 'OCCUPIED' , PDO::PARAM_STR);
        $command->bindValue(":estado3", 'PRE-RESERVED' , PDO::PARAM_STR);
        $command->bindValue(":date1", $fecha1."%" , PDO::PARAM_STR);
        $dataReader=$command->queryAll();
        //$connection->active=false;
        $tabledailyreport='
            <p style="text-align:right">
                <span style="font-size:14px">
                    <strong><span style="font-family:arial,helvetica,sans-serif">HOJA DE REPORTE DIARIO:&nbsp;'.$fecha1.'</span></strong>
                </span>
            </p>
            <table class="items table table-condensed table-striped">
                 <tfoot>
                    <tr><td colspan="10" rowspan="1">&nbsp;</td></tr>
                    <tr><td colspan="10" rowspan="1">&nbsp;</td></tr>
                </tfoot>
            <tbody>
        ';


        $grupo=null;

        foreach($dataReader as $item){

            $totalReservation=Reservation::model()->count(
                'customer_reservation_id=:customerReservationId',
                array('customerReservationId'=>$item['customerId'])
            );

            $grupoant=$grupo;
            $grupo=$item['customerId'];

            $room=explode('-',$item['room']);
            $room=(int)$room[1];

            $pagosCliente=0;
            $saldo=0;

            $pricepets=$this->pricePets((int)$item['pets']);
            $discoutCabanas=($item['see_discount']==1) ? $this->getTotalDiscountCabanas($item['price']) : 0;
            $tot_noch_ta=$item['nigth_ta']*$item['price_ta'];
            $tot_noch_tb=$item['nigth_tb']*$item['price_tb'];

            $sqlPayments="SELECT * FROM payments where customer_reservation_id=:customerReservationId";
            $command=Yii::app()->db->createCommand($sqlPayments);
            $command->bindValue(":customerReservationId", $item['customerId'] , PDO::PARAM_INT);
            $payments=$command->queryAll();

            if($payments){
                foreach($payments as $pago){
                    $pagosCliente=$pagosCliente+$pago['amount'];
                }
            }

            if($item['see_discount']==1){
                $discoutCabanas= $this->getTotalDiscountCabanas($item['total']);
                $saldo=$item['total']-$discoutCabanas-$pagosCliente;
            }else{
                $saldo=$item['total']-$pagosCliente;
            }

            if($grupoant != $grupo){
                $tabledailyreport.='<tr><td colspan="7" align="center" bgcolor="#CCCCCC"><strong>'.strtoupper($item['first_name']." ".$item['last_name']).'</strong></td></tr>';
            }


            $tabledailyreport.='
                    <tr>
                        <td>
                            <p>Caba&ntilde;a: '.$item['room'].'</p>
                            <p>Checkin: '.$item['checkin'].'</p>
                            <p>Checkout: '.$item['checkout'].'</p>
                            <p>Estatus: '.$item['statux'].'</p>
                        </td>
                        <td>
                            <p>Id: '.$item['customerId'].'</p>
                            <p>Nombre: '.$item['first_name'].' '.$item['last_name'].'</p>
                            <p>Pais: '.$item['country'].'</p>
                            <p>Estado: '.$item['state'].'</p>
                        </td>
                        <td>
                            <p>Adultos: '.$item['adults'].'</p>
                            <p>Menores 10a: '.$item['children'].'</p>
                            <p>Mascotas:'.$item['pets'].'</p>
                        </td>
                        <td>
                            <p>Noches Tot: '.$item['nights'].'</p>
                            <p>Noches TA: '.$item['nigth_ta'].'</p>
                            <p>Noches TB: '.$item['nigth_tb'].'</p>
                        </td>
                        <td>
                            <p>Prec x noch TA: '.$item['price_ta'].'</p>
                            <p>Prec x noch TB: '.$item['price_tb'].'</p>
                            <p>Prec x noch Masc: '.$pricepets.'</p>
                        </td>
                        <td>
                            <p>Tot noch TA: '.$tot_noch_ta.'</p>
                            <p>Tot noch TB: '.$tot_noch_tb.'</p>
                        </td>
                        <td>
                            <p>Early check-in: '.$item['price_early_checkin'].'</p>
                            <p>Late check-out: '.$item['price_late_checkout'].'</p>
                        </td>
		            </tr>
                    ';

            $counter++;

            if($counter == $totalReservation){

                $total=$total+$saldo;

                $tabledailyreport.='
                     <tr>
		                <td colspan="10" rowspan="1" style="text-align:right; vertical-align:middle">
                            <p style="text-align:right"><strong>Subtotal: '.$item['total'].'</strong></p>
                            <p style="text-align:right"><strong>Anticipo: '.$pagosCliente.'</strong></p>
                            <p style="text-align:right"><strong>Descuento: '.$discoutCabanas.'</strong></p>
                            <p style="text-align:right"><strong>Debe: '.$saldo.'</strong></p>
		                </td>
		            </tr>
                ';

                $counter=0;
            }

            $adultos=$adultos+$item['adults'];
            $niños=$niños+$item['children'];
            $mascotas=$mascotas+$item['pets'];
        }


        $tabledailyreport.='
                <tr style="background:#EEEEEE;">
                    <td valign="middle" colspan="5" rowspan="1" style="text-align: center;vertical-align:middle;"><strong>TOTALES:</strong></td>
                    <td>
                        <p><strong>Adultos:</strong> '.$adultos.'</p>
                        <p><strong>Ni&ntilde;os:</strong> '.$niños.'</p>
                        <p><strong>Mascotas:</strong> '.$mascotas.'</p>
                    </td>
                    <td style="text-align: center;vertical-align:middle;">$'.number_format($total,2).'</td>
                </tr>
                ';

        $tabledailyreport.='</tbody></table>';

        return $tabledailyreport;

    }


    public function reservationTable(){
        $tabledailyreport='';
        $counter=0;
        $grupo=null;
        $total=0;
        $roomName="";
        $count=0;
        $model=array();

        $sql="SELECT customer_reservations.id as customerReservationID,customer_reservations.see_discount,reservation.*,
        customers.first_name,customers.state FROM customer_reservations inner join reservation on
        customer_reservations.id=reservation.customer_reservation_id inner join customers on
        customer_reservations.customer_id=customers.id where substr(checkin,1,10)>=CURDATE() and substr(checkout,1,10)>=CURDATE()
        order by reservation.checkin";

        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql);
        $dataReader=$command->queryAll();

        $reservationTable='
        <div style="width:100%; height:500px; overflow: scroll;"  id="reservations-grid" class="grid-view">
            <table class="items table table-hover table-condensed table-bordered">
            <thead>
                <tr>
                    <th>'.Yii::t('mx','Cabana').'</th>
                    <th>'.Yii::t('mx','Check In').'</th>
                    <th>'.Yii::t('mx','Check In Time').'</th>
                    <th>'.Yii::t('mx','Check Out').'</th>
                    <th>'.Yii::t('mx','Check Out Time').'</th>
                    <th>'.Yii::t('mx','State').'</th>
                    <th>'.Yii::t('mx','Adults').'</th>
                    <th>'.Yii::t('mx','Children').'</th>
                    <th>'.Yii::t('mx','Pets').'</th>
                    <th># '.Yii::t('mx','Nights').'</th>
                    <th># '.Yii::t('mx','Nights').' Ta</th>
                    <th># '.Yii::t('mx','Nights').' Tb</th>
                    <th>'.Yii::t('mx','Price x Night').' Ta</th>
                    <th>'.Yii::t('mx','Price x Night').' Tb</th>
                    <th>'.Yii::t('mx','Price Early Check In').'</th>
                    <th>'.Yii::t('mx','Price Late Check Out').'</th>
                    <th>'.Yii::t('mx','Price').'</th>
                </tr>
            <thead>
            <tbody>
                <tr>
        ';

        foreach($dataReader as $item){


            if($item['room_id'] !=0){
                $room=Rooms::model()->findByPk($item['room_id']);
                $roomName=$room->room;
            }
            else{ $roomName=$item['service_type'];  }

            $totalReservation=Reservation::model()->count(
                'customer_reservation_id=:customerReservationId',
                array('customerReservationId'=>$item['customerReservationID'])
            );

            $grupoant=$grupo;
            $grupo=$item['first_name'];

            $in= date("Y-m-d H:i",strtotime($item['checkin']));
            $out= date("Y-m-d H:i",strtotime($item['checkout']));
            $checkin=$this->toSpanishDate(date("Y-M-d",strtotime($in)));
            $checkout=$this->toSpanishDate(date("Y-M-d",strtotime($out)));
            $checkin_time=date("H:i",strtotime($in));
            $checkout_time=date("H:i",strtotime($out));

            if($grupoant != $grupo){

                $view=Yii::app()->createUrl('reservation/view',array('id'=>$item['customerReservationID']));
                $payment=Yii::app()->createUrl('/payments/index',array('id'=>$item['customerReservationID']));

                $reservationTable.='<tr>
                <td colspan="17" align="center" bgcolor="#EEEEEE"><strong>'.$item['first_name'].' - '.$item['state'].'</strong>
                    <div class="pull-right">

                        <a style="margin-right:10px;" class="view" title="'.Yii::t('mx','Details Reservation').'" rel="tooltip" href="'.$view.'">
                            <i class="icon-eye-open icon-2x"></i>
                        </a>

                        <a style="margin-right:10px;" class="view" title="'.Yii::t('mx','Register Deposit').'" rel="tooltip" href="'.$payment.'">
                            <i class="icon-money icon-2x"></i>
                        </a>

                    </div>
                </td>
            </tr>';
            }

            $reservationTable.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
            $reservationTable.='
                        <td>'.$roomName.'</td>
                        <td>'.$checkin.'</td>
                        <td>'.$checkin_time.'</td>
                        <td>'.$checkout.'</td>
                        <td>'.$checkout_time.'</td>
                        <td>'.Yii::t('mx',$item['statux']).'</td>
                        <td>'.$item['adults'].'</td>
                        <td>'.$item['children'].'</td>
                        <td>'.$item['pets'].'</td>
                        <td>'.$item['nights'].'</td>
                        <td>'.$item['nigth_ta'].'</td>
                        <td>'.$item['nigth_tb'].'</td>
                        <td>'.$item['price_ta'].'</td>
                        <td>'.$item['price_tb'].'</td>
                        <td>'.$item['price_early_checkin'].'</td>
                        <td>'.$item['price_late_checkout'].'</td>
                        <td>'.number_format($item['price'],2).'</td>
                    </tr>';
            $counter++;
            $total+=$item['price'];

            $model[]=array(
                'service_type'=>$item['service_type'],
                'price'=>$item['price'],
                'totalpax'=>$item['totalpax']
            );

            if($counter == $totalReservation){

                if($item['see_discount']==1){
                    $reservationTable.='<tr><td colspan="17">';
                    $reservationTable.=Yii::app()->quoteUtil->getTableDiscount($model);
                    $reservationTable.='</td></tr>';
                }else{
                    $reservationTable.='<tr>
                    <td colspan="17" class="pull-rigth">
                        <h5 style="text-align: right;">
                            <strong>'.Yii::t('mx','Total').': '.number_format($total,2).'</strong>
                        </h5>
                    </td>
                    </tr>';
                }



                $counter=0;
                $total=0;
                $model=array();
            }

        }

        $reservationTable.='</tbody></table></div>';

        return  $reservationTable;

    }

    public function exportPdf(){

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/cocotheme/css/style.css');
        $footer = '<div align="center">'.Yii::t('mx','Pager').' {PAGENO} </div>';

        $table=$this->reservationTable();

        $mpdf = Yii::app()->ePdf->mpdf('c','letter',10,'',10,10,30,20,10,10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText('COCOAVENTURA');
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->SetHTMLHeader($this->reportHeader());
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$table)));
        $mpdf->Output('reporte.pdf','D');  //EYiiPdf::OUTPUT_TO_DOWNLOAD

    }

    public function ExportBalance($data){
        $counter=0;

        $tableBalance='
        <div class="grid-view">
            <table class="items table table-condensed table-bordered table-striped">
                <thead>
                    <tr>
                        <th>'.Yii::t('mx','Payment Type').'</th>
                        <th>'.Yii::t('mx','Cheq').'</th>
                        <th>'.Yii::t('mx','Date').'</th>
                        <th>'.Yii::t('mx','Rid To').'</th>
                        <th>'.Yii::t('mx','Concept').'</th>
                        <th>'.Yii::t('mx','Person').'</th>
                        <th>'.Yii::t('mx','Bank Concept').'</th>
                        <th>'.Yii::t('mx','Retirement').'</th>
                        <th>'.Yii::t('mx','Deposit').'</th>
                        <th>'.Yii::t('mx','Balance').'</th>
                    </tr>
                <thead>
            <tbody>
        ';


        foreach($data as $item):

            $tableBalance.= ($counter % 2 == 0) ? '<tr  class="odd">' :  '<tr class="even">';
            $tableBalance.='
                        <td>'.$item->payment->payment.'</td>
                        <td>'.$item->cheq.'</td>
                        <td>'.$this->toSpanishDate(date('Y-M-d',strtotime($item->datex))).'</td>
                        <td>'.$item->released.'</td>
                        <td>'.$item->concept.'</td>
                        <td>'.$item->person.'</td>
                        <td>'.$item->bank_concept.'</td>
                        <td>$'.number_format($item->retirement,2).'</td>
                        <td>$'.number_format($item->deposit,2).'</td>
                        <td>$'.number_format($item->balance,2).'</td>
                    </tr>';

            $counter++;

        endforeach;

        $tableBalance.='</tbody></table></div>';

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/cocotheme/css/style.css');
        $footer = '<div align="center">'.Yii::t('mx','Pager').' {PAGENO} </div>';

        $mpdf = Yii::app()->ePdf->mpdf('c','letter',10,'',10,10,30,20,10,10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText('COCOAVENTURA');
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->SetHTMLHeader($this->reportHeader());
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$tableBalance)));
        $mpdf->Output('reporte.pdf','D');  //EYiiPdf::OUTPUT_TO_DOWNLOAD

    }

    public function ExportPdfToAccountant($data){
        $counter=0;

        $tableBalance='
        <div class="grid-view">
            <table class="items table table-condensed table-bordered table-striped">
                <thead>
                    <tr>

                        <th>'.Yii::t('mx','Cheq').'</th>
                        <th>'.Yii::t('mx','Rid To').'</th>
                        <th>'.Yii::t('mx','Concept').'</th>
                        <th>'.Yii::t('mx','Retirement').'</th>
                        <th>'.Yii::t('mx','Deposit').'</th>
                        <th>'.Yii::t('mx','Balance').'</th>
                    </tr>
                <thead>
            <tbody>
        ';

        foreach($data as $item):

            $tableBalance.= ($counter % 2 == 0) ? '<tr  class="odd">' :  '<tr class="even">';
            $tableBalance.='
                        <td>'.$item->cheq.'</td>
                        <td>'.$item->released.'</td>
                        <td>'.$item->concept.'</td>
                        <td>$'.number_format($item->retirement,2).'</td>
                        <td>$'.number_format($item->deposit,2).'</td>
                        <td>$'.number_format($item->balance,2).'</td>
                    </tr>';

            $counter++;

        endforeach;

        $tableBalance.='</tbody></table></div>';

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/cocotheme/css/style.css');
        $footer = '<div align="center">'.Yii::t('mx','Pager').' {PAGENO} </div>';

        $mpdf = Yii::app()->ePdf->mpdf('c','letter',10,'',10,10,30,20,10,10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText('COCOAVENTURA');
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->SetHTMLHeader($this->reportHeader());
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$tableBalance)));
        $mpdf->Output('reporte.pdf','D');  //EYiiPdf::OUTPUT_TO_DOWNLOAD

    }


    public function EmailFormats($customerReservationId,$format,$response=null,$bankId=null){


        $criteriaReserv=array(
            'condition'=>'customer_reservation_id=:customer',
            'params'=>array(':customer'=>$customerReservationId),
        );

        $customerReservation=CustomerReservations::model()->findByPk($customerReservationId);
        $customer=Customers::model()->findByPk($customerReservation->customer_id);
        $settings=Settings::model()->find();
        $reservations=Reservation::model()->findAll($criteriaReserv);

        $payments=Payments::model()->findAll(array(
            'condition'=>'customer_reservation_id=:customerReservationId',
            'params'=>array(':customerReservationId'=>$customerReservationId)
        ));

        $payment=0;
        $totalCotizacion=0;
        $emailformatId=(int)$format;

        if($reservations){
            foreach($reservations as $item):

                $checkin= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkin);
                $checkout= Yii::app()->quoteUtil->ToEnglishDateTime($item->checkout);

                $checkin_time=date("H:i",strtotime($checkin));
                $checkout_time=date("H:i",strtotime($checkout));

                $checkin=date("Y-m-d",strtotime($checkin));
                $checkout=date("Y-m-d",strtotime($checkout));

                $models[]=array(
                    'id' =>$item->id,
                    'service_type' =>$item->service_type,
                    'room_type_id'=>$item->room_type_id,
                    'customer_reservation_id' =>$item->customer_reservation_id,
                    'room_id' =>$item->room_id,
                    'checkin' =>$checkin,
                    'checkout' =>$checkout,
                    'adults' =>$item->adults,
                    'children' =>$item->children,
                    'pets' =>$item->pets,
                    'totalpax' =>$item->totalpax,
                    'statux' =>$item->statux,
                    'nigth_ta' =>$item->nigth_ta,
                    'nigth_tb' =>$item->nigth_tb,
                    'nights' =>$item->nights,
                    'price_ta' =>$item->price_ta,
                    'price_tb' => $item->price_tb,
                    'price_early_checkin' =>$item->price_early_checkin,
                    'price_late_checkout' =>$item->price_late_checkout,
                    'price' => $item->price,
                    'description' => $item->description,
                    'checkin_hour'=>$checkin_time,
                    'checkout_hour'=>$checkout_time
                );
            endforeach;
        }

        $fecha = date_create(date('Y-m-d'));
        date_add($fecha, date_interval_create_from_date_string($settings->days_limit_of_payment.' days'));
        $limitDayPayment=date_format($fecha, 'Y-M-d');
        $pagoRestantePorciento=100-(int)$settings->early_payment;

        if($customerReservation->see_discount==true){
            $tabla=Yii::app()->quoteUtil->getTableCotizacion($models);
            $totalCotizacion=Yii::app()->quoteUtil->getTotalPrice($models,true);
        }

        if($customerReservation->see_discount==false){
            $tabla=Yii::app()->quoteUtil->getCotizacionNoDiscount($models);
            $totalCotizacion=Yii::app()->quoteUtil->getTotalPrice($models,false);
        }

        $userId=(int)Yii::app()->user->id;

        $employee=Employees::model()->find(array('condition'=>'user_id=:userId','params'=>array('userId'=>$userId)));

        $atte='<p>'.$employee->first_name." ".$employee->middle_name." ".$employee->last_name.'</p>';

        if($bankId) $bank=$this->getBankInformation($bankId);
        else $bank=null;


        $search=array(
            '{NOMBRE-CLIENTE}','{APELLIDO-CLIENTE}',
            '{PAIS-CLIENTE}','{ESTADO-CLIENTE}',
            '{CIUDAD-CLIENTE}','{TELEFONO-CASA-CLIENTE}',
            '{TELEFONO-TRABAJO-CLIENTE}','{TELEFONO-CELULAR-CLIENTE}',
            '{EMAIL-CLIENTE}','{EMAIL-ALTERNATIVO-CLIENTE}',
            '{RESPUESTA}','{TABLA-COTIZACION}',
            '{NOMBRE-USUARIO}','{PUESTO-USUARIO}',
            '{DIAS-LIMITE-PAGO}','{PAGO-A-DEPOSITAR-CLIENTE}',
            '{%-PAGO-ADELANTO-CLIENTE}','{%-SALDO-CLIENTE}',
            '{SALDO-PENDIENTE-CLIENTE}','{TABLA-INFO-CUENTA}',
            '{PRIMER-PAGO}'
        );


        //si es envio de cuenta
        if($emailformatId==1){

            $totalAPagar=($totalCotizacion*(int)$settings->early_payment)/100;
            $totalAPagar=number_format($totalAPagar,2);

            $balance=($totalCotizacion*$pagoRestantePorciento)/100;
            $balance=number_format($balance,2);

            $replace=array(
                $customer->first_name,$customer->last_name,
                $customer->country,$customer->state,
                $customer->city,$customer->home_phone,
                $customer->work_phone,$customer->cell_phone,
                $customer->email,$customer->alternative_email,
                $response,$tabla,
                $employee->first_name." ".$employee->middle_name." ".$employee->last_name,$employee->job_title,
                $limitDayPayment,$totalAPagar,
                $settings->early_payment,$pagoRestantePorciento,
                $balance,$bank,
                $totalAPagar
            );

        }

        //si es confirmacion de pago
        if($emailformatId==2){

            foreach($payments as $pago){
                $payment=$payment+$pago->amount;
            }

            $totalPagado=$payment;
            $balance=$totalCotizacion-$totalPagado;
            $balance=number_format($balance,2);

            $replace=array(
                $customer->first_name,$customer->last_name,
                $customer->country,$customer->state,
                $customer->city,$customer->home_phone,
                $customer->work_phone,$customer->cell_phone,
                $customer->email,$customer->alternative_email,
                $response,$tabla,
                $employee->first_name." ".$employee->middle_name." ".$employee->last_name,$employee->job_title,
                $limitDayPayment,number_format($totalPagado,2),
                $settings->early_payment,$pagoRestantePorciento,
                $balance,$bank,
                number_format($totalPagado,2)
            );

        }


        $sql2="select * from email_format_items where email_format_id=:formatId order by orden asc";
        $connection=Yii::app()->db;
        $command=$connection->createCommand($sql2);
        $command->bindValue(":formatId", $emailformatId , PDO::PARAM_INT);
        $emailItems=$command->queryAll();

        $formato="";

        foreach($emailItems as $item):
            $politicas=Policies::model()->findByPk($item['name']);
            $formato.=$politicas->content;
        endforeach;

        $formato=str_replace($search,$replace,$formato);

        return $formato;

    }


   public function getBankInformation($bankId){

       $bank=BankAccounts::model()->findByPk($bankId);

       $table='

       <table border="1" cellpadding="1" cellspacing="1">
            <thead>
                <tr>
                    <th scope="row" style="text-align: right;">
                        <strong><span style="font-weight: bold; text-align: center;">'.Yii::t('mx','Name').'</span></strong>
                    </th>
                    <th scope="col" style="text-align: right;">'.$bank->account_name.'</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row" style="text-align: right;">
                        <strong>'.Yii::t('mx','Bank').'</strong>
                    </th>
                    <td style="text-align: right;">'.$bank->bank->bank.'</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: right;">
                        <strong><span style="font-weight: bold; text-align: center;">'.Yii::t('mx','Account').'</span></strong>
                    </th>
                    <td style="text-align: right;">'.$bank->account_number.'</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: right;">
                        <strong>'.Yii::t('mx','Clabe').'</strong>
                    </th>
                    <td style="text-align: right;">'.$bank->clabe.'</td>
                </tr>
                <tr>
                    <th scope="row" style="text-align: right;">
                        <strong>'.Yii::t('mx','Rfc').'</strong>
                    </th>
                    <td style="text-align: right;">'.$bank->bank->rfc.'</td>
                </tr>
            </tbody>
        </table>';

       return $table;

}

    public function reportsBalance($model,$limit){

        $counter=0;
        $grupo=null;
        $grupoant=0;

        $table='
            <table class="items table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>'.Yii::t('mx','Operation').'</th>
                        <th>'.Yii::t('mx','Register').'</th>
                        <th>'.Yii::t('mx','Movement').'</th>
                        <th>'.Yii::t('mx','Balance').'</th>
                        <th>'.Yii::t('mx','Date').'</th>
                    </tr>
                <thead>
            <tbody>
                <tr>
        ';

        foreach($model as $item){

            $grupobrazalet=0;

            $grupoant=$grupo;
            $grupo=$item['names'];

            $braceletant=$grupobrazalet;
            $grupobrazalet=$item['bracelet_id'];

            $balance=$item['balance'];
            $lista=array();

            if($grupoant != $grupo){
                $table.='<tr><td colspan="5" align="center" bgcolor="#CCCCCC"><strong>'.strtoupper($item['names']).'</strong></td></tr>';
            }

            if($braceletant != $grupobrazalet){

                $bracelet=Bracelets::model()->findByPk($item['bracelet_id']);
                $table.='<tr><td colspan="5" align="center" bgcolor="#CCCCCC"><strong>'.$bracelet->color.'</strong></td></tr>';
                unset($bracelet);
            }

            $history=BraceletsHistory::model()->findAll(
                array(
                    'condition' => 'assignment_id=:assignmentId',
                    'params'=>array('assignmentId'=>$item['id']),
                    'order'=>'datex desc',
                    'limit'=>$limit
                )
            );

            $lista=$this->getHistoryBracelets($history,$balance);

            unset($history);

            foreach($lista as $i){
                $table.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $table.='
                            <td>'.$i['operation'].'</td>
                            <td>'.$i['register'].'</td>
                            <td>'.$i['movement'].'</td>
                            <td>'.$i['balance'].'</td>
                            <td>'.$i['datex'].'</td>
                        </tr>';
                $counter++;

                unset($i);
            }

            unset($lista);
            unset($item);

        }

        $table.='</tbody></table>';
        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/cocotheme/css/style.css');

        $footer = '<div align="center">'.Yii::t('mx','Pager').' {PAGENO} </div>';

        $mpdf = Yii::app()->ePdf->mpdf('c','A4','','',10,10,45,20,10,10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->SetWatermarkText('COCOAVENTURA');
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->showWatermarkText = true;
        $mpdf->mirrorMargins = 1;
        $mpdf->SetHTMLHeader($this->reportHeader());
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$table)));
        $mpdf->Output('reporte.pdf','D');  //EYiiPdf::OUTPUT_TO_DOWNLOAD

        unset($mpdf);

    }

    public function getHistoryBracelets($history,$balance){

        $aux=$balance;
        $lista=array();

        foreach($history as $ix=>$itemx){

            $saldo=0;

            $lista[]=$itemx->attributes;

            if($itemx->operation=='COMPRA'){
                $saldo=$aux;
                $lista[$ix]['balance']=$saldo;
                $aux=$saldo-$itemx->quantity;
            }

            if($itemx->operation=='VENTA'){
                $saldo=$aux;
                $lista[$ix]['balance']=$saldo;
                $aux=$saldo+$itemx->quantity;
            }

            if($itemx->operation=='TRANSFERENCIA'){

                $pos =  strpos($itemx->movement,'+');

                if($pos !== FALSE){
                    $saldo=$aux;
                    $lista[$ix]['balance']=$saldo;
                    $aux=$saldo-$itemx->quantity;
                }

            }

            if($itemx->operation=='TRANSFERENCIA'){

                $pos = strpos($itemx->movement,'-');

                if($pos !== FALSE){
                    $saldo=$aux;
                    $lista[$ix]['balance']=$saldo;
                    $aux=$saldo+$itemx->quantity;
                }
            }

        }

        return $lista;
    }


    public function changePriority($taskId){

        $task=Tasks::model()->findByPk($taskId);

        $days= (strtotime($task->date_due)-strtotime(date("Y-m-d")))/86400;
        $days= abs($days);
        $days = floor($days);

        if($days<=3) $task->priority=1;
        $task->save();

    }


    public function cronjob(){

        $list=Tasks::model()->findAll(array(
            'condition'=>'status!=4',
            'order'=>'priority'
        ));


        foreach($list as $task){

            $datedue=$this->toEnglishDateTime1($task->date_due);
            $expiration=new DateTime($datedue);
            $currentDate= new DateTime(date('Y-m-d H:i'));
            $dif=date_diff($currentDate,$expiration);
            $day=(int)$dif->d;

            switch($task->priority){

                case 2: $tarea=Tasks::model()->findByPk($task->id);
                    if($day==3){
                        $tarea->priority=1;
                        $tarea->save();
                    }
                    break;

                case 3: $tarea=Tasks::model()->findByPk($task->id);
                    if($day==4){
                        $tarea->priority=2;
                        $tarea->save();
                    }
                    if($day==3){
                        $tarea->priority=1;
                        $tarea->save();
                    }
                    break;

                case 4: $tarea=Tasks::model()->findByPk($task->id);
                    if($day==5){
                        $tarea->priority=3;
                        $tarea->save();
                    }
                    if($day==4){
                        $tarea->priority=2;
                        $tarea->save();
                    }
                    if($day==3){
                        $tarea->priority=1;
                        $tarea->save();
                    }
                    break;
                case 5: $tarea=Tasks::model()->findByPk($task->id);
                    if($day==6){
                        $tarea->priority=4;
                        $tarea->save();
                    }
                    if($day==5){
                        $tarea->priority=3;
                        $tarea->save();
                    }
                    if($day==4){
                        $tarea->priority=2;
                        $tarea->save();
                    }
                    if($day==3){
                        $tarea->priority=1;
                        $tarea->save();
                    }
                    break;
            }

        }

    }



    private function reSchedule($name, DateTime $time, $url, $command, $frequency) {


        $time = new DateTime(date('Y-m-d'));
        $interval = 'P1D'; //P7D semanal - mensual P1M
        $time->add(new DateInterval($interval));

        if ($frequency === 'once')
            return;

        switch ($frequency) {

            case self::DAILY:
                $interval = 'P1D';
                break;

            case self::WEEKLY:
                $interval = 'P7D';
                break;

            case self::MONTHLY:
                $interval = 'P1M';
                break;
            default:
                echo 'invalid frequency...';
                break;
        }

        $time->add(new DateInterval($interval));

        $this->schedule($name, $time, $url, $command, $frequency);


    }

    public function diaSemana($fecha){

        $date=explode('-',$fecha);
        $ano=(int)$date[0];
        $mes=(int)$date[1];
        $dia=(int)$date[2];

        // 0->domingo	 | 6->sabado
        $dia= date("w",mktime(0, 0, 0, $mes, $dia, $ano));

       return $dia;
    }


    public function getdiasReales($diadelasemana,$diasparapagar,$hora,$disponibilidad){

        $i=$diadelasemana;
        $fin=$diadelasemana+$diasparapagar;
        $dias=array('DOM','LUN','MAR','MIE','JUE','VIE','SAB');
        $d=0;
        $c=$i;
        $rldias=array();
        $hora1 = strtotime($hora);
        $hora2 = strtotime("13:00");
        $disp=$disponibilidad;

        while($i<$fin){
            if($c<=6){
                if($dias[$c]!='DOM' && $dias[$c]!='SAB'){
                    if($disponibilidad>=50){
                        $d++;
                        array_push($rldias,$dias[$c]);
                        if($i==$diadelasemana){
                            if($hora1>=$hora2){
                                $d--;
                                array_pop($rldias);
                            }
                        }
                    }else{
                        $disp="Requerido 50%";
                    }
                }
                $c++;
            }
            else{
                $c=0;
                if($dias[$c]!='DOM' && $dias[$c]!='SAB'){
                    if($disponibilidad>=50){
                        $d++;
                        array_push($rldias,$dias[$c]);
                        if($i==$diadelasemana){
                            if($hora1>=$hora2){
                                $d--;
                                array_pop($rldias);
                            }
                        }
                    }else{
                        $disp="Requerido 50%";
                    }
                }
                $c++;
            }
            $i++;
        }

        $rdias=implode(',',$rldias);

        return array('dias'=>$d,'diasSemana'=>$rdias,'disp'=>$disp);

    }

    public function convertToLatitude($ndegrees,$nminuts,$nseconds){

        $latitude=$ndegrees+($nminuts/60)+($nseconds/3600);
        $latitude=$this->rounded($latitude,4);

        return $latitude;

    }

    public function convertToLongitude($wdegrees,$wminuts,$wseconds){

        $longitude=$wdegrees+($wminuts/60)+($wseconds/3600);
        $longitude=$this->rounded($longitude,4);
        return $longitude;
    }

    function rounded($number, $decimals) {
        $factor = pow(10, $decimals);
        return (round($number*$factor)/$factor);
    }


    function numtoletras($xcifra)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
//
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {

                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }


    function numtoletras2($xcifra)
    {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
//
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas

                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {

                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada

                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena.= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena.= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN BILLON ";
                        else
                            $xcadena.= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena.= "UN MILLON ";
                        else
                            $xcadena.= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            //$xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            //$xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                            //$xcadena.= " PESOS $xdecimales/100 M.N. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

// END FUNCTION

    function subfijo($xx)
    { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }


    function fechaALetras($fecha){
        $fecha_separada=explode("-", $fecha);

        $dia= strtolower($this->numtoletras2($fecha_separada[0]));

        switch ($fecha_separada[1]) {

            case 'Ene': $mes='Enero';  break;
            case 'Feb': $mes='Febrero'; break;
            case 'Mar': $mes='Marzo';  break;
            case 'Abr': $mes='Abril';  break;
            case 'May': $mes='Mayo'; break;
            case 'Jun': $mes='Junio';  break;
            case 'Jul': $mes='Julio'; break;
            case 'Ago': $mes='Agosto'; break;
            case 'Sep': $mes='Septiembre'; break;
            case 'Oct': $mes='Octubre'; break;
            case 'Nov': $mes='Noviembre'; break;
            case 'Dic': $mes='Diciembre'; break;

            default:
                break;
        }

        $anio= strtolower($this->numtoletras2($fecha_separada[2]));


        return "$dia días del mes de $mes del año $anio";
    }


    public function ContractToPdf($id){

        $model= ContractInformation::model()->findByPk($id);
        $footer = '<div align="center">'.Yii::t('mx','Pager').' {PAGENO} </div>';
        $mpdf = Yii::app()->ePdf->mpdf('c','letter','','',10,10,25,20,10,10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->mirrorMargins = 1;
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$model->content)));
        $mpdf->Output('reporte.pdf','D');  //EYiiPdf::OUTPUT_TO_DOWNLOAD

    }

    public function Download($file,$size){

        if(file_exists($file)) {
            header('Content-Type: application/force-download');
            header('Content-Type: application/octet-stream');
            header('Content-Type: application/download');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.$size);
            header('Content-Disposition: attachment; filename="'.basename($file).'";');
            //ob_clean();
            //flush();
            readfile($file);
            //exit;
        }

    }

    public function generaPoliza($poliza,$polizaTitle,$resumenTitle){

        $invoiceIds=$poliza->invoice_ids;
        $authorized=$poliza->authorized->initials;
        $userId=$poliza->user_id;
        $table="";

        if($poliza->payment_type==1 || $poliza->payment_type==2 || $poliza->payment_type==3){  //CUENTA CHEQUES

            $cheque=$poliza->operations->cheq;


            $cuenta=$poliza->operations->accountBank->bank->bank."-".substr($poliza->operations->accountBank->account_number,-3);
            $concepto=$poliza->operations->concept;
            $released=$poliza->operations->released;
            $date=$poliza->operations->datex;
            $retirement=$poliza->operations->retirement;

        }

        if($poliza->payment_type==4){ // CUENTA DEBITO

            $cheque=$poliza->accountDebit->cheq;
            $cuenta=BankAccounts::model()->accountByPk($poliza->accountDebit->accountBank->id);
            $concepto=$poliza->accountDebit->concept;
            $released=$poliza->accountDebit->released;
            $date=$poliza->accountDebit->datex;
            $retirement=$poliza->accountDebit->retirement;

        }

        if($poliza->payment_type==6){ // CUENTA CREDITO

            $cheque=$poliza->accountCredit->cheq;
            $cuenta=BankAccounts::model()->accountByPk($poliza->accountCredit->accountBank->id);
            $concepto=$poliza->accountCredit->concept;
            $released=$poliza->accountCredit->released;
            $date=$poliza->accountCredit->datex;
            $retirement=$poliza->accountCredit->retirement;

        }


        if($poliza->has_bill==1){

            $ids=explode(',',$invoiceIds);
            $counter=0;
            $sumaSubtotal=0;
            $sumaRetiva=0;
            $sumaVat=0;
            $sumaTotal=0;
            $mainTable='';

            $table='
            <table class="items table table-hover table-condensed table-bordered">
                <thead>
                    <tr>
                        <th>'.Yii::t('mx','NOMBRE').'</th>
                        <th>'.Yii::t('mx','# FACT').'</th>
                        <th>'.Yii::t('mx','SUBTOTAL').'</th>
                        <th>'.Yii::t('mx','RET IVA').'</th>
                        <th>'.Yii::t('mx','IVA').'</th>
                        <th>'.Yii::t('mx','TOTAL').'</th>
                    </tr>
                <thead>
            <tbody>
        ';


            foreach($ids as $item){
                $invoice=DirectInvoice::model()->findByPk($item);
                $sumaSubtotal+=$invoice->subtotal;
                $sumaRetiva+=$invoice->retiva;
                $sumaVat+=$invoice->vat;
                $sumaTotal+=$invoice->total;

                $table.= ($counter % 2 == 0) ? '<tr  class="alt">' :  '<tr>';
                $table.='
                            <td>'.$invoice->provider->company.'</td>
                            <td>'.$invoice->n_invoice.'</td>
                            <td>$'.number_format($invoice->subtotal,2).'</td>
                            <td>$'.number_format($invoice->retiva,2).'</td>
                            <td>$'.number_format($invoice->vat,2).'</td>
                            <td>$'.number_format($invoice->total,2).'</td>
                        </tr>';
                $counter++;

            }
            $table.='<tfoot>
                    <tr>
                    <td>
                         <p>'.$cuenta.'</p>
                         <p>CHEQUE # '.$cheque.'</p>
                    </td>
                    <td style="text-align: right;font-style:italic;font-weight:bold;">TOTALES:</td>
                    <td><strong>$'.number_format($sumaSubtotal,2).'</strong></td>
                    <td><strong>$'.number_format($sumaRetiva,2).'</strong></td>
                    <td><strong>$'.number_format($sumaVat,2).'</strong></td>
                    <td><strong>$'.number_format($sumaTotal,2).'</strong></td>
                    </tr>
                 </tfoot>';

            $table.='</tbody></table>';
        }



        $mainTable='

                    <table border="0" cellpadding="1" cellspacing="1" style="width: 100%;border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px;margin-bottom:10px;">
                        <tbody>
                        <tr>
                            <td colspan="3" style="text-align: center;">
                                <p><strong>'.$polizaTitle.'</strong></p>
                                 <p>&nbsp;</p>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="1" style="text-align: center;">
                                <p>'.$released.'</p>
                                 <p>&nbsp;</p>
                            </td>
                            <td style="text-align: right;padding-right: 10px;">'.$date.'</td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="1" style="text-align: center;">
                                <p>'.$this->numtoletras($retirement).'</p>
                            </td>
                            <td style="text-align: right;padding-right: 10px;">$'.number_format($retirement,2).'</td>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="1" style="text-align: center;">CH. '.$cheque.'</td>
                            <td style="text-align: right;padding-right: 10px;">'.$cuenta.'</td>
                        </tr>
                        </tbody>
                    </table>
                    <table border="1" cellpadding="1" cellspacing="1" style="width: 100%;border-collapse: collapse;margin-bottom:10px;">
                        <tbody>
                        <tr>
                            <td style="text-align: center; width: 60%;">
                                <p><strong>CONCEPTO DE PAGO</strong></p>
                                <p>&nbsp;</p>
                                <p>'.$concepto.'</p>
                            </td>
                            <td style="width: 10%;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                            <td style="text-align: center; width: 30%;">
                                <p><strong>FIRMA DE CHEQUE RECIBIDO</strong></p>
                                <p>&nbsp;</p>
                                <p>&nbsp;</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <table border="1" cellpadding="1" cellspacing="1" style="width: 100%;border-collapse: collapse;margin-bottom:10px;">
                        <tbody>
                        <tr>
                            <td style="text-align: center;">CUENTA</td>
                            <td style="text-align: center;">SUB-CUENTA</td>
                            <td style="text-align: center;">NOMBRE</td>
                            <td style="text-align: center;">PARCIAL</td>
                            <td style="text-align: center;">DEBE</td>
                            <td style="text-align: center;">HEBER</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" rowspan="1" style="text-align: right;padding-right:10px;"><strong>SUMAS IGUALES</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    </table>
                    <table border="1" cellpadding="1" cellspacing="1" style="width: 100%;border-collapse: collapse;margin-bottom:10px;">
                        <tbody>
                        <tr>
                            <td style="text-align: center;">HECHO POR</td>
                            <td style="text-align: center;">REVISADO POR</td>
                            <td style="text-align: center;">AUTORIZADO</td>
                            <td style="text-align: center;">AUXILIARES</td>
                            <td style="text-align: center;">DIARIO</td>
                            <td style="text-align: center;">POLIZA N&ordm;</td>
                        </tr>
                        <tr>
                            <td style="text-align: center;">'.Employees::model()->getInitials($userId).'</td>
                            <td>&nbsp;</td>
                            <td style="text-align: center;">'.$authorized.'</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>
                    <hr>
                     <strong><p>'.$resumenTitle.'</p></strong>
                    '.$table.'
                    ';

        return $mainTable;

    }

    public function polizaToPdf($table=array()){

        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot').'/themes/cocotheme/css/style.css');

        $footer = '<div align="center">'.Yii::t('mx','Page').' {PAGENO} </div>';
        $mpdf = Yii::app()->ePdf->mpdf('c','letter',10,'',10,10,30,20,10,10);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->mirrorMargins = 1;
        $mpdf->SetHTMLHeader($this->reportHeader());
        $mpdf->SetHTMLFooter($footer);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$table[0])));
        $mpdf->AddPage();
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$table[1])));
        $mpdf->Output('poliza.pdf','D');

    }

    public function generaCheque($operationId){
        $poliza=Polizas::model()->findByPk($operationId);
        $beneficiary=($poliza->for_beneficiary_account==1) ? Yii::t('mx','For credit to the beneficiary account') : "";

        //border-style: solid; border-top-width: 1px;border-left-width: 1px
        $table='
            <table border="0" cellpadding="1" cellspacing="1" style="width: 570px;">
                <tbody>
                    <tr>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td style="text-align: right;">'.$this->toSpanishDateDescription(date('Y-M-d',strtotime($poliza->operations->datex))).'</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; </td>
                        <td>&nbsp; &nbsp; &nbsp; &nbsp; </td>
                        <td style="text-align: left;">'.$poliza->operations->released.'</td>
                        <td style="text-align: right;">'.number_format($poliza->operations->retirement,2).'</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3" rowspan="1" style="text-align: left;">('.$this->numtoletras($poliza->operations->retirement).')</td>
                    </tr>
                     <tr>
                        <td>&nbsp;</td>
                        <td colspan="3" rowspan="1" style="text-align: left;"><p>&nbsp;</p>'.$beneficiary.'</td>
                    </tr>
                </tbody>
            </table>
        ';

        //mode,format,fontSize,font,margin-left,margin-right,margin-top,margin-botom,margin-header,margin-footer,orientation
        $mpdf = Yii::app()->ePdf->mpdf('c','letter',10,'',10,10,10,20,10,10);
        $mpdf->mirrorMargins = 1;
        $mpdf->WriteHTML($this->render('_ajaxContent', array('table'=>$table)));
        $mpdf->Output('cheque.pdf','D');  //I para imprimir en html

    }


    public function registerAccountCheques($paymentType,$accounId,$paymentMethod,$date,$released,$concept,$person,$bankConcept,$retirement,$deposit,$balance){

        $operation=new Operations;
        $operation->payment_type=$paymentType;
        $operation->account_id=$accounId;;
        $operation->cheq=$paymentMethod;
        $operation->datex=$date;
        $operation->released=$released;
        $operation->concept=$concept;
        $operation->person=$person;
        $operation->bank_concept=$bankConcept;
        $operation->retirement=$retirement;
        $operation->deposit=$deposit;
        $operation->balance=$balance;

        if($operation->save()){
            return $operation->id;
        }else{
            return $operation->getErrors();
        }

    }

    public function registerAccountDebit($paymentType,$accounId,$paymentMethod,$date,$released,$concept,$person,$bankConcept,$retirement,$deposit,$balance){

        $operation=new DebitOperations;
        $operation->payment_type=$paymentType;
        $operation->account_id=$accounId;
        $operation->cheq=$paymentMethod;
        $operation->datex=$date;
        $operation->released=$released;
        $operation->concept=$concept;
        $operation->person=$person;
        $operation->bank_concept=$bankConcept;
        $operation->retirement=$retirement;
        $operation->deposit=$deposit;
        $operation->balance=$balance;

        if($operation->save()){
            return $operation->id;
        }else{
            return $operation->getErrors();
        }

    }

    public function registerAccountCredit($paymentType,$accounId,$paymentMethod,$date,$released,$concept,$person,$bankConcept,$retirement,$deposit,$balance){

        $operation=new CreditOperations;
        $operation->payment_type=$paymentType;
        $operation->account_id=$accounId;;
        $operation->cheq=$paymentMethod;
        $operation->datex=$date;
        $operation->released=$released;
        $operation->concept=$concept;
        $operation->person=$person;
        $operation->bank_concept=$bankConcept;
        $operation->retirement=$retirement;
        $operation->deposit=$deposit;
        $operation->balance=$balance;

        if($operation->save()){
            return $operation->id;
        }else{
            return $operation->getErrors();
        }

    }


    public function menuAccounts(){

        $botones=array();

        $sql="select distinct(banks.bank),banks.id from banks inner join bank_accounts on banks.id=bank_accounts.bank_id order by banks.bank";
        $command=Yii::app()->db->createCommand($sql);
        $banks=$command->queryAll();


        foreach($banks as $bank){

            $sql="select distinct(bank_accounts.account_type_id) from account_types inner join
           bank_accounts on account_types.id=bank_accounts.account_type_id where bank_accounts.bank_id=:bannkId";

            $command=Yii::app()->db->createCommand($sql);
            $command->bindValue(":bannkId", $bank['id'] , PDO::PARAM_INT);
            $accountsTypes=$command->queryAll();

            $items=array();

            foreach($accountsTypes as $accountType){

                $subitems=array();

                $accounts=BankAccounts::model()->findAll(array(
                    'condition'=>'bank_id=:bankId and account_type_id=:accountTypeId',
                    'params'=>array('bankId'=>$bank['id'],'accountTypeId'=>$accountType['account_type_id'])
                ));

                foreach($accounts as $account){
                    $subitems[]=array('label'=>$account->bank->bank.' - '. substr($account->account_number,-3),'url' =>array('saldos','accountId'=>$account->id,'accountType'=>$account->account_type_id));
                }

                $items[]=array('label' => $account->accountType->tipe, 'url' =>'#','items'=>$subitems);

            }

            $botones[]=array('label' => $bank['bank'],'items' => $items);

        }

        return $botones;
    }


    public function firstDayThisMonth(){
        $fecha = new DateTime();
        $fecha->modify('first day of this month');

        return $fecha->format('Y-m-d');

    }

    public function lastDayThisMonth(){

        $currentDate=new DateTime(date('Y-m-d'));
        $dias=cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
        $interval = 'P'.($dias-1).'D';
        $currentDate->add(new DateInterval($interval));

        return $currentDate->format('Y-m-d');

    }


    public function reportHeader(){

        $header = '
            <table width="100%" style="border-bottom: 1px solid #000000; vertical-align: bottom; font-family: serif; font-size: 9pt; color: #000088;">
                <tr>
                    <td width="50%">'.CHtml::image(Yii::getPathOfAlias('webroot').'/images/logo.jpg','',array('width'=>'100px','height'=>'50px')).'</td>
                    <td width="50%" style="text-align: right;">'.$this->toSpanishDateTime(date("Y-M-d H:i")).'</td>
                </tr>
            </table>
            ';

        return $header;

    }


    public function retirementAccount($accountId,$retirement){

        $account=BankAccounts::model()->findByPk($accountId);
        $account->initial_balance=$account->initial_balance-$retirement;

        if($account->save()){
            return true;
        }else{
            return false;
        }

    }

    public function depositAccount($accountId,$deposit){

        $account=BankAccounts::model()->findByPk($accountId);

        if($account){
            $account->initial_balance=$account->initial_balance+$deposit;
            if($account->save()) return true;
            else return false;

        }else{
            return false;
        }



    }

    public function consecutiveCheque($accountId){

        $account=BankAccounts::model()->findByPk($accountId);

        if($account){
            $account->consecutive=$account->consecutive+1;
            if($account->save()){
                return true;
            }else{
                return false;
            }
        }
    }

    public function changeStatusReservation($customerReservationId,$estatus){

        $lista=Reservation::model()->findAll(array(
            'condition'=>'customer_reservation_id=:customerReservationId',
            'params'=>array('customerReservationId'=>$customerReservationId)
        ));

        if($lista){

           foreach($lista as $reservation){
               $reservation->statux=$estatus;
               $reservation->checkin=date('Y-m-d H:i',strtotime($this->toEnglishDateTime($reservation->checkin)));
               $reservation->checkout=date('Y-m-d H:i',strtotime($this->toEnglishDateTime($reservation->checkout)));
               $reservation->save();
           }
        }
    }

    function resizeImage($originalImage,$toWidth,$toHeight){

        list($width, $height) = getimagesize($originalImage);

        $xscale=$width/$toWidth;
        $yscale=$height/$toHeight;

        if ($yscale>$xscale){
            $new_width = round($width * (1/$yscale));
            $new_height = round($height * (1/$yscale));

        } else {
            $new_width = round($width * (1/$xscale));
            $new_height = round($height * (1/$xscale));
        }

        $imageResized = imagecreatetruecolor($new_width, $new_height);
        $imageTmp     = imagecreatefromjpeg ($originalImage);

        imagecopyresampled($imageResized, $imageTmp,0, 0, 0, 0, $new_width, $new_height, $width, $height);

        return $imageResized;
    }

}