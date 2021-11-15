var StylerCustomChange = false;
jQuery(document).ready(function () {

    jQuery(document).on("DOMSubtreeModified", "style", function () {
        if (StylerCustomChange) {
            return;
        }
        var text = jQuery(this).html();
        if (text.search('(max-width:-1px)') > 0) {
            text = text.replace(/ > /g, ' StSPECIALSTRING ');
            text = text.replace('(max-width:' + (ElementorBreakPoints.tabletlandscape - 1) + 'px)', '(max-width:' + (ElementorBreakPoints.tablet - 1) + 'px)');
            text = text.replace('(max-width:' + (ElementorBreakPoints.mobile - 1) + 'px)', '(max-width:' + ElementorBreakPoints.mobile + 'px)');
            text = text.replace('(max-width:-1px)', '(min-width:' + ElementorBreakPoints.tabletlandscape + 'px) and (max-width:' + ElementorBreakPoints.laptop + 'px)');
            text = text.replace('(max-width:-1px)', '(min-width:' + ElementorBreakPoints.tablet + 'px) and (max-width:' + (ElementorBreakPoints.tabletlandscape - 1) + 'px)');
            text = text.replace('(max-width:-1px)', '(max-width:' + ElementorBreakPoints.smallmobile + 'px)');
            //text = text.replace(/[.][^}]*\{(\n)?outline:(.?)notset;(\n)?[^}]*\}/g, '');
            text = text.replace(/@media[^}]*\{(.?)\}/g, '');
            text = text.replace(/ StSPECIALSTRING /g, ' > ');
            StylerCustomChange = true;
            jQuery(this).html(text);
            StylerCustomChange = false;
        } else if (text.search('outline:notset;') > 0) {
            text = text.replace(/ > /g, ' StSPECIALSTRING ');
            //text = text.replace(/[.][^}]*\{(\n)?outline:(.?)notset;(\n)?[^}]*\}/g, '');
            text = text.replace(/@media[^}]*\{(.?)\}/g, '');
            text = text.replace(/ StSPECIALSTRING /g, ' > ');
            StylerCustomChange = true;
            jQuery(this).html(text);
            StylerCustomChange = false;
        }
    });
    jQuery("style").each(function () {
        if (StylerCustomChange) {
            return;
        }
        var text = jQuery(this).html();
        if (text.search('(max-width:-1px)') > 0) {
            text = text.replace(/ > /g, ' StSPECIALSTRING ');
            text = text.replace('(max-width:' + (ElementorBreakPoints.tabletlandscape - 1) + 'px)', '(max-width:' + (ElementorBreakPoints.tablet - 1) + 'px)');
            text = text.replace('(max-width:' + (ElementorBreakPoints.mobile - 1) + 'px)', '(max-width:' + ElementorBreakPoints.mobile + 'px)');
            text = text.replace('(max-width:-1px)', '(min-width:' + ElementorBreakPoints.tabletlandscape + 'px) and (max-width:' + ElementorBreakPoints.laptop + 'px)');
            text = text.replace('(max-width:-1px)', '(min-width:' + ElementorBreakPoints.tablet + 'px) and (max-width:' + (ElementorBreakPoints.tabletlandscape - 1) + 'px)');
            text = text.replace('(max-width:-1px)', '(max-width:' + ElementorBreakPoints.smallmobile + 'px)');
            //text = text.replace(/[.|#][^}]*\{(\n)?outline:(.?)notset;(\n)?[^}]*\}/g, '');
            text = text.replace(/@media[^}]*\{(.?)\}/g, '');
            text = text.replace(/ StSPECIALSTRING /g, ' > ');
            StylerCustomChange = true;
            jQuery(this).html(text);
            StylerCustomChange = false;
        } else if (text.search('outline:notset;') > 0) {
            text = text.replace(/ > /g, ' StSPECIALSTRING ');
            //text = text.replace(/[.][^}]*\{(\n)?outline:(.?)notset;(\n)?[^}]*\}/g, '');
            text = text.replace(/@media[^}]*\{(.?)\}/g, '');
            text = text.replace(/ StSPECIALSTRING /g, ' > ');
            StylerCustomChange = true;
            jQuery(this).html(text);
            StylerCustomChange = false;
        }
    });
})