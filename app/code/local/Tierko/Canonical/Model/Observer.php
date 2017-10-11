<?php

class Tierko_Canonical_Model_Observer
{

    /**
     * Adding canonical rel after head block load
     * @param $observer
     */
    public function addCanonicalRel($observer)
    {
        $block = $observer->getEvent()
            ->getBlock();

        if ($block instanceof Mage_Page_Block_Html_Head) {
            $block->addLinkRel('canonical', Mage::helper('tierko_canonical')
                ->getCanonicalRel());
        }
    }
}