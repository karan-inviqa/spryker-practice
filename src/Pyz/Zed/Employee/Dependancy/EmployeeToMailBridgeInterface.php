<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2019-01-11
 * Time: 11:39
 */

namespace Pyz\Zed\Employee\Dependancy;


use Generated\Shared\Transfer\MailTransfer;

interface EmployeeToMailBridgeInterface
{
    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return void
     */
    public function handleMail(MailTransfer $mailTransfer);
}