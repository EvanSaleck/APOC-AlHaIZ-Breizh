console.log('detailsLogement.js');
document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        console.log('data');
        console.log(data);
        let imagePrinc = document.getElementById("imageLogement");
        console.log(data[0].imagePrincipale);
        imagePrinc.setAttribute("src",data[0].imagePrincipale);
        
        
    });

});