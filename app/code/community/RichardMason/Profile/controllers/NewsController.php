<?php
/**
 * Mason Web Development
 *
 * @category    RichardMason
 * @package     RichardMason_Profile
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class RichardMason_Profile_NewsController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
		$this->loadLayout();     
		$this->renderLayout();
    }
    
    public function readAction()
    {
		$this->loadLayout();
		$block=Mage::getBlockSingleton('profile/profile');
		//load profile
    	$profile = $block->getProfile();
    	if($profile) {
		 	$this->getLayout()->getBlock('head')->setTitle($profile->getData("content_heading"))
				->setDescription($profile->getData("meta_description"))
				->setKeywords($profile->getData("meta_keywords"));
    	}
		$this->renderLayout();
    }
	
	public function rssAction()
    {
		$profiles = Mage::getModel('profile/profile')->getCollection()
			->addStoreFilter(Mage::app()->getStore()->getId());
		$profiles->addFieldToFilter('category_id', RichardMason_Profile_Model_Profile::CATEGORY_NEWS);
		$profiles->setOrder("creation_time", "DESC");
		echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
		echo '<rss version="2.0">'."\n";
		echo '<channel>'."\n";
		echo '<title>Island Spice: News</title>'."\n";
		echo '<link>'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'].'</link>'."\n";
		echo '<pubDate>'.date('r').'</pubDate>'."\n";
		
		foreach ($profiles as $n) {
			if ($n->getData("is_active")) {
				$newsUrl = Mage::getUrl('profile/news/read', array("id" => $n->getData("profile_id")));
				echo '<item>'."\n";
				echo '<title><![CDATA['.$n->getData("content_heading").']]></title>'."\n";
				echo '<guid isPermaLink="true">'.$newsUrl.'</guid>'."\n";
				echo '<link>'.$newsUrl.'</link>'."\n";
				echo '<description><![CDATA['.$n->getContent(256).']]></description>'."\n";
				echo '<pubDate>'.$n->getData("creation_time").'</pubDate>'."\n";
				echo '</item>'."\n";
			}
		}
		
		echo '</channel>'."\n";
		echo '/rss'."\n";
    }
    
}