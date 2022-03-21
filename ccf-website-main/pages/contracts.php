<?php
    if(!\lib\Session::getInstance()->isLogged()) {
        header('Location:index.php');
        exit;
    }
    lib\Page::getInstance()->setTitle('Zone RH / Contracts');
    
    $contracts = lib\Database::getInstance()->qa(
            'select c.*, '
            . ' if(c.`end` is not null and date(c.`end`)<=date(now()), 0, 1) as active, '
            . ' (c.`vacations` - count(v.`day`)) as solde, '
            . ' p.`firstname` as first, p.`lastname` as last '
            . ' from `contracts` c '
            . ' left join `persons` p on p.`id`=c.`person` '
            . ' left join `vacations` v on v.`person`=p.`id` and v.`approved`=1 '
            . ' where p.`id` is not null '
            . ' group by p.`id` '
            . ' order by p.`id` desc');
?><header>
    <h1>
        🍋
        Citron Telecom
    </h1><?php include ROOTDIR.'/fragments/menu.php'; ?>
</header>
<main>
    <aside>
        <h2>
            Liste des employés
        </h2>
        <p>
            <a href="<?php echo \lib\Page::link('person'); ?>">Saisir un nouveau contrat</a>
        </p>
    </aside>
    <section>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Entrée</th>
                    <th>Poste</th>
                    <th>Statut</th>
                    <th>Solde</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody><?php foreach($contracts as $contract) { ?>
                <tr>
                    <th><?php echo intval($contract['id']); ?></th>
                    <td><?php echo htmlspecialchars($contract['last']); ?></td>
                    <td><?php echo htmlspecialchars($contract['first']); ?></td>
                    <td><?php echo htmlspecialchars($contract['start']); ?></td>
                    <td><?php echo htmlspecialchars($contract['position']); ?></td>
                    <td><?php echo $contract['active']? 'En poste':'Sortie le '.htmlspecialchars($contract['end']); ?></td>
                    <td><?php echo intval($contract['solde']); ?></td>
                    <td>
                        <a href="<?php echo \lib\Page::link('person&edit='.intval($contract['id'])); ?>">📝</a>
                        <a href="<?php echo \lib\Page::link('fire&edit='.intval($contract['id'])); ?>">🚪</a>
                    </td>
                </tr><?php } ?>
            </tbody>
        </table>
    </section>
</main>