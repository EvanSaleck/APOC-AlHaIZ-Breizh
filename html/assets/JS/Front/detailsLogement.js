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

function afficheRecap(valide) {
    let btnRes = document.getElementById("btnRes");
    let recapitulatifDevis = document.getElementById("recap");
    
    if (valide) {
        btnRes.disabled = false;
        recapitulatifDevis.style.display = "flex"
    } else {
        btnRes.disabled = true;
        recapitulatifDevis.style.display = "none"
    }
}

console.log('detailsLogement.js');
document.addEventListener('DOMContentLoaded', function() {
    console.log(sessionStorage.getItem('idLogement'));
    fetch('/api/getLogementDataById/' + sessionStorage.getItem('idLogement'))
    .then(response => response.json())
    .then(data => {
        afficheRecap(false)

        let titreLogement = document.getElementById("titreLog");
        titreLogement.innerHTML = data[0]['titre'];

        let villeLogement = document.getElementById("villeLog");
        villeLogement.innerHTML = data[0]['nom_ville'];

        let prixLogement = document.getElementById("prix");
        prixLogement.innerHTML = parseFloat(data[0]['prix_nuit_ttc']);

        let nbPersonnesMax = document.getElementById("nbPersonnesMax");
        nbPersonnesMax.innerHTML = data[0]['personnes_max'];

        let nbChambres = document.getElementById("nbChambres");
        nbChambres.innerHTML = data[0]['nb_chambres'];

        let nbLitsDoubles = document.getElementById("nbLitsDoubles");
        nbLitsDoubles.innerHTML = data[0]['nb_lits_doubles'];

        let nbLitsSimples = document.getElementById("nbLitsSimples");
        nbLitsSimples.innerHTML = data[0]['nb_lits_simples'];

        let descDet = document.getElementById("descDet");
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
            if (htmlAmenagement == "") {
                htmlAmenagement = "<p>- Aucun aménagement -</p>"
            }
            listeAmenagements.innerHTML = htmlAmenagement
        });

        let sctNbOccupants = document.getElementById("sctNbOccupants");
        let htmlSelectNbPersonnes = ""
        for (let i = 1; i <= data[0]['personnes_max']; i++) {
            htmlSelectNbPersonnes = htmlSelectNbPersonnes + "<option value='" + i + "'>" + i + " Pers.</option>"
        }
        sctNbOccupants.innerHTML = htmlSelectNbPersonnes;

        let btnDate = document.getElementById("btnDate");
        btnDate.addEventListener("click", () => {
            let popupDate = document.getElementById("popupDate");
            if (popupDate.style.display == "block") {
                popupDate.style.display = "none"
            } else {
                popupDate.style.display = "block"
            }
        });

        let totalTtc = document.getElementById("totalTtc");
        let dateDebut = document.getElementById("dateDebut");
        let dateArrivee = document.getElementById("dateArrivee");
        let dateFin = document.getElementById("dateFin");
        let dateDepart = document.getElementById("dateDepart");

        console.log(dateDebut.value)
        dateArrivee.innerHTML = dateDebut.value
        dateDepart.innerHTML = dateFin.value

        dateDebut.setAttribute("max",dateFin.value);
        dateFin.setAttribute("min",dateDebut.value);

        dateDebut.addEventListener("input", () => {
            dateFin.setAttribute("min",dateDebut.value)
            dateArrivee.innerHTML = dateDebut.value
            totalTtc.innerHTML = calculDevis(data[0]['prix_nuit_ttc'])
            afficheRecap(new Date(dateDebut.value).getTime() - new Date(dateFin.value).getTime() <= 0 )
        });
        dateFin.addEventListener("input", () => {
            dateDebut.setAttribute("max",dateFin.value)
            dateDepart.innerHTML = dateFin.value
            totalTtc.innerHTML = calculDevis(data[0]['prix_nuit_ttc'])
            afficheRecap(new Date(dateDebut.value).getTime() - new Date(dateFin.value).getTime() <= 0 )
        });
        totalTtc.innerHTML = calculDevis(data[0]['prix_nuit_ttc'])
    
        let btnRes = document.getElementById("btnRes");
        btnRes.addEventListener('click', function() {
            envoiDevis(data[0]['prix_nuit_ttc'],data[0])
            window.location.href = `/reservation/devis`;
        });
        btnRes.disabled = true;

        let imagePrinc = document.getElementById("imageLogement");
        imagePrinc.setAttribute("src",data[0]['image_principale']+".svg");
    });
});