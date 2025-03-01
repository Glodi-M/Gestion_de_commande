<?php
ob_start();
include_once 'header.php';
include_once 'main.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID client invalide.");
}

$idclient = $_GET['id'];

// Récupérer les informations du client à modifier
$query = "SELECT * FROM client WHERE idclient = :idclient";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute(['idclient' => $idclient]);
$client = $pdostmt->fetch(PDO::FETCH_ASSOC);

if (!$client) {
    die("Client non trouvé.");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');


    $errors = [];


    if (empty($nom)) {
        $errors[] = "Le champ 'Nom' est obligatoire.";
    }
    if (empty($ville)) {
        $errors[] = "Le champ 'Ville' est obligatoire.";
    }
    if (empty($telephone) || !preg_match('/^[0-9]{10}$/', $telephone)) {
        $errors[] = "Le champ 'Téléphone' est obligatoire et doit contenir 10 chiffres.";
    }


    if (empty($errors)) {
        try {

            $query = "UPDATE client SET nom = :nom, ville = :ville, telephone = :telephone WHERE idclient = :idclient";
            $pdostmt = $pdo->prepare($query);
            $pdostmt->execute([
                'nom' => $nom,
                'ville' => $ville,
                'telephone' => $telephone,
                'idclient' => $idclient
            ]);


            echo "<p style='color: green;'>Client mis à jour avec succès.</p>";


            header('Location: clients.php');
            exit;
        } catch (PDOException $e) {

            $errors[] = "Erreur lors de la mise à jour du client : " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}

ob_end_flush();
?>

<h1 class="mt-5 ml-5">Modifier un client</h1>

<form class="row g-3" method="POST">
    <div class="col-md-6">
        <label for="inputNom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="inputNom" name="nom" value="<?= htmlspecialchars($client['nom']) ?>">
    </div>
    <div class="col-md-6">
        <label for="inputVille" class="form-label">Ville</label>
        <input type="text" class="form-control" id="inputVille" name="ville" value="<?= htmlspecialchars($client['ville']) ?>">
    </div>
    <div class="col-12">
        <label for="inputTelephone" class="form-label">Téléphone</label>
        <input type="text" class="form-control" id="inputTelephone" name="telephone" value="<?= htmlspecialchars($client['telephone']) ?>">
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