addEventListener("DOMContentLoaded", () => {
    let idresa = sessionStorage.getItem("idresa");
    let id = new FormData();
    id.append("id", idresa);

    fetch("/api/getReservationById", { method: "POST", body: id })
        .then((response) => response.json())
        .then((data) => {
            console.log("Détails de la réservation :");
            console.log(data);

            // Formatage des dates au format JJ/MM/AAAA
            let valArr = data.date_arrivee.split('-');
            let valDep = data.date_depart.split('-');
            let dateArrFormatee = valArr[2] + "-" + valArr[1] + "-" + valArr[0];
            let dateDepFormatee = valDep[2] + "-" + valDep[1] + "-" + valDep[0];

            // Maj du contenu de détails de réservation
            document.getElementById("dateArrivee").textContent = dateArrFormatee;
            document.getElementById("dateFin").textContent = dateDepFormatee;
            document.getElementById("sctNbOccupants").textContent = `${data.nb_occupant} occupants`;
            document.getElementById("tarifTTC").textContent = `${data.total_tarif_ttc}€`;
            let taxeSejour = parseFloat(data.taxe_sejour) + parseFloat(data.frais_service);
            console.log(taxeSejour)
            document.getElementById("taxeSejour").textContent = `${taxeSejour}€`;
            document.getElementById("totalTtc").textContent = `${data.tarif_total}€`;
    
            id = new FormData();
            id.append("id", data.r_id_logement);

            console.log('ID compte client : ' + data.r_id_compte);
            let idclient = data.r_id_compte;
            
            fetch("/api/getLogementById", { method: "POST", body: id })
                .then((response) => response.json())
                .then((data) => {

                console.log("Données du logement :");
                console.log(data);
                document.getElementById("titrelogement").textContent = data[0].titre;
                document.getElementById("photologresa").src = data[0].image_principale;

                id = new FormData();
                id.append("id", idclient);

                fetch("/api/getCompteClientDetailsById", { method: "POST", body: id })
                    .then((response) => response.json())
                    .then((data) => {

                    console.log("Données du compte client : " + data);
                    //document.getElementById("photoClient").src = data[0].photo_profil;
                    document.getElementById("nomClient").textContent = data.pseudo;
                    document.getElementById("mailClient").textContent = data.e_mail;
                });
            });
        
    });
});