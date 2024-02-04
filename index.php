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

$test = SeleniumTest::getInstance();

$webDriver = $test->webDriver;

foreach ($linksArray as $key => $linkInfo) {

        $link = $linkInfo['link'];
        $parser = $linkInfo['parser'];

        print_r("Link: $link, Parser: $parser\n");

        $linksArray[$key]['result'] = false;

        $parameters = [$webDriver, $link];

    try {

        if ($parser == '') {

            $webDriver->get($link);

            $elements = $webDriver->findElements(WebDriverBy::className('cf-lead'));

            //$elements_2 = $webDriver->findElements(WebDriverBy::className('wpcf7-form'));

            if (count($elements) > 0) {

                $linksArray[$key]['parser'] = 'CFLeadsForm';

                $linksArray[$key]['result'] = call_user_func_array($linksArray[$key]['parser'], $parameters);

            }
//            if (count($elements_2) > 0) {
//
//                $linksArray[$key]['parser'] = 'WPcf7Form';
//
//                $linksArray[$key]['result'] = call_user_func_array($linksArray[$key]['parser'], $parameters);
//
//            }
            else {

                print_r("Element with class name not found.\n");
            }
        } else {

            $linksArray[$key]['result'] = call_user_func_array($linkInfo['parser'], $parameters);
        }
    } catch (Throwable $e) {

        print_r("Error: " . $e->getMessage() . "\n");
    }
}

writeLinksToFile('links.txt', $linksArray);

$test->tearDown();
