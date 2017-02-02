<?php

namespace App;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Cache\Repository as Cache;

class Documentation
{
    /**
     * The filesystem implementation.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The cache implementation.
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Create a new documentation instance.
     *
     * @param  Filesystem  $files
     * @param  Cache  $cache
     * @return void
     */
    public function __construct(Filesystem $files, Cache $cache)
    {
        $this->files = $files;
        $this->cache = $cache;
    }

    /**
     * Get the documentation index page.
     *
     * @param  string  $version
     * @return string
     */
    public function getIndex($language, $version)
    {
        return $this->cache->remember('docs.'.$language.'.'.$version.'.index', 5, function () use ($language, $version) {
            $path = base_path('resources/docs/'.$language.'/'.$version.'/documentation.md');

            if ($this->files->exists($path)) {
                return $this->replaceLinks($language, $version, markdown($this->files->get($path)));
            }

            return null;
        });
    }

    /**
     * Get the given documentation page.
     *
     * @param  string  $version
     * @param  string  $page
     * @return string
     */
    public function get($language, $version, $page)
    {
        return $this->cache->remember('docs.'.$language.'.'.$version.'.'.$page, 5, function () use ($language, $version, $page) {
            $path = base_path('resources/docs/'.$language.'/'.$version.'/'.$page.'.md');

            if ($this->files->exists($path)) {
                return $this->replaceLinks($language, $version, markdown($this->files->get($path)));
            }

            return null;
        });
    }

    /**
     * Replace the version place-holder in links.
     *
     * @param  string  $version
     * @param  string  $content
     * @return string
     */
    public static function replaceLinks($language, $version, $content)
    {
        $content = str_replace('{{version}}', $version, $content);
        return str_replace('{{language}}', $language, $content);
    }

    /**
     * Check if the given section exists.
     *
     * @param  string  $version
     * @param  string  $page
     * @return boolean
     */
    public function sectionExists($language, $version, $page)
    {
        return $this->files->exists(
            base_path('resources/docs/'.$language.'/'.$version.'/'.$page.'.md')
        );
    }

    /**
     * Get the publicly available versions of the documentation
     *
     * @return array
     */
    public static function getDocVersions()
    {
        return [
            // 'master' => 'Master',
            '5.4' => '5.4',
            '5.3' => '5.3',
            '5.2' => '5.2',
            '5.1' => '5.1',
            // '5.0' => '5.0',
            // '4.2' => '4.2',
        ];
    }

    /**
     * Get the publicly available languages of the documentation
     *
     * @return array
     */
    public static function getDocLanguages()
    {
        return [
            'en', 'zh'
        ];
    }
}
