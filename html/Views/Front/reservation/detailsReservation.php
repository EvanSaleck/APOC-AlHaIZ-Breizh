<?php 
    include_once 'Views/Front/composants/navbar.php';
    include_once 'Views/Front/composants/card.php';
    include_once 'Views/Front/composants/header.php';
    include_once 'Views/Front/composants/head.php';
?>
<div class="detailResa">
    <a href="/logement"><button class="boutonPrecedent">Précédent</button></a>

    <div class="headerDevis">
        <button class="retour">
            <a onclick="history.back()"><img src="/assets/imgs/mobile/Chevron2.svg" alt="retourPagePrecedente" /></a>
        </button>
        <h1 class="titreRecapDevis"> Réservation détaillée </h1>
    </div>
    
    <div class="infosLogementsTOTAL">
        <div class="infosLogementResa">
            <div class="infosLogement">
                <div class="logementResa">
                    <h2 class="titreLogDevis" id="titrelogement"></h2>
                    <figure><img class="photoLogResa" id="photologresa"></figure>
                </div>

                <div class="Proprio">
                    <h2>Propriétaire</h2>
                    <img id="photoproprio">
                    <p id="nomproprio"></p>
                    <p id="mailproprio"></p>
                    <p id="telproprio"></p>
                </div>
            </div>
        </div>

        <div class="premiereBarre"></div>

        <div class="infosDetailsResa">
            <h3> Votre réservation </h3>
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
                <p class="info-label">Tarif TTC :</p>
                <p id="tarifTTC"></p>
            </div>

            <div>
                <p class="info-label">Taxes & Frais de services:</p>
                <p id="taxeSejour"></p>
            </div>

            <div>
                <p class="info-label">Total pour 12 nuits (en €) :</p>
                <p id="totalTtc"></p>
            </div>
        </div>
    </div>

    <div class="condAnnul">
        <h3> Conditions d'annulation </h3>
            <p>
                Annulation gratuite avant le <span id="date">30 mai</span>. Après cette date, des frais de 20% du montant total de la réservation (soit <span id="prixfrais">250</span> euros ) seront appliqués.
            </p>
    </div>
</div>