<?php

namespace App\Services;

require_once('Scraper.php');

use App\Services\Scraper;

class AmazonProductScraper extends Scraper
{

    /**
     * Get Product Title from Dom
     * @return string
     */
    public function getProductTitle()
    {
        $titleElement = $this->dom->getElementById('productTitle');
        return trim($titleElement->textContent);
    }

    /**
     * Get Product Brand from DOM
     * @return string
     */
    public function getProductBrand()
    {
        $brandElement = $this->dom->getElementById('brand');
        return trim($brandElement->textContent);
    }

    /**
     * Get Product image URL
     * @return Array
     */
    public function getProductImageUrl()
    {
        $pattern = '/(<img.*src=["\']{1})(https:\/\/images-na\.ssl-images-amazon\.com\/images\/I\/.*_SS40_.jpg)(["\']{1})>/';
        preg_match_all($pattern, $this->html, $imagesUrl);
        $imagesUrl = $imagesUrl[2];
        for ($i = 0; $i < count($imagesUrl); $i++) {
            $imagesUrl[$i] = $this->cleanImageUrls($imagesUrl[$i]);
        }
        return $imagesUrl;
    }

    /**
     * Get Product Informations
     * @return Array    Key = Product Info title, content = Product info content
     */
    public function getProductInformations()
    {
        $productInfos = $this->dom->getElementById('productDetails_detailBullets_sections1');
        $productInfosRow = $productInfos->getElementsByTagName("tr");
        for ($i=0; $i < $productInfosRow->length; $i++) {
            $infos[] = [trim($productInfosRow->item($i)->getElementsByTagName('th')->item(0)->textContent) => trim($productInfosRow->item($i)->getElementsByTagName('td')->item(0)->textContent)];
        }
        return $infos;
    }

    /**
     * Get Product Prices
     * @return array [regular, special]
     */
    public function getProductPrices()
    {
        $priceElement = $this->dom->getElementById("price");
        $oldPriceNodes = $this->xPath->query(".//*[contains(concat(' ', normalize-space(@class), ' '), ' a-text-strike ')]", $priceElement);
        $oldPrice = $oldPriceNodes->item(0)->textContent;

        $newPriceElement = $this->dom->getElementById("priceblock_ourprice");
        $newPrice = $newPriceElement->textContent;
        $prices = [
            'regular' =>  $oldPrice,
            'special' =>  $newPrice,
        ];

        return $prices;
    }

    /**
     * Clean Image Urls by removing part indicating it's a thumbnail
     * @param  String $url
     * @return string
     */
    private function cleanImageUrls($url)
    {
        return str_replace("._SS40_", "", $url);
    }
}
