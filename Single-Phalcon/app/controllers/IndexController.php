<?php
/**
 * Created by IntelliJ IDEA.
 * User: yutouehara
 * Date: 1/30/18
 * Time: 9:18 AM
 */

use Phalcon\Mvc\Controller;
use Phalcon\Filter;


class IndexController extends Controller
{
    public function indexAction()
    {
        echo '<h1>Hello Toandang!</h1>';
    }
    public function callAction(){
        echo '<h1>ToanDang</h1>';
    }

    public function filterAction(){


        $out = $this->filter->sanitize("some(one)@exa\mple.com", "email");
        echo $out;

    }


}

