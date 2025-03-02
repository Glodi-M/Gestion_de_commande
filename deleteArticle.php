<?php
require_once 'connexion.php';
require_once 'main.php';

if (!empty($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $query = 'DELETE FROM article WHERE idarticle = :id';
    $objstmt = $pdo->prepare($query);
    $objstmt->execute([':id' => $id]);
    $objstmt->closeCursor();
    header('Location: articles.php');
} else {
    header('Location: articles.php');
}
