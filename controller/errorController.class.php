<?php

/**
 * Description of errorController
 *
 * @author trox
 */
class errorController
{

    public function errorAction()
    {
        yasCMS\Registry::getInstance()->getInstance()->set('pagetitle', 'Seite nicht gefunden');
        include 'tpl/header.php';
        include 'tpl/error.php';
        include 'tpl/footer.php';
    }

}

?>
