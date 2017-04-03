# Amazon Scraper

## Topic
You must write a webscrapper to extract information from an amazon product page.

## Instructions

- No PHP framework use
- You can split the code into several files if needed
- Script must be compatible with the following product pages :
	- http://www.amazon.com/PLAY-BANG-OLUFSEN-Wireless-Headphones/dp/B00R45Z2WU
	- http://www.amazon.com/gp/product/B00M0QVG3W/
	- http://www.amazon.com/gp/product/B00PQWIZPY

- The entry point is a php file calling method main calling the following code (productId being amazon id like B00R45Z2WU, B00M0QVG3W) :
$product = new Product($productId);
- the following information must be available in the product object :
	- Product title
	- Manufacturer
	- prices (regular price, special price)
	- every "Product Information" as array
	- Array of pictures Urls
	- Offers list (available from http://www.amazon.com/gp/offer-listing/XXXX/, XXX being the amazon id)
		- Price
		- Shipping
		- Seller name
		- Condition (new or used)

## Remarks

For this exercise, I used Curl and DOMDocument. I wasn't used to it but I decided to use it as it was close to jQuery way of searching. So I had to make some searches on the web as I had never made a web scraper even if I knew the principle in general. I discovered it was better to use Amazon Product API (and certainly easier and far less likely to change). Amazon API is also legal as they fight against "brute force" scraping. But as I was asked for a web scraper, I made it through curl.

### Details

- Product Manufacturer: I used product brand as "manufacturer" was sometimes found in product informations, so I thought it was a better to fetch brand for this.
- Product images: As all images aren't loaded by default, I decided to fetch images thumbnails and remove their thumb pattern (__SS40__.). I used regular expression to find it as it seemed that all product images where on https://images-na.ssl-images-amazon.com/images/I/. Also I could have used Dom to restrict the search field. (I've lost a lot of time finding that I hadn't all images loaded by default...) :(
- Prices: Just reach for "prices" element block and look for striken through text to fetch regular price. Special price is fetched by element ID.
- Product Infos : Just get element of the table in "Product Information" section. I think this is what you are waiting for. So, you don't have "Warranty & support"  and "Feedback" even if it's in the section. Information should be cleaned especially for customer review. I didn't do that by I would use regular expression to extract the number of stars and / or reviews.
- OffersList : it's a array of Offer objects for me. I decided to use xPath to fetch informations I needed.
	- Offer Condition : I just get the exact title of the condition (not only USED or NEW) as sometimes the condition could be "refurbished" (and as it was faster for me).