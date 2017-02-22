<?php

require_once "src/Upload/FindingsUploader.php";
require_once "src/Upload/MetadataUploader.php";
require_once "src/MuBench/Detector.php";
require_once "DatabaseTestCase.php";

use MuBench\Detector;

class StoreDetectorTest extends DatabaseTestCase
{

    function test_create_detector()
    {
        $uploader = new FindingsUploader($this->db, $this->logger);

        $data = json_decode(
            <<<EOD
    {
        "detector": "-d-",
        "project": "-p-",
        "version": "-v-",
        "misuse": "-m-",
        "result": "failure",
        "runtime": 30.1,
        "number_of_findings": 0,
        "potential_hits": []
    }
EOD
        );

        $uploader->processData("ex1", $data, $data->{'potential_hits'});
        $actual_detector = $this->db->getDetector("-d-");
        $expected_detector = new Detector("-d-", 1);

        self::assertEquals($expected_detector, $actual_detector);
    }

}
