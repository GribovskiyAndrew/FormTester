<?php

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

function CFLeadsForm($webDriver, $link) {

    try {

        $webDriver->get($link);

        $form = $webDriver->wait(20)->until(
            WebDriverExpectedCondition::presenceOfElementLocated(
                WebDriverBy::className('cf-lead')
            )
        );

        $name = $form->findElement(WebDriverBy::cssSelector('input[type="text"][id*="cf_lead_first_name"], input[type="text"][name="cf_lead_first_name"]'));
        $phone = $form->findElement(WebDriverBy::cssSelector('input[type="text"][id*="cf_lead_phone"], input[type="text"][name="cf_lead_phone"]'));
        $email = $form->findElement(WebDriverBy::cssSelector('input[type="email"][id*="cf_lead_email"], input[type="email"][name="cf_lead_email"]'));
        $message = $form->findElement(WebDriverBy::cssSelector('textarea[id*="cf_lead_message"], textarea[name="cf_lead_message"]'));
        $button = $form->findElement(WebDriverBy::cssSelector('a[id*="cf_lead_send"], a[name="cf_lead_send"]'));

        $name->sendKeys('');
        $phone->sendKeys('8434');
        $email->sendKeys('youremail@.com');
        $message->sendKeys('Your message');

        $button->click();

        $nameStyle = $name->getAttribute('style');
        $phoneStyle = $phone->getAttribute('style');
        $emailStyle = $email->getAttribute('style');

        $invalidStyle = 'border: 1px solid rgb(212, 86, 106)';
        $validStyle = 'border: 1px solid rgb(234, 233, 233)';

        if (strpos($nameStyle, $invalidStyle) !== false) {
            print_r("Name input style is as expected.\n");
        } else {
            print_r("Name input style is not as expected.\n");
            return false;
        }

        if (strpos($phoneStyle, $invalidStyle) !== false) {
            print_r("Phone input style is as expected.\n");
        } else {
            print_r("Phone input style is not as expected.\n");
            return false;
        }

        if (strpos($emailStyle, $invalidStyle) !== false) {
            print_r("Email input style is as expected.\n");
        } else {
            print_r("Email input style is not as expected.\n");
            return false;
        }

        $name->clear();
        $phone->clear();
        $email->clear();
        $message->clear();

        $name->sendKeys('Test');
        $phone->sendKeys('0384394948');
        $email->sendKeys('test@test.com');
        $message->sendKeys('Your message');

        $button->click();

        $webDriver->wait(10)->until(WebDriverExpectedCondition::urlContains('thank-you'));

        $currentUrl = $webDriver->getCurrentURL();
        if (strpos($currentUrl, 'thank-you') !== false) {
            print_r("Successful verification of the form on the site: " . $link . "\n");
            return true;
        } else {
            print_r("Unsuccessful verification of the form on the site: " . $link . "\n");
            return false;
        }
} catch (Throwable $e) {

    print_r("Error: " . $e->getMessage() . "\n");
    return false;
}

}
