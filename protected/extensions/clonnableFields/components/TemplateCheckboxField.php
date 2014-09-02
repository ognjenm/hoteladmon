<?php

    class TemplateCheckboxField extends TemplateAbstractField
    {
        public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
        {
            if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
            $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

            if (ClonnableFields::isModel($model))
            {
                return CHtml::activeCheckBox($model, $attribute, $htmlOptions);
            }
            else
            {
                return CHtml::checkBox($name, (int)$value>0, $htmlOptions);
            }
        }

    }