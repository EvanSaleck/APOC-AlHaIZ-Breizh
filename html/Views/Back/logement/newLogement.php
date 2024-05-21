<?php
    include_once("Views/Front/composants/head.php");
?>
</head>
<body>
    <pre>
        <?php 
            // print_r($_SERVER);
            // print_r(get_included_files());
        ?>
    </pre>
    <h1>Ajouter un logement</h1>

    <form name="newLogement" id="newLogement" method="POST">
        <div class="containerPrincipal">
            <div class="infosEtPhoto">
                <div class="infosPrincipales">
                    <div class="ligneDeuxInputs">
                        <div class="input1">
                            <label for="titre" class="souligne">Titre</label>
                            <input type="text" name="titre" id="titre" > /* required */
                        </div>
                        <div class="input2">
                            <label for="tarif" class="souligne">Tarif par nuit</label>
                            <input type="text" name="tarif" id="tarif" > /* required */    
                        </div>
                    </div>
                    <label for="adresse" class="souligne">Adresse</label>
                    <div id="adresse">
                        <div>
                            <label for="nom_rue">N° et Nom de rue</label>
                            <input type="text" name="nom_rue" id="nom_rue">
                        </div>
                        <div class="ligneDeuxInputs">
                            <div class="input1">
                                <label for="ville">Ville</label>
                                <input type="text" name="ville" id="ville" > /* required */
                            </div>
                            <div class="input2">
                                <label for="cp">Code postal</label>
                                <input type="text" name="cp" id="cp" > /* required */
                            </div>
                        </div>
                        <div>
                            <label for="complement_adresse">Complément d'adresse</label>
                            <input type="text" name="complement_adresse" id="complement_adresse">
                        </div>        
                    </div>
                </div>
                <div class="photo">
                    <label for="photo" class="souligne">Photo du logement</label>
                    <input type="file" name="photo" id="photo" > /* required */
                </div>
            </div>
            <div class="infosComplementaires">
                <div class="amenagementEtDescription">
                    <div>
                        <label for="amenagementsBoutons" class="souligne">Aménagements</label>
                        <div id="amenagementsBoutons">
                            <button id="jardin">
                                <img src="/assets/imgs/iconsAmenagements/jardin.svg" alt="Logo représentant un jardin">
                                Jardin
                            </button>
                            <button id="balcon">
                                <img src="/assets/imgs/iconsAmenagements/balcon.svg" alt="Logo représentant un balcon">
                                Balcon
                            </button>
                            <button id="terrasse">
                                <img src="/assets/imgs/iconsAmenagements/terrasse.svg" alt="Logo représentant une terrasse">
                                Terrasse
                            </button>
                            <button id="piscine">
                                <img src="/assets/imgs/iconsAmenagements/piscine.svg" alt="Logo représentant une piscine">
                                Piscine
                            </button>
                            <button id="jaccuzi">
                                <img src="/assets/imgs/iconsAmenagements/jacuzzi.svg" alt="Logo représentant un jacuzzi">
                                Jacuzzi
                            </button>
                        </div>
                    </div>
                    <div class="accrocheDescription">
                        <div>
                            <label for="accroche" class="souligne">Accroche</label>
                            <textarea name="accroche" id="accroche" > /* required */</textarea>
                        </div>
                        <div>
                            <label for="description" class="souligne">Description</label>
                            <textarea name="description" id="description" > /* required */</textarea>
                        </div>
                    </div>
                </div>
                <div class="caracterisitquesLogements">
                    <div>
                        <label for="caracteristique" class="souligne">Caractéristiques du logement</label>
                        <div id="caracteristique">
                            <div>
                                <label for="surface">Surface habitable</label>
                                <input type="text" name="surface" id="surface" > /* required */
                            </div>
                            <div>
                                <label for="nbPersMax">Nomre pers. max</label>
                                <input type="text" name="nbPersMax" id="nbPersMax" > /* required */
                            </div>
                            <div>
                                <label for="nbPieces">Nomre de pièces</label>
                                <input type="text" name="nbPieces" id="nbPieces" > /* required */
                            </div>
                            <div>
                                <label for="nbChambres">Nomre de chambres</label>
                                <input type="text" name="nbChambres" id="nbChambres" > /* required */
                            </div>
                            <div>
                                <label for="nbLitsSimples">Nomre de lits simples</label>
                                <input type="text" name="nbLitsSimples" id="nbLitsSimples" > /* required */
                            </div>
                            <div>
                                <label for="nbLitsDoubles">Nombre de lits doubles</label>
                                <input type="text" name="nbLitsDoubles" id="nbLitsDoubles" > /* required */
                            </div>
                        </div>
                    </div>
                    <div>
                        <label for="conditionsReservations" class="souligne">Conditions de réservation</label>
                        <div id="conditionsReservations">
                            <div>
                                <label for="delaiResaArrivee">Délai réservation/arrivée</label>
                                <div class="selectJour">
                                    <input type="text" name="delaiResaArrivee" id="delaiResaArrivee">
                                    <select name="uniteDelaiResaArrivee" id="uniteDelaiResaArrivee">
                                        <option value="jours">Jour(s)</option>
                                        <option value="semaines">Semaine(s)</option>
                                        <option value="mois">Mois</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="dureeMinLoc">Durée minimale location</label>
                                <div class="selectJour">
                                    <input type="text" name="dureeMinLoc" id="dureeMinLoc">
                                    <select name="uniteDureeMinLoc" id="uniteDureeMinLoc">
                                        <option value="jours">Jour(s)</option>
                                        <option value="semaines">Semaine(s)</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label for="delaiAnnulMax">Délai d'annulation maximum</label>
                                <div class="selectJour">
                                    <input type="text" name="delaiAnnulMax" id="delaiAnnulMax">
                                    <select name="uniteDelaiAnnulMax" id="uniteDelaiAnnulMax">
                                        <option value="jours">Jour(s)</option>
                                        <option value="semaines">Semaine(s)</option>
                                        <option value="mois">Mois</option>
                                    </select>
                                </div>
                            </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="btnValider">
                <button>Valider</button>
            </div>
        </div>
    </form>
</body>
</html>
