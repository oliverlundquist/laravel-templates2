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
        'logo'        => '/images/default-logo.png',
        'borderColor' => ['name' => 'aliceblue', 'code' => 'F0F8FF'],
        'headline'    => 'Webshop',
        'kicker'      => 'An attention grabbing kicker'
    ];
}
