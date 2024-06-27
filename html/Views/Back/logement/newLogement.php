<?php
    include_once("Views/Back/composants/header.php");
    include_once("Views/Back/composants/head.php");
?>
<body>
    <pre>
        <?php 
            // print_r($_SERVER);
            // print_r(get_included_files());
        ?>
    </pre>
    <h1>Ajouter un logement</h1>

    <form name="formNewLogement" id="formNewLogement" method="POST">
        <div class="containerPrincipal">
            <div class="infosEtPhoto">
                <div class="infosPrincipales">
                    <div class="ligneDeuxInputs">
                        <div class="input1">
                            <label for="titre" class="souligne">Titre*</label>
                            <input type="text" name="titre" id="titre" placeholder="ex : Maison de campagne" value="MAison test">
                            <span class="messageError"></span>
                        </div>
                        <div class="input2">
                            <label for="tarif" class="souligne">Tarif par nuit*</label>
                            <div class="divTarif">
                                <input type="text" name="tarif" id="tarif" placeholder="ex : 50" value="54"><span>€</span>
                            </div>
                            <span class="messageError"></span>  
                        </div>
                    </div>
                    <label for="adresse" class="souligne">Adresse</label>
                    <div id="adresse">
                        <div>
                            <label for="nom_rue">N° et Nom de rue*</label>
                            <input type="text" name="nom_rue" id="nom_rue" placeholder="ex : 50 rue des Lilas" value="43 rue gregregreg">
                        </div>
                        <span class="messageError"></span>
                        <div class="ligneDeuxInputs">
                            <div class="input1">
                                <label for="ville">Ville*</label>
                                <input type="text" name="ville" id="ville" placeholder="ex : Lannion" value="Lannion">
                                <span class="messageError"></span>
                            </div>
                            <div class="input2">
                                <label for="cp">Code postal*</label>
                                <input type="text" name="cp" id="cp" placeholder="ex : 22700" value="22700">
                                <span class="messageError"></span>  
                            </div>
                        </div>
                        <div>
                            <label for="complement_adresse">Complément d'adresse</label>
                            <input type="text" name="complement_adresse" id="complement_adresse" placeholder="ex : 2ème étage">
                        </div>
                        <span class="messageError"></span>   
                    </div>
                </div>
                <div class="photo">
                    <div>
                        <label for="photo-input" class="souligne" id="labelDropPhoto">Photo du logement*</label>
                        <input type="file" id="photo-input" style="display: none;">
                    </div>
                    <div class="drop-photo" id="drop-photo">
                        <img src="/assets/imgs/logoDragImg.svg" alt="Logo d'image">
                        Déposez votre photo ici
                        <button id="photo-button" type="button">Ou sélectionnez un fichier</button>
                        <span id="photo-nom-image"></span>
                        <span class="messageError"></span>  
                    </div>
                </div>
            </div>
            <div class="infosComplementaires">
                <div class="amenagementEtDescription">
                    <div>
                        <label for="amenagementsBoutons" class="souligne">Aménagements</label>
                        <div id="amenagementsBoutons">
                            <button type="button" id="1">
                                <img src="/assets/imgs/iconsAmenagements/jardin.svg" alt="Logo représentant un jardin">
                                Jardin
                            </button>
                            <button type="button" id="2">
                                <img src="/assets/imgs/iconsAmenagements/balcon.svg" alt="Logo représentant un balcon">
                                Balcon
                            </button>
                            <button type="button" id="3">
                                <img src="/assets/imgs/iconsAmenagements/terrasse.svg" alt="Logo représentant une terrasse">
                                Terrasse
                            </button>
                            <button type="button" id="4">
                                <img src="/assets/imgs/iconsAmenagements/piscine.svg" alt="Logo représentant une piscine">
                                Piscine
                            </button>
                            <button type="button" id="5">
                                <img src="/assets/imgs/iconsAmenagements/jacuzzi.svg" alt="Logo représentant un jacuzzi">
                                Jacuzzi
                            </button>
                            <input type="hidden" id="amenagements" name="amenagements">
                        </div>
                        <span class="messageError"></span>  
                    </div>
                    <div class="ligneDeuxInputs">
                        <div class="input1">
                            <label for="type" class="souligne">Type</label>
                            <select name="type" id="type">
                                <option value="1">Studio</option>
                                <option value="2">T1</option>
                                <option value="3">T2</option>
                                <option value="4">T3</option>
                                <option value="5">T4</option>
                                <option value="6">T5 et plus</option>
                                <option value="7">F1</option>
                                <option value="8">F2</option>
                                <option value="9">F3</option>
                                <option value="10">F4</option>
                                <option value="11">F5 et plus</option>
                            </select>
                        </div>
                        <div class="input3">
                            <label for="categorie" class="souligne">Catégorie</label>
                            <select name="categorie" id="categorie">
                                <option value="1">Appartement</option>
                                <option value="2">Maison</option>
                                <option value="3">Villa d'exception</option>
                                <option value="4">Chalet</option>
                                <option value="5">Bateau</option>
                                <option value="6">Logement insolite</option>
                            </select>
                        </div>
                    </div>
                    <div class="accrocheDescription">
                        <div>
                            <label for="accroche" class="souligne">Accroche</label>
                            <textarea name="accroche" id="accroche" placeholder="ex : Maison à deux pas des arbres, idéales pour des balades !"></textarea>
                        </div>
                        <span class="messageError"></span>  
                        <div>
                            <label for="description" class="souligne">Description</label>
                            <textarea name="description" id="description" placeholder="ex : Une maison spacieuse pouvant accueillir jusquà six personnes, idéale pour les familles ou les groupes."></textarea>
                        </div>
                        <span class="messageError"></span>  
                    </div>
                </div>
                <div class="caracterisitquesLogements">
                    <div>
                        <label for="caracteristique" class="souligne">Caractéristiques du logement</label>
                        <div id="caracteristique">
                            <div>
                                <label for="surface">Surface habitable (en m²)*</label>
                                <input type="text" name="surface" id="surface" placeholder="20" value="23">
                            </div>
                            <span class="messageError"></span>  
                            <div>
                                <label for="nbPersMax">Nombre pers. max*</label>
                                <input type="text" name="nbPersMax" id="nbPersMax" placeholder="6" value="3">
                            </div>
                            <span class="messageError"></span>   
                            <div>
                                <label for="nbChambres">Nombre de chambres*</label>
                                <input type="text" name="nbChambres" id="nbChambres" placeholder="3" value="3"> 
                            </div>
                            <span class="messageError"></span>  
                            <div>
                                <label for="nbLitsSimples">Nomre de lits simples*</label>
                                <input type="text" name="nbLitsSimples" id="nbLitsSimples" placeholder="2" value="3"> 
                            </div>
                            <span class="messageError"></span>  
                            <div>
                                <label for="nbLitsDoubles">Nombre de lits doubles*</label>
                                <input type="text" name="nbLitsDoubles" id="nbLitsDoubles" placeholder="2" value="4"> 
                            </div>
                            <span class="messageError"></span>  
                        </div>
                    </div>
                    <div>
                        <label for="conditionsReservations" class="souligne">Conditions de réservation</label>
                        <div id="conditionsReservations">
                            <div>
                                <label for="delaiResaArrivee">Délai réservation/arrivée</label>
                                <div class="selectJour">
                                    <input type="text" name="delaiResaArrivee" id="delaiResaArrivee" placeholder="2">
                                    <select name="uniteDelaiResaArrivee" id="uniteDelaiResaArrivee">
                                        <option value="jours">Jour(s)</option>
                                        <option value="semaines">Semaine(s)</option>
                                        <option value="mois">Mois</option>
                                    </select>
                                </div>
                            </div>
                            <span class="messageError"></span>  
                            <div>
                                <label for="dureeMinLoc">Durée minimale location 
                                    <br>(au moins <br> deux jours)</label>
                                <div class="selectJour">
                                    <input type="text" name="dureeMinLoc" id="dureeMinLoc" placeholder="4" value="5">
                                    <select name="uniteDureeMinLoc" id="uniteDureeMinLoc">
                                        <option value="jours">Jour(s)</option>
                                        <option value="semaines">Semaine(s)</option>
                                    </select>
                                </div>
                            </div>
                            <span class="messageError"></span>  
                            <div>
                                <label for="delaiAnnulMax">Délai d'annulation maximum</label>
                                <div class="selectJour">
                                    <input type="text" name="delaiAnnulMax" id="delaiAnnulMax" placeholder="2">
                                    <select name="uniteDelaiAnnulMax" id="uniteDelaiAnnulMax">
                                        <option value="jours">Jour(s)</option>
                                        <option value="semaines">Semaine(s)</option>
                                        <option value="mois">Mois</option>
                                    </select>
                                </div>
                            </div>
                            <span class="messageError"></span>  
                        </div>
                    </div>
                </div>
            </div>
            <div class="btnValider">
                <input type="submit" value="Valider">
            </div>
        </div>
    </form>
</body>
<?php include_once 'Views/Back/composants/footer.php' ?>
</html>
