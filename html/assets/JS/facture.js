// Convertit la date en format de 
function usDateToEurDate(date) {
    let lstDate = date.split("-")

    return lstDate[2]+"/"+lstDate[1]+"/"+lstDate[0]
}

// Pour ouvrir cette page veuillez utiliser window.open("/facture/<id>", "_blank");
    
let urlPiece =  document.location.href.split("/")
console.log(urlPiece[4]);

document.addEventListener('DOMContentLoaded', function() {
    fetch('/api/getFactureByResId/' + urlPiece[4])
    .then(response => response.json())
    .then(data => {
        if (data.length == 0) {
            alert("Erreur : pas de facture pour cet identifiant");
            window.location.href = `/`;
        }

        let numFacture = document.getElementById("numFacture");
        numFacture.innerHTML = data[0]['id_facture'];

        let dateFacturation = document.getElementById("dateFacturation");
        dateFacturation.innerHTML = usDateToEurDate(data[0]['date_facture']);
        

        let nomFacturant = document.getElementById("nomFacturant");
        nomFacturant.innerHTML = data[0]['nom_proprietaire']+" "+data[0]['prenom_proprietaire'];

        let adresseDe1 = document.getElementById("adresseDe1");
        adresseDe1.innerHTML = data[0]['numero_rue_pro']+" "+data[0]['nom_rue_pro'];

        let adresseDe2 = document.getElementById("adresseDe2");
        adresseDe2.innerHTML = data[0]['code_postal_pro']+" "+data[0]['nom_ville_pro'];

        let emailDe = document.getElementById("emailDe");
        emailDe.innerHTML = data[0]['email_proprietaire'];


        let nomFacture = document.getElementById("nomFacture");
        nomFacture.innerHTML = data[0]['nom_client']+" "+data[0]['prenom_client'];

        let adresseA1 = document.getElementById("adresseA1");
        adresseA1.innerHTML = data[0]['numero_rue_client']+" "+data[0]['nom_rue_client'];

        let adresseA2 = document.getElementById("adresseA2");
        adresseA2.innerHTML = data[0]['code_postal_client']+" "+data[0]['nom_ville_client'];

        let emailA = document.getElementById("emailA");
        emailA.innerHTML = data[0]['email_client'];


        let nomLogement = document.getElementById("nomLogement");
        nomLogement.innerHTML = data[0]['nom_logement'];

        let affDateArrivee = document.getElementById("dateArrivee");
        affDateArrivee.innerHTML = usDateToEurDate(data[0]['date_arrivee']);

        let affDateDepart = document.getElementById("dateDepart");
        affDateDepart.innerHTML = usDateToEurDate(data[0]['date_depart']);

        let affNbLocataires = document.getElementById("nbLocataires");
        affNbLocataires.innerHTML = data[0]['nb_occupant'];


        let adresseLocation1 = document.getElementById("adresseLocation1");
        adresseLocation1.innerHTML = data[0]['numero_rue']+" "+data[0]['nom_rue'];

        let adresseLocation2 = document.getElementById("adresseLocation2");
        adresseLocation2.innerHTML = data[0]['code_postal']+" "+data[0]['nom_ville'];

        // début tableau

        let nbNuits = data[0]['nb_nuit'];
        let prixNuitHT = data[0]['prix_nuit_ht'];
        let prixSejourHT = nbNuits * prixNuitHT;
        let tvaSejour = prixSejourHT * 0.10;
        let prixSejourTTC = prixSejourHT + tvaSejour;

        let affNbNuits = document.getElementById("nbNuits");
        affNbNuits.innerHTML = nbNuits;
        let affPrixNuitHT = document.getElementById("prixNuitHT");
        affPrixNuitHT.innerHTML = Number.parseFloat(prixNuitHT).toFixed(2);
        let affPrixSejourHT = document.getElementById("prixSejourHT");
        affPrixSejourHT.innerHTML = Number.parseFloat(prixSejourHT).toFixed(2);
        let affTvaSejour = document.getElementById("tvaSejour");
        affTvaSejour.innerHTML = Number.parseFloat(tvaSejour).toFixed(2);
        let affSejourTTC = document.getElementById("prixSejourTTC");
        affSejourTTC.innerHTML = Number.parseFloat(prixSejourTTC).toFixed(2);

        let fraisServicesHT = prixSejourHT * 0.01;
        let tvaFraisServices = fraisServicesHT * 0.20;
        let fraisServicesTTC = fraisServicesHT + tvaFraisServices;

        let affFraisServicesHT1 = document.getElementById("fraisServicesHT1");
        affFraisServicesHT1.innerHTML = Number.parseFloat(fraisServicesHT).toFixed(2);
        let affFraisServicesHT2 = document.getElementById("fraisServicesHT2");
        affFraisServicesHT2.innerHTML = Number.parseFloat(fraisServicesHT).toFixed(2);
        let affTvaFraisServices = document.getElementById("tvaFraisServices");
        affTvaFraisServices.innerHTML = Number.parseFloat(tvaFraisServices).toFixed(2);
        let affFraisServicesTTC = document.getElementById("fraisServicesTTC");
        affFraisServicesTTC.innerHTML = Number.parseFloat(fraisServicesTTC).toFixed(2);

        let taxeSejour = data[0]['nb_occupant'] * nbNuits;

        let affTaxeSejourHT = document.getElementById("taxeSejourHT");
        affTaxeSejourHT.innerHTML = Number.parseFloat(taxeSejour).toFixed(2);
        let affTaxeSejourTTC = document.getElementById("taxeSejourTTC");
        affTaxeSejourTTC.innerHTML = Number.parseFloat(taxeSejour).toFixed(2);

        let totalDevis = prixSejourTTC + fraisServicesTTC + taxeSejour;

        let affTotalTTC = document.getElementById("totalTTC");
        affTotalTTC.innerHTML = Number.parseFloat(totalDevis).toFixed(2);

        // Fin tableau

        var facture = document.getElementById('facture');
        html2pdf(facture)
        setTimeout(function() {window.close()}, 2000);
    });
});