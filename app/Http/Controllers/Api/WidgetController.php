<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Widgets\Widget;
use Illuminate\Http\Request;
use stdClass;

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
        $this->validate($this->request, [
            'widget'          => 'required|array|filled',
            'widget.name'     => 'required|string',
            'widget.version'  => 'required|string',
            'widget.instance' => 'string|max:8',
            'widget.styles'   => 'string',
            'widget.scripts'  => 'string',
            'widget.content'  => 'string',
            'widget.settings' => 'array'
        ]);

        $data = $this->request->input('widget', $default = []);

        return Widget::getWidget($data)->fill($data);
    }
}
