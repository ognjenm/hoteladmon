<?php        echo  CHtml::form('','post',array('class'=>'lang'));
            echo CHtml::dropDownList('_lang', $currentLang, array('en_us' => 'English', 'es_mx' => 'Spanish'), array('submit' => ''));
        echo CHtml::endForm();
?>