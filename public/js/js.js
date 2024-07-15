$(document).ready(function() {
    $('.sub-menu ul').hide();
    $(".sub-menu a").click(function () {
        $(this).parent(".sub-menu").children("ul").slideToggle("100");
        $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
    });
});
document.addEventListener('DOMContentLoaded', function () {
    // Toggle main menu
    document.getElementById('menu-toggle').addEventListener('click', function () {
        document.getElementById('menu').classList.toggle('open');
    });

    // Toggle submenus
    var submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            var submenu = this.nextElementSibling;
            submenu.classList.toggle('open');
        });
    });
});







