<?php 
    $client = $params['client'];
    $employees = $params['employees'];
    $relatedEmployees = $params['relatedEmployees']
?>

<div>
    <?php echo "<h1><b>$client[client_name]</b></h1>" ?>
</div>
<div class="row">
    <div class="col-4">
        <h5><b>Dane klienta:</b></h5>
        <li><b>NIP:</b> <?php echo $client['NIP']; ?></li>
        <li><b>Kraj</b> <?php echo $client['country']; ?></li>
        <li><b>Miasto:</b> <?php echo $client['city']; ?></li>
        <li><b>Adres:</b> <?php echo $client['address']; ?></li>
    </div>
    <div class="col-4">
        <h5><b>Osoba kontaktowa:</b></h5>
        <li><b>Imię:</b> <?php echo $client['first_name']; ?></li>
        <li><b>Nazwisko:</b> <?php echo $client['last_name']; ?></li>
        <li><b>Email:</b> <?php echo $client['country']; ?></li>
        <li><b>Nr telefonu:</b> <?php echo $client['phone_number']; ?></li>
    </div>
    <div class="col-4">
        <h5><b>Informacje o pakiecie:</b></h5>
        <li><b>Typ pakietu:</b> <?php echo $client['package_name']; ?></li>
        <li><b>Początek:</b> <?php echo $client['start_date']; ?></li>
        <li><b>Koniec:</b> <?php echo $client['end_date']; ?></li>
    </div>
</div>
<div>
    <h3 class="mt-3"><b>Patroni:</b></h3>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>id</th>
                <th>Imię</th>
                <th>Nazwisko</th>
                <th>Data urodzenia</th>
                <th>Płeć</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($relatedEmployees as $employee): ?>
                <tr>
                    <?php foreach($employee as $dataCell): ?>
                        <td><?php echo $dataCell; ?></td>
                    <?php endforeach; ?>
                    <?php echo '<td><a href="./?entity=Client&action=removeRelation&cId=' . $client["client_id"] . "&eId=" . $employee["employee_id"] . '"><button class="btn btn-danger">Usuń</button></a></td>' ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div>
<h3><b>Dodaj patrona</b></h3>
    <form class="createForm" action="./?entity=Client&action=addRelation" method="post">

        <?php echo '<input type="hidden" name="client_id" value="' . $client["client_id"] . '">' ?>
        
        <select class="mb-2" id="employees" name="employee_id">
            <?php foreach($employees as $employee): ?>
                <?php echo '<option value="' . $employee["employee_id"] . '">' . $employee["first_name"] . " " . $employee["last_name"] . '</option>' ?>
            <?php endforeach; ?>
        </select> <br>

        <input class="btn btn-success" type="submit" value="Dodaj">
    </form>
</div>

