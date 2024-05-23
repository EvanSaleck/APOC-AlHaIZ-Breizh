<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Feuilles de style -->
    <link rel="stylesheet" type="text/css" href="/assets/SCSS/devis.css">
        <script>
        // Récupérer les données de sessionStorage
        <?php 
            $resa = [
                'date_arrivee' => '30/01/2024',
                'date_depart' => '7/02/2024',
                'nb_occupant' => '3',
                'prix_nuit_ttc' => '56',
                'taxe_sejour' => '5',
                'total_tarif_ttc' => '89'
            ];?>
        sessionStorage.setItem('logement', JSON.stringify(<?php echo json_encode($resa);?>))

    </script>
          
</head>
<body>
    <div class="devis">
        <div class="headerDevis">
            <button class="retour">
                <img src="/assets/imgs/mobile/Chevron2.svg" alt="retourPagePrecedente" />
            </button>
            <h1 class="titreRecapDevis"> Récapitulatif de la réservation </h1>
        </div>
        <div class="infosLogement">
            <div class="logementResa">
                <h2 class="titreLogDevis"> Maison de campagne LANDERNEAU </h2>
                <div class="noteResa">
                    <p> Note </p>
                    <div class="note">
                        <img class="noteEtoile" src="/assets/imgs/notes/star_full.svg" alt="">
                        <img class="noteEtoile" src="/assets/imgs/notes/star_full.svg" alt="">
                        <img class="noteEtoile" src="/assets/imgs/notes/star_full.svg" alt="">
                        <img class="noteEtoile" src="/assets/imgs/notes/star_full.svg" alt="">
                        <img class="noteEtoile" src="/assets/imgs/notes/star_empty.svg" alt="">
                    </div>
                </div>
            </div>
            <figure>
                <img class="photoLogResa" src="/assets/imgs/logements/MaisonLanderneau.png" alt="Maison landerneau"> 
            </figure>
        </div>

        <div class="premiereBarre"></div>

        <div class="infosReservationDev">
            <div class="info-row">
                <p class="info-label">Date d'arrivée :</p>
                <p id="date_arrivee">30/02/2025</p>
            </div>
            <div class="info-row">
                <p class="info-label">Date de départ :</p>
                <p class="date_depart">31/02/2025</p>
            </div>
            <div class="info-row">
                <p class="info-label">Nombre d'occupants :</p>
                <p class="nb_occupant">3 occupants</p>
            </div>
            <div class="deuxiemeBarre"></div>
            <div class="info-row">
                <p class="info-label">Tarif nuit :</p>
                <p class="prix_nuit_ttc">210€</p>
            </div>
            <div class="info-row">
                <p class="info-label">Taxes :</p>
                <p class="taxe_sejour">25€</p>
            </div>
            <div class="info-row">
                <p class="info-label">Total pour 12 nuits (en €) :</p>
                <p class="total_tarif_ttc">2560€</p>
            </div>
        </div>

        <div class="PaiementResa">
            <p> Payer via </p>
            <div class="ChoixPaiement">
                <div class="PaiementVisa">
                    <img class="imageVisa" src="/assets/imgs/paiement/visa.png" alt="Image VISA">
                    <p> Carte bancaire </p>
                </div>
                <div class="PaiementPaypal">
                    <img class="imagePaypal" src="/assets/imgs/paiement/paypal.png" alt="Image Paypal">
                    <p> Paypal </p>
                </div>
            </div>
        </div>
        <div class="condAnnul">
            <h3> Conditions d'annulation </h3>
            <p>
                Annulation gratuite avant le 25 mai. Après cette date, des frais de 20% du montant total de la réservation (soit 512 euros ) seront appliqués.
            </p>
        <section>
        <button class="proceder_paiement">Payer</button>
        <span class="overlay"></span>
        <div class="modal-box">
            <div class="headerPaiementValide">
                <i class="fa-regular fa-circle-check"></i>
                <img class="paiementValide" src="/assets/imgs/paiement/validPaiement.png" alt="Paiement validé">
                <h2>Paiement effectué</h2>
            </div>
            <p>Vous recevrez la confirmation de votre demande de réservation par mail dans les prochaines 24 heures</p>
        </div>
        </section>
        <script src="/assets/JS/devis.js"></script>
    </div>
</body>
</html>