<?php

use Alexplusde\YComFastForward\YComFastForward;
?>
<fieldset>
    <div class="form-group">
        <label class="control-label"><?= rex_i18n::msg('ycom_fast_forward.module.title'); ?></label>
        <div class="">
            <input class="form-control" type="text" name="REX_INPUT_VALUE[1]" value="REX_VALUE[1]">
        </div>
    </div>

    <div class="form-group">
        <label class="control-label"><?= rex_i18n::msg('ycom_fast_forward.module.description'); ?></label>
        <div class="">
            <textarea <?= YComFastForward::getConfig('editor') ? YComFastForward::getConfig('editor') : 'class="form-control"' ?> rows="6" name="REX_INPUT_VALUE[2]">REX_VALUE[2]</textarea>
        </div>
    </div>
</fieldset>
<fieldset>
    <div class="form-group">
        <label class="control-label">Fragment</label>
        <div class="">
            <select class="form-control" required="required" name="REX_INPUT_VALUE[10]">
                <?php
                $fragment_files = glob(rex_path::addon('ycom_fast_forward', 'fragments/ycom_fast_forward/') . '*.php');
                ?>
                <option value=""><?= rex_i18n::msg('ycom_fast_forward.module.select.default'); ?></option>
                <?php
                foreach ($fragment_files as $fragment_file) {
                    if('REX_VALUE[10]' === basename($fragment_file)) {
                        echo '<option value="' . basename($fragment_file) . '" selected>' . basename($fragment_file) . '</option>';
                        continue;
                    };
                    echo '<option value="' . basename($fragment_file) . '">' . basename($fragment_file) . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
</fieldset>
