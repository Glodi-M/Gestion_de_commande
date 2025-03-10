<?php
include_once 'header.php';
include_once 'main.php';

$query = "SELECT 
c.nom, 
c.ville, 
c.telephone, 
co.date, 
a.description, 
a.prix_unitaire, 
lc.quantite
FROM 
client c
JOIN 
commande co ON c.idclient = co.idclient
JOIN 
ligne_de_commande lc ON co.idcommande = lc.commande_id
JOIN 
article a ON lc.article_id = a.idarticle";

$objstmt = $pdo->prepare($query);
$objstmt->execute();
// $objstmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!-- Begin page content -->

<h1 class="mt-5">Accueil</h1>

<table id="myTable" class="display">
    <thead>
        <tr>
            <th>NOM</th>
            <th>TELEPHONE</th>
            <th>VILLE</th>
            <th>DATE</th>
            <th>DESCRIPTION</th>
            <th>PRIX UNITAIRE</th>
            <th>QUANTITE</th>


        </tr>
    </thead>
    <tbody>

        <?php while ($row = $objstmt->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr>

                <td><?php echo $row['nom']; ?></td>
                <td><?php echo $row['telephone']; ?></td>
                <td><?php echo $row['ville']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['prix_unitaire']; ?></td>
                <td><?php echo $row['quantite']; ?></td>

            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
</div>
</main>




<?php
$objstmt->closeCursor();
include_once 'footer.php';
?>