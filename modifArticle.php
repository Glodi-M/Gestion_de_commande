<?php
session_start();
ob_start();
include_once 'header.php';
include_once 'main.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID article invalide.");
}

$idarticle = $_GET['id'];

// Récupérer les informations de l'article à modifier
$query = "SELECT * FROM article WHERE idarticle = :idarticle";
$pdostmt = $pdo->prepare($query);
$pdostmt->execute(['idarticle' => $idarticle]);
$article = $pdostmt->fetch(PDO::FETCH_ASSOC); // Renommez la variable pour plus de clarté

if (!$article) {
    die("Article non trouvé.");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $description = trim($_POST['description'] ?? '');
    $prix = trim($_POST['prix'] ?? '');

    $errors = [];

    if (empty($description)) {
        $errors[] = "Le champ 'Description' est obligatoire.";
    }
    if (empty($prix) || !is_numeric($prix)) {
        $errors[] = "Le champ 'Prix' est obligatoire et doit être un nombre.";
    }

    if (empty($errors)) {
        try {
            $query = "UPDATE article SET description = :description, prix_unitaire = :prix WHERE idarticle = :idarticle";
            $pdostmt = $pdo->prepare($query);
            $pdostmt->execute([
                'description' => $description,
                'prix' => $prix,
                'idarticle' => $idarticle
            ]);

            $_SESSION['success_message'] = "Article mis à jour avec succès.";
            header('Location: articles.php');
            exit;
        } catch (PDOException $e) {
            $errors[] = "Erreur lors de la mise à jour de l'article: " . $e->getMessage();
        }
    }

    if (!empty($errors)) {
        echo "<div class='alert alert-danger'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
    }
}
ob_end_flush();
?>

<h1 class="mt-5 ml-5">Modifier un article</h1>
<form class="row g-3" method="POST">
    <div class="col-md-6">
        <label for="inputDescription" class="form-label">Description</label>
        <input type="text" class="form-control" id="inputDescription" name="description" value="<?= htmlspecialchars($article['description']) ?>">
    </div>
    <div class="col-md-6">
        <label for="inputPrix" class="form-label">Prix Unitaire</label>
        <input type="text" class="form-control" id="inputPrix" name="prix" value="<?= htmlspecialchars($article['prix_unitaire']) ?>">
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