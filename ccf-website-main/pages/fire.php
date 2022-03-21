<?php
    if(!\lib\Session::getInstance()->isLogged()) {
        header('Location:index.php');
        exit;
    }
    lib\Page::getInstance()->setTitle('Zone RH / Contracts');
    
    $qs = 'select c.*, p.`firstname` as first, p.`lastname` as last, p.`birthdate` as birth, p.`gender` '
            . ' from `contracts` c left join `persons` p on p.`id`=c.`person` '
            . ' where c.`id`=:c';
    
    $person = null;
    if(!empty($_REQUEST['edit'])) {
        $person = lib\Database::getInstance()->qo($qs, ['c' => $_REQUEST['edit'],]);
    }
    
    if(!empty($person) && !empty($_REQUEST['reallyFire'])) {
        $ct = new dal\Contract();
        $ct->load($person['id']);
        $ct->setEnd(new \DateTime('now'));
        $r = $ct->update();
        header('Location:'.\lib\Page::link('contracts'));
        exit;
    }
    
    
?><header>
    <h1>
        🍋
        Citron Telecom
    </h1><?php include ROOTDIR.'/fragments/menu.php'; ?>
</header>
<main>
    <aside>
        <h2>
            Renvoyer un employé
        </h2>
        <p>
            Renvoyer un employé
            placera à aujourd'hui sa date de fin de contrat.
        </p>
    </aside>
    <section>
        <form method="post">
            <fieldset>
                <legend>Confirmation</legend>
                <p>
                    <input type="submit"
                           name="reallyFire"
                           value="J'assume mon capitalisme absolu
et je renvoie cet envoyé
comme si je me sentais maître de son destin" />
                </p>
            </fieldset>
        </form>
    </section>
</main>