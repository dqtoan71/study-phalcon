<?php
/**
 * Created by IntelliJ IDEA.
 * User: phucanthony
 * Date: 12/6/17
 * Time: 11:40 AM
 */

use services\NewsService;

$di->setShared(
    'news', function () {
    $config = $this->getConfig();
    $news = new NewsService($config->news);
    return $news;
}
);