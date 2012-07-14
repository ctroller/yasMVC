<?php

namespace yasCMS;

class Page
{

    private $data = array();

    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function displayPage()
    {
        Registry::getInstance()->getInstance()->set('pagetitle', $this->data['page_title']);
        Registry::getInstance()->getInstance()->set('keywords', &$this->data['page_keywords']);
        include 'tpl/header.php';
        include 'tpl/page.php';
        include 'tpl/footer.php';
    }

}