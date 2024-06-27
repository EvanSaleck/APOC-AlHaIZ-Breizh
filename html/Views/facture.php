
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="/assets/SCSS/facture.css" rel="stylesheet">
</head>
<body>
    <div id=facture>
        <section>
            <img id=logo src="/assets/imgs/logo.webp" alt="ALAIZH BREIZH">
            <h2>AlHaIZ Breizh</h2>
            <p>IUT Lannion</p>
            <br>
            <h2 id=labelFacture>FACTURE n°<span id="numFacture"></span></h2>
            <p>Facturée le <span id="dateFacturation"></span></p>
        </section>
        <section id=adresse>
            <div id=adFrom>
                <p>De :</p>
                <br>
                <p id="nomFacturant"></p>
                <p id="adresseDe1"></p>
                <p id="adresseDe2"></p>
                <p id="adresseDe3"></p>
                <p id="emailDe"></p>
            </div>
            <div id=adTo>
                <p>Adressée à :</p>
                <br>
                <p id="nomFacture"></p>
                <p id="adresseA1"></p>
                <p id="adresseA2"></p>
                <p id="adresseA"></p>
                <p id="emailA"></p>
            </div>

        </section>
        <section>
            <p>Logement loué : <span id=nomLogement></span></p>
            <p>Séjour du <span id="dateArrivee"></span> au <span id="dateDepart"></span></p>
            <p><span id=nbLocataires></span> locataire(s)</p>
            <br>
            <p>Adresse de la location :</p>
            <p id="adresseLocation1"></p>
            <p id="adresseLocation2"></p>
            <p id="adresseLocation3"></p>

        </section>
        <table>
            <tr>
                <th>Désignation</th>
                <th>Quantité</th>
                <th>Prix unitaire HT</th>
                <th>Total HT</th>
                <th>TVA</th>
                <th>Total TTC</th>
            </tr>
            <tr>
                <td class="titreLigne">Nuitées</td>
                <td id="nbNuits"></td>
                <td><span id="prixNuitHT"></span> €</td>
                <td><span id="prixSejourHT"></span> €</td>
                <td><span id="tvaSejour"></span> €</td>
                <td><span id="prixSejourTTC"></span> €</td>
            </tr>
            <tr>
                <td class="titreLigne">Frais services</td>
                <td>1</td>
                <td><span id="fraisServicesHT1"></span> €</td>
                <td><span id="fraisServicesHT2"></span> €</td>
                <td><span id="tvaFraisServices"></span> €</td>
                <td><span id="fraisServicesTTC"></span> €</td>
            </tr>
            <tr>
                <td class="titreLigne">Taxe séjour</td>
                <td>1</td>
                <td>1.00 €</td>
                <td><span id="taxeSejourHT"></span> €</td>
                <td>0.00 €</td>
                <td><span id="taxeSejourTTC"></span> €</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <th>TOTAL TTC</th>
                <th><span id="totalTTC"></span> €</th>
            </tr>
        </table>
    </div>
    <script src="/assets/JS/facture.js"></script>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>