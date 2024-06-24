addEventListener("DOMContentLoaded", () => {
    // idresa récupéré après la boucle de création d'objets <tr> du init() de listeReservations.js
    let idResa = sessionStorage.getItem("idresa");
    let id = new FormData();
    id.append("id", idResa);

    fetch("/api/getReservationById", { method: "POST", body: id })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            document.getElementById("dateArrivee").textContent = data.date_arrivee;
            document.getElementById("dateFin").textContent = data.date_depart;
            document.getElementById("sctNbOccupants").textContent = `${data.nb_occupant} occupants`;
            document.getElementById("tarifTTC").textContent = `${data.total_tarif_ttc}€`;
            document.getElementById("taxeSejour").textContent = `${data.taxe_sejour}€`;
            document.getElementById("totalTtc").textContent = `${data.tarif_total}€`;
    
            id = new FormData();
            id.append("id", data.r_id_logement);

            console.log('Num compte client : ' + data.r_id_compte);
            let idclient = data.r_id_compte;
            
            fetch("/api/getLogementById", { method: "POST", body: id })
            .then((response) => response.json())
            .then((data) => {
                console.log("Données du logement : " + data);
                document.getElementById("titrelogement").textContent = data[0].titre;
                document.getElementById("photologresa").src = data[0].image_principale;

                id = new FormData();
                id.append("id", idclient);

                fetch("/api/getCompteClientDetailsBack", { method: "POST", body: id })
                .then((response) => response.json())
                .then((data) => {
                    console.log("Données du compte client : " + data);
                    //document.getElementById("photoClient").src = data[0].photo_profil;
                    document.getElementById("nomClient").textContent = data[0].pseudo;
                    document.getElementById("mailClient").textContent = data[0].e_mail;
                });
            });
        
    });
});