<?php
namespace webvimark\extensions\GridPageSize;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Url;

class GridPageSize extends Widget
{
    /**
	 * @var string
	 */
    public $pjaxId;

    /**
	 * Default - Url::to(['grid-page-size'])
	 *
	 * @var string
	 */
    public $url;

    /**
	 * @var array
	 */
    public $dropDownOptions;

    /**
	 * @var string
	 */
    public $text = 'Записей на странице';

    /**
	 * @throws \yii\base\InvalidConfigException
	 * @return string
	 */
    public function run()
    {
        if (! $this->pjaxId) {
            throw new InvalidConfigException('Missing pjaxId param');
        }

        $this->setDefaultOptions();

        $this->view->registerJs($this->js());

        return $this->render('index');
    }

    /**
	 * Set default options
	 */
    protected function setDefaultOptions()
    {
        if (! $this->dropDownOptions) {
            $this->dropDownOptions = [5=>5, 10=>10, 20=>20, 50=>50, 100=>100, 200=>200];
        }

        if (! $this->url) {
            $this->url = Url::to(['grid-page-size']);
        }
    }

    /**
	 * @return string
	 */
    protected function js()
    {
        $pjaxId = '#' . ltrim($this->pjaxId, '#');

        $js = <<<JS
			$(document).on('change', '[name="grid-page-size"]', function () {
				var _t = $(this);
				$.post('$this->url', { 'grid-page-size': _t.val() })
					.done(function () {
						$.pjax.reload({container: '$pjaxId'})
					});
			});
JS;

        return $js;

    }
}
