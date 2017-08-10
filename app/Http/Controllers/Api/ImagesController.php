<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ImagesController extends Controller
{
    /**
     * The Request implementation holder.
     *
     * @var Illuminate\Http\Request|Mockery
     */
    protected $request;

    /**
     * The Storage implementation holder.
     *
     * @var Illuminate\Filesystem\FilesystemManager|Mockery
     */
    protected $storage;

    /**
     * Create new instances for dependencies.
     *
     * @param  Mockery|null $request
     * @param  Mockery|null $storage
     * @return void
     */
    public function __construct($request = null, $storage = null)
    {
        $this->request = $request ?: app('request');
        $this->storage = $storage ?: app('filesystem');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->storage->disk('uploads')->files($subfolder = '');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        sleep(rand(0,3));

        $file = $this->request->file('image');
        $name = $file->getClientOriginalName();
        $path = $this->storage->disk('uploads')->putFile($subfolder = '', $file);

        return [
            'status' => $file->getError() !== 0 ? 'error!' : 'ok!',
            'name'   => $name,
            'path'   => $path,
            'errors' => $file->getError()
        ];
    }
}
