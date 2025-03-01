<?php
include_once 'header.php';
include 'main.php';
?>


<!-- Begin page content -->
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Clients</h1>

        <?php
        $query = "SELECT * FROM client";
        $pdostmt = $pdo->prepare($query);
        $pdostmt->execute();
        ?>

        <table id="myTable" class="display">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOM</th>
                    <th>VILLE</th>
                    <th>TELEPHONE</th>
                </tr>
            </thead>

            <tbody>

                <?php
                while ($row = $pdostmt->fetch(PDO::FETCH_ASSOC)) : ?>
                    <tr>
                        <td><?php echo $row['idclient']; ?></td>
                        <td><?php echo $row['nom']; ?></td>
                        <td><?php echo $row['ville']; ?></td>
                        <td><?php echo $row['telephone']; ?></td>
                    </tr>

                <?php endwhile; ?>

            </tbody>
        </table>
    </div>
</main>

<?php
include_once 'footer.php';
?>