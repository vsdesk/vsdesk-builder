<?php

use yii\helpers\Html;
use yii\bootstrap5\Modal;
use yii\gii\generators\model\Generator;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $schema vsdesk\models\Schema */
/* @var $form yii\widgets\ActiveForm */

?>

<?php Modal::begin([
    'id' => 'generate-modal',
    'options' => ['class' => 'modal fade', 'data-backdrop' => 'static'],
    'title' =>  '<h4>Terminal</h4>',
    'toggleButton' => $schema->readyToGenerate() ? 
    	['label' => '<span class="fui-play"></span> СГЕНЕРИРОВАТЬ', 'class' => 'btn btn-inverse mt20 mb20'] :
    	['label' => '<span class="fui-play"></span> СГЕНЕРИРОВАТЬ', 'class' => 'btn btn-inverse mt20 mb20', 'disabled' => true, 'data-toggle'=> 'tooltip', 'title' => 'Either there is no created entities or there is an entity without any attribute'],
]); ?>

<p class="jumbotron alert alert-danger text-center">
	Нажимая кнопку <strong>СГЕНЕРИРОВАТЬ</strong> вы подтверджате что <strong class="text-uppercase">уничтожаете</strong> вашу <strong class="text-uppercase">базу данных</strong> и большинство <strong class="text-uppercase">ваших рабочих файлов</strong>. Расширение предназначено для новых билдов. Используйте с осторожностью!
	<a href="#" onclick="$('#commands').toggle()">Кликните сюда чтобы увидеть список применяемых команд.</a>
</p>

<pre id="commands" style="display:none">
	<ol>
		<?php foreach ($schema->consoleCommands as $cmd) {
			echo '<li>' . $cmd . '</li>';
		} ?>	
	</ol>
</pre>

<div class="text-center">
	<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
	<button 
		id="generateBtn"
		type="button" 
		class="btn btn-inverse" 
		<?php if ($schema->readyToGenerate() === false) echo 'disabled="" data-toggle="tooltip" title="Either there is no created entities or there is an entity without any attribute"'; ?> 
		data-cmd-path="<?= Url::to(['default/get-commands', 'id' => $schema->id], true) ?>"
		data-console-path="<?= Url::to(['default/std'], true) ?>"
	><span class="fui-play"></span> СГЕНЕРИРОВАТЬ</button>
</div>


<pre id="console" class="terminal palette palette-midnight-blue" style="display:none"></pre>

<?php Modal::end(); ?>


