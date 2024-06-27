<?php
    include_once 'Views/Back/composants/header.php';
    include_once 'Views/Back/composants/head.php';
?>
<div class="detailResa">
    <a href="/back/reservations/"><button class="boutonPrecedent">Précédent</button></a>

    <div class="headerDevis">
        <button class="retour">
            <a onclick="history.back()"> <img src="/assets/imgs/mobile/Chevron2.svg" alt="retourPagePrecedente"/> </a>
        </button>
        <h1 class="titreRecapDevis">Réservation détaillée</h1>
    </div>

    <div class="infosLogementsTOTAL">
        <div class="infosLogementResa">
            <div class="infosLogement">
                <div class="logementResa">
                    <h2 class="titreLogDevis" id="titrelogement"></h2>
                    <figure><img class="photoLogResa" id="photologresa"></figure>
                </div>

                <article class="Client">
                    <div>
                        <h2 class="titreClient">Client</h2>
                        <img id="photoClient">
                    </div>
                    <div>
                        <p id="nomClient"></p>
                        <p id="mailClient"></p>
                    </div>
                </article>
            </div>
        </div>

        <div class="premiereBarre"></div>

        <div class="infosDetailsResa">
            <h3>Détails de réservation</h3>
            <div>
                <p class="info-label">Date d'arrivée :</p>
                <p id="dateArrivee"></p>
            </div>

            <div>
                <p class="info-label">Date de départ :</p>
                <p id="dateFin"></p>
            </div>

            <div>
                <p class="info-label">Nombre d'occupants :</p>
                <p id="sctNbOccupants"></p>
            </div>

            <div class="deuxiemeBarre"></div>

            <div>
                <p class="info-label">Frais de services :</p>
                <p id="fraisServices"></p>
            </div>

            <div>
                <p class="info-label">Taxes :</p>
                <p id="taxeSejour"></p>
            </div>

            <div>
                <p class="info-label">Total pour 12 nuits (en €) :</p>
                <p id="totalTtc"></p>
            </div>

            <div>
                <p class="info-label">Tarif TTC :</p>
                <p id="tarifTTC"></p>
            </div>
        </div>
    </div>

    <div class="bnTel"><button id="boutonTelecharger">Télécharger Facture</button></div>

    <div class="condAnnul">
        <h3>Conditions d'annulation</h3>
        <p>
            Annulation gratuite avant le <span id="date">30 mai</span>. Après cette date, des frais de 20% du montant total de la réservation (soit <span id="prixfrais">250</span> euros ) seront appliqués.
        </p>
    </div>
</div>

<?php include_once 'Views/Back/composants/footer.php'; ?>