<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Templates;
use App\TemplatePages;

class TemplatesController extends Controller
{
    /**
     * The Templates implementation holder.
     *
     * @var App\Templates|Mockery
     */
    protected $templates;

    /**
     * The TemplatePages implementation holder.
     *
     * @var App\TemplatePages|Mockery
     */
    protected $templatePages;

    /**
     * Create new instances for dependencies.
     *
     * @param  Mockery|null $templates
     * @param  Mockery|null $templatePages
     * @return void
     */
    public function __construct($templates = null, $templatePages = null)
    {
        $this->templates     = $templates     ?: new Templates;
        $this->templatePages = $templatePages ?: new TemplatePages;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->templates->with('pages')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $this->templates->create([])->pages()->create([]);

        return ['status' => 'ok!'];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function activate($id)
    {
        $this->templates->where('active', 1)->update(['active' => 0]);
        $this->templates->where('id', $id)->update(['active' => 1]);

        return ['status' => 'ok!'];
    }
}
