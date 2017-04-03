<?php
namespace App\Model;

use App\Model\Offer;
use App\Services\AmazonProductScraper;
use App\Services\AmazonOffersScraper;

class Product
{
    public $title;
    public $manufacturer;
    public $prices;
    public $infos = [];
    public $pictureUrls = [];
    public $offersList = [];

    public function __construct($asin)
    {
        $url = "https://www.amazon.com/gp/product/$asin";
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
            // Set Offer
            $offer = new Offer();
            $offer->price = $offersScraper->getOfferPrice($offers->item($i));
            $offer->shipping = $offersScraper->getOfferShipping($offers->item($i));
            $offer->condition = $offersScraper->getOfferCondition($offers->item($i));
            $offer->seller = $offersScraper->getSeller($offers->item($i));

            // Add to OffersList
            $this->offersList[] = $offer;
        }
    }
}
