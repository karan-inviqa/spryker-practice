<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2019-01-11
 * Time: 11:39
 */

namespace Pyz\Zed\Employee\Dependancy;


use Generated\Shared\Transfer\MailTransfer;

class EmployeeToMailBridge implements EmployeeToMailBridgeInterface
{

    /**
     * @var \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected $mailFacade;

    /**
     * @param \Spryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     */
    public function __construct($mailFacade)
    {
        $this->mailFacade = $mailFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleMail(MailTransfer $mailTransfer)
    {
        $this->mailFacade->handleMail($mailTransfer);
    }

    public function sendMail(MailTransfer $mailTransfer)
    {
        $this->mailFacade->sendMail($mailTransfer);
    }
}