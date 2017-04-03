<?php

namespace App\Services;

use App\Services\Scraper;

class AmazonOffersScraper extends Scraper
{
    /**
     * Get all Offers from page
     * @return DomNodeList
     */
    public function getOffers()
    {
        $offersNodes = $this->xPath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' olpOffer ')]");
        return $offersNodes;
    }

    /**
     * Get Offer Price
     * @param  DomNode $offerNode Relative Node to search price in.
     * @return string
     */
    public function getOfferPrice($offerNode)
    {
        $priceNodes = $this->xPath->query(".//*[contains(concat(' ', normalize-space(@class), ' '), ' olpOfferPrice ')]", $offerNode);
        $price = $priceNodes->item(0)->textContent;
        return trim($price);
    }

    /**
     * Get Offer Shipping Price
     * @param  DomNode $offerNode Relative Node to search price in.
     * @return string
     */
    public function getOfferShipping($offerNode)
    {
        $shippingNodes = $this->xPath->query(".//*[contains(concat(' ', normalize-space(@class), ' '), ' olpShippingPrice ')]", $offerNode);
        if ($shippingNodes->length == 0) {
            return "$0.00";
        }
        $shipping = $shippingNodes->item(0)->textContent;
        return trim($shipping);
    }

    /**
     * Get Offer condition
     * @param  DomNode $offerNode Relative Node to search price in.
     * @return string
     */
    public function getOfferCondition($offerNode)
    {
        $conditionNodes = $this->xPath->query(".//*[contains(concat(' ', normalize-space(@class), ' '), ' olpCondition ')]", $offerNode);
        $condition = $conditionNodes->item(0)->textContent;
        return $condition;
    }

    /**
     * Get Seller Name
     * @param  DomNode $offerNode Relative Node to search price in.
     * @return string
     */
    public function getSeller($offerNode)
    {
        $sellerNodes = $this->xPath->query(".//*[contains(concat(' ', normalize-space(@class), ' '), ' olpSellerName ')]", $offerNode);
        $seller = $sellerNodes->item(0)->textContent;
        return $seller;
    }
}
