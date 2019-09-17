<?php
/**
 * Created by PhpStorm.
 * User: filiprachunek
 * Date: 05/02/2017
 * Time: 21:18
 */

namespace Memsource\Page;


abstract class AbstractPage {

    abstract function initPage();
    abstract function renderPage();

}