<?php
include_once 'header.php';
include_once 'main.php';
?>

<h1 class="mt-5">Articles</h1>


<?php
$query = "SELECT * FROM article";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();
?>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>ID</th>
            <th>DESCRIPTION</th>
            <th>PRIX UNITAIRE</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) :
        ?>
            <tr>
                <td><?php echo $row['idarticle']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['prix_unitaire']; ?></td>
            </tr>

        <?php endwhile; ?>

    </tbody>
</table>
</div>
</main>

<?php
include_once 'footer.php';
?>