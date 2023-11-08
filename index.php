<?php

require_once('vendor/autoload.php');
require_once('web-driver-helper.php');
require_once('file-reader.php');
require_once('form-testers/default-form.php');

use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

$filename = 'links.txt';
$linksArray = readLinksFromFile($filename);

print_r($linksArray);

$test = SeleniumTest::getInstance();

$webDriver = $test->webDriver;

foreach ($linksArray as $key => $linkInfo) {

        $link = $linkInfo['link'];
        $parser = $linkInfo['parser'];

        print_r("Link: $link, Parser: $parser\n");

        $result = false;

        $parameters = [$webDriver, $link];

        if ($parser == '') {

            $webDriver->get($link);

            $elements = $webDriver->findElements(WebDriverBy::className('cf-lead'));

            if (count($elements) > 0) {

                $linksArray[$key]['parser'] = 'CFLeadsForm';

                $result = call_user_func_array('CFLeadsForm', $parameters);

            } else {

                print_r("Element with class name not found.\n");

            }
        } else {

            $result = call_user_func_array($linkInfo['parser'], $parameters);
        }
}

print_r($linksArray);

writeLinksToFile('links.txt', $linksArray);

$test->tearDown();
