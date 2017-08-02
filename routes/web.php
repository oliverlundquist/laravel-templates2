<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Http\Request;
use App\Templates;
use App\TemplatePages;

Route::get('/', function (Request $request) {
    if (($templatePreviewId = $request->input('preview_template_id')) !== null) {
        return view('index', ['contents' => (new Templates)->where('id', $templatePreviewId)->first()->pages()->where('page', 'index')->value('contents')]);
    }
    return view('index', ['contents' => (new Templates)->where('active', 1)->first()->pages()->where('page', 'index')->value('contents')]);
});
Route::get('csrf', function () { return csrf_token(); });

Route::namespace('Admin')->prefix('admin')->group(function () {
    Route::get('templates', function () { return view('admin.templates_index'); });
    Route::get('templates/{id}', function ($id) { return view('admin.templates_edit', ['templateId' => $id]); });
});
