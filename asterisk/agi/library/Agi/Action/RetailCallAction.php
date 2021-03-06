<?php

namespace Agi\Action;

class RetailCallAction extends RouterAction
{
    protected $_retailAccount;

    protected $_dialStatus = null;

    protected $_dialContext = 'call-retail';

    protected $_processDialStatus = true;

    public function setRetailAccount($retailAccount)
    {
        $this->_retailAccount = $retailAccount;
        return $this;
    }

    public function call()
    {
        if (empty($this->_retailAccount)) {
            $this->agi->error("Retail account is not properly defined. Check configuration.");
            return;
        }

        // Local variables to improve readability
        $retailAccount = $this->_retailAccount;

        // Transform destination to retail preferred format
        $number =  $retailAccount->E164ToPreferred($this->agi->getExtension());

        // Some verbose dolan pls
        $this->agi->notice("Preparing call to %s through retail account \e[0;36m%s [retailAccount%d])\e[0m",
                        $number, $retailAccount->getName(), $retailAccount->getId());

        // Transfor number to account Preferred
        $preferred = $retailAccount->E164ToPreferred($this->agi->getOrigCallerIdNum());
        $this->agi->setCallerIdNum($preferred);

        // Get retail account endpoint
        $endpointName = $retailAccount->getSorcery();

        // Configure Dial options
        $options = ""; // FIXME

        // Call the PSJIP endpoint
        $this->agi->setVariable("DIAL_EXT", $number);
        $this->agi->setVariable("DIAL_DST", "PJSIP/$endpointName");
        $this->agi->setVariable("__DIAL_ENDPOINT", $endpointName);
        $this->agi->setVariable("DIAL_TIMEOUT", "");
        $this->agi->setVariable("DIAL_OPTS", $options);

        // Redirect to the calling dialplan context
        $this->agi->redirect('call-friend', $number);
    }

}
