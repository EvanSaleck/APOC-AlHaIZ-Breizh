addEventListener("DOMContentLoaded", () => {
let id = new FormData();
id.append('id', 1);
let idlogement = null;
fetch('/api/getReservationById', { method: 'POST', body: id })
.then(response => response.json())
.then(data => {
    console.log(data);
    document.getElementById('dateArrivee').textContent = data.date_arrivee;
    document.getElementById('dateFin').textContent = data.date_depart;
    document.getElementById('sctNbOccupants').textContent = `${data.nb_occupant} occupants`;
    document.getElementById('tarifTTC').textContent = `${data.total_tarif_ttc}€`;
    document.getElementById('taxeSejour').textContent = `${data.taxe_sejour}€`;
    document.getElementById('totalTtc').textContent = `${data.tarif_total}€`;

    idlogement = data.id_logement;
});
let idproprio = null;
if(sessionStorage.getItem('Data')!=null){
    let data = JSON.parse(sessionStorage.getItem('Data'));
    document.getElementById('titrelogement').value = data.titre;
    let img = document.getElementById('imglogement').src = data.image_principale
    idproprio = data.id_proprietaire;
} else {
    id = new FormData();
    id.append('id', 1);
    fetch('/api/getLogementById', { method: 'POST', body: id })
    .then(response => response.json())
    .then(data => {
        console.log(data[0].titre);
        document.getElementById('titrelogement').textContent = data[0].titre;
        let img = document.getElementById('photologresa').src = data[0].image_principale+'.svg';
        idproprio = data[0].l_id_compte;
        let proprio = new FormData();
        proprio.append('id', idproprio);
        fetch('/api/getProprioById', { method: 'POST', body: proprio })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            document.getElementById('nomproprio').textContent = data.pseudo;
            document.getElementById('mailproprio').textContent = data.e_mail;
            document.getElementById('photoproprio').src = data.photo_profil;
            });
    });
    }
});
