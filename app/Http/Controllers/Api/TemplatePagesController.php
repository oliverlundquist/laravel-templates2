<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\TemplatePages;

class TemplatePagesController extends Controller
{
    /**
     * The Request implementation holder.
     *
     * @var Illuminate\Http\Request|Mockery
     */
    protected $request;

    /**
     * The TemplatePages implementation holder.
     *
     * @var App\TemplatePages|Mockery
     */
    protected $templatePages;

    /**
     * Create new instances for dependencies.
     *
     * @param  Mockery|null $request
     * @param  Mockery|null $templatePages
     * @return void
     */
    public function __construct($request = null, $templatePages = null)
    {
        $this->request = $request ?: app('request');
        $this->templatePages = $templatePages ?: new TemplatePages;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int                     $id
     * @return Response
     */
    public function update($id)
    {
        $this->templatePages
                ->where('templates_id', $id)
                ->where('page', 'index')
                ->first()
                ->fill($this->request->all())
                ->save();

        return ['status' => 'ok!'];
    }
}
