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
    <div class="admin box">
        <div class="row">
        <div class="large-10 column"><h2>View Family</h2></div>
        <div class="large-2 column right">
            <?php if( $this->checkAccess('TaskEditPedigreeData') ): ?>
                <a href="/Genetics/pedigree/edit/<?php echo $model->id; ?>" class="button small right" id="pedigree_edit">Edit</a>
            <?php endif; ?>
        </div>
    </div>
        
        <?php $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'htmlOptions' => array('class'=>'detailview'),
        'attributes'=>array(
            'id',
            'inheritance.name',
            'comments',
            'disorder',
            array(
                'label' => $model->getAttributeLabel('consanguinity'),
                'value' => $model->consanguinity ? 'yes' : 'no',
            ),
            array(
                'label' => $model->getAttributeLabel('gene.name'),
                'type' => 'raw',
                'value' => function () use ($model){
                    if($model->gene){
                     return '<a href="/Genetics/gene/view/' . $model->gene->id . '" >' . $model->gene->name . '</a>';
                    }
                }
            ),
            'base_change_type',
            array(
                'label' => $model->getAttributeLabel('base_change'),
                'value' => $model->base_change ? $model->base_change : '<span class="null">Not set</span>',
                'type'=>'raw',
            ),
            'amino_acid_change_id',
            array(
                'label' => $model->getAttributeLabel('amino_acid_change'),
                'value' => $model->amino_acid_change ? $model->amino_acid_change : '<span class="null">Not set</span>',
                'type' => 'raw',
            ),
            array(
                'label' => $model->getAttributeLabel('genomic_coordinate'),
                'type' => 'raw',
                'value' => $model->genomic_coordinate ? $model->genomic_coordinate : '<span class="null">Not set</span>',
            ),
            array(
                'label' => $model->getAttributeLabel('genome_version'),
                'type' => 'raw',
                'value' => $model->genome_version ? $model->genome_version : '<span class="null">Not set</span>',
            ),
            array(
                'label' => $model->getAttributeLabel('gene_transcript'),
                'type' => 'raw',
                'value' => $model->gene_transcript ? $model->gene_transcript : '<span class="null">Not set</span>',
            ),
            array(
                'label' => $model->getAttributeLabel('created_date'),
                'type' => 'raw',
                'value' => function() use ($model){
                    $date = new DateTime($model->created_date);
                    return $date->format('d M Y');
                }
            ),
            array(
                'label' => 'Subjects',
                'type' => 'raw',
                'value' => function() use ($model){

                    $html = '<ul class="subjects_list">';
                    foreach($model->subjects as $subject){
                        $html .= '<li>';
                        $html .= '<a href="/Genetics/subject/view/' . $subject->id . '" title="' . $subject->patient->fullName . '">';
                        $html .= $subject->patient->fullName . '</a>';
                        $html .= '<span class="status"><i>(Status: ' . $subject->statusForPedigree($model->id) . ')</i></span>';
                        $html .= '</li>';
                    }
                    $html .= '</ul>';
                    return $html;

                }
            )
    ),
)); ?>
    </div>