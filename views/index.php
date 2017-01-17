<?php
/**
 * @var View $this
 */
?>
<?php
use webvimark\extensions\GridPageSize\GridPageSize;
use yii\helpers\Html;
use yii\web\View;

$context = $this->context;
?>
<div class="form-inline pull-right">
	<?php if ( $context->enableClearFilters ): ?>
		<span id="<?= ltrim($context->gridId, '#') ?>-clear-filters-btn"
			  class="btn btn-sm btn-default <?= $context->clearFilterDisabledClass; ?>">
			<?= GridPageSize::t('app', 'Clear filters') ?>
		</span>
	<?php endif; ?>
	<?= $context->text ?>
	<?= Html::dropDownList(
		'grid-page-size', \Yii::$app->request->cookies->getValue('_grid_page_size', 20),
		$this->context->dropDownOptions,
		['class'=>'form-control input-sm']
	) ?>
</div>