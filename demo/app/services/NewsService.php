<?php
/**
 * Created by IntelliJ IDEA.
 * User: phucanthony
 * Date: 12/8/17
 * Time: 3:33 PM
 */

namespace services;


use Phalcon\Mvc\User\Component;

class NewsService extends Component
{
    private $url;

    public function __construct($config)
    {
        $this->url = $config->url;
    }

    private function getCategory($category) {
        switch ($category) {
            default:
            case '2サイト共有':
                return 'campaign';
        }
    }

    public function getUsappyNews() {
        $xml = file_get_contents($this->url);

        $doc = new \SimpleXMLElement($xml);
        $doc->registerXPathNamespace('atom', 'http://www.w3.org/2005/Atom');

        $items = $doc->xpath('//item');
        $results = [];
        foreach ($items as $item) {
            $results[] = (object)[
                'category' => self::getCategory((string)$item->xpath('category')[0]),
                'link' => (string)$item->xpath('link')[0],
                'date' => (string)$item->xpath('pubDate')[0],
                'content' => (string)$item->xpath('title')[0]
            ];
        }
        return $results;

    }
}