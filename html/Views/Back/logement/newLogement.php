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
    <div class="containerPrincipal">
        <div class="infosEtPhoto">
            <div class="infosPrincipales">
                <div class="titreTarifs">
                    <div class="titre">
                        <label for="titre">Titre</label>
                        <input type="text" name="titre" id="titre" required>
                    </div>
                    <div class="tarif">
                        <label for="tarif">Tarif par nuit</label>
                        <input type="text" name="tarif" id="tarif" required>    
                    </div>
                </div>
                <label for="adresse">Adresse</label>
                <div id="adresse">
                    <div>
                        <label for="nom_rue">N° et Nom de rue</label>
                        <input type="text" name="nom_rue" id="nom_rue">
                    </div>
                    <div>
                        <label for="ville">Ville</label>
                        <input type="text" name="ville" id="ville" required>
                
                        <label for="cp">Code postal</label>
                        <input type="text" name="cp" id="cp" required>
                    </div>
                    <div>
                        <label for="complement_adresse">Complément d'adresse</label>
                        <input type="text" name="complement_adresse" id="complement_adresse">
                    </div>        
                </div>
            </div>
            <div class="photo">
                <label for="photo">Photo du logement</label>
                <input type="file" name="photo" id="photo" required>
            </div>
        </div>
        <div class="infosComplementaires">
            <div class="amenagementEtDescription">
                <div>
                    <label for="amenagements">Aménagements</label>
                    <div id="amenagements">
                        <label>
                            <input type="checkbox" name="amenagement" value="Option1" class="amenagement-checkbox">
                            <span class="button">Jardin</span>
                        </label>
                        <label>
                            <input type="checkbox" name="amenagement" value="Option2" class="amenagement-checkbox">
                            <span class="button">Balcon</span>
                        </label>
                        <label>
                            <input type="checkbox" name="amenagement" value="Option3" class="amenagement-checkbox">
                            <span class="button">Terrasse</span>
                        </label>
                        <label>
                            <input type="checkbox" name="amenagement" value="Option4" class="amenagement-checkbox">
                            <span class="button">Piscine</span>
                        </label>
                        <label>
                            <input type="checkbox" name="amenagement" value="Option5" class="amenagement-checkbox">
                            <span class="button">Jacuzzi</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label for="accroche">Accroche</label>
                    <textarea name="accroche" id="accroche" required></textarea>
                </div>
                <div>
                    <label for="description">Discription</label>
                    <textarea name="description" id="description" required></textarea>
                </div>
            </div>
            <div class="caracterisitquesLogements">
                <div>
                    <label for="caracteristique">Caractéristiques du logement</label>
                    <div id="caracteristique">
                        <div>
                            <label for="surface">Surface habitable</label>
                            <input type="text" name="surface" id="surface" required>
                        </div>
                        <div>
                            <label for="nbPersMax">Nomre pers. max</label>
                            <input type="text" name="nbPersMax" id="nbPersMax" required>
                        </div>
                        <div>
                            <label for="nbPieces">Nomre de pièces</label>
                            <input type="text" name="nbPieces" id="nbPieces" required>
                        </div>
                        <div>
                            <label for="nbChambres">Nomre de chambres</label>
                            <input type="text" name="nbChambres" id="nbChambres" required>
                        </div>
                        <div>
                            <label for="nbLitsSimples">Nomre de lits simples</label>
                            <input type="text" name="nbLitsSimples" id="nbLitsSimples" required>
                        </div>
                        <div>
                            <label for="nbLitsDoubles">Nombre de lits doubles</label>
                            <input type="text" name="nbLitsDoubles" id="nbLitsDoubles" required>
                        </div>
                    </div>
                </div>
                <div>
                    <label for="conditionsReservations">Conditions de réservation</label>
                    <div id="conditionsReservations">
                        <div>
                            <label for="delaiResaArrivee">Délai réservation/arrivée</label>
                            <input type="text" name="delaiResaArrivee" id="delaiResaArrivee">
                            <select name="uniteDelaiResaArrivee" id="uniteDelaiResaArrivee">
                                <option value="jours">Jour(s)</option>
                                <option value="semaines">Semaine(s)</option>
                                <option value="mois">Mois</option>
                            </select>
                        </div>
                        <div>
                            <label for="dureeMinLoc">Durée minimale location</label>
                            <select name="uniteDureeMinLoc" id="uniteDureeMinLoc">
                                <option value="jours">Jour(s)</option>
                                <option value="semaines">Semaine(s)</option>
                            </select>
                        </div>
                        <div>
                            <label for="delaiAnnulMax">Délai d'annulation maximum</label>
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
        <button>Valider</button>
    </div>
</body>
</html>
