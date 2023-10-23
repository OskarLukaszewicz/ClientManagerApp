<?php $employees = $params['items']; ?>

<h1><b>Pracownicy</b></h1>
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
        <?php foreach($employees as $employee): ?>
            <tr>
                <?php foreach($employee as $dataCell): ?>
                    <td><?php echo $dataCell; ?></td>
                <?php endforeach; ?>
                <?php echo '<td><a href="./?entity=Employee&action=view&id=' . $employee["employee_id"] . '"><button class="btn btn-info">Widok</button></a></td>' ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>