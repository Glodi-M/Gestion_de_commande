<?php
ob_start();
include_once 'header.php';
include 'main.php';
$query = "SELECT idclient FROM client";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute();


$query2 = "SELECT idarticle FROM article";
$pdostmt2 = $pdo->prepare($query2);
$pdostmt2->execute();


// Ajouter une commande

if (!empty($_POST["idClient"]) &&  !empty($_POST["date"])) {
    $idClient = $_POST["idClient"];
    $date = $_POST["date"];
    $query = "INSERT INTO commande (idclient, date) VALUES (:idClient, :date)";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        ':idClient' => $idClient,
        ':date' => $date
    ]);
    header("Location: commandes.php");
    exit;
}

?>


<h1 class="mt-5 ml-5">Ajout une commande</h1>


<form class="row g-3" method="POST">

    <div class="col-md-6">
        <label for="inputIdClient" class="form-label">ID CLIENT</label>
        <select class="form-control" name="idClient" id="inputIdClient" required>
            <?php

            foreach ($pdostmt->fetchAll(PDO::FETCH_NUM) as $tabvalues) {

                foreach ($tabvalues as $value) {
                    echo "<option value='$value'>$value</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputDate" class="form-label">DATE</label>
        <input type="date" class="form-control" id="inputDate" name="date" required>
    </div>
    <div class="col-md-6">
        <label for="inputIdartcile" class="form-label">ARTICLE</label>
        <select class="form-control" name="idArticle" id="inputIderticle" required>
            <?php

            foreach ($pdostmt2->fetchAll(PDO::FETCH_NUM) as $tabvalues) {

                foreach ($tabvalues as $value) {
                    echo "<option value='$value'>$value</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="col-md-6">
        <label for="inputQte" class="form-label">QUANTITE</label>
        <input type="texte" class="form-control" id="inputQte" name="qte" required>
    </div>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </div>
</form>


</div>
</main>


<?php
include_once 'footer.php';
?>