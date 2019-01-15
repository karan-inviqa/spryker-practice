<?php
/**
 * Created by PhpStorm.
 * User: karanpopat
 * Date: 2019-01-11
 * Time: 15:01
 */

namespace Pyz\Zed\Employee\Plugin\Mail;


use Spryker\Yves\Kernel\AbstractPlugin;
use Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface;
use Spryker\Zed\Mail\Dependency\Plugin\MailTypePluginInterface;

class EmployeeNotificationMailTypePlugin extends AbstractPlugin implements MailTypePluginInterface
{
    const MAIL_TYPE = 'employee notification';
    const MAIL_SUBJECT = "Your status is updated";

    /**
     * Specification:
     * - Returns the name of the MailType
     *
     * @api
     *
     * @return string
     */
    public function getName()
    {
        return static::MAIL_TYPE;
    }

    /**
     * Specification:
     * - Builds the MailTransfer
     *
     * @api
     *
     * @param \Spryker\Zed\Mail\Business\Model\Mail\Builder\MailBuilderInterface $mailBuilder
     *
     * @return void
     */
    public function build(MailBuilderInterface $mailBuilder)
    {
        $this
            ->setSubject($mailBuilder)
            ->setHtmlTemplate($mailBuilder)
            ->setTextTemplate($mailBuilder)
            ->setSender($mailBuilder)
            ->setRecipient($mailBuilder);
    }

    /**
     * @param MailBuilderInterface $mailBuilder
     * @return $this
     */
    private function setSubject(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setSubject('employee.notification.subject');
        return $this;
    }

    /**
     * @param MailBuilderInterface $mailBuilder
     * @return $this
     */
    private function setHtmlTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setHtmlTemplate('employee/mail/employee_notification.html.twig');
        return $this;
    }

    /**
     * @param MailBuilderInterface $mailBuilder
     * @return $this
     */
    private function setTextTemplate(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setTextTemplate('customer/mail/employee_notification.text.twig');

        return $this;
    }

    /**
     * @param MailBuilderInterface $mailBuilder
     * @return $this
     */
    private function setSender(MailBuilderInterface $mailBuilder)
    {
        $mailBuilder->setSender('employee.notification.sender.email');
        return $this;
    }

    /**
     * @param MailBuilderInterface $mailBuilder
     * @return $this
     */
    private function setRecipient(MailBuilderInterface $mailBuilder)
    {
        return $this;

    }


}