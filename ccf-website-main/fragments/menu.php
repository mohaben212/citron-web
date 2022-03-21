<?php if(lib\Session::getInstance()->isLogged()) { ?><nav>
    <menu>
        <li>
            <a href="<?php echo \lib\Page::link('person'); ?>"><?php echo t('contract.new'); ?></a>
        </li>
        <li>
            <a href="<?php echo \lib\Page::link('contracts'); ?>"><?php echo t('contract.list'); ?></a>
        </li>
        <li>
            <a href="<?php echo \lib\Page::link('vacations'); ?>"><?php echo t('vacations'); ?></a>
        </li>
        <li>
            <a href="<?php echo \lib\Page::link('money'); ?>"><?php echo t('financial.report'); ?></a>
        </li>
        <li>
            <a href="<?php echo lib\Page::link('logoff'); ?>"><?php echo t('logoff'); ?></a>
        </li>
    </menu>
</nav><?php } ?>