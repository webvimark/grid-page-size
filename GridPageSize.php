<?php
namespace webvimark\extensions\GridPageSize;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Url;
use Yii;

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
	 * Text "Records per page"
	 *
	 * @var string
	 */
	public $text;

	/**
	 * Multilingual support
	 */
	public function init()
	{
		parent::init();
		$this->registerTranslations();

		$this->text = $this->text ? $this->text : GridPageSize::t('app', 'Records per page');
	}

	/**
	 * Multilingual support
	 */
	public function registerTranslations()
	{
		$i18n = Yii::$app->i18n;
		$i18n->translations['widgets/GridPageSize/*'] = [
			'class' => 'yii\i18n\PhpMessageSource',
			'sourceLanguage' => 'en-US',
			'basePath' => __DIR__ . '/messages',
			'fileMap' => [
				'widgets/GridPageSize/app' => 'app.php',
			],
		];
	}

	/**
	 * @param string $category
	 * @param string $message
	 * @param array  $params
	 * @param null   $language
	 *
	 * @return string
	 */
	public static function t($category, $message, $params = [], $language = null)
	{
		return Yii::t('widgets/GridPageSize/' . $category, $message, $params, $language);
	}

	/**
	 * @throws \yii\base\InvalidConfigException
	 * @return string
	 */
	public function run()
	{
		if ( ! $this->pjaxId )
		{
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
		if ( ! $this->dropDownOptions )
		{
			$this->dropDownOptions = [5=>5, 10=>10, 20=>20, 50=>50, 100=>100, 200=>200];
		}

		if ( ! $this->url )
		{
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
			$(document).off('change', '[name="grid-page-size"]').on('change', '[name="grid-page-size"]', function () {
				var _t = $(this);
				$.post('$this->url', { 'grid-page-size': _t.val() })
					.done(function(){
						$.pjax.reload({container: '$pjaxId'})
					});
			});
JS;

		return $js;

	}
} 
