<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

class CoreCommercePurchaseListsPackage extends Package {

	protected $pkgHandle = 'core_commerce_purchase_lists';
	protected $appVersionRequired = '5.6';
	protected $pkgVersion = '0.9.1';
	
	
	public function getPackageDescription() {
		return t('View, print and export lists of customers that have purchased a particular product');
	}
	
	public function getPackageName(){
		return t('eCommerce Product Purchaser Lists');
	}
	
	public function on_start() {
		
	}
	
	public function uninstall() {
		parent::uninstall();
	}
	
	public function upgrade() {
		parent::upgrade();		
	}
	
	public function install() {
        $installed = Package::getInstalledHandles();
        
        if( !(is_array($installed) && in_array('core_commerce',$installed)) ) {
        	throw new Exception(t('This package requires that at least version 2.8.3 of the <a href="http://www.concrete5.org/marketplace/addons/ecommerce/" target="_blank">eCommerce package</a> is installed<br/>'));	
        }
        
        $pkg = Package::getByHandle('core_commerce');
        if (!is_object($pkg) || version_compare($pkg->getPackageVersion(), '2.8.3', '<')) {
        	throw new Exception(t('You must upgrade the eCommerce add-on to version 2.8.3 or higher.'));
        }
        
        $pkg = parent::install();
        
        
        $page = Page::getByPath('/dashboard/core_commerce/purchasers');
        if (!is_object($page) || !intval($page->getCollectionID())) {
            $page = SinglePage::add('/dashboard/core_commerce/purchasers', $pkg);
        }
        if (is_object($page) && intval($page->getCollectionID())) {
            $page->update(array('cName' => t('Product purchasers'), 'cDescription' => t("Generate lists of purchasers for a product")));
        } else throw new Exception(t('Error: /dashboard/core_commerce/purchasers page not created'));
        
             
        
	}
}
