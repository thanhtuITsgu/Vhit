<?php

namespace Vhit\StockManagement\Observer;

class StockManager implements \Magento\Framework\Event\ObserverInterface
{
    protected $session;

    public function __construct(
        \Magento\Backend\Model\Auth\Session $session
    )
    {
        $this->session = $session;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getProduct();
        $roleCurrent = $this->session->getUser()->getRole()->getRoleName();
        if($roleCurrent == "Stock Manager")
        {
            $product->setStatus(2);
            $product->save();
        }
    }
}
