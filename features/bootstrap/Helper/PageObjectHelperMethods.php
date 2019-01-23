<?php

namespace Karan\Helper;

trait PageObjectHelperMethods
{
    public function openPage($params = [])
    {
        $this->open($params);
        $this->waitForPageLoad();
    }

    public function acceptAlert()
    {
        $this->getDriver()->getWebDriverSession()->accept_alert();
    }

    public function waitForCondition($condition, $maxWait = 50000)
    {
        $this->getDriver()->wait($maxWait, $condition);
    }

    public function waitForPageLoad($maxWait = 50000)
    {
        $this->waitForCondition('(document.readyState == "complete") && (typeof window.jQuery == "function") && (jQuery.active == 0)', $maxWait);
    }

    public function waitForElement($elementName, $maxWait = 50000)
    {
        $visibilityCheck = $this->getElementVisibilyCheck($elementName);
        $this->waitForCondition("(typeof window.jQuery == 'function') && $visibilityCheck", $maxWait);
    }

    public function waitUntilElementDisappear($elementName, $maxWait = 120000)
    {
        $visibilityCheck = $this->getElementVisibilyCheck($elementName);
        $this->waitForCondition("(typeof window.jQuery == 'function') && !$visibilityCheck", $maxWait);
    }

    public function waitTime($waitTime)
    {
        $this->getDriver()->wait($waitTime);
    }

    public function scrollToBottom()
    {
        $this->getDriver()->executeScript('window.scrollTo(0,document.body.scrollHeight);');
    }

    public function scrollUp($pixels)
    {
        $this->getDriver()->executeScript('window.scrollBy(0, -' . $pixels . ');');
    }

    public function scrollToTop()
    {
        $this->getDriver()->executeScript('window.scrollTo(0,0);');
    }

    public function clickElement($elementName)
    {
        $this->getElementWithWait($elementName)->click();
    }

    public function getElementValue($elementName)
    {
        return $this->getElementWithWait($elementName)->getValue();
    }

    public function setElementValue($elementName, $value)
    {
        $this->getElementWithWait($elementName)->setValue($value);
    }

    public function getElementText($elementName)
    {
        return $this->getElementWithWait($elementName)->getText();
    }

    public function getElementWithWait($elementName, $waitTime = 2500)
    {
        $this->waitForElement($elementName, $waitTime);
        return $this->getElement($elementName);
    }

    public function getElementVisibilyCheck($elementName)
    {
        $visibilityCheck = 'true';

        if (isset($this->elements[$elementName]['css'])) {
            $elementFinder = $this->elements[$elementName]['css'];
            $visibilityCheck = "jQuery('$elementFinder').is(':visible')";
        }

        if (isset($this->elements[$elementName]['xpath'])) {
            $elementFinder = $this->elements[$elementName]['xpath'];
            $visibilityCheck = "jQuery(document.evaluate('$elementFinder', document, null, XPathResult.ANY_TYPE, null).iterateNext()).is(':visible')";
        }

        return $visibilityCheck;
    }

    public function isElementVisible($elementName)
    {
        if ($this->hasElement($elementName)) {
            $xpath = $this->getElement($elementName)->getXpath();
            return $this->getDriver()->isVisible($xpath);
        }

        return false;
    }
}
