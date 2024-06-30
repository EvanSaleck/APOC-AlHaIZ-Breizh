addEventListener("DOMContentLoaded", () => {
    let idresa = sessionStorage.getItem("idresa");
    let id = new FormData();
    id.append("id", idresa);
    
    // Récupération des informations de la réservation 
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
            document.getElementById("taxeSejour").textContent = `${taxeSejour}€`;
            document.getElementById("totalTtc").textContent = `${data.tarif_total}€`;

            id = new FormData();
            id.append("id", data.r_id_logement);

            let idproprio = null;

            // Récupération des informations du logement
            fetch("/api/getLogementById", { method: "POST", body: id })
                .then((response) => response.json())
                .then((data) => {

                console.log(data);
                document.getElementById("titrelogement").textContent = data[0].titre;
                let img = (document.getElementById("photologresa").src = data[0].image_principale);
                idproprio = data[0].l_id_compte;
                let proprio = new FormData();
                proprio.append("id", idproprio);

                fetch("/api/getProprioById", { method: "POST", body: proprio })
                    .then((response) => response.json())
                    .then((data) => {
                      
                    document.getElementById("nomproprio").textContent = data.pseudo;
                    document.getElementById("mailproprio").textContent = data.e_mail;
                    document.getElementById("photoproprio").src = data.photo_profil;
                });
            });
    });
});
