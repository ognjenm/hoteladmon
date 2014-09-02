function handleDividers(widget, showLastDivider)
{
    'use strict';
    if (!showLastDivider)
    {
        jQuery('.field-rows .cloned-row .cloned-row-dividers', widget).css('display', '');
        jQuery('.field-rows .cloned-row .cloned-row-dividers', widget).last().css('display', 'none');
    }
}

function regenerateFieldsName(rowIndex, row)
{
    'use strict';
    jQuery('input, textarea, checkbox, radio, select', row).each
    (
        function()
        {
            if (jQuery(this).length>0)
            {
                if (typeof jQuery(this).attr('data-groupname') !== 'undefined' && typeof jQuery(this).attr('data-attribute') !== 'undefined')
                {
                    var groupName = jQuery(this).attr('data-groupname');
                    var attribute = jQuery(this).attr('data-attribute');

                    jQuery(this).attr('name',groupName+'['+rowIndex+']'+'['+attribute+']');

                    if (typeof jQuery(this).attr('data-widgetname') !== 'undefined')
                    {
                        var widgetname =jQuery(this).attr('data-widgetname');
                        jQuery(this).attr('id', widgetname+'_'+groupName+'_'+rowIndex+'_'+'_'+attribute);
                    }
                }
            }
        }
    );
}

function regenerateAllFieldsNames(widget)
{
    'use strict';
    var clonedRows=jQuery('.field-rows .cloned-row', widget);
    var rowIndex=0;

    clonedRows.each
    (
        function(i, elem)
        {
            rowIndex++;
            regenerateFieldsName(rowIndex, jQuery(this));
        }
    );
}

function initSortable(widget, showLastDivider, afterSortRowsCustomAction)
{
    'use strict';
    jQuery('.field-rows', widget).sortable(
        {
            //revert: true,
            items:'div.cloned-row',
            cursor: 'move',
            axis: 'y',
            opacity: 0.70,
            forceHelperSize: true,
            forcePlaceholderSize: true,
            tolerance: 'pointer',
            zIndex: 9999,
            delay: 150,
            distance: 5,
            start: function(e, ui) {
                jQuery('.cloned-row-dividers', ui.item).css('display', '');
            },
            stop: function(e, ui) {
                handleDividers(widget, showLastDivider);
            },
            update: function(e, ui) {
                var source=jQuery('div.hidden-template', widget);
                afterSortRowsCustomAction(widget, source, jQuery(this), 0);
                regenerateAllFieldsNames(widget);
            }
        }
    );
}

function removeRowAction (removeLink, maxCloneRows, minCloneRows, beforeAddRowCustomAction, afterAddRowCustomAction, beforeRemoveRowCustomAction, afterRemoveRowCustomAction, dinamicLabels, showLastDivider)
{
    'use strict';
    var target = removeLink.parents('.cloned-row');
    var widget = removeLink.parents('.clonnable-fields-widget');
    var source=jQuery('div.hidden-template', widget);

    var currentClonedNum=jQuery('.field-rows .cloned-row', widget).length;

    if (currentClonedNum-1<minCloneRows)
    {
        jQuery('a.remove-cloned-row', widget).css('display','none');
        return;
    }

    currentClonedNum--;

    beforeRemoveRowCustomAction(widget, source, target, currentClonedNum);

    if (dinamicLabels && currentClonedNum<=0)
    {
        jQuery('div.field-labels', widget).css('display','none');
    }

    jQuery('a[data-toggle="tooltip"]', target).tooltip('destroy');

    target.slideUp(300, function()
    {
        target.remove();
        handleDividers(widget, showLastDivider);
        afterRemoveRowCustomAction(widget, source, target, currentClonedNum);
        regenerateAllFieldsNames(widget);
    });

    jQuery('a.clone-row', widget).css('display','');

    if (minCloneRows>0 && currentClonedNum<=minCloneRows)
    {
        jQuery('a.remove-cloned-row', widget).css('display','none');
    }
}

function addRowAction (addLink, maxCloneRows, minCloneRows, beforeAddRowCustomAction, afterAddRowCustomAction, beforeRemoveRowCustomAction, afterRemoveRowCustomAction, dinamicLabels, showLastDivider)
{
    'use strict';
    var widget=addLink.parent();
    var currentClonedNum=jQuery('.field-rows .cloned-row', widget).length;

    if (maxCloneRows !==0 && currentClonedNum>=maxCloneRows)
    {
        return;
    }

    var target = jQuery('.field-rows', widget);
    var source=jQuery('div.hidden-template', widget);

    currentClonedNum++;

    var cloned=source.clone();
    cloned.removeClass('hidden-template');
    cloned.addClass('cloned-row');

    if (currentClonedNum<=minCloneRows)
    {
        jQuery('a.remove-cloned-row', widget).css('display','none');
    }
    else
    {
        jQuery('a.remove-cloned-row', widget).css('display', '');
    }

    jQuery('a.remove-cloned-row', cloned).click
        (
            function()
            {
                removeRowAction(jQuery(this), maxCloneRows, minCloneRows, beforeAddRowCustomAction, afterAddRowCustomAction, beforeRemoveRowCustomAction, afterRemoveRowCustomAction, dinamicLabels, showLastDivider);
                return false;
            }
        );

    regenerateFieldsName(currentClonedNum, cloned);

    if (maxCloneRows !==0 && currentClonedNum>=maxCloneRows)
    {
        addLink.css('display','none');
    }

    if (dinamicLabels)
    {
        jQuery('div.field-labels', widget).css('display','');
    }

    beforeAddRowCustomAction(widget, source, cloned, currentClonedNum);
    jQuery('a[data-toggle=\"tooltip\"]', cloned).tooltip();

    cloned.appendTo(target);

    handleDividers(widget, showLastDivider);
    cloned.slideDown(300);

    afterAddRowCustomAction(widget, source, cloned, currentClonedNum);
}

function initClonnableFields(widgetId, maxCloneRows, minCloneRows, afterSortRowsCustomAction, beforeAddRowCustomAction, afterAddRowCustomAction, beforeRemoveRowCustomAction, afterRemoveRowCustomAction, dinamicLabels, showLastDivider, sortable)
{
    'use strict';
    var widget=jQuery('div#'+widgetId);
    var source=jQuery('div.hidden-template', widget);

    jQuery('a.clone-row', widget).click
    (
        function()
        {
            addRowAction(jQuery(this), maxCloneRows, minCloneRows, beforeAddRowCustomAction, afterAddRowCustomAction, beforeRemoveRowCustomAction, afterRemoveRowCustomAction, dinamicLabels, showLastDivider);
            return false;
        }
    );

    jQuery('a.remove-cloned-row', widget).click
    (
        function()
        {
            removeRowAction(jQuery(this), maxCloneRows, minCloneRows, beforeAddRowCustomAction, afterAddRowCustomAction, beforeRemoveRowCustomAction, afterRemoveRowCustomAction, dinamicLabels, showLastDivider);
            return false;
        }
    );

    var alreadyClonedRows=jQuery('.field-rows .cloned-row', widget);
    var currentClonedNum=0;

    alreadyClonedRows.each
    (
        function(i, elem)
        {
            currentClonedNum++;
            beforeAddRowCustomAction(widget, source, jQuery(this), currentClonedNum);
            afterAddRowCustomAction(widget, source, jQuery(this), currentClonedNum);
        }
    );

    if (sortable)
    {
        initSortable(widget, showLastDivider, afterSortRowsCustomAction);
    }
}
