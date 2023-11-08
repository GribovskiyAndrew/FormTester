<?php

function readLinksFromFile($filename) {
    $linksArray = array();

    $file = fopen($filename, 'r');

    if ($file) {
        while (($line = fgets($file)) !== false) {
            $parts = explode(',', $line);

            $link = trim($parts[0]);
            $parser = isset($parts[1]) ? trim($parts[1]) : '';
            $result = isset($parts[2]) ? trim($parts[2]) : '';

            $linkInfo = array(
                'link' => $link,
                'parser' => $parser,
                'result' => $result
            );

            $linksArray[] = $linkInfo;
        }

        fclose($file);
    } else {
        print_r("Failed to open the file.\n");
    }

    return $linksArray;
}

function writeLinksToFile($filename, $linksArray) {
    $file = fopen($filename, 'w');

    if ($file) {
        foreach ($linksArray as $linkInfo) {
            $line = $linkInfo['link'];

            if (!empty($linkInfo['parser'])) {
                $line .= ', ' . $linkInfo['parser'];
            }

            if (!empty($linkInfo['result'])) {
                $line .= ', ' . $linkInfo['result'];
            }

            $line .= PHP_EOL;

            fwrite($file, $line);
        }

        fclose($file);
        print_r("Data written to" . $filename . "\n");
    } else {
        print_r("Failed to open the file for writing.\n");
    }
}

