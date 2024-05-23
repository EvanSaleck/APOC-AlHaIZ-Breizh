function calculDevis(prixNuitTTC) {
    let dateDebut = document.getElementById("dateDebut");
    let dateFin = document.getElementById("dateFin");
    let sctNbOccupants = document.getElementById("sctNbOccupants");

    let tempsDateArrivee = new Date(dateDebut.value).getTime()
    let tempsDateDepart = new Date(dateFin.value).getTime()
    let nbNuits = (tempsDateDepart - tempsDateArrivee)/ (1000 * 3600 * 24)
    let prixSejourTTC = prixNuitTTC * nbNuits
    let fraisServices = prixSejourTTC * 0.01
    let taxeSejour = sctNbOccupants.value * nbNuits
    let totalDevis = prixSejourTTC + fraisServices + taxeSejour
    return totalDevis
}

function envoiDevis(prixNuitTTC,data) {
    let dateDebut = document.getElementById("dateDebut");
    let dateFin = document.getElementById("dateFin");
    let sctNbOccupants = document.getElementById("sctNbOccupants");

    let tempsDateArrivee = new Date(dateDebut.value).getTime()
    let tempsDateDepart = new Date(dateFin.value).getTime()
    let nbNuits = (tempsDateDepart - tempsDateArrivee)/ (1000 * 3600 * 24)
    let prixSejourTTC = prixNuitTTC * nbNuits
    let fraisServices = prixSejourTTC * 0.01
    let taxeSejour = sctNbOccupants.value * nbNuits
    let totalDevis = prixSejourTTC + fraisServices + taxeSejour

    sessionStorage.setItem('dateArrivee', dateDebut.value);
    sessionStorage.setItem('dateDepart', dateFin.value);
    sessionStorage.setItem('nbOccupants', sctNbOccupants.value);
    sessionStorage.setItem('totalLocation', prixSejourTTC);
    sessionStorage.setItem('fraisService', fraisServices);
    sessionStorage.setItem('taxeSejour', taxeSejour);
    sessionStorage.setItem('totalTTC', totalDevis);
    sessionStorage.setItem('dataLogement', data);
}

console.log('detailsLogement.js');
document.addEventListener('DOMContentLoaded', function() {
    console.log(sessionStorage.getItem('idLogement'));
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        console.log('data');
        console.log(data);
        let imagePrinc = document.getElementById("imageLogement");
        console.log(data[0]['image_principale']);
        imagePrinc.setAttribute("src",data[0]['image_principale']+".svg");

        let titreLogement = document.getElementById("titreLog");
        console.log(data[0]['titre']);
        titreLogement.innerHTML = data[0]['titre'];

        let villeLogement = document.getElementById("villeLog");
        console.log(data[0]['nom_ville']);
        villeLogement.innerHTML = data[0]['nom_ville'];

        let prixLogement = document.getElementById("prix");
        console.log(data[0]['prix_nuit_ttc']);
        prixLogement.innerHTML = parseFloat(data[0]['prix_nuit_ttc']);

        let nbPersonnesMax = document.getElementById("nbPersonnesMax");
        console.log(data[0]['personnes_max']);
        nbPersonnesMax.innerHTML = data[0]['personnes_max'];

        let nbChambres = document.getElementById("nbChambres");
        console.log(data[0]['nb_chambres']);
        nbChambres.innerHTML = data[0]['nb_chambres'];

        let nbLitsDoubles = document.getElementById("nbLitsDoubles");
        console.log(data[0]['nb_lits_doubles']);
        nbLitsDoubles.innerHTML = data[0]['nb_lits_doubles'];

        let nbLitsSimples = document.getElementById("nbLitsSimples");
        console.log(data[0]['nb_lits_simples']);
        nbLitsSimples.innerHTML = data[0]['nb_lits_simples'];

        let descDet = document.getElementById("descDet");
        console.log(data[0]['description']);
        descDet.innerHTML = data[0]['description'];

        let listeAmenagements = document.getElementById("listeAmenagements");
        let htmlAmenagement = ""
        fetch('/api/getAmenagementsOfLogementById/' + sessionStorage.getItem('idLogement'))
        .then(response => response.json())
        .then(dataAm => {
            let imgAmenagement
            dataAm.forEach(amenagement => {
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
            console.log(htmlAmenagement)
            if (htmlAmenagement == "") {
                htmlAmenagement = "<p>- Aucun aménagement -</p>"
            }
            listeAmenagements.innerHTML = htmlAmenagement
        });

        let sctNbOccupants = document.getElementById("sctNbOccupants");
        console.log(data[0]['personnes_max']);
        let htmlSelectNbPersonnes = ""
        for (let i = 1; i <= data[0]['personnes_max']; i++) {
            htmlSelectNbPersonnes = htmlSelectNbPersonnes + "<option value='" + i + "'>" + i + " Pers.</option>"
        }
        sctNbOccupants.innerHTML = htmlSelectNbPersonnes;

        let btnDate = document.getElementById("btnDate");
        btnDate.addEventListener("click", () => {
            let popupDate = document.getElementById("popupDate");
            if (popupDate.style.display == "block") {
                console.log("disparait");
                popupDate.style.display = "none"
            } else {
                console.log("affiche");
                popupDate.style.display = "block"
            }
        });

        let totalTtc = document.getElementById("totalTtc");
        let dateDebut = document.getElementById("dateDebut");
        let dateArrivee = document.getElementById("dateArrivee");
        let dateFin = document.getElementById("dateFin");
        let dateDepart = document.getElementById("dateDepart");

        console.log(dateDebut.value)
        /*
        if (dateDebut.value == "") {
            console.log("ça marche !")
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            console.log(mm + '-' + dd + '-' + yyyy);
            // dateDebut.innerText = mm + '-' + dd + '-' + yyyy;
            dateDebut.setAttribute("value", mm + '-' + dd + '-' + yyyy )
            dateDebut.placeholder = mm + '-' + dd + '-' + yyyy
            console.log(dateDebut.value)
        }
        if (dateFin.value == "") {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            dateFin.value = mm + '-' + dd + '-' + yyyy;
        }
        */
        dateArrivee.innerHTML = dateDebut.value
        dateDepart.innerHTML = dateFin.value

        dateDebut.setAttribute("max",dateFin.value);
        dateFin.setAttribute("min",dateDebut.value);

        dateDebut.addEventListener("input", () => {
            dateFin.setAttribute("min",dateDebut.value)
            dateArrivee.innerHTML = dateDebut.value
            totalTtc.innerHTML = calculDevis(data[0]['prix_nuit_ttc'])
        });
        
        dateFin.addEventListener("input", () => {
            dateDebut.setAttribute("max",dateFin.value)
            dateDepart.innerHTML = dateFin.value
            totalTtc.innerHTML = calculDevis(data[0]['prix_nuit_ttc'])
        });
        totalTtc.innerHTML = calculDevis(data[0]['prix_nuit_ttc'])
    
        let btnRes = document.getElementById("btnRes");
        btnRes.addEventListener('click', function() {
            envoiDevis(data[0]['prix_nuit_ttc'],data[0])
            window.location.href = `/reservation/devis`;
        });
    });
});