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
}


/**
 * This toggles the visibility of our parent permission fields depending on the
 * current selected value of the underAge field
 */
function magicdustToggleFields()
{
    console.log(new Date());
    // Hide all link control fields.
    // jQuery('[id^="magicdust_button_widget-"][id$="-control"]').hide();
    var allControlGroups = jQuery('[data-control-group][data-control-group!="link-type"]');
    allControlGroups.hide();
    // Empty the name value for all link select boxes.  (This deactivates them)
    allControlGroups.children().filter('select').attr('name', '');


    // Show the control fields that correspond with each selected value for link
    // type.
    jQuery('[data-select="link-type"]').each(function() {
        // Determine the selected value of this select box.
        var selectedValue = jQuery(this).val();

        // Select the containing widget's form element.
        var widget = jQuery(this).parent().parent()

        // Select the active control group.
        var activeControlGroup = widget.children().filter('[data-control-group="' + selectedValue + '"]');
        console.log("Pre-activation: " + activeControlGroup.attr('data-control-group'));

        // Activate the selected form field by applying value of "data-name" as "name".
        var activeName = activeControlGroup.children().filter('select, input').attr('data-name');
        console.log(activeName);

        activeControlGroup.children().filter('select, input').attr('name', activeName);
        activeControlGroup.show();

        console.log("Post-activation: " + activeControlGroup.attr('data-control-group'));
    });
}