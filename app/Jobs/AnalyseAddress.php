<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use GuzzleHttp\Client;

class AnalyseAddress implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $httpClient;

    /**
     * Create a new job instance.
     */
    public function __construct($paramAdr)
    {
        $this->targetAdr = $paramAdr;
        $this->maxDepth = 2;
        $this->httpClient = new Client();
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $externalDependencies = [];

        $fetchPage = function ($currentUrl) {
            try {
                $response = $this->httpClient->get($currentUrl);
                if ($response->getStatusCode() === 200) {
                    $html = (string) $response->getBody();
                    $dom = new DOMDocument();
                    @$dom->loadHTML($html);

                    $deps = [];
                    $tags = ['link', 'script', 'img', 'iframe', 'style'];
                    foreach ($tags as $tag) {
                        $elements = $dom->getElementsByTagName($tag);
                        foreach ($elements as $element) {
                            $depUrl = $element->getAttribute('src');
                            if (!empty($depUrl)) {
                                $hostname = parse_url($depUrl, PHP_URL_HOST);
                                $deps[] = [
                                    'hostname' => $hostname,
                                    'source' => $currentUrl,
                                ];
                            }
                        }
                    }

                    return $deps;
                }
            } catch (Exception $e) {
                echo "Error fetching $currentUrl: " . $e->getMessage();
            }
        };

        $maxDepth = $this->maxDepth;

        $crawlPage = function ($currentUrl, $depth) use (&$crawlPage,
            &$externalDependencies, $fetchPage, $maxDepth) {
            if ($depth > $maxDepth) {
                return;
            }

            $deps = $fetchPage($currentUrl);
            if ($deps) {
                $externalDependencies = array_merge($externalDependencies, $deps);
                foreach ($deps as $dep) {
                    $depUrl = urljoin($currentUrl, $dep['hostname']);
                    $crawlPage($depUrl, $depth + 1);
                }
            }
        };

        $crawlPage($this->targetAdr, 0);

        dd($externalDependencies);
    }
}
