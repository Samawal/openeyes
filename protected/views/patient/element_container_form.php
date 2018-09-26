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
?>
<?php
$section_classes = array('element full edit');
$section_classes[] = CHtml::modelName($element->elementType->class_name);
if ($this->isRequired($element)) {
    $section_classes[] = 'required';
}
if ($this->isHiddenInUI($element)) {
    $section_classes[] = 'hide';
}
if (is_subclass_of($element, 'SplitEventTypeElement')) {
    $section_classes[] = 'eye-divider';
}

$element_Type = $element->getElementType();
?>

<?php if (!preg_match('/\[\-(.*)\-\]/', $element->elementType->name)) { ?>
    <section
            class="<?php echo implode(' ', $section_classes); ?>"
            data-element-type-id="<?php echo $element->elementType->id ?>"
            data-element-type-class="<?php echo CHtml::modelName($element->elementType->class_name) ?>"
            data-element-type-name="<?php echo $element->elementType->name ?>"
            data-element-display-order="<?= $element->getChildDisplayOrder($this->action) ?>"
            data-element-parent-id="<?php
            if ($element->elementType->isChild()) {
                echo $element->elementType->parent_element_type_id;
            } ?>"
            data-element-parent-display-order="<?= $element->getParentDisplayOrder($this->action) ?>"
    >

        <?php if (!property_exists($element, 'hide_form_header') || !$element->hide_form_header) { ?>
            <header class="element-header">
                <!-- Add a element remove flag which is used when saving data -->
                <input type="hidden" name="<?php echo CHtml::modelName($element->elementType->class_name)?>[element_removed]" value="0">
                <!-- Element title -->
                <h3 class="element-title"><?php echo $element->getFormTitle() ?></h3>
            </header>
            <!-- Additional element title information -->
            <?php if (isset($this->clips['element-title-additional'])) { ?>
                <div class="element-title-additional">
                    <?php
                    $this->renderClip('element-title-additional');
                    // don't want the header clip to repeat in child elements
                    unset($this->clips['element-title-additional']);
                    ?>
                </div>
            <?php } ?>
            <!-- Element actions -->
            <div class="element-actions">
                <!-- order is important for layout because of Flex -->
                <?php if ($this->canViewPrevious($element) || $this->canCopy($element)) { ?>
                    <span class="js-duplicate-element">
            <i class="oe-i duplicate"></i>
          </span>
                <?php } ?>
                <!-- remove MUST be last element -->
                <span class="<?= ($this->isRequiredInUI($element)) ? 'disabled' : 'js-remove-element' ?>"
                      title="<?= ($this->isRequiredInUI($element)) ? 'Mandatory Field' : '' ?>">
                    <?php if(!isset($no_bin) || $no_bin == false) { ?>
                        <i class="oe-i trash-blue"></i>
                     <?php } ?>
          </span>
            </div>
        <?php } ?>

        <?php echo $content; ?>

    </section>
<?php } else { ?>
    <section
            class="<?php echo implode(' ', $section_classes); ?>"
            data-element-type-id="<?php echo $element->elementType->id ?>"
            data-element-type-class="<?php echo CHtml::modelName($element->elementType->class_name) ?>"
            data-element-type-name="<?php echo $element->elementType->name ?>"
            data-element-display-order="<?php echo $element->elementType->display_order ?>">

        <?php echo $content; ?>

    </section>
<?php } ?>