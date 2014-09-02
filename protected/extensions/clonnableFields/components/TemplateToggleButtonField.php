<?php

class TemplateToggleButtonField extends TemplateAbstractField
{
    public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
    {
        if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}

        $toggleButtonHtmlOptions=array('class'=>'toggle-button '.$fieldClassName);

        $result =  CHtml::openTag('div', $toggleButtonHtmlOptions);
        if (ClonnableFields::isModel($model))
        {
            $result.= CHtml::activeCheckBox($model, $attribute, $htmlOptions);
        }
        else
        {
            $result.= CHtml::checkBox($name, $value, $htmlOptions);
        }
        $result.=CHtml::closeTag('div');

        return $result;
    }

    public function afterAddRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
    {
        $config = $this->getConfiguration($params);
        $result = "


        jQuery('.$fieldClassName', target).toggleButtons({$config});";

        return $result;
    }

    protected function getConfiguration($param)
    {
        $config = $param;

        if (isset($config['onChange']) && $config['onChange'] !== null)
        {
            if ((!$config['onChange'] instanceof CJavaScriptExpression) && strpos($config['onChange'], 'js:') !== 0)
            {
                $config['onChange'] = new CJavaScriptExpression($config['onChange']);
            }
        }
        else
        {
            $config['onChange'] = 'js:$.noop';
        }

        if (!isset($config['width'])) { $config['width'] = 100; }
        if (!isset($config['height'])) { $config['height'] = 25; }
        if (!isset($config['animated'])) { $config['animated'] = true; }
        if (!isset($config['label']))
        {
            $config['label'] = array( 'enabled' => 'ON', 'disabled' => 'OFF' );
        }
        else
        {
            if (!isset($config['label']['enabled'])) { $config['label']['enabled'] = 'ON'; }
            if (!isset($config['label']['disabled'])) { $config['label']['disabled'] = 'OFF'; }
        }

        //["primary", "danger", "info", "success", "warning"] or nothing
        if (!isset($config['style']))
        {
            //$config['style'] = array( 'enabled' => 'primary', 'disabled' => null, 'custom' => array('enabled' => array(), 'disabled' => array()));
            $config['style'] = array( 'enabled' => 'primary');
        }
        else
        {
            if (!isset($config['style']['enabled'])) { $config['style']['enabled'] = 'primary'; }
            if (!isset($config['style']['disabled'])) { $config['style']['disabled'] = null; }
            if (!isset($config['style']['custom']))
            {
                $config['style']['custom'] = array('enabled' => array(), 'disabled' => array());
            }
            else
            {
                if ( !isset($config['style']['custom']['enabled']) ) { $config['style']['custom']['enabled'] = array(); }
                if ( !isset($config['style']['custom']['disabled']) ) { $config['style']['custom']['disabled'] = array(); }
            }
        }

        foreach ($config as $key => $element)
        {
            if (empty($element)) {
                unset($config[$key]);
            }
        }

        return CJavaScript::encode($config);
    }

    public function registerAssets()
    {
        Yii::app()->bootstrap->registerAssetCss('bootstrap-toggle-buttons.css');
        Yii::app()->bootstrap->registerAssetJs('jquery.toggle.buttons.js');
        parent::registerAssets();
    }
}