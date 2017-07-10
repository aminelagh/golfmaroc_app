<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ticket de vente</title>
    <link rel="stylesheet" href="{{ asset('pdf/style.css') }}">

</head>
<body>
<header>
    <h1>Ticket de vente</h1>
    <address>
        <p>Golf Maroc</p>

        <p>Magasin N°3A<br>Bloc A1 Résidence Tifaouine</p>

        <p>Av. Moukaouama - Agadir</p>

        <p>+212 5 28 84 47 27</p>
    </address>
    <span><img alt="" src="{{ asset('pdf/logo1.png') }}"><input type="file" accept="image/*"></span>
</header>

<article>
    <h1>Recipient</h1>
    <address>
        <p>Client : <br>Nom client </p>
    </address>
    <table class="meta">
        <tr>
            <th><span>Facture N°</span></th>
            <td><span>101138</span></td>
        </tr>
        <tr>
            <th><span>Date</span></th>
            <td><span></span></td>
        </tr>
        <tr>
            <th><span>Total HT</span></th>
            <td><span id="prefix">  </span><span>600.00</span></td>
        </tr>
    </table>
    <table class="inventory">
        <thead>
        <tr>
            <th><span>Reference</span></th>
            <th><span>Designation</span></th>
            <th><span>Quantite</span></th>
            <th><span>Prix Unitaire HT</span></th>
            <th><span>Taux Remise</span></th>
            <th><span>Montant Remise</span></th>
            <th><span>Montant Total HT</span></th>
            <th><span> TVA</span></th>
            <th><span>Montant TTC Net</span></th>
        </tr>
        </thead>
        <tbody>
        <tr>

            <td><span></span><span></span></td>
            <td><span></span></td>
            <td><span></span><span></span></td>
            <td><span></span><span>DH</span></td>
            <td><span></span><span></span></td>
            <td><span></span><span>DH</span></td>
            <td><span></span><span>DH</span></td>
            <td><span></span><span></span></td>
            <td><span></span><span>DH</span></td>
        </tr>
        </tbody>
    </table>

    <table class="balance">
        <tr>
            <th><span>Total HT</span></th>
            <td><span>  </span><span> </span></td>
        </tr>
        <tr>
            <th><span>Net HT</span></th>
            <td><span>  </span><span>DH</span></td>
        </tr>
        <tr>
            <th><span>Total TVA</span></th>
            <td><span>  </span><span>DH</span></td>
        </tr>
        <tr>
            <th><span>Total TTC</span></th>
            <td><span>  </span><span>DH</span></td>
        </tr>
        <tr>
            <th><span>Net à payer</span></th>
            <td><span>  </span><span>DH</span></td>
        </tr>
    </table>
</article>

</body>
</html>