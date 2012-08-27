<?php
class Spice_Extendedco_Model_Card
{
	public function addCatalogUrlToSession($e)
	{
                $_this = $e->product;
                $categoryUrl = $_this->getCategoryCollection()->getLastItem()->getUrl();
                Mage::getSingleton('checkout/session')->setLastCategoryUrl($categoryUrl);
	}
 
}
?>
