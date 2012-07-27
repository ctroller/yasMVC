<?php

/**
 * Description of errorController
 *
 * @author trox
 */
class errorController extends yasMVC\Controller
{

    public function errorAction()
    {
        yasMVC\Registry::getInstance()->set('pagetitle', 'Seite nicht gefunden');
        include 'tpl/header.php';
        include 'tpl/error.php';
        include 'tpl/footer.php';
    }

}

?>
