<?php

namespace Karan\Page;

use SensioLabs\Behat\PageObjectExtension\PageObject\Page as PageObject;
use Karan\Helper\PageObjectHelperMethods;
use Karan\Page\AdminLoginPage;

class Page extends PageObject
{
    use PageObjectHelperMethods;

    protected $path;

    /**
     * Sets the market selected by the session.
     *
     * @param int|null $marketId
     * @throws \Behat\Mink\Exception\DriverException
     * @throws \Behat\Mink\Exception\UnsupportedDriverActionException
     */
    public function setMarketIdCookie(?int $marketId)
    {
        $this->getDriver()->setCookie('market_id', $marketId);
    }

}
