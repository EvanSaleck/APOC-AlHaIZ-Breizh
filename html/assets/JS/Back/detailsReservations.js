addEventListener("DOMContentLoaded", () => {
    // idResa récupéré après la boucle de création d'objets <tr> du init() de listeReservations.js
    let idResa = sessionStorage.getItem("idResa");
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
            
            fetch("/api/getLogementById", { method: "POST", body: id })
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                document.getElementById("titrelogement").textContent = data[0].titre;
                // let img = (document.getElementById("photologresa").src = data[0].image_principale);
                document.getElementById("photologresa").src = data[0].image_principale;

                let idclient = data[0].l_id_compte;
                let client = new FormData();
                client.append("id", idclient);

                fetch("/api/getCompteClientDetails", { method: "POST", body: idclient })
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    document.getElementById("photoclient").src = data.photo_profil;
                    document.getElementById("nomclient").textContent = data.pseudo;
                    document.getElementById("mailclient").textContent = data.e_mail;
                });
            });
        
    });
});  