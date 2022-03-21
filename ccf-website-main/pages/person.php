<?php
    if(!\lib\Session::getInstance()->isLogged()) {
        header('Location:index.php');
        exit;
    }
    $qs = 'select c.*, p.`firstname` as first, p.`lastname` as last, p.`birthdate` as birth, p.`gender` '
            . ' from `contracts` c left join `persons` p on p.`id`=c.`person` '
            . ' where c.`id`=:c';
    
    $person = null;
    if(!empty($_REQUEST['edit'])) {
        $person = lib\Database::getInstance()->qo($qs, ['c' => $_REQUEST['edit'],]);
    }
    
    if(!empty($_REQUEST['saveContract'])) {
        if(empty($person)) { // create
            $pr = new dal\Person();
            $pr->setFirstname($_REQUEST['firstname']);
            $pr->setLastname($_REQUEST['lastname']);
            if(!empty($_REQUEST['gender'])) {
                $pr->setGender($_REQUEST['gender']);
            }
            if(!empty($_REQUEST['birthdate'])) {
                $pr->setBirthdate($_REQUEST['birthdate']);
            }
            if($pr->insert()) {
                $ct = new \dal\Contract();
                $ct->setPerson($pr->getId());
                $ct->setPosition($_REQUEST['position']);
                $ct->setVacations(\lib\Config::getInstance('general')->get('vacations'));
                $ct->setSalary($_REQUEST['salary']);
                $ct->setStart($_REQUEST['start']);
                if(!empty($_REQUEST['end'])) {
                    $ct->setEnd($_REQUEST['end']);
                }
                if($ct->insert()) {
                    $person = lib\Database::getInstance()->qo($qs, ['c' => $ct->getId(),]);
                }
            }
        } else {
            $ct = new \dal\Contract();
            $ct->load($person['id']);
            if(!empty($ct->getId()) && !empty($ct->getPerson())) {
                $pr = new dal\Person();
                $pr->load($ct->getPerson());
                if(!empty($pr->getId())) {
                    $pr->setFirstname($_REQUEST['firstname']);
                    $pr->setLastname($_REQUEST['lastname']);
                    if(!empty($_REQUEST['gender'])) {
                        $pr->setGender($_REQUEST['gender']);
                    }
                    if(!empty($_REQUEST['birthdate'])) {
                        $pr->setBirthdate($_REQUEST['birthdate']);
                    }
                    $pr->update();
                    $ct->setPosition($_REQUEST['position']);
                    $ct->setSalary($_REQUEST['salary']);
                    $ct->setStart($_REQUEST['start']);
                    if(!empty($_REQUEST['end'])) {
                        $ct->setEnd($_REQUEST['end']);
                    }
                    $ct->update();
                    $person = lib\Database::getInstance()->qo($qs, ['c' => $ct->getId(),]);
                }
            }
        }
    }
    
    lib\Page::getInstance()->setTitle('Zone RH / Nouveau contrat');
    
?><header>
    <h1>
        🍋
        Citron Telecom
    </h1><?php include ROOTDIR.'/fragments/menu.php'; ?>
</header>
<main>
    <aside>
        <h2>
            <?php if(empty($person)) { ?>
            Création d'un nouveau contrat
            <?php } else { ?>
            Modification d'un contrat existant
            <?php } ?>
        </h2>
        <p>
            <a href="<?php echo \lib\Page::link('contracts'); ?>">Retour à la liste des contrats</a>
        </p>
    </aside>
    <section>
        <form method="post" action="<?php echo \lib\Page::link('person'); ?>">
            <fieldset>
                <legend>Informations personnelles</legend>
                <p>
                    <label for="person_last">
                        Nom
                    </label>
                    <input type="text"
                           name="lastname"
                           id="person_last"
                           required="required"<?php if(!empty($person)) { ?>
                           value="<?php echo htmlspecialchars($person['last']); ?>"<?php } ?>
                           maxlength="50" />
                </p>
                <p>
                    <label for="person_first">
                        Prénom
                    </label>
                    <input type="text"
                           name="firstname"
                           id="person_first"
                           required="required"<?php if(!empty($person)) { ?>
                           value="<?php echo htmlspecialchars($person['first']); ?>"<?php } ?>
                           maxlength="50" />
                </p>
                <p>
                    <label for="person_birth">
                        Date de naissance
                    </label>
                    <input type="date"
                           name="birthdate"
                           id="person_birth"<?php if(!empty($person)) { ?>
                           value="<?php echo htmlspecialchars($person['birth']); ?>"<?php } ?> />
                </p>
                <p>
                    <label for="person_gender">
                        Genre
                    </label>
                    <select name="gender"
                            id="person_gender">
                        <option value=""></option>
                        <?php foreach(['m' => 'Masculin', 'f' => 'Féminin', 'o' => 'Autre',] as $k => $v) { ?>
                        <option value="<?php echo $k; ?>"<?php if(!empty($person) && ($person['gender'] === $k)) { ?>
                            selected="selected"<?php } ?>>
                            <?php echo htmlspecialchars($v); ?>
                        </option>
                        <?php } ?>
                    </select>
                </p>
            </fieldset>
            <fieldset>
                <legend>Informations du contrat</legend>
                <p>
                    <label for="contract_start">
                        Date de début du contrat
                    </label>
                    <input type="date"
                           name="start"
                           required="required"
                           id="contract_start"<?php if(!empty($person)) { ?>
                           value="<?php echo htmlspecialchars($person['start']); ?>"<?php } ?> />
                </p>
                <p>
                    <label for="contract_end">
                        Date de fin du contrat
                    </label>
                    <input type="date"
                           name="end"
                           id="contract_end"<?php if(!empty($person)) { ?>
                           value="<?php echo htmlspecialchars($person['end']); ?>"<?php } ?> />
                </p>
                <p>
                    <label for="contract_position">
                        Poste
                    </label>
                    <input type="text"
                           name="position"
                           id="contract_position"
                           required="required"<?php if(!empty($person)) { ?>
                           value="<?php echo htmlspecialchars($person['position']); ?>"<?php } ?>
                           maxlength="50" />
                </p>
                <p>
                    <label for="contract_salary">
                        Salaire
                    </label>
                    <input type="number"
                           min="0"
                           step="50"
                           name="salary"
                           id="contract_salary"<?php if(!empty($person)) { ?>
                           value="<?php echo htmlspecialchars($person['salary']); ?>"<?php } ?> />
                </p>
            </fieldset>
            <p>
                <?php if(!empty($person)) { ?>
                <input type="hidden" name="edit" value="<?php echo intval($person['id']); ?>" /><?php } ?>
                <input type="submit" name="saveContract" value="Sauvegarder ce contrat" />
            </p>
        </form>
    </section>
</main>