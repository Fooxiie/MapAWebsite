<?php

namespace Tests\Unit;

use App\Utils\AppAnalyser;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class AppAnalyserTest extends TestCase
{

    /**
     *  Test de la classe AppAnalyser qui analyse
     * @return void
     * @throws \PHPUnit\Framework\MockObject\Exception
     */
    public function testAnalyse()
    {
        $analyser = new AppAnalyser("http://exemple.com");

        $fakeHtml = '<html>
                        <head>
                            <link rel="stylesheet" type="text/css" href="https://fake-style-sheet.com/style.css">
                            <script src="https://fake-script.com/script.js"></script>
                        </head>
                        <body>
                            <img src="https://fake-image.com/image.jpg" alt="Fake Image">
                        </body>
                    </html>';
        $result = $analyser->analyseHTML($fakeHtml, 0);
        $this->assertIsArray($result);
        $this->assertArrayHasKey("fake-style-sheet.com", $result);
        $this->assertArrayHasKey("fake-script.com", $result);
        $this->assertArrayHasKey("fake-image.com", $result);
    }
}
