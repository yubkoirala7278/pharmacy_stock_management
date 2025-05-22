  $(function() {
    // Load the navigation HTML
    $("#menu").load("nav.html", function() {
        // Get the current page URL
        var currentPage = window.location.pathname.split("/").pop();

        // Find the corresponding <a> tag with the href matching the current page
        $('#menu a[href="' + currentPage + '"]').each(function() {
            // Add mm-active to the parent <li>
            $(this).closest('li').addClass('mm-active');

            // If the current page is a child, add mm-active to the parent <li> as well
            if ($(this).parents('ul.mm-collapse').length) {
                $(this).parents('ul.mm-collapse').addClass('mm-show');
                $(this).parents('li').addClass('mm-active');
            }
        });
    });
});
