<?php 
    require("Views/Front/composants/header.php");
    require("Views/Front/composants/head.php");
    // require("Views/Front/composants/navbar.php");
?>
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

<body>
    <button class="boutonPrecedent">Précédent</button>
        
    <div class="devis">
        <div class="headerDevis">
            <button class="retour">
                <img src="/assets/imgs/mobile/Chevron2.svg" alt="retourPagePrecedente" />
            </button>
            <h1 class="titreRecapDevis"> Récapitulatif de la réservation </h1>
        </div>
        <div class="infosLogementsTOTAL">
            <div class="infosLogementResa">
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
                        <img class="photoLogResa" src="/assets/imgs/offres/MaisonLanderneau.png" alt="Maison landerneau"> 
                    </figure>
                </div>

                <div class="premiereBarre"></div>

                <div class="infosReservationDev">
                    <h3> Votre réservation </h3>
                    <div>
                        <p class="info-label">Date d'arrivée :</p>
                        <p id="date_arrivee">30/02/2025</p>
                    </div>
                    <div>
                        <p class="info-label">Date de départ :</p>
                        <p class="date_depart">31/02/2025</p>
                    </div>
                    <div>
                        <p class="info-label">Nombre d'occupants :</p>
                        <p class="nb_occupant">3 occupants</p>
                    </div>
                    <div class="deuxiemeBarre"></div>
                    <div>
                        <p class="info-label">Tarif nuit :</p>
                        <p class="prix_nuit_ttc">210€</p>
                    </div>
                    <div>
                        <p class="info-label">Taxes :</p>
                        <p class="taxe_sejour">25€</p>
                    </div>
                    <div>
                        <p class="info-label">Total pour 12 nuits (en €) :</p>
                        <p class="total_tarif_ttc">2560€</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="PaiementResa">
            <p> Payer via </p>
            <div class="ChoixPaiement">
                <div class="PaiementVisa">
                    <img class="imageVisa" src="/assets/imgs/paiement/visa.png" alt="Image VISA">
                    <p> Carte bancaire </p>
                    <div class="styleInput">
                        <input id="carteCredit" maxlength="3" placeholder="Carte de crédit ou débit" />
                    </div>
                    <div class="styleInput">
                        <input id="expiration" maxlength="7" placeholder="Expiration" />
                        <input id="cvv" maxlength="4" placeholder="Cryptogramme de sécurité" />
                    </div>
                    <div class="styleInput">
                        <input id="nom" placeholder="Nom sur la carte" />
                        <input id="codePostal" maxlength="5" placeholder="Code postal" />
                    </div>
                </div>
                <div class="PaiementPaypal">
                    <img class="imagePaypal" src="/assets/imgs/paiement/paypal.png" alt="Image Paypal">
                    <p> Paypal </p>
                    <img class="boutonPrecedent" src="/assets/imgs/paiement/paypal.png">
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
    </div>
</body>
</html>