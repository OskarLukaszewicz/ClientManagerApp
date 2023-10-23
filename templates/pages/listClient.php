<?php 
    $clients = $params['items'];
?>
<div>
    <h1><b>Klienci</b></h1>
</div>
<div>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>id</th>
                <th>Nazwa agencji</th>
                <th>Osoba Kontaktowa</th>
                <th>Nr kontaktowy</th>
                <th>Rodzaj pakietu</th>
                <th>Koniec pakietu</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clients as $client): ?>
                <tr>
                    <?php foreach($client as $dataCell): ?>
                        <td><?php echo $dataCell; ?></td>
                    <?php endforeach; ?>
                    <td>
                        <?php echo '<a href="./?entity=Client&action=view&id=' . $client["client_id"] . '"><button class="btn btn-info">Widok</button></a>' ?>
                        <?php echo '<a href="./?entity=Client&action=delete&id=' . $client["client_id"] . '"><button class="btn btn-danger">Usuń</button></a>' ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<a href="./?entity=Client&action=create"><button class="btn btn-success">Dodaj klienta</button></a>