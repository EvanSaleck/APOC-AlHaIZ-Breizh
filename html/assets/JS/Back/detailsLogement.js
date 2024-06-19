var inputs = document.getElementsByTagName('input');
for (var i = 0; i < inputs.length; i++) {
    if (inputs[i].id!== 'btnModifier') {
        inputs[i].disabled = true;
    }
}

var selects = document.getElementsByTagName('select');
for (var i = 0; i < selects.length; i++) {
    selects[i].disabled = true;
}


var textArea = document.getElementsByTagName('textarea');
for (var i = 0; i < textArea.length; i++) {
    textArea[i].disabled = true;
}

console.log('detailsLogement.js');
document.addEventListener('DOMContentLoaded', function() {
    console.log(sessionStorage.getItem('idLogement'));
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        console.log(data)

        let titreLogement = document.getElementById("titre");
        titreLogement.value = data[0]['titre'];

        let villeLogement = document.getElementById("ville");
        villeLogement.value = data[0]['nom_ville'];

        let prixLogement = document.getElementById("tarif");
        prixLogement.value = parseFloat(data[0]['prix_nuit_ttc']);

        let nom_rue = document.getElementById("nom_rue");
        nom_rue.value = data[0]['nom_rue'];

        let ville = document.getElementById("ville");
        ville.value = data[0]['nom_ville'];

        let cp = document.getElementById("cp");
        cp.value = data[0]['code_postal'];

        let complement = document.getElementById("complement_adresse");
        complement.value = data[0]['complement'];

        let accroche = document.getElementById("accroche");
        accroche.textContent = data[0]['accroche'];

        let descDet = document.getElementById("description");
        descDet.textContent = data[0]['description'];
        
        let surface_hab = document.getElementById("surface");
        surface_hab.value = data[0]['surface_hab'];

        let personnes_max = document.getElementById("nbPersMax");
        personnes_max.value = data[0]['personnes_max'];


        let nombreChambres = document.getElementById("nbChambres");
        nombreChambres.value = data[0]['nb_chambres'];

        let nombreLitsSimples = document.getElementById("nbLitsSimples");
        nombreLitsSimples.value = data[0]['nb_lits_simples'];

        let nombreLitsDoubles = document.getElementById("nbLitsDoubles");
        nombreLitsDoubles.value = data[0]['nb_lits_doubles'];

        let delaiResaArrivee = document.getElementById("delaiResaArrivee");
        delaiResaArrivee.value = data[0]['avance_resa_min'];

        let dureeMinLocation = document.getElementById("dureeMinLoc");
        dureeMinLocation.value = data[0]['duree_min_location'];

        let delaiAnnulMax = document.getElementById("delaiAnnulMax");
        delaiAnnulMax.value = data[0]['delai_annul_max'];
        
        let image = document.getElementById("image-logement");
        image.style.backgroundImage = "url('" + data[0]['image_principale'] + "')";

        /*
        fetch('/api/getTypeOfLogementById/' + sessionStorage.getItem('idLogement'))
        .then(response => response.json())
        .then(dataType => {
            // console.log(dataType)
        })
        */
    

        fetch('/api/getCategorieOfLogementById/' + sessionStorage.getItem('idLogement'))
        .then(response => response.json())
        .then(
            
        )
        

            
        /* let listeAmenagements = document.getElementById("listeAmenagements");
        let htmlAmenagement = ""
        fetch('/api/getAmenagementsOfLogementById/' + sessionStorage.getItem('idLogement'))
        .then(response => response.json())
        .then(dataAm => {
            console.log(dataAm)
            let imgAmenagement
            dataAm.forEach(amenagement => {
                console.log(dataAm)
                switch (amenagement['id_amenagement']) {
                    case 1:
                        imgAmenagement = "/assets/imgs/iconsAmenagements/jardin.svg"
                        break;
                    case 2:
                        imgAmenagement = "/assets/imgs/iconsAmenagements/balcon.svg"
                        break;
                    case 3:
                        imgAmenagement = "/assets/imgs/iconsAmenagements/terrasse.svg"
                        break;
                    case 4:
                        imgAmenagement = "/assets/imgs/iconsAmenagements/piscine.svg"
                        break;
                    case 5:
                        imgAmenagement = "/assets/imgs/iconsAmenagements/jacuzzi.svg"
                        break;
                
                    default:
                        imgAmenagement = "/assets/imgs/iconsAmenagements/jardin.svg"
                        break;
                }
                htmlAmenagement = htmlAmenagement + "<div class=badgeAmenagement><img src='" + imgAmenagement + "' alt='" + amenagement['nom_amenagement'] + "'><h3>Jardin</p></div>"
                
            });
            if (htmlAmenagement == "") {
                htmlAmenagement = "<p>- Aucun aménagement -</p>"
            }
            listeAmenagements.innerHTML = htmlAmenagement
        });
        console.log(htmlAmenagement) */
        

        const boutonModifier = document.querySelectorAll('.btnModifier > input');
        
            boutonModifier.forEach(element => {
                element.addEventListener('click', function(e) {
                    e.preventDefault();
                
                    sessionStorage.setItem('idLogement', this.parentElement.getAttribute('data-id'));
                
                    // Redirige en utilisant window.location
                    window.location = "/logements/details/modifier";
                });
                
            });
    });
});