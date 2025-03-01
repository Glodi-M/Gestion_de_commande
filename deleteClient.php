<?php
require_once 'connexion.php';
require_once 'main.php';

if (!empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = 'DELETE FROM client WHERE idclient = :id';
    $objstmt = $pdo->prepare($query);
    $objstmt->execute([':id' => $id]);
    $objstmt->closeCursor();
    header('Location: clients.php');
} else {
    header('Location: clients.php');
}
