<?php declare(strict_types=1);

namespace App;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model
{
    /**
     * Table definition variable.
     *
     * @var string
     */
    protected $table = 'templates';

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
        'scripts'  => '{"header":"","footer":""}',
        'settings' => '{}'
    ];

    /**
     * Get scripts attribute from model.
     *
     * @param  string  $value
     * @return string
     */
    public function getScriptsAttribute($value)
    {
        return is_string($value) ? json_decode($value) : $value;
    }

    /**
     * Get settings attribute from model.
     *
     * @param  string  $value
     * @return string
     */
    public function getSettingsAttribute($value)
    {
        return is_string($value) ? json_decode($value) : $value;
    }

    /**
     * Eloquent relationship with TemplatePages model
     *
     * @return App\TemplatePages
     */
    public function pages()
    {
        return $this->hasMany('App\TemplatePages');
    }
}
