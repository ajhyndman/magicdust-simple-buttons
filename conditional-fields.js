/**
 * Show or hide widget control blocks based on the value of the user's "Link
 * Type" selection.
 */

jQuery(document).ready(function() {
    // Call this first so we start out with the correct visibility depending on
    // the pre-selected form values.
    magicdustToggleFields();

    // Toggle active control groups when a new link type is selected.
    jQuery('[data-select="link-type"]').on( "change", magicdustToggleFields );
    // Toggle active control groups when the widget is saved.
    jQuery(document).ajaxComplete( magicdustToggleFields );

});

/**
 * This toggles the visibility of our parent permission fields depending on the
 * current selected value of the underAge field
 */
function magicdustToggleFields()
{
    // Hide all link control fields.
    // jQuery('[id^="magicdust_button_widget-"][id$="-control"]').hide();
    jQuery('[data-control-group]').hide();
    console.log("\nHIDE THESE:")
    console.log(jQuery('[data-control]'));

    // Show the control fields that correspond with each selected value for link
    // type.
    jQuery('[data-select="link-type"]').each(function() {
        // Determine the selected value of this select box.
        var selected_value = jQuery(this).val();

        // Select all other control groups in the same widget.
        var widget = jQuery(this).parent().parent()

        // Show control groups in this widget whose type matches the selected
        // value.
        widget.children().filter('[data-control-group="' + selected_value + '"]').show();
    });
}