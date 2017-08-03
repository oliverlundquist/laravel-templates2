<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    /**
     * The Request implementation holder.
     *
     * @var Illuminate\Http\Request|Mockery
     */
    protected $request;

    /**
     * Create new instances for dependencies.
     *
     * @param  Mockery|null $request
     * @return void
     */
    public function __construct($request = null)
    {
        $this->request = $request ?: app('request');
    }

    /**
     * Generate a new widget.
     *
     * @return Response
     */
    public function generate()
    {
        $instance  = str_random(8);
        $widget    = $this->request->input('widget');
        $version   = $this->request->input('version');
        $styles    = (bool) $this->request->input('styles');
        $settings  = (object) $this->request->input('settings', $default = []);
        $template  = (string) view('widgets.' . $widget . '-' . $version, compact('instance', 'widget', 'version', 'styles', 'settings'));

        return [
            'widget'   => $widget,
            'version'  => $version,
            'instance' => $instance,
            'content'  => $template,
            'settings' => $settings
        ];
    }
}
