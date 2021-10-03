<!DOCTYPE html>
<html>
<head>

    <!-- Global head -->
    <?php include("global/global_head.html") ?>
    <link rel="stylesheet" href="global/head.css">
    <link rel="stylesheet" href="paiement/paiement.css">

    <!-- Icones pour le symbole de carte bancaire par exemple -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/3.6.95/css/materialdesignicons.css">

    <title>Paiement</title>

</head>
<body>

<!-- Titre de la page -->
<h2>Page de paiement</h2>

<!-- Contenu du panier -->
<div id="panier">
    <h3>Votre Panier</h3>
    <table class="table" id="table-panier">
    <thead>
        <!-- Titres de la table -->
        <tr>
            <th scope="col">#</th>
            <th scope="col">Nom de l'article</th>
            <th scope="col">Quantité</th>
            <th scope="col">Prix</th>
        </tr>
    </thead>
    <tbody>
        <!-- Un element de la table -->
        <tr>
            <th scope="row">1</th>
            <td>Vase très stylé</td>
            <td>5</td>
            <td>13€</td>
        </tr>
        <!-- Un element de la table -->
        <tr>
            <th scope="row">2</th>
            <td>Bol en porcelaine</td>
            <td>173€</td>
            <td>La peau de mon cul</td>
        </tr>
        <!-- Un element de la table -->
        <tr>
            <th scope="row">3</th>
            <td>Assiette propre</td>
            <td>15</td>
            <td>50€</td>
        </tr>
    </tbody>
    <!-- Pied de la table -->
    <tfoot>
        <tr>
            <th scope="row" colspan="3">Total</th>
            <td>Très cher</td>
        </tr>
    </tfoot>
    </table>
</div>

<!-- Le formulaire de paiement -->
<form id="form-paiement">
    <h3>Vos informations de paiement</h3>
    <!-- Le champ de nom -->
    <label for="input-nom" class="form-label">Nom</label>
    <div class="input-group mb-3">
    <input type="text" class="form-control" id="input-nom" placeholder="Saisissez votre nom">
    </div>
    <!-- Le champ de numero de carte -->
    <label for="input-card-number" class="form-label">Numéro de carte</label>
    <div class="input-group mb-3">
    <input type="text" class="form-control" id="input-card-number" placeholder="0000 0000 0000 0000">
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="mdi mdi-credit-card"></i>
            </span>
        </div>
    </div>
    <!-- La ligne du bas -->
    <div class="row">
        <!-- Le champ du mois -->
        <div class="form-group col-sm-4">
            <label for="input-month">Mois</label>
            <select class="form-select" id="input-month">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
            </select>
        </div>
        <!-- Le champ de l'annee -->
        <div class="form-group col-sm-4">
            <label for="ccyear">Année</label>
            <select class="form-select" id="ccyear">
                <option>2017</option>
                <option>2018</option>
                <option>2019</option>
                <option>2020</option>
                <option>2021</option>
                <option>2022</option>
                <option>2023</option>
                <option>2024</option>
                <option>2025</option>
                <option>2026</option>
                <option>2027</option>
                <option>2028</option>
            </select>
        </div>
        <!-- Le champ CVC -->
        <div class="col-sm-4">
            <div class="form-group">
                <label for="cvv">CVC</label>
                <input class="form-control" id="cvv" type="text" placeholder="123">
            </div>
        </div>
    </div>

</form>

</body>
</html>