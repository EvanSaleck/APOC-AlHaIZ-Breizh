addEventListener("DOMContentLoaded", () => {
    let idresa = sessionStorage.getItem("idresa");
    let id = new FormData();
    id.append("id", idresa);

    // Récupération des données de la réservation
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
            document.getElementById("fraisServices").textContent = `${data.frais_service.replace('.', ',')}€`;
            document.getElementById("taxeSejour").textContent = `${data.taxe_sejour.replace('.', ',')}€`;
            document.getElementById("tarifTTC").textContent = `${data.tarif_total.replace('.', ',')}€`;
            document.getElementById("totalTtc").textContent = `${data.total_tarif_ttc.replace('.', ',')}€`;
    
            id = new FormData();
            id.append("id", data.r_id_logement);

            var idclient = data.r_id_compte;
            console.log(data.r_id_compte)

            var idPourClient = new FormData();
            idPourClient.append("id", data.r_id_compte);

            let bnTel = document.getElementById("boutonTelecharger");
            bnTel.addEventListener("click", (event) => {
                window.open("/facture/"+idresa)
            });
            

            // Récupération des données du logement
            fetch("/api/getLogementById", { method: "POST", body: id })
                .then((response) => response.json())
                .then((data) => {

                console.log("Données du logement :");
                console.log(data);
                document.getElementById("titrelogement").textContent = data[0].titre;
                document.getElementById("photologresa").src = data[0].image_principale;

                fetch("/api/getCompteClientDetails", { method: "POST", body: idPourClient })
                    .then((response) => response.json())
                    .then((data) => {

                    console.log("Données du compte client :");
                    console.log(data);

                    document.getElementById("nomClient").textContent = data[0].pseudo;
                    document.getElementById("mailClient").textContent = data[0].e_mail;
                    document.getElementById("photoClient").src = data[0].photo_profil;
                });
            });
        
    });
});