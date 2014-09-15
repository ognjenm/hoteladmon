<?php


class JQRelcopy extends CWidget
{

	public $removeText;
	public $removeHtmlOptions = array();
	public $options = array();
	public $jsBeforeClone; // 'jsBeforeClone' => "alert(this.attr('class'));";
	public $jsAfterClone;  // 'jsAfterClone' => "alert(this.attr('class'));";
	public $jsBeforeNewId;  // 'jsBeforeNewId' => "alert(this.attr('id'));";
	public $jsAfterNewId;  // 'jsAfterNewId' => "alert(this.attr('id'));";


	private $_assets;


	public static function afterNewIdDatePicker($config)
	{
		$options = isset($config['options']) ? $config['options'] : array();
		$jsOptions = CJavaScript::encode($options);

		$language = isset($config['language']) ? $config['language'] : '';
		if (!empty($language))
			$language = "jQuery.datepicker.regional['$language'],";

		return "if(this.hasClass('hasDatepicker')) {this.removeClass('hasDatepicker'); this.datepicker(jQuery.extend({showMonthAfterYear:false}, $language {$jsOptions}));};";
	}


	public static function afterNewIdDateTimePicker($config)
	{
		$options = isset($config['options']) ? $config['options'] : array();
		$jsOptions = CJavaScript::encode($options);

		$language = isset($element['language']) ? $config['language'] : '';
		if (!empty($language))
			$language = "jQuery.datepicker.regional['$language'],";

		return "if(this.hasClass('hasDatepicker')) {this.removeClass('hasDatepicker').datetimepicker(jQuery.extend($language {$jsOptions}));};";
	}


	public static function afterNewIdAutoComplete($config)
	{
		$options = isset($config['options']) ? $config['options'] : array();
		if(isset($config['sourceUrl']))
			$options['source']=CHtml::normalizeUrl($config['sourceUrl']);
		else
			$options['source']=$config['source'];

		$jsOptions = CJavaScript::encode($options);

        return "if (this.hasClass('ui-autocomplete-input') ){
				var mmfAutoCompleteParent = this.parent();
				var mmfAutoCompleteClone  = this.clone();
				this.remove();
				mmfAutoCompleteClone.autocomplete({$jsOptions});
				mmfAutoCompleteParent.prepend(mmfAutoCompleteClone);
			}";
	}

	public function init()
	{
        $this->_assets=Yii::app()->getClientScript();
        $this->_assets->registerCoreScript('jquery');
        $this->_assets->registerScriptFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets'.'/js/jquery.relcopy.yii.3.3.js'));

		if (!empty($this->removeText))
		{
			$onClick = '$(this).parent().remove(); index--; return false;';
			$htmlOptions = array_merge($this->removeHtmlOptions,array('onclick'=>$onClick));
			$append = CHtml::link($this->removeText,'#',$htmlOptions);

			$this->options['append'] = empty($this->options['append']) ? $append : $append .' '.$this->options['append'];
		}

		if (!empty($this->jsBeforeClone))
			$this->options['beforeClone'] = $this->jsBeforeClone;

		if (!empty($this->jsAfterClone))
			$this->options['afterClone'] = $this->jsAfterClone;

		if (!empty($this->jsBeforeNewId))
			$this->options['beforeNewId'] = $this->jsBeforeNewId;

		if (!empty($this->jsAfterNewId))
			$this->options['afterNewId'] = $this->jsAfterNewId;

		$options = CJavaScript::encode($this->options);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$this->id,"jQuery('#{$this->id}').relCopy($options);");
		parent::init();
	}
}
?>