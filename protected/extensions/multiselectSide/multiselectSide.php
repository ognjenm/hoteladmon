<?php
/**
 * MultiSelects class file
 *
 * This widget is used to transfer options between two select filed
 *
 * Usage
 * <pre>
 * $this->widget('ext.multiselectSide.multiselectSide',array(
 *     'leftTitle'=>'Mexico',
 *     'leftName'=>'Person[australia][]',
 *     'leftList'=>Person::model()->findUsersByCountry(14),
 *     'rightTitle'=>'EU',
 *     'rightName'=>'Person[eu][]',
 *     'rightList'=>Person::model()->findUsersByCountry(158),
 *     'size'=>20,
 *     'width'=>'200px',
 * ));
 * </pre>
 */

class multiselectSide extends CWidget{
    /**
     * The label for the left mutiple select
     * option
     * @var string
     */
    public $leftTitle;
    /**
     * The label for the right mutiple select
     * option
     * @var string
     */
    public $rightTitle;
    /**
     * The name for the left mutiple select
     * require
     * @var string
     */
    public $leftName;
    /**
     * The name for the right mutiple select
     * require
     * @var string
     */
    public $rightName;
    /**
     * data for generating the left list options
     * require
     * @var array
     */
    public $leftList;
    /**
     * data for generating the right list options
     * require
     * @var array
     */
    public $rightList;
    /**
     * The size for the multiple selects.
     * option
     * @var integer
     */
    public $size=15;

    /**
     * The width for the multiple selects.
     * option
     * @var string
     */
    public $width;

    /**
     * register clientside widget files
     */

    protected function registerClientScript()
    {
        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile(Yii::app()->getAssetManager()->publish(dirname(__FILE__).'/js/multiselect.min.js'));
    }

} 