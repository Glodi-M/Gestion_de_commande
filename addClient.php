<?php
ob_start();
include_once 'header.php';
include_once 'main.php';

// Vérifier si le formulaire a été soumis

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nom = trim($_POST['nom'] ?? '');
    $ville = trim($_POST['ville'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    // Tableau pour stocker les erreurs
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

    // Si aucune erreur, procéder à l'insertion

    if (empty($errors)) {
        try {

            $query = "INSERT INTO client (nom, ville, telephone) VALUES (:nom, :ville, :telephone)";
            $pdostmt = $pdo->prepare($query);


            $pdostmt->execute([
                ':nom' => $nom,
                ':ville' => $ville,
                ':telephone' => $telephone
            ]);

            header("Location: clients.php");
            exit;
        } catch (PDOException $e) {

            $errors[] = "Erreur lors de l'ajout du client : " . $e->getMessage();
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



<h1 class="mt-5 ml-5">Ajout un client</h1>


<form class="row g-3" method="POST">

    <div class="col-md-6">
        <label for="inputNom" class="form-label">Nom</label>
        <input type="text" class="form-control" id="inputNom" name="nom" placeholder="Nom" required>
    </div>
    <div class="col-md-6">
        <label for="inputVille" class="form-label">Ville</label>
        <input type="text" class="form-control" id="inputVille" name="ville" placeholder="Ville" required>
    </div>
    <div class="col-12">
        <label for="inputTelephone" class="form-label">Téléphone</label>
        <input type="text" class="form-control" id="inputTelephone" name="telephone" placeholder="Téléphone" required>
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