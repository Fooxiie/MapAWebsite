<?php

namespace App\Utils;

use DOMDocument;
use Exception;
use GuzzleHttp\Client;

class AppAnalyser
{
    private $httpClient;
    private mixed $url;
    private int $maxDepth;

    private array $externalDependencies = [];

    public function __construct($url)
    {
        $this->url = $url;
        $this->maxDepth = 2;
        $this->httpClient = new Client([
            'verify' => 'C:\Users\Fooxiie\PhpstormProjects\MapAWebsite\resources\certificate\cacert.pem',
        ]);
    }

    public function start_analyse()
    {
        $this->externalDependencies = $this->analyse($this->url);
    }

    private function analyse($urlToScan, $depth = 0)
    {
        try {
            $response = $this->httpClient->get($urlToScan);
            if ($response->getStatusCode() === 200) {
                $html = (string)$response->getBody();

                return $this->analyseHTML($html, $depth);
            } else {
                return [];
            }
        } catch (Exception $e) {
            return [];
        }
    }

    public function analyseHTML(string $html, $depth) {
        $dom = new DOMDocument();
        @$dom->loadHTML($html);

        $deps = [];
        $tags = ['link' => 'href', 'script' => 'src', 'img' => 'src', 'iframe' => 'src'];
        foreach ($tags as $tag => $tagName) {
            $elements = $dom->getElementsByTagName($tag);
            foreach ($elements as $element) {
                $depUrl = $element->getAttribute($tagName);
                if ($this->is_valid_dep_url($depUrl)) {
                    $hostname = parse_url($depUrl, PHP_URL_HOST);
                    $newDep = [
                        'hostname' => $hostname,
                    ];
                    if (!in_array($newDep, $deps)) {
                        if ($depth == 0) {
                            $deps[$newDep['hostname']] = $this->analyse($newDep['hostname'], 1);
                        } else {
                            $deps[] = $newDep;
                        }
                    }
                }
            }
        }
        return $deps;
    }

    private function is_valid_dep_url($url): bool
    {
        return !empty($url) &&
            filter_var($url, FILTER_VALIDATE_URL) !== false &&
            parse_url($this->url, PHP_URL_HOST) != parse_url($url, PHP_URL_HOST);
    }

    /**
     * @return array
     */
    public function getExternalDependencies(): array
    {
        return $this->externalDependencies;
    }
}


