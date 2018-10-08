<?php
/**
 * (C) OpenEyes Foundation, 2018
 * This file is part of OpenEyes.
 * OpenEyes is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 * OpenEyes is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.
 * You should have received a copy of the GNU Affero General Public License along with OpenEyes in a file titled COPYING. If not, see <http://www.gnu.org/licenses/>.
 *
 * @link http://www.openeyes.org.uk
 *
 * @author OpenEyes <info@openeyes.org.uk>
 * @copyright Copyright (C) 2017, OpenEyes Foundation
 * @license http://www.gnu.org/licenses/agpl-3.0.html The GNU Affero General Public License V3.0
 */

?>

<?php
    $form = $this->beginWidget(
        'BaseEventTypeCActiveForm',
        [
            'id' => 'adminform',
            'enableAjaxValidation' => false,
            'focus' => '#username',
            'layoutColumns' => array(
                'label' => 2,
                'field' => 4,
            ),
        ]
    ) ?>

<form id="findings" method="POST">
    <input type="hidden" name="YII_CSRF_TOKEN" value="<?php echo Yii::app()->request->csrfToken ?>"/>
        <div class="cols-7">
        <table class="standard cols-full" id="finding-table">
            <colgroup>
                <col class="cols-1">
                <col class="cols-4">
                <col class="cols-4">
                <col class="cols-1">
                <col class="cols-1">
            </colgroup>

            <thead>
            <tr>
                <th>Order</th>
                <th>Name</th>
                <th>Subspecialties</th>
                <th>Requires Description</th>
                <th>Active</th>
            </tr>
            </thead>

            <tbody class="sortable">

            <?php foreach ($findings as $key => $finding) :
                $data = [
                    'finding' => $finding,
                    'key' => $key
                ];
                $this->renderPartial('findings/_row', ['data' => $data, 'subspecialty' => $subspecialty]);
            endforeach;?>
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6">
                    <?php echo CHtml::htmlButton(
                        'Add',
                        [
                            'class' => 'small secondary button',
                            'name' => 'add',
                            'type' => 'button',
                            'id' => 'et_admin-add'
                        ]
                    );?>
                    <?php echo CHtml::button(
                        'Save',
                        [
                            'class' => 'small primary button',
                            'name' => 'save',
                            'type' => 'submit',
                            'id' => 'et_admin-save'
                        ]
                    ); ?>
                </td>
            </tr>
            </tfoot>
        </table>
        </div>
</form>
<?php $this->endWidget() ?>

<script type="text/template" id="finding-row-template" style="display:none">
    <?php
        $data = [
            'finding' => new Finding(),
            'key' => '{{key}}'
        ];
        $this->renderPartial('findings/_row', ['data' => $data, 'subspecialty' => $subspecialty]);
        ?>
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.sortable').sortable({
            stop: function(e, ui) {
                $('#finding-table tbody tr').each(function(index, tr) {
                    $(tr).find('.js-display-order').val(index);
                });
            }
        });
    });

    $('#et_sort').on('click', function() {
        $('#definition-list').attr('action', $(this).data('uri')).submit();
    })

    // Add a new row to the table using the template
    $('#et_admin-add').on('click', function() {
        $('#definition-list').attr('action', $(this).data('uri')).submit();
        let $table = $('#finding-table tbody');
        let data = {
            key: $table.find('tr').length
        };
        let tr = Mustache.render($('#finding-row-template').text(), data);
        $table.append(tr);
    })
</script>