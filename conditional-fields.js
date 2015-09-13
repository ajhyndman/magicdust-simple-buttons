/**
 * Show or hide widget control blocks based on the value of the user's "Link
 * Type" selection.
 *
 */





/* Start the toggle feature.  Restart it if a widget is saved. */
jQuery(document).ready(initialise_toggle);
jQuery(document).ajaxComplete(initialise_toggle);


/**
 * Run the toggle function once, and then listen for change events on link-type
 * select boxes.
 */
function initialise_toggle() {
    // Call this first so we start out with the correct visibility depending on
    // the pre-selected form values.
    magicdustToggleFields();

    // Toggle active control groups when a new link type is selected.
    jQuery('[data-select="link-type"]').on( "change", magicdustToggleFields );

    // Toggle active control groups when the widget is saved.
    // jQuery(document).ajaxComplete(function () {
    //     magicdustToggleFields();
    // }
}


/**
 * This toggles the visibility of our parent permission fields depending on the
 * current selected value of the underAge field
 */
function magicdustToggleFields()
{
    // Hide all link control fields.
    // jQuery('[id^="magicdust_button_widget-"][id$="-control"]').hide();
    jQuery('[data-control-group][data-control-group!="link-type"]').hide();
    console.log("\nHIDE THESE:")
    console.log(jQuery('[data-control]'));

    // Show the control fields that correspond with each selected value for link
    // type.
    jQuery('[data-select="link-type"]').each(function() {
        // Determine the selected value of this select box.
        var selected_value = jQuery(this).val();

        // Select all other control groups in the same widget.
        var widget = jQuery(this).parent().parent()

        // Move to the end, and show control groups in this widget whose type matches the selected
        // value.
        var control_groups = widget.children().filter('[data-control-group]');
        var active_group = control_groups.filter('[data-control-group="' + selected_value + '"]').detach();
        control_groups.last().after(active_group);
        active_group.show();
    });
}