// dom chargé 
document.addEventListener('DOMContentLoaded', function() {
    
    let amenagementsBtns = document.querySelectorAll('#amenagementsBoutons button');

    amenagementsBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                btn.classList.toggle('active');
            });
    });
});