<?php

namespace Memsource\Tests\Utils;

use Memsource\Utils\ActionUtils;


class ActionUtilsTest extends \WP_UnitTestCase
{


    public function test_IsGETAction()
    {
        $action = 'some-action';
        $action2 = 'some-action-2';
        $_GET['action'] = $action;
        $_GET['action2'] = $action2;

        $this->assertTrue(ActionUtils::isAction($action, 'get'));
        $this->assertTrue(ActionUtils::isAction($action2, 'get'));
    }



    public function testIsPOSTAction()
    {
        $action = 'some-action';
        $action2 = 'some-action-2';
        $_POST['action'] = $action;
        $_POST['action2'] = $action2;

        $this->assertTrue(ActionUtils::isAction($action, 'post'));
        $this->assertTrue(ActionUtils::isAction($action2, 'post'));
    }



    public function testIsNotGETAction()
    {
        $_GET['action'] = 'action';
        $_GET['action2'] = 'action2';

        $this->assertFalse(ActionUtils::isAction('diff-action', 'get'));
    }



    public function testIsNotPOSTAction()
    {
        $_POST['action'] = 'action';
        $_POST['action2'] = 'action2';

        $this->assertFalse(ActionUtils::isAction('diff-action', 'post'));
    }

}