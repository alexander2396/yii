<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Companies;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\models\Branches */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branches-form">

    <?php $form = ActiveForm::begin(['id'=>$model->formName()]); ?>
    
    <?= $form->field($model, 'company_id')->widget(Select2::classname(), [
            'data' => ArrayHelper::map(Companies::find()->all(), 'id', 'title'),
            'language' => 'en',
            'options' => ['placeholder' => 'Select a state ...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]);
    ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive', ], ['prompt' => 'Status']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    
</div>

<?php
$script = <<< JS
    $('form#{$model->formName()}').on('beforeSubmit', function(e)
    {
        var \$form = $(this);
        $.post(
            \$form.attr("action"), //serialize Yii2 form
            \$form.serialize()
        )
            .done(function(result) {
            if(result == 1) {
                $(\$form).trigger("reset");
                $(document).find('#secondmodal').modal('hide');
                $.pjax.reload({container:'#branchesGrid'});
            } else {
                $("#message").html(result);
            }
            }).fail(function()
            {
                console.log("server error");
            });
        return false;
    });           
JS;
$this->registerJs($script);
?>
