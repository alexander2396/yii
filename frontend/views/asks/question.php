<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Asks */

$this->title = 'Задать вопрос';
?>

<div class="asks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'question')->textInput(['maxlength' => true, 'value' => $question]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Спросить' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    <p class="lead"><?= $answer ?></p>

</div>
