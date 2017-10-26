<?php

/**
 * Set the default documentation version...
 */
define('DEFAULT_VERSION', '5.5');
define('DEFAULT_LANGUAGE', 'zh');

/**
 * Convert some text to Markdown...
 */
function markdown($text)
{
    return (new ParsedownExtra)->text($text);
}

// Route::get('/', function () {
    // return view('marketing')->with(['currentVersion' => DEFAULT_VERSION]);
// });

Route::get('/', 'DocsController@showRootPage');
Route::get('{language}/{version}/{page?}', 'DocsController@show');
