<?php
include_once 'header.php';
include 'main.php';
$count = 0;
$liste = [];
$query = "SELECT idcommande FROM commande WHERE idcommande IN (SELECT commande_id FROM ligne_de_commande)";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();

foreach ($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabvalues) {

    foreach ($tabvalues as $value) {
        $liste[] = $value;
    }
}
?>


<h1 class="mt-5">Commandes</h1>


<?php
$query = "SELECT * FROM commande";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();
?>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>ID COMMANDE</th>
            <th> ID CLIENT</th>
            <th>DATE</th>
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody>

        <?php while ($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) :
            $count++;
        ?>
            <tr>
                <td><?php echo $row['idcommande']; ?></td>
                <td><?php echo $row['idclient']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td></td>
            </tr>

        <?php endwhile; ?>

    </tbody>
</table>
</div>
</main>

<?php
include_once 'footer.php';
?>