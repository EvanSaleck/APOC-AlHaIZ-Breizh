<?php
    include_once 'Views/Front/composants/navbar.php';
    include_once 'Views/Front/composants/header.php';
    include_once 'Views/Front/composants/head.php';
?>

<body>
    <div id=descLogement>
        <section id=sectionDesc>
            <button id=btnRetourMobile><img src="/assets/imgs/mobile/Chevron2.svg" alt="Retour"></button>
            <img id=imageLogement src="" alt="Image du logement">
            <div id=divTitre>
                <h1 id=titreLog></h1>
                <h1> - </h1>
                <h1 id=villeLog></h1>
            </div>
            <article id=artPrixNote>
                <!--
                <div id=note>
                    <p>Note</p>
                    <img id=etoileNotation1 src="/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id=etoileNotation2 src="/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id=etoileNotation3 src="/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id=etoileNotation4 src="/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id=etoileNotation5 src="/assets/imgs/notes/star_empty.svg" alt="Etoile">
                </div>
                -->
                <div id="divPrix">
                    <p labelTarifDesktop>Tarif: <span id="prix"></span>€ par nuit</p>
                </div>
            </article>
            <article id=carateristiques>
                <div class=barre></div>
                <h2>Caratéristiques du logement</h2>
                <div id=divNbPersonnesMax>
                    <p>Nombre de personnes maximum:</p>
                    <span id=nbPersonnesMax>---</span>
                </div>
                <div id=literie>
                    <div>
                        <p>Chambres : </p>
                        <span id=nbChambres>---</span>
                    </div>
                    <div>
                        <p>Lits doubles : </p>
                        <span id=nbLitsDoubles>---</span>
                    </div>
                    <div>
                        <p>Lits simples : </p>
                        <span id=nbLitsSimples>---</span>
                    </div>
                </div>
            
            </article>
            <article>
                <div class=barre></div>
                <h2>Description</h2>
                <p id=descDet>Pas de description</p>
            </article>
            
            <article>
                <div class=barre></div>
                <h2>Aménagements</h2>
                <div id=listeAmenagements><p>- Aucun aménagement -</p></div>
            </article>
            <article>
                <!--
                <div class="barre"></div>
                <h2>Activités à proximité</h2>
                <div id=listeActivite>
                    <div class="activite">
                        <img src="" alt="Image activite">
                        <h3>Nom de l'activite</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam.</p>
                    </div>
                    <div class="activite">
                        <img src="" alt="Image activite">
                        <h3>Nom de l'activite</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam.</p>
                    </div>
                </div>
                -->
            </article>
        </section>
        <div id=popupDate>
            <h3>Renseignez les dates de début et de fin de votre séjour:</h2>
            <div class=barre></div>
            <div class=ligneSaisiePopup>
                <label class=labelPopup for="dateDebut">Date d'arivée:</label>
                <input type="date" class=champSaisiePopup id=dateDebut name="dateDebut" min="2024-06-01" max="2024-12-31"/>
            </div>
            <div class=ligneSaisiePopup>
                <label class=labelPopup for="dateFin">Date de départ:</label>
                <input type="date" class=champSaisiePopup id=dateFin name="dateFin" min="2024-06-01" max="2024-12-31"/>
            </div>
        </div>
        <div id=recap>
            <div>
                <p>Date d'arivée:</p>
                <span id=dateArrivee></span>
            </div>
            <div>
                <p>Date de départ:</p>
                <span id=dateDepart></span>
            </div>
            <div>
                <p>Total TTC:</p>
                <p><span id=totalTtc></span> €</p>
            </div>
        </div>
        <div id=reservation>
            <button id=btnDate class=btn><img src="/assets/imgs/mobile/Calendrier.svg" alt="Calendrier"></button>
            <select id=sctNbOccupants  class=btn name="nbOccupants"></select>
            <button id=btnRes class=btn>Réserver</button>
        </div>
        <div id=buffer></div>
    </div>
</body>
<?php
    include_once 'Views/Front/composants/footer.php';
?>
</html>