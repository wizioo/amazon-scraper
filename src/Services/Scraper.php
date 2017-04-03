<?php

namespace App\Services;

use DomDocument;
use DomXpath;

abstract class Scraper
{
    public $html;
    public $dom;
    public $xPath;

    public function __construct($url)
    {

        $this->dom = new DOMDocument();
        $this->html = $this->getHtml($url);
        libxml_use_internal_errors(true);
        $this->dom->loadHTML($this->html);
        libxml_clear_errors(true);
        $this->xPath = new DomXpath($this->dom);
    }

    /**
     * Get HTML from Url by initiating Curl
     * @param  string $url
     * @return String
     */
    public function getHtml($url)
    {
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 10.10; labnol;) ctrlq.org");
            curl_setopt($curl, CURLOPT_FAILONERROR, true);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $html = curl_exec($curl);
            curl_close($curl);

            return $html;
    }
}
