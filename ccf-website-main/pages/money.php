<?php
    if(!\lib\Session::getInstance()->isLogged()) {
        header('Location:index.php');
        exit;
    }
    lib\Page::getInstance()->setTitle('Zone RH / Money');
    
    
?><header>
    <h1>
        🍋
        Citron Telecom
    </h1><?php include ROOTDIR.'/fragments/menu.php'; ?>
</header>
<main>
    <aside>
        <h2>
            Finances
        </h2>
        <p>
            Gestion des finances
        </p>
    </aside>
    <section>
        <p>
            Ecran en construction
        </p>
    </section>
</main>