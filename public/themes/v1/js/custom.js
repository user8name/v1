/**
 * custom javascript
 */
$(document).ready(function() {
    $("#searchbutton").click(function() {
        $("#searchform").find('[type="submit"]').trigger('click');

    });
});