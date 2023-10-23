<?php $contacts = $params['items']; ?>
<h1><b>Osoby kontaktowe</b></h1>
<table id="myTable" class="display">
    <thead>
        <tr>
            <th>id</th>
            <th>Imię</th>
            <th>Nazwisko</th>
            <th>E-mail</th>
            <th>Numer telefonu</th>
            <th>Agencja</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($contacts as $contact): ?>
            <tr>
                <?php foreach($contact as $dataCell): ?>
                    <td><?php echo $dataCell; ?></td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
        
    </tbody>
</table>

