// au chargement du dom
document.addEventListener('DOMContentLoaded', function() {
    // on récupère les logements
    fetch('api/getLogements')
        .then(response => response.json())
        .then(data => {
            console.log(data);
            data.forEach(logement => {
                
            });
        });
});