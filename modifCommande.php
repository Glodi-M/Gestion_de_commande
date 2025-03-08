<?php
ob_start();
include_once 'header.php';
include_once 'main.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $idClient = $_POST['idClient'];
    $date = $_POST['date'];
    $idcommande = $_POST['idcommande'];

    // Valider les données 
    if (empty($idClient) || empty($date) || empty($idcommande)) {
        die("Tous les champs sont obligatoires.");
    }

    // Mettre à jour la commande
    $query = "UPDATE commande SET idclient = :idClient, date = :date WHERE idcommande = :idcommande";
    $pdostmt = $pdo->prepare($query);
    $pdostmt->execute([
        'idClient' => $idClient,
        'date' => $date,
        'idcommande' => $idcommande
    ]);

    header("Location: commandes.php");
    exit;
}

// Vérifier si l'ID de la commande est passé en paramètre
if (empty($_GET['id'])) {
    die("ID de commande manquant.");
}

// Récupérer les informations de la commande
$idcommande = $_GET['id'];
$query = "SELECT * FROM commande WHERE idcommande = :id";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute(['id' => $idcommande]);
$commande = $pdostmt->fetch(PDO::FETCH_ASSOC);

if (!$commande) {
    die("Commande non trouvée.");
}

// Récupérer tous les clients pour le menu déroulant
$queryClients = "SELECT idclient FROM client";
$pdostmtClients = $pdo->prepare($queryClients);
$pdostmtClients->execute();
$clients = $pdostmtClients->fetchAll(PDO::FETCH_ASSOC);

ob_end_flush();
?>

<h1 class="mt-5 ml-5">Modifier une commande</h1>

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

    <div class="col-12">
        <button type="submit" class="btn btn-primary">Modifier</button>
    </div>
</form>

</div>
</main>

<?php
include_once 'footer.php';
?>