// script.js

document.addEventListener('DOMContentLoaded', function() {
    var dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(function(dropdown) {
        dropdown.addEventListener('mouseover', function() {
            this.querySelector('.dropdown-menu').style.display = 'block';
        });
        dropdown.addEventListener('mouseout', function() {
            this.querySelector('.dropdown-menu').style.display = 'none';
        });
    });

    var scrollLinks = document.querySelectorAll('a[href^="#"]');
    scrollLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            var targetId = this.getAttribute('href').substring(1);
            var targetElement = document.getElementById(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Alternância do menu para dispositivos móveis
    var menuToggle = document.getElementById('mobile-menu');
    var menu = document.getElementById('menu');
    menuToggle.addEventListener('click', function() {
        menu.classList.toggle('showing');
    });
});
