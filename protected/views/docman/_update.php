<?php
/**
 * OpenEyes.
 *
 * (C) Moorfields Eye Hospital NHS Foundation Trust, 2008-2011
 * (C) OpenEyes Foundation, 2011-2013
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (c) 2008-2011, Moorfields Eye Hospital NHS Foundation Trust
 * @copyright Copyright (c) 2011-2013, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/gpl-3.0.html The GNU General Public License V3.0
 */
?>
<style type='text/css'>
table { border:1px solid black; cell-spacing:0; cell-padding:0; }
td { border:1px solid black; border-collapse: 1; vertical-align:top; }
tr { background-color: #eee; color: black; padding:2px 5px; }
select.addr { width:200px !important; max-width:200px; }
div#docman_block select.macro { max-width:220px; }
table.docman tbody tr td img { vertical-align: text-top; height:13px; width:13px; }
table.docman > tbody > tr > td:first-child { width:200px; max-width:200px; }
button.docman { width:80px; background: none; font-size:13px; line-height:20px; height:20px; margin:5px 0; padding:0; text-align:center; }
button.red { background-color:red; color: white; }
button.green { background-color:green; color: white; }
</style>

    <?php echo CHtml::activeHiddenField($document_set, 'id') ?>
    <?php echo CHtml::activeHiddenField($document_set->document_instance[0], 'id') ?>
    <table id="dm_table" data-macro_id="<?php echo $macro_id; ?>">
        <tbody>
            <tr id="dm_0">
                <th>To/CC</th>
                <th>Recipient/Address</th>
                <th>Role</th>
                <th>Delivery Method(s)</th>
                <th> </th>
            </tr>
            
            <?php foreach($document_set->document_instance[0]->document_target as $row_index => $target):?>
            
                <?php 
                    if( Yii::app()->request->isPostRequest ){
                        $post_target = Yii::app()->request->getPost('DocumentTarget');

                        if( isset($post_target[$row_index]) ){
                            $target->attributes = $post_target[$row_index]['attributes'];
                        }
                    }
                ?>
                <tr class="rowindex-<?php echo $row_index ?>" data-rowindex="<?php echo $row_index ?>">
                    <td> 
                        <?php echo $target->ToCc; ?>
                        <?php echo CHtml::hiddenField("DocumentTarget[" . $row_index . "][attributes][id]", $target->id); ?>
                        <?php echo CHtml::hiddenField("DocumentTarget[" . $row_index . "][attributes][ToCc]", $target->ToCc); ?>
                    </td>
                    <td>
                        <?php $this->renderPartial('//docman/table/contact_name_address', array(
                                'contact_id' => $target->contact_id,
                                'contact_name' => $target->contact_name,
                                'address_targets' => $element->address_targets,
                                'target' => $target,
                                'contact_type' => $target->contact_type,
                                'row_index' => $row_index,
                                'address' => $target->address,
                                'is_editable' => $element->draft));
                        ?>
                    </td>
                    <td>
                        <?php if($element->draft): ?>
                            <?php $this->renderPartial('//docman/table/contact_type', array(
                                        'contact_type' => $target->contact_type,
                                        'row_index' => $row_index));
                            ?>
                        <?php else: ?>
                            <?php echo $target->contact_type != 'GP' ? (ucfirst(strtolower($target->contact_type))) : $target->contact_type; ?>
                            <?php if($target->contact_modified){ echo "<br>(Modified)";}?>
                            <?php echo  CHtml::hiddenField('DocumentTarget['.$row_index.'][attributes][contact_type]', $target->contact_type, array('data-rowindex' => $row_index)); ?>
                        <?php endif; ?>
                    </td>
                    <td class="docman_delivery_method">
                        <?php $this->renderPartial('//docman/table/delivery_methods', array(
                                        'is_draft' => $element->draft,
                                        'contact_type' => $target->contact_type,
                                        'target' => $target,
                                        'row_index' => $row_index));
                        ?>
                    </td>
                    <td>
                        <?php if($element->draft == "1"): ?>
                            <a class="remove_recipient removeItem" data-rowindex="<?php echo $row_index ?>">Remove</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr class="new_entry_row">
                <td colspan="6">
                    <button class="button small secondary" id="docman_add_new_recipient">Add new recipient</button>
                </td>
            </tr>
    </table>         
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            