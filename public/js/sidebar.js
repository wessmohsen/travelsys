$(document).ready(function () {
    // Handle treeview toggle
    $('.has-treeview > a').on('click', function (e) {
        e.preventDefault();

        var parent = $(this).parent();
        var arrow = $(this).find('.fas');

        // Close other menus
        if (!parent.hasClass('menu-open')) {
            $('.has-treeview').removeClass('menu-open');
            $('.nav-treeview').slideUp(300);
            $('.has-treeview > a .fas').removeClass('fa-angle-down').addClass('fa-angle-right');
        }

        // Toggle current menu
        parent.toggleClass('menu-open');
        parent.find('.nav-treeview').first().slideToggle(300);

        // Toggle arrow icon
        if (parent.hasClass('menu-open')) {
            arrow.removeClass('fa-angle-right').addClass('fa-angle-down');
        } else {
            arrow.removeClass('fa-angle-down').addClass('fa-angle-right');
        }
    });

    // Keep active menu open on page load
    $('.nav-link.active').closest('.has-treeview').addClass('menu-open');
    $('.nav-link.active').closest('.nav-treeview').show();
    $('.nav-link.active').closest('.has-treeview').find('.fas')
        .removeClass('fa-angle-right')
        .addClass('fa-angle-down');
});
