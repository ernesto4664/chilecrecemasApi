$(document).ready(function() {
    $('.sub-menu ul').hide();
    $(".sub-menu a").click(function () {
        $(this).parent(".sub-menu").children("ul").slideToggle("100");
        $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementById('menu');

    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(event) {
            event.preventDefault();
            const parentItem = this.parentElement;
            parentItem.classList.toggle('active');
        });
    });

    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('active');
    });
});

