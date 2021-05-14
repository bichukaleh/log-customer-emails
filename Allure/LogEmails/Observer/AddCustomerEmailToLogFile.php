<?php

namespace Allure\LogEmails\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Registry;

class AddCustomerEmailToLogFile implements ObserverInterface
{
	 public function __construct(CustomerRepositoryInterface $customerRepositoryInterface, Registry $registry){    
	 	$this->_customerRepositoryInterface = $customerRepositoryInterface;
	 	$this->_registry = $registry;
	 	// $this->unsetRegistryVariable();
	  }

  	public function execute(\Magento\Framework\Event\Observer $observer)
	  {    
	  	$customer = $observer->getEvent()->getCustomer();
	  	if(!$this->getRegistryVariable()){
	  		$writer = new \Zend\Log\Writer\Stream(BP .'/var/log/customerEmails.log');
	        $logger = new \Zend\Log\Logger();
	        $logger->addWriter($writer);
	        $logger->info($customer->getEmail());
	        $this->setRegistryVariable();
	  	}
	  	
	}

	public function setRegistryVariable()
	{
	 $this->_registry->register('logflag', 'false');
	}
	 
	public function getRegistryVariable()
	{
	 return $this->_registry->registry('logflag');
	}
	 
	public function unsetRegistryVariable()
	{
	 return $this->_registry->unregister('logflag');
	}
}