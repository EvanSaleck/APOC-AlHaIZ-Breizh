console.log('detailsLogement.js');
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        console.log('data');
        console.log(data);
    });

});