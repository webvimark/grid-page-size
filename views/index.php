<?php
/**
 * @var View $this
 */
?>
<?php
use yii\helpers\Html;
use yii\web\View;

?>
<div class="form-inline pull-right" style="margin-top: -5px">
	<?= $this->context->text ?>
	<?= Html::dropDownList(
		'grid-page-size', \Yii::$app->request->cookies->getValue('_grid_page_size', 20),
		$this->context->dropDownOptions,
		['class'=>'form-control input-sm']
	) ?>
</div>