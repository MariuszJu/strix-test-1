<?php

namespace StrixTask\View\Presenter\Index;

use Zend\View\Model\ViewModel;
use StrixTask\View\Presenter\Presenter;

interface IndexPresenter extends Presenter
{

    /**
     * @return ViewModel|void
     */
    public function index();
    
}
