<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\Asks */

$this->title = 'Ответьте на вопрос';
?>
<div class="asks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <p class="lead"><?= $model->question ?></p>
    
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'answer')->textInput(['maxlength' => true, 'value' => '']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Ответить' : 'Ответить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
    

</div>