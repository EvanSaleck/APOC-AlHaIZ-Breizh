// dom chargé 
document.addEventListener('DOMContentLoaded', function() {
    
    let amenagementsBtns = document.querySelectorAll('#amenagementsBoutons button');

    amenagementsBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                btn.classList.toggle('active');
            });
    });

    let btnValider = document.querySelector('.btnValider button');

    btnValider.addEventListener('click', function(e) {
        var formCreate = document.getElementById("newLogement");
        formData = new FormData(formCreate);
        console.log(formData);
    });
});