<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */
$usedOverallPeriods = array();
if (isset($element->clinic_interval_id)) {
    $usedOverallPeriods[] = $element->clinic_interval_id;
}
if (isset($element->photo_id)) {
    $usedOverallPeriods[] = $element->photo_id;
}
if (isset($element->oct_id)) {
    $usedOverallPeriods[] = $element->oct_id;
}
if (isset($element->hfa_id)) {
    $usedOverallPeriods[] = $element->hfa_id;
}
if (isset($element->hrt_id)) {
    $usedOverallPeriods[] = $element->hrt_id;
}

$overallPeriods = CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_OverallPeriod::model()
    ->activeOrPk($usedOverallPeriods)->findAll(
    array('order' => 'display_order asc')), 'id', 'name'
);

$intervalVisits = CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_VisitInterval::model()
    ->activeOrPk(@$element->gonio_id)
    ->findAll(array('order' => 'display_order asc')), 'id', 'name'
);

$usedTargetIOPS = array();
if (isset($element->right_target_iop_id)) {
    $usedTargetIOPS[] = $element->right_target_iop_id;
}
if (isset($element->left_target_iop_id)) {
    $usedTargetIOPS[] = $element->left_target_iop_id;
}

$targetIOPS =
    CHtml::listData(\OEModule\OphCiExamination\models\OphCiExamination_TargetIop::model()
        ->activeOrPk($usedTargetIOPS)->findAll(array('order' => 'display_order asc')), 'id', 'name');

?>

<div class="element-fields full-width">
	<?php echo $form->hiddenInput($element, 'eye_id', false, array('class' => 'sideField')); ?>

  <table class="cols-8 element-fields">
    <tbody class="cols-full element-fields">
      <tr>
        <td><?= $form->dropDownList($element, 'clinic_interval_id', $overallPeriods, array(), false, array('label' => 4, 'field' => 3))?></td>
        <td><?= $form->dropDownList($element, 'photo_id', $overallPeriods, array(), false, array('label' => 4, 'field' => 3))?></td>
        <td><?= $form->dropDownList($element, 'oct_id', $overallPeriods, array(), false, array('label' => 4, 'field' => 3))?></td>
      </tr>
      <tr>
        <td><?= $form->dropDownList($element, 'hfa_id', $overallPeriods, array(), false, array('label' => 4, 'field' => 3))?></td>
        <td><?= $form->dropDownList($element, 'gonio_id', $intervalVisits, array(), false, array('label' => 4, 'field' => 3))?></td>
        <td><?= $form->dropDownList($element, 'hrt_id', $overallPeriods, array(), false, array('label' => 4, 'field' => 3))?></td>
      </tr>
    </tbody>
  </table>
  <div class="cols-8">
    <?php echo $form->textArea($element, 'comments', array('nowrapper' => true), false, array('rows' => 1, 'placeholder' => 'Comments'), array('field' => 12))?>
  </div>
</div>
<div class="element-fields element-eyes">
<?php foreach(['left' => 'right', 'right' => 'left'] as $side => $eye):
    $hasEyeFunc = 'has'.ucfirst($eye);
    ?>
  <div class="element-eye <?=$eye?>-eye column <?=$side?> side <?= !$element->$hasEyeFunc() ? "inactive" : ""?>" data-side="<?=$eye?>">
    <div class="active-form">
      <a class="remove-side"><i class="oe-i remove-circle small"></i></a>
      <div class="row field-row">
        <div class="large-3 column">
          <label for="<?= CHtml::modelName($element).'['.$eye.'_target_iop_id]' ?>">
            Target IOP:
          </label>
          <?= $form->dropDownList($element, $eye.'_target_iop_id', $targetIOPS, array('nowrapper' => true, 'empty' => '- Select -')) ?>
          mmHg
        </div>
      </div>
    </div>
    <div class="inactive-form side" style="<?= $element->$hasEyeFunc() ? "display: none" : ""?>">
      <div class="add-side">
        <a href="#">
          Add <?=$eye?> eye <span class="icon-add-side"></span>
        </a>
      </div>
    </div>
  </div>
  <?php endforeach; ?>

<script type="text/javascript">
	if (typeof setCurrentManagementIOP == 'function') {
		setCurrentManagementIOP('left');
		setCurrentManagementIOP('right');
	}
</script>
<?php
    Yii::app()->clientScript->registerScriptFile("{$this->assetPath}/js/OverallManagement.js", CClientScript::POS_HEAD);
?>

