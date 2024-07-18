document.addEventListener('DOMContentLoaded', function () {
    // Toggle main menu
    document.getElementById('menu-toggle').addEventListener('click', function () {
        document.getElementById('menu').classList.toggle('menu-visible');
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
