document.addEventListener("DOMContentLoaded", function() {
    var lastScrollTop = 0;
    var navbar = document.querySelector('.navbar');

    window.addEventListener("scroll", function() {
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > lastScrollTop && lastScrollTop >= 0) {
            navbar.classList.add('navbar-hidden');
        } else {
            navbar.classList.remove('navbar-hidden');
        }

        lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; 
    }, false);
});
