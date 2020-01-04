$(function () {
    $('.x-navigation li a').filter(function () {
        return this.href === location.href;
    }).closest("li").addClass('active');
    $('.x-navigation li ul li a').filter(function () {
        return this.href === location.href;
    }).closest("li").addClass('active').parents("li").addClass('active');
    $('.back').on('click', function () {
        $(this).attr('href', $(this).attr('data-link'));
    });
});