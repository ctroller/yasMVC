<?php

namespace yasMVC\View;

class View extends AbstractView
{

    protected function _run()
    {
        include func_get_arg(0);
    }

}