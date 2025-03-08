<?php
include_once 'header.php';
include_once 'main.php';
$count = 0;
$liste = [];
$query = "SELECT idarticle FROM article WHERE idarticle IN (SELECT article_id FROM ligne_de_commande)";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();

foreach ($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabvalues) {

    foreach ($tabvalues as $value) {
        $liste[] = $value;
    }
}

?>

<!-- Begin page content -->

<h1 class="mt-5">Articles</h1>
<a href="addArticle.php" class="btn btn-primary" style="float:right; margin-bottom: 20px">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
    </svg>
</a>


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
            <th>ACTIONS</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) :
            $count++;
        ?>
            <tr>
                <td><?php echo $row['idarticle']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td><?php echo $row['prix_unitaire']; ?></td>
                <td>
                    <a href="modifArticle.php?id=<?php echo $row['idarticle']; ?>" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                            <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                        </svg>
                    </a>

                    <button type="button" data-bs-toggle="modal" <?php if (in_array($row['idarticle'], $liste)) {
                                                                        echo "disabled";
                                                                    } ?> data-bs-target="#deleteModal<?php echo $count ?>" class="btn btn-danger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                            <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                        </svg>
                    </button>

                </td>


            </tr>

            <!-- Modal -->
            <div class="modal fade" id="deleteModal<?php echo $count ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Suppression</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Voulez-vous vraiment supprimer cet article ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <a href="deleteArticle.php?id=<?php echo $row['idarticle']; ?>" class="btn btn-danger">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php endwhile; ?>

    </tbody>
</table>
</div>
</main>

<?php
include_once 'footer.php';
?>