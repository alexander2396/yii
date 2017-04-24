<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Companies;
use backend\models\Branches;

/* @var $this yii\web\View */
/* @var $model backend\models\Departments */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="departments-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_id')->dropDownList(
            ArrayHelper::map( Companies::find()->all(), 'id', 'title' ),
            [
                'prompt' => 'Select Company',
                'onchange' => '
                    $.post( "/backend/web/branches/lists?id='.'"+$(this).val(), function ( data ){
                        $( "select#departments-branch_id" ).html( data );
                    });
                '     
            ]) ?>

    <?= $form->field($model, 'branch_id')->dropDownList(
            ArrayHelper::map( Branches::find()->all(), 'id', 'title' ),
            [
                'prompt' => 'Select Branch'   
            ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
