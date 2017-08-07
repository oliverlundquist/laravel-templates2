<?php declare(strict_types=1);

namespace App\Widgets;

class HeaderV1 extends Widget
{
    /**
     * Default settings for this widget.
     *
     * @var array
     */
    protected $defaultSettings = [
        'color'           => ['name' => 'aliceblue', 'code' => 'F0F8FF'],
        'backgroundColor' => ['name' => 'antiquewhite', 'code' => 'FAEBD7']
    ];
}
