<?php

class TemplateSelect2Field extends TemplateAbstractField
{
    public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
    {
        if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
        $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

        $asDropDownList = (isset($params['asDropDownList']) && $params['asDropDownList'])? true : false;

        if (ClonnableFields::isModel($model))
        {
            return $asDropDownList
                ?
                CHtml::activeDropDownList($model, $attribute, $data, $htmlOptions)
                :
                CHtml::activeHiddenField($model, $attribute, $htmlOptions);
        }
        else
        {
            return $asDropDownList
                ?
                CHtml::dropDownList($name, $value, $data, $htmlOptions)
                :
                CHtml::hiddenField($name, $value, $htmlOptions);
        }

    }

    public function beforeAddRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
    {

        $options = isset($params['options']) && !empty($params['options']) ? CJavaScript::encode($params['options']) : '';

        //$defValue = !empty($this->val) ? ".select2('val', '$this->val')" : '';
        $defValue='';

        $result="jQuery('.$fieldClassName', target).select2({$options})$defValue;";

        if (isset($params['events']) && is_array($params['events']))
        {
            foreach ($params['events'] as $event => $handler) {
                $result=$result.".on('{$event}', " . CJavaScript::encode($handler) . ")";
            }
        }

        return $result;
    }

    public function registerAssets()
    {
        Yii::app()->bootstrap->registerPackage('select2');

        parent::registerAssets();
    }
}