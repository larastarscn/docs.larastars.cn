<?php

namespace App\Http\Controllers;

use App\Documentation;
use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class DocsController extends Controller
{
    /**
     * The documentation repository.
     *
     * @var Documentation
     */
    protected $docs;

    /**
     * Create a new controller instance.
     *
     * @param  Documentation  $docs
     * @return void
     */
    public function __construct(Documentation $docs)
    {
        $this->docs = $docs;
    }

    /**
     * Show the root documentation page (/docs).
     *
     * @return Response
     */
    public function showRootPage(Request $request)
    {
        $language = $request->cookie('language', DEFAULT_LANGUAGE);
        $version = $request->cookie('version', DEFAULT_VERSION);
        return redirect('/'.$language.'/'.$version);
    }

    /**
     * Show a documentation page.
     *
     * @param  string $version
     * @param  string|null $page
     * @return Response
     */
    public function show($language, $version, $page = null)
    {
        if (! $this->isLanguage($language)) {
            return redirect(DEFAULT_LANGUAGE.'/'.DEFAULT_VERSION.'/'.$version, 301);
        }
        if (! $this->isVersion($version)) {
            return redirect($language.'/'.DEFAULT_VERSION.'/'.$version, 301);
        }

        if (! defined('CURRENT_VERSION')) {
            define('CURRENT_VERSION', $version);
        }

        $sectionPage = $page ?: 'installation';
        $content = $this->docs->get($language, $version, $sectionPage);

        if (is_null($content) && $language === 'zh') {
            $language = 'en';
            $content = $this->docs->get($language, $version, $sectionPage);
        }

        if (is_null($content)) {
            abort(404);
        }

        $crawler = new Crawler();
        $crawler->addHtmlContent($content);
        $title = $crawler->filterXPath('//h1');

        $section = '';

        if ($this->docs->sectionExists($language, $version, $page)) {
            $section .= '/'.$page;
        } elseif (! is_null($page)) {
            return redirect('/'.$language.'/'.$version);
        }

        $canonical = null;

        if ($this->docs->sectionExists($language, DEFAULT_VERSION, $sectionPage)) {
            $canonical = $language.'/'.DEFAULT_VERSION.'/'.$sectionPage;
        }

        $data = [
            'title' => count($title) ? $title->text() : null,
            'index' => $this->docs->getIndex($language, $version),
            'content' => $content,
            'currentVersion' => $version,
            'versions' => Documentation::getDocVersions(),
            'currentSection' => $section,
            'canonical' => $canonical,
            'language' => $language
        ];

        if ($this->shouldSendCookie($language, $version)) {
            return response()->view('docs', $data, 200)
                            ->cookie('language', $language, 60 * 24 * 90)
                            ->cookie('version', $version, 60 * 24 * 90);
        } 

        return  view('docs', $data);
    }

    protected function shouldSendCookie($language, $version)
    {
        return $language !== request()->cookie('language') || $version !== request()->cookie('version');
    }

    /**
     * Determine if the given URL segment is a valid version.
     *
     * @param  string  $version
     * @return bool
     */
    protected function isVersion($version)
    {
        return in_array($version, array_keys(Documentation::getDocVersions()));
    }

    /**
     * Determine if the given URL segment is a valid language
     *
     * @param  string  $language
     * @return bool
     */
    protected function isLanguage($language)
    {
        return in_array($language, array_keys(Documentation::getDocLanguages()));
    }
}
