<?php
/**
 * Created by IntelliJ IDEA.
 * User: yutouehara
 * Date: 1/31/18
 * Time: 9:35 AM
 */

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        echo "Index- Demo Phalcon";
        $this->view->disable();
    }

    public function callAction()
    {
        echo "Call - Demo Phalcon";
        $this->view->disable();
    }


}