<?php

use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Modal;

/* @var $this yii\web\View */
/* @var $model vsdesk\models\Entity */
/* @var $form yii\widgets\ActiveForm */
?>

<span class="entity-form">

    <?php $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => ['data-type'=>'ajax', 'style' => ['display' => 'inherit']],
        'action' => $model->isNewRecord ? ['create-entity'] : ['update-entity', 'id' => $model->id],
        'enableAjaxValidation' => true
    ]); ?>

    <?php
    Modal::begin([
        'id' => 'entity-' . ($model->isNewRecord ? 'new' : $model->id),
        'size' => modal::SIZE_LARGE,
        'options' => ['data-backdrop' => 'false', 'data-dismiss' => 'modal' ],
        'title' =>  $model->isNewRecord ? 
            '<h6 class="text-center">Создать и добавить новую сущность к схеме '.$model->schema->name.'</h6>' : '<h6 class="text-center">Редактировать сущность '.$model->name.'</h6>',
        'toggleButton' => $model->isNewRecord ? 
            ['label' => '<span class="fui-plus"></span> ДОБАВИТЬ', 'class' => 'btn btn-primary pull-right'] :
            ['label' => '<span class="fui-new"></span> ИЗМЕНИТЬ', 'class' => 'btn btn-info'] ,
        'footer' => 
            Html::resetButton('Reset', ['class' => 'btn btn-default']) .
            Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-info'])
    ]);
    ?>

    <?= $form->field($model, 'schema_id')->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <?= Html::hiddenInput('reload-pjax', 'entity-form', ['disabled' => true, 'data-close-modal' => 'true']); ?>
    <?= Html::hiddenInput('reload-pjax', 'entity-list', ['disabled' => true]); ?>
    <?= Html::hiddenInput('reload-pjax', 'entity-info', ['disabled' => true]); ?>
    <?= Html::hiddenInput('reload-pjax', 'entity-title', ['disabled' => true]); ?>
    <?= Html::hiddenInput('reload-pjax', 'breadcrumbs', ['disabled' => true]); ?>

    <?php Modal::end(); ActiveForm::end(); ?>

</span>
