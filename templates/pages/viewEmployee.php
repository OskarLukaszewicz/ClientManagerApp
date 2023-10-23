<?php 
    $employee = $params['employee'];
    $clients = $params['clients'];
    $relatedClients = $params['related_clients']
?>
<div class="mb-3">
    <?php echo "<h1><b>" . $employee['first_name'] . " " . $employee['last_name'] . "</b></h1>" ?>
    <span class="ml-1"><?php echo "<b>" . $employee['email'] . "</b>" ?></span>
</div>
<div>
    <h3><b>Klienci:</b></h3>
    <table id="myTable" class="display">
        <thead>
            <tr>
                <th>id</th>
                <th>Nazwa agencji</th>
                <th>Kraj</th>
                <th>Miasto</th>
                <th>Osoba kontaktowa</th>
                <th>Numer telefonu</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($relatedClients as $relatedClient): ?>
                <tr>
                    <?php foreach($relatedClient as $dataCell): ?>
                        <td><?php echo $dataCell; ?></td>
                    <?php endforeach; ?>
                    <?php echo '<td><a href="./?entity=Employee&action=removeRelation&eId=' . $employee["employee_id"] . "&cId=" . $relatedClient["client_id"] . '"><button class="btn btn-danger">Usuń</button></a></td>' ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div>
    <h3><b>Dodaj klienta:</b></h3>
    <form class="createForm" action="./?entity=Employee&action=addRelation" method="post">

        <?php echo '<input type="hidden" name="employee_id" value="' . $employee["employee_id"] . '">' ?>
        
        <select id="companies" name="client_id">
            <?php foreach($clients as $client): ?>
                <?php echo '<option value="' . $client["client_id"] . '">' . $client["client_name"] . '</option>' ?>
            <?php endforeach; ?>
        </select> <br>

        <input class="btn btn-success" type="submit" value="Dodaj">
    </form>
</div>