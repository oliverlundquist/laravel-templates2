<?php declare(strict_types=1);

namespace App\Widgets;

use Illuminate\Http\Request;

abstract class Widget
{
    /**
	 * Get instance of the given widget.
	 *
	 * @param  array $data
     * @return mixed
	 */
	public static function getWidget(array $data)
    {
        $className = '\App\Widgets\\' . ucfirst(camel_case($data['name'])) . 'V' . $data['version'];

        return new $className;
    }

    /**
	 * Fill the instance properties with given data.
	 *
	 * @param  array $data
     * @return mixed
	 */
	public function fill(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        return $this;
    }

    /**
	 * Get the instance property.
	 *
	 * @return mixed
	 */
    public function __get($key) {
        return $this->getData()[$key] ?? null;
    }

    /**
	 * Get the instance as a string.
	 *
	 * @return array
	 */
	public function getData(): array
    {
        return [
            'name'     => $this->name,
            'version'  => $this->version,
            'instance' => $this->instance = $this->instance ?? str_random(8),
            'styles'   => $this->styles ?? '',
            'scripts'  => $this->scripts ?? '',
            'content'  => $this->content ?? '',
            'settings' => array_replace($this->defaultSettings, $this->settings ?? []),
        ];
    }

    /**
	 * Get the instance as a string.
	 *
	 * @return string
	 */
	public function __toString()
    {
        $data = $this->getData();
        $templatePath = 'widgets.' . $data['name'] . '-' . $data['version'];
        $templateData = ['widget' => json_decode(json_encode($this->getData()))];

        return json_encode(['widget' => array_replace_recursive($data, [
            'styles'  => (string) view($templatePath . '.styles', $templateData),
            'content' => (string) view($templatePath . '.template', $templateData),
            'scripts' => (string) view($templatePath . '.scripts',  $templateData),
        ])]);
    }
}
