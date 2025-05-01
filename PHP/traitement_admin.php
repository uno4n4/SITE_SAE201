<?php 

include 'inscription.php';

if (isset($_POST['accepter1'])){
    $id = $_POST['id'];
    $sql = "UPDATE inscription_eleve SET statut = 'accepté' WHERE ID = $id";
    $conn->query($sql);
}

if (isset($_POST['refuser1'])){
    $id = $_POST['id'];
    $sql = "UPDATE inscription_eleve SET statut = 'refusé' WHERE ID = $id";
    $conn->query($sql);
}

header("Location: admin.php");
exit();

?>