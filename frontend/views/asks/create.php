<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Asks */

$this->title = 'Create Asks';
$this->params['breadcrumbs'][] = ['label' => 'Asks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="asks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
