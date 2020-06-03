<?php

namespace Arbify\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;

class FilterToDomElement
{
    private const HEADER = 'X-DOM-FILTER';

    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var Response $response */
        $response = $next($request);

        if (!$request->hasHeader(self::HEADER)) {
            return $response;
        }

        $selector = $request->header(self::HEADER);
        $crawler = new Crawler($response->getContent());

        $response->setContent(
            $crawler->filter($selector)->outerHtml()
        );

        app('debugbar')->disable();

        return $response;
    }
}
