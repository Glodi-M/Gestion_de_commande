<?php
ob_start();
include_once 'header.php';
include_once 'main.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idClient = $_POST['idClient'];
    $date = $_POST['date'];
    $idcommande = $_POST['idcommande'];
    $idArticles = $_POST['idArticle'];
    $quantites = $_POST['qte'];

    // Valider les données
    if (empty($idClient) || empty($date) || empty($idcommande) || empty($idArticles) || empty($quantites)) {
        die("Tous les champs sont obligatoires.");
    }

    // Démarrer une transaction
    $pdo->beginTransaction();

    try {
        // Mettre à jour la commande
        $query = "UPDATE commande SET idclient = :idClient, date = :date WHERE idcommande = :idcommande";
        $pdostmt = $pdo->prepare($query);
        $pdostmt->execute([
            'idClient' => $idClient,
            'date' => $date,
            'idcommande' => $idcommande
        ]);

        // Supprimer les anciennes lignes de commande
        $queryDeleteLignes = "DELETE FROM ligne_de_commande WHERE commande_id = :idcommande";
        $pdostmtDeleteLignes = $pdo->prepare($queryDeleteLignes);
        $pdostmtDeleteLignes->execute(['idcommande' => $idcommande]);

        // Insérer les nouvelles lignes de commande
        foreach ($idArticles as $index => $idArticle) {
            $qte = $quantites[$index];

            $queryInsertLigne = "INSERT INTO ligne_de_commande (commande_id, article_id, quantite) VALUES (:commande_id, :article_id, :quantite)";
            $pdostmtInsertLigne = $pdo->prepare($queryInsertLigne);
            $pdostmtInsertLigne->execute([
                'commande_id' => $idcommande,
                'article_id' => $idArticle,
                'quantite' => $qte
            ]);
        }

        // Valider la transaction
        $pdo->commit();


        header("Location: commandes.php");
        exit;
    } catch (Exception $e) {
        // Annuler la transaction en cas d'erreur
        $pdo->rollBack();
        die("Erreur lors de la mise à jour : " . $e->getMessage());
    }
}

// Vérifier si l'ID de la commande est passé en paramètre
if (empty($_GET['id'])) {
    die("ID de commande manquant.");
}

// Récupéreration des informations de la commande
$idcommande = $_GET['id'];
$query = "SELECT * FROM commande WHERE idcommande = :id";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute(['id' => $idcommande]);
$commande = $pdostmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande non trouvée.");
}

// Récupéreration de tous les clients pour le menu déroulant
$queryClients = "SELECT idclient FROM client";
$pdostmtClients = $pdo->prepare($queryClients);
$pdostmtClients->execute();
$clients = $pdostmtClients->fetchAll(PDO::FETCH_ASSOC);

// Récupéreration des lignes de commande associées
$queryLignes = "SELECT * FROM ligne_de_commande WHERE commande_id = :idcommande";
$pdostmtLignes = $pdo->prepare($queryLignes);
$pdostmtLignes->execute(['idcommande' => $idcommande]);
$lignes = $pdostmtLignes->fetchAll(PDO::FETCH_ASSOC);

// Récupéreration de tous les articles pour le menu déroulant
$queryArticles = "SELECT idarticle, description FROM article";
$pdostmtArticles = $pdo->prepare($queryArticles);
$pdostmtArticles->execute();
$articles = $pdostmtArticles->fetchAll(PDO::FETCH_ASSOC);

ob_end_flush();
?>

<h1 class="mt-5 ml-5 mb-5">Modifier une commande</h1>

<form class="row g-3" method="POST">
    <input type="hidden" name="idcommande" value="<?php echo htmlspecialchars($commande['idcommande']); ?>">

    <div class="col-md-6">
        <label for="inputIdClient" class="form-label">ID CLIENT</label>
        <select class="form-control" name="idClient" id="inputIdClient" required>
            <?php foreach ($clients as $client) : ?>
                <option value="<?php echo htmlspecialchars($client['idclient']); ?>"
                    <?php echo ($client['idclient'] == $commande['idclient']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($client['idclient']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="col-md-6">
        <label for="inputDate" class="form-label">DATE</label>
        <input type="date" class="form-control" id="inputDate" name="date" value="<?php echo htmlspecialchars($commande['date']); ?>" required>
    </div>

    <?php foreach ($lignes as $index => $ligne) : ?>
        <div class="row g-3 mb-3">
            <div class="col-md-6">
                <label for="idArticle<?php echo $index; ?>" class="form-label">Article</label>
                <select class="form-control" name="idArticle[]" id="idArticle<?php echo $index; ?>" required>
                    <?php foreach ($articles as $article) : ?>
                        <option value="<?php echo htmlspecialchars($article['idarticle']); ?>"
                            <?php echo ($article['idarticle'] == $ligne['article_id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($article['description']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-6">
                <label for="qte<?php echo $index; ?>" class="form-label">Quantité</label>
                <input type="number" class="form-control" name="qte[]" id="qte<?php echo $index; ?>" value="<?php echo htmlspecialchars($ligne['quantite']); ?>" required>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Modifier</button>
    </div>
</form>

</div>
</main>

<?php
include_once 'footer.php';
?>