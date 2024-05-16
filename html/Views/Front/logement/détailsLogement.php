<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="/html/assets/SCSS/détailsLogement.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div id=descLogement>
        <section id=sectionDesc>
            <img id=imageLogement src="/html/assets/imgs/imageLogementPlaceholder.png" alt="Image du logement">
            <div id=divTitre>
                <h1 id=titreLog>Maison de campagne</h1>
                <h1> - </h1>
                <h1 id=villeLog>LANDERNEAU</h1>
            </div>
            <article id=artPrixNote>
                <div id="note">
                    <p>Note</p>
                    <img id="etoileNotation1" src="/html/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id="etoileNotation2" src="/html/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id="etoileNotation3" src="/html/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id="etoileNotation4" src="/html/assets/imgs/notes/star_full.svg" alt="Etoile">
                    <img id="etoileNotation5" src="/html/assets/imgs/notes/star_empty.svg" alt="Etoile">
                </div>
                <!--
                <div id="divPrix">
                    <span id="prix">65</span>
                    <p>€ par nuit</p>
                </div>
                -->
            </article>
            <article id=carateristiques>
                <div class="barre"></div>
                <h2>Caratéristiques du logement</h2>
                <div id=divNbPersonnesMax>
                    <p>Nombre de personnes maximum :</p>
                    <span id="nbPersonnesMax">NB</span>
                </div>
                <div id="literie">
                    <div>
                        <p>Chambres : </p>
                        <span id="nbChambres">NB</span>
                    </div>
                    <div>
                        <p>Lits doubles : </p>
                        <span id="nbLitsDoubles">NB</span>
                    </div>
                    <div>
                        <p>Lits simples : </p>
                        <span id="nbLitsSimples">NB</span>
                    </div>
                </div>
            
            </article>
            <article>
                <div class="barre"></div>
                <h2>Description</h2>
                <p id="descDet">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam. Maecenas ligula massa, varius a, semper congue, euismod non, mi. Proin porttitor, orci nec nonummy molestie, enim est eleifend mi, non fermentum diam nisl sit amet erat. Duis semper. Duis arcu massa, scelerisque vitae, consequat in, pretium a, enim. Pellentesque congue. Ut in risus volutpat libero pharetra tempor. Cras vestibulum bibendum augue. Praesent egestas leo in pede. Praesent blandit odio eu enim. Pellentesque sed dui ut augue blandit sodales. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aliquam nibh. Mauris ac mauris sed pede pellentesque fermentum. Maecenas adipiscing ante non diam sodales hendrerit.</p>
            </article>
            
            <article>
                <div class="barre"></div>
                <h2>Aménagements</h2>
                <div id=listeAmenagements>
                    <div class=badgeAmenagement>
                        <img src="/html/assets/imgs/mobile/Sapin.svg" alt="Image aménagement 1">
                        <h3>Jardin</p>
                    </div>
                    <div class=badgeAmenagement>
                        <img src="/html/assets/imgs/mobile/Parasol.svg" alt="Image aménagement 2">
                        <h3>Terasse</p>
                    </div>
                </div>
                
            </article>
            <article>
            <div class="barre"></div>
                <h2>Activités à proximité</h2>
                <!--
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
        <div id=buffer></div>
    </div>
</body>
</html>