<?php
namespace App\Model;

require_once('model/Offer.php');
require_once('Services/AmazonProductScraper.php');
require_once('Services/AmazonOffersScraper.php');

use App\Model\Offer;
use App\Services\AmazonProductScraper;
use App\Services\AmazonOffersScraper;

class Product
{
    private $title;
    private $manufacturer;
    private $prices;
    private $infos = [];
    private $pictureUrls = [];
    private $offersList;

    public function __construct($asin)
    {
        $url = "https://www.amazon.com/gp/product/$asin";
        // $this->offersList = new OffersList();
        $productScraper = new AmazonProductScraper($url);
        $this->infos = $productScraper->getProductInformations();
        $this->prices = $productScraper->getProductPrices();
        $this->pictureUrls = $productScraper->getProductImageUrl();
        $this->title = $productScraper->getProductTitle();
        $this->manufacturer = $productScraper->getProductBrand();

        $this->setOffersList($asin);
    }

    protected function setOffersList($asin)
    {
        $url = "http://www.amazon.com/gp/offer-listing/$asin";
        $offersScraper = new AmazonOffersScraper($url);
        $offers = $offersScraper->getOffers();
        for ($i=0; $i < $offers->length; $i++) {
            $offer = new Offer();
            $offer->price = $offersScraper->getOfferPrice($offers->item($i));
            $offer->shipping = $offersScraper->getOfferShipping($offers->item($i));
            $offer->condition = $offersScraper->getOfferCondition($offers->item($i));
            $offer->seller = $offersScraper->getSeller($offers->item($i));
            $this->offers[] = $offer;
        }
    }
}
