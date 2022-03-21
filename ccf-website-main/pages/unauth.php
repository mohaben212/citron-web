<?php
    $error = null;
    if(!empty($_REQUEST['submitLogin'])
            && !empty($_REQUEST['login'])
            && !empty($_REQUEST['pwd'])) {
        $found = lib\Database::getInstance()->qo('select `login` from `users` where `login`=:u and `pwd`=:p', [
            'u' => $_REQUEST['login'],
            'p' => \lib\Encode::getInstance()->x(trim($_REQUEST['pwd'])),
        ]);
        if(!empty($found)) {
            \lib\Session::getInstance()->login($found['login']);
            header('Location:index.php'); // refresh
            exit;
        } else {
            $error = 'Echec de l\'authentification : vérifiez login et/ou mot de passe !';
        }
    }
    lib\Page::getInstance()->setTitle('Accueil / Login');
    
    $contact = \lib\Config::getInstance('general')->get('contact');
?><header>
    <h1>
        🍋
        Citron Telecom
    </h1><?php include ROOTDIR.'/fragments/menu.php'; ?>
</header>
<main>
    <aside>
        <h2>
            Zone RH
        </h2>
        <p>
            Pour obtenir vos accès,
            contactez un administrateur du système:
            <a href="<?php echo htmlspecialchars($contact['mail']?? ''); ?>">
                <?php echo htmlspecialchars($contact['name']?? ''); ?>
            </a>
        </p>
    </aside>
    <section>
        <form method="post">
            <fieldset>
                <legend>Connexion</legend>
                <?php if(!empty($error)) { ?>
                <p class="error"><?php echo $error; ?></p>
                <?php } ?>
                <p>
                    <input type="text" name="login" required="required" placeholder="Identifiant" />
                    <input type="password" name="pwd" required="required" placeholder="Mot de passe" />
                    <input type="submit" name="submitLogin" value="Connexion" />
                </p>
            </fieldset>
        </form>
    </section>
</main>