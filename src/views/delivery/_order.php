<?php
use yii\helpers\Html;

/** @var array $model */
?>

<tr>
    <th scope="row"><input class="form-check-input" type="checkbox" value="<?= $model['weight'] ?>" id="checkbox-id-<?= $model['id'] ?>"></th>
    <td><?= Html::encode($model['name']) ?></td>
    <td><?= $model['weight'] ?></td>
</tr>