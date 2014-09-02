<?php

    class ClonnableFields extends CWidget
    {
        const LABELS_NEVER=0; //заголовки всегда скрыты
        const LABELS_ALWAYS=1; //заголовки всегда отображаются
        const LABELS_DINAMIC=2; //заголовки скрыты только тогда, когда ни одной строки не клонировано

        /**
         * @var string -название основного массива. Все поля будут в массиве с этим ключем
         */
        public $rowGroupName='';

        /**
         * @var array содержит в себе информацию о полях, их структуру
         */
        public $fields=array();

        /**
         * @var int
         */
        public $labelsMode=self::LABELS_ALWAYS;

        /**
         * @var integer содержит в себе максимальное количество клонируемых строк. 0 -неограничено
         */
        public $maxCloneRows=0;

        /**
         * @var integer $minCloneRows - min
         */
        public $minCloneRows=0;

        /**
         * @var integer $startRows - quantity of cloned rows on widget render.
         */
        public $startRows=1;

        /** @var string */
        public $addButtonLabel='Add';

        /** @var array */
        public $addButtonHtmlOptions=array();

        /** @var string */
        public $removeButtonLabel='Remove';

        /** @var array */
        public $removeButtonHtmlOptions=array();

        /** @var $models CModel[] - models array (use models or datas array) */
        public $models;

        /** @var array - data array (use models or datas array) */
        public $datas = array();

        /** @var string - widget ID */
        public $widgetId;

        /** @var array - global javascript variables array */
        public $globalJSVars;

        public $errorDecoration='';

        /** @var string - HTML divider */
        public $divider='<hr />';

        /** @var bool - Show or hide last divider */
        public $showLastDivider = true;

        /** @var bool - Sortable or not by drag'n'drop */
        public $sortable=true;

        private $_labelsExist=false;
        private $_rowsExist=false;

        private $_widgetId='';

        private $_errorFieldNumbers = array();


        public function init()
        {
            // take the current extension path
            $dir = dirname(__FILE__);
            // generate alias name
            $alias = md5($dir);
            // create alias
            Yii::setPathOfAlias($alias,$dir);
            // import other classes
            Yii::import($alias.'.components.*');

            if (isset($this->widgetId))
            {
                $this->_widgetId=$this->widgetId;
            }
            else
            {
                $this->_widgetId='clonnable-fields-widget-'.$this->getId(true);
            }

            $fieldNum=1;
            foreach ($this->fields as &$field)
            {
                if (!isset($field['field']['fieldClassName']) || !is_string($field['field']['fieldClassName']) || $field['field']['fieldClassName'] =='')
                {
                    $field['field']['fieldClassName']='clonnable-field-'.$fieldNum;
                }

                $fieldNum++;
            }

            if ($this->minCloneRows>$this->startRows) {$this->startRows=$this->minCloneRows;}
            parent::init();
        }


        /**
         * Run this widget.
         * This method registers necessary javascript and renders the needed HTML code.
         */
        public function run()
        {
            if ((int)$this->startRows <= 0) {$this->startRows = 0;}
            if ((int)$this->startRows > (int)$this->maxCloneRows && (int)$this->maxCloneRows > 0) { $this->maxCloneRows = (int)$this->startRows;}

            $dataFields='';
            $rowIndex=1;
            if (isset($this->models) && is_array($this->models))
            {
                foreach ($this->models as $model)
                {
                    /** @var CModel $model */
                    $dataFields.=$this->getDataRow($rowIndex, $model, null);
                    $rowIndex++;
                }
            }
            elseif (isset($this->datas) && is_array($this->datas))
            {
                foreach ($this->datas as $data)
                {
                    $dataFields.=$this->getDataRow($rowIndex, null, $data);
                    $rowIndex++;
                }
            }

            for($i=$rowIndex; $i <= $this->startRows; $i++)
            {
                $dataFields.=$this->getDataRow($rowIndex, null, null);
                $rowIndex++;
            }

            //<editor-fold desc="Headers and hidden template generation">
            $labels='';
            $hiddenTemplateFields='';
            $fieldNum=1;
            foreach ($this->fields as $field)
            {
                $fieldHtmlOptions = isset($field['fieldHtmlOptions']) ? $field['fieldHtmlOptions'] : array();
                if (isset($field['hidden']) && $field['hidden']) { $fieldHtmlOptions['style'] = 'display:none;'; }

                $hasError=isset($this->_errorFieldNumbers[$fieldNum]);
                $labels.= CHtml::tag('div', $fieldHtmlOptions, $this->getLabelField($field, $hasError));

                $hiddenTemplateFields.=CHtml::tag('div', $fieldHtmlOptions, $this->getTemplateField($field));

                $fieldNum++;
            }
            //</editor-fold>

            echo CHtml::openTag('div', array('id'=>$this->_widgetId, 'class'=>'clonnable-fields-widget'));
                echo $this->envelopClonedRow(true, 0, $hiddenTemplateFields, '');

                if ($this->labelsMode!=self::LABELS_NEVER)
                {
                    echo CHtml::tag('div', array('class'=>'field-labels', 'style'=>(($this->labelsMode==self::LABELS_DINAMIC && !$this->_rowsExist)?'display:none' : null)), $labels);
                }

                echo CHtml::tag('div', array('class'=>'field-rows', 'style'=>'clear: both;'), $dataFields);
                echo CHtml::link($this->addButtonLabel, '#clone-row', self::addClass($this->addButtonHtmlOptions, 'clone-row'));

            echo CHtml::closeTag('div');

            $this->registerJS();
        }

        /**Генерация клонированных строк
         * @param integer $rowIndex
         * @param CModel $model
         * @param array $data
         * @return string
         */
        protected function getDataRow($rowIndex, $model=null, $data=null)
        {
            $row='';
            $errors='';
            $fieldNum=1;
            foreach ($this->fields as $field)
            {
                $fieldHtmlOptions = isset($field['fieldHtmlOptions']) ? $field['fieldHtmlOptions'] : array();
                if (isset($field['hidden']) && $field['hidden']) { $fieldHtmlOptions['style'] = 'display:none;'; }

                if (isset($field['field']) && isset($field['field']['class']) && class_exists($field['field']['class']) && isset($field['field']['attribute']))
                {
                    /** @var $class TemplateAbstractField */
                    $class=new $field['field']['class'];
                    $attribute=$field['field']['attribute'];
                    $fieldClassName= $field['field']['fieldClassName'];
                    $htmlOptions=(isset($field['field']['htmlOptions'])?$field['field']['htmlOptions']:array());
                    $fieldName=self::generateFieldName(false, $this->rowGroupName, $rowIndex, $attribute);
                    $htmlOptions['name']=$fieldName;
                    $htmlOptions['id']=self::generateFieldId($this->getId(), $this->rowGroupName, $rowIndex, $attribute);
                    $htmlOptions['data-groupname']=$this->rowGroupName;
                    $htmlOptions['data-attribute']=$attribute;
                    $htmlOptions['data-widgetname']=$this->getId();

                    $value='';
                    $hasError=false;
                    $userData=(isset($field['field']['data'])) ?$field['field']['data']:'';
                    $params=(isset($field['field']['params'])) ?$field['field']['params']:'';

                    if (isset($model) && $model instanceof CModel && isset($model->$attribute))
                    {
                        if (isset($model->$attribute))
                        {
                            $value=$model->$attribute;
                        }

                        if ($model->hasErrors($attribute))
                        {
                            if ($this->errorDecoration=='')
                            {
                                $errors.=CHtml::error($model, $attribute);
                            }
                            else
                            {
                                $errorMsg=$model->getError($attribute);
                                $errors.=str_replace('{message}', $errorMsg, $this->errorDecoration);
                            }

                            $this->_errorFieldNumbers[$fieldNum]=true;
                            $hasError=true;
                        }
                    }
                    elseif (isset($data[$attribute]))
                    {
                        if (isset($data[$attribute]))
                        {
                            $value=$data[$attribute];
                        }
                    }

                    $row.= CHtml::tag('div', $fieldHtmlOptions, $class->getField($this->getId(), $this->rowGroupName, $rowIndex, $model, $attribute, $fieldName, $value, $fieldClassName, $htmlOptions, $hasError, $userData, $params));
                    $fieldNum++;
                    $this->_rowsExist=true;
                }

                $fieldHtmlOptions=null;
            }

            return $this->envelopClonedRow(false, $rowIndex, $row, $errors);
        }

        private function envelopClonedRow($template, $rowIndex, $row, $errors)
        {
            $result='';
            if ($template)
            {
                $clonedRowHtmlOptions=array('class'=>'hidden-template', 'style'=>'display:none;');
                $deleteLink=$this->renderDeleteButtonHtml(0, $this->removeButtonLabel, $this->removeButtonHtmlOptions);
            }
            else
            {
                $clonedRowHtmlOptions=array('class'=>'cloned-row');
                $deleteLink=$this->renderDeleteButtonHtml($rowIndex, $this->removeButtonLabel, $this->removeButtonHtmlOptions);
            }

            $result.= CHtml::openTag('div', $clonedRowHtmlOptions);
                $result.= CHtml::openTag('div');
                    $result.= $row;
                    $result.= $deleteLink;
                    $result.= CHtml::tag('div', array('class'=>'clonnable-field-status', 'style'=>'clear: both;'), $errors);
                $result.= CHtml::closeTag('div');
                $result.= CHtml::tag('div', array('class'=>'cloned-row-dividers'), $this->divider);
            $result.= CHtml::closeTag('div');
            return $result;
        }

        //<editor-fold desc="Генерация полей заголовков">
        /** Возвращает HTML код label
         * @param array $field
         * @param bool $hasError
         * @return string
         */
        protected function getLabelField($field, $hasError=false)
        {
            if (isset($field['label']))
            {
                if (isset($field['label']['title']))
                {
                    $title=$field['label']['title'];
                    $htmlOptions = isset($field['label']['htmlOptions'])?$field['label']['htmlOptions']:array();
                    if ($hasError)
                    {
                        if (isset($htmlOptions['class']))
                        {
                            $htmlOptions['class'].=CHtml::$errorCss;
                        }
                        else
                        {
                            $htmlOptions['class']=CHtml::$errorCss;
                        }
                    }

                    $this->_labelsExist=true;
                    return CHtml::label($title,'', $htmlOptions);
                }
            }

            return '';
        }
        //</editor-fold>

        //<editor-fold desc="Генерация полей скрытого шаблона">
        /** Создает поле для скрытого шаблона, который будет клонирован
         * @param array $field
         * @return mixed|string
         */
        protected function getTemplateField($field)
        {
            if (isset($field['field']) && isset($field['field']['class']) && class_exists($field['field']['class']) && isset($field['field']['attribute']))
            {
                /**
                 * @var $class TemplateAbstractField
                 */
                $class=new $field['field']['class'];
                $fieldClassName= $field['field']['fieldClassName'];
                $attribute=$field['field']['attribute'];
                $htmlOptions=(isset($field['field']['htmlOptions'])?$field['field']['htmlOptions']:array());

                $fieldName=self::generateFieldName(true, $this->rowGroupName, 0, $attribute);
                $htmlOptions['name']=$fieldName;
                $htmlOptions['id']=self::generateFieldId($this->getId(), $this->rowGroupName, 0, $attribute);
                $htmlOptions['data-groupname']=$this->rowGroupName;
                $htmlOptions['data-attribute']=$attribute;
                $htmlOptions['data-widgetname']=$this->getId();


                $value = isset($field['field']['start_value'])?$field['field']['start_value']:'';
                $userData=(isset($field['field']['data'])) ?$field['field']['data']:'';
                $params=(isset($field['field']['params'])) ?$field['field']['params']:'';

                return $class->getField($this->getId(), $this->rowGroupName, 0, null, $attribute, $fieldName, $value, $fieldClassName, $htmlOptions, false, $userData, $params);
            }
            return '';
        }

        //</editor-fold>

        //<editor-fold desc="JavaScript functions">
        private function registerJS()
        {
            $js="
".$this->createGlobnalJSVars()."
jQuery(document).ready
(
    function()
    {
        var maxCloneRows=$this->maxCloneRows;
        var minCloneRows=$this->minCloneRows;
        var widgetId='".$this->_widgetId."';
        var showLastDivider='".$this->showLastDivider."';
        var target=jQuery('fakevalue');
        var dinamicLabels=".($this->labelsMode==self::LABELS_DINAMIC? 'true' : 'false').";
        var sortable=".($this->sortable ? 'true' : 'false').";
        ".$this->createFieldsJavaActions()."
        initClonnableFields(widgetId, maxCloneRows, minCloneRows, afterSortRowsCustomAction, beforeAddRowCustomAction, afterAddRowCustomAction, beforeRemoveRowCustomAction, afterRemoveRowCustomAction, dinamicLabels, showLastDivider, sortable);
    }
);
";
            $cs=Yii::app()->clientScript;
            $cs->registerScript(__CLASS__.'#'.$this->getId(), $js,CClientScript::POS_READY);

            $bu=Yii::app()->assetManager->publish(dirname(__FILE__).'/assets/');
            $cs->registerScriptFile($bu.'/clonnableFields'. (!YII_DEBUG ? '.min' : '') . '.js',CClientScript::POS_END);
        }

        /**
         * Создает java функции полей - инициализаторы и деструкторы полей
         * @return string
         */
        protected function createFieldsJavaActions()
        {
            $js1="var beforeAddRowCustomAction = function(widget, source, target, currentClonedNum) {";
            $js2="var beforeRemoveRowCustomAction = function(widget, source, target, currentClonedNum) {";
            $js3="var afterAddRowCustomAction = function(widget, source, target, currentClonedNum) {";
            $js4="var afterRemoveRowCustomAction = function(widget, source, target, currentClonedNum) {";
            $js5="var afterSortRowsCustomAction = function(widget, source, target, currentClonedNum) {";
            foreach ($this->fields as $field)
            {
                if (isset($field['field']) && isset($field['field']['class']) && class_exists($field['field']['class']))
                {
                    $attribute=(isset($field['field']['attribute'])) ?$field['field']['attribute']:'';
                    $data=(isset($field['field']['data'])) ?$field['field']['data']:'';
                    $params=(isset($field['field']['params'])) ?$field['field']['params']:'';

                    /**
                     * @var $class TemplateAbstractField
                     */
                    $class=new $field['field']['class'];
                    $js1.=$class->beforeAddRowCustomAction($attribute, $field['field']['fieldClassName'], $data,$params);
                    $js2.=$class->beforeRemoveRowCustomAction($attribute, $field['field']['fieldClassName'], $data,$params);
                    $js3.=$class->afterAddRowCustomAction($attribute, $field['field']['fieldClassName'], $data,$params);
                    $js4.=$class->afterRemoveRowCustomAction($attribute, $field['field']['fieldClassName'], $data,$params);
                    $js5.=$class->afterSortRowsCustomAction($attribute, $field['field']['fieldClassName'], $data,$params);
                    $class->registerAssets();
                }
            }
            $js1.="};";
            $js2.="};";
            $js3.="};";
            $js4.="};";
            $js5.="};";

            return $js1."
        ".$js2."
        ".$js3."
        ".$js4."
        ".$js5;
        }

        protected function createGlobnalJSVars()
        {
            if (isset($this->globalJSVars))
            {
                if (is_array($this->globalJSVars))
                {
                    $js='';
                    foreach($this->globalJSVars as $var=>$value)
                    {
                        $js.=$var.' = '. CJavaScript::encode($value, true).';';
                    }
                    return $js;
                }
                else
                {
                    return $this->globalJSVars;
                }
            }
            else
            {
                return '';
            }
        }
        //</editor-fold>

        /**
         * @param integer $rowIndex
         * @param string $text
         * @param array $htmlOptions
         *
         * @return string
         */
        private function renderDeleteButtonHtml($rowIndex, $text, $htmlOptions=array())
        {
            $htmlOptions=self::addClass($htmlOptions, 'remove-cloned-row');
            if ($rowIndex <= $this->minCloneRows) {$htmlOption['sstyle'] = 'display:none';}

            return CHtml::link($text, '#delete-row', $htmlOptions);
        }

        public static function addClass($htmlOptions, $className)
        {
            if (isset($htmlOptions['class']) && trim($htmlOptions['class']) != '')
            {
                $htmlOptions['class'].= ' '.$className;
            }
            else
            {
                $htmlOptions['class'] = $className;
            }

            return $htmlOptions;
        }

        /**
         * @param CModel $model
         * @return bool
         */
        public static function isModel($model)
        {
            if (isset($model) && $model instanceof CModel && isset($model->attributes) && $model->attributes!==null)
            {
                return true;
            }
            else
            {
                return false;
            }
        }

        public static function generateFieldName($template=false, $rowGroupName, $rowIndex, $attribute)
        {
            $rowGroupName = ($template ? 'template_' : '').$rowGroupName;
            return $rowGroupName.'['.$rowIndex.']['.$attribute.']';
        }

        public static function generateFieldId($widgetId, $rowGroupName, $rowIndex, $attribute)
        {
            return $widgetId.'_'.$rowGroupName.'_'.$rowIndex.'_'.$attribute;
        }
    }
