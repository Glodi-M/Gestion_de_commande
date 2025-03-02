<?php
ob_start();
include_once 'header.php';
include_once 'main.php';

// Vérifier si le formulaire a été soumis

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $description = trim($_POST['description'] ?? '');
    $prix = trim($_POST['prix'] ?? '');

    $errors = [];

    if (empty($description)) {
        $errors[] = "Le champ 'Description' est obligatoire.";
    }
    if (empty($prix) || !is_numeric($prix)) {
        $errors[] = "Le champ 'Prix' est obligatoire et doit contenir des chiffres.";
    }

    if (empty($errors)) {
        try {

            $query = "INSERT INTO article (description, prix_unitaire) VALUES (:description, :prix)";
            $pdostmt = $pdo->prepare($query);

            $pdostmt->execute([
                ':description' => $description,
                ':prix' => $prix
            ]);

            header("Location: articles.php");
            exit;
        } catch (PDOException $e) {

            $errors[] = "Erreur lors de l'ajout de l'article : " . $e->getMessage();
            error_log("Erreur SQL : " . $e->getMessage(), 3, "errors.log");
        }
    }

    // Si des erreurs sont présentes, les afficher
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color: red;'>$error</p>";
        }
    }
}
ob_end_flush();
?>


<h1 class="mt-5 ml-5">Ajout un article</h1>
<form class="row g-3" method="POST">

    <div class="col-md-6">
        <label for="inputDescription" class="form-label">Description</label>
        <input type="text" class="form-control" id="inputDescription" name="description" placeholder="Description de l'article" required>
    </div>
    <div class="col-md-6">
        <label for="inputPrix" class="form-label">Prix Unitaire</label>
        <input type="text" class="form-control" id="inputPrix" name="prix" placeholder="Prix unitaire de l'article" required>
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