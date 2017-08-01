<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class TemplatePages extends Model
{
    /**
     * Table definition variable.
     *
     * @var string
     */
    protected $table = 'template_pages';

    /**
     * Mass-assign guarded keys.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The model's attributes.
     *
     * @var array
     */
    protected $attributes = [
        'page' => 'index',
        'contents' => '{}'
    ];
}
