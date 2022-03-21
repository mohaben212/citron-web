<?php
    if(!\lib\Session::getInstance()->isLogged()) {
        header('Location:index.php');
        exit;
    }
    lib\Page::getInstance()->setTitle('Zone RH / Vacations');
    
    
?><header>
    <h1>
        🍋
        Citron Telecom
    </h1><?php include ROOTDIR.'/fragments/menu.php'; ?>
</header>
<main>
    <aside>
        <h2>
            Congés
        </h2>
        <p>
            Gestion des congés
        </p>
    </aside>
    <section>
        <p>
            Ecran en construction
        </p>
    </section>
</main>