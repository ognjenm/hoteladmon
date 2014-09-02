<?php

class TemplateTypeaheadField extends TemplateAbstractField
{
    public function getField($widgetId, $rowGroupName='', $rowIndex, $model, $attribute, $name, $value='', $fieldClassName='', $htmlOptions=array(), $hasError=false, $data='', $params='')
    {
        if ($hasError) {$fieldClassName=$fieldClassName.' '.CHtml::$errorCss;}
        $htmlOptions=ClonnableFields::addClass($htmlOptions, $fieldClassName);

        $htmlOptions['autocomplete']='off';
        $htmlOptions['aria-autocomplete']='list';
        $htmlOptions['aria-haspopup']='true';

        if (ClonnableFields::isModel($model))
        {
            return CHtml::activeTextField($model, $attribute, $htmlOptions);
        }
        else
        {
            return CHtml::textField($name, $value, $htmlOptions);
        }
    }

    public function beforeAddRowCustomAction($fieldName='', $fieldClassName='', $data='', $params='')
    {
        $source='""';

        if (is_array($data))
        {
            //$source=CJSON::encode($data);
            $source=CJavaScript::encode($data, true);
        }
        else
        {
            if ($data!='')
            {
                $source=$data;
            }
            elseif (isset($params['source']))
            {
                //$source=CJSON::encode($params['source']);
                $source=CJavaScript::encode($params['source'], true);
            }

        }

        $items=5;
        if (isset($params['items']) && (int)$params['items']>0)
        {
            $items=$params['items'];
        }

        $minLength=1;
        if (isset($params['minLength']) && (int)$params['minLength']>0)
        {
            $minLength=$params['minLength'];
        }

        $highlightWrong='false';
        $highlightStyleWrong='color:red';
        $highlightStyleOk='';
        if (isset($params['highlightWrong']))
        {
            $highlightWrong='true';

            if (isset($params['highlightWrong']['styleWrong']))
            {
                $highlightStyleWrong=$params['highlightWrong']['styleWrong'];
            }

            if (isset($params['highlightWrong']['styleOk']))
            {
                $highlightStyleOk=$params['highlightWrong']['styleOk'];
            }
        }
        return
        "
            jQuery('.$fieldClassName', target).typeahead({'source':$source,'items':$items, 'minLength':$minLength,
                'matcher':function(item)
                {".
                    ($highlightWrong?"
                    var iStr=$.trim(this.query).toLowerCase();
                    if (typeof this.source !=='undefined' && iStr!=='')
                    {
                        for ( var i in this.source )
                        {
                            if (this.source[i].toLowerCase()==iStr)
                            {
                                this.\$element.attr('style', '$highlightStyleOk');
                                return ~item.toLowerCase().indexOf(this.query.toLowerCase());
                            }
                        }

                        this.\$element.attr('style', '$highlightStyleWrong');
                    }
                    ":'')."
                    return ~item.toLowerCase().indexOf(this.query.toLowerCase());
                },
                'updater': function (item)
                {".($highlightWrong?"
                    this.\$element.attr('style', '$highlightStyleOk');":"")."
                    return item;
                }
            });
        ";
    }
}