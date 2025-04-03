<fieldset>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="identifier"><?php echo $langArray['Redirect identifier']; ?></label>
            <input type="text" name="identifier" value="<?php echo htmlspecialchars($edit ? $dynamic_qrcode['identifier'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="<?php echo $langArray['Identifier']; ?>" class="form-control" id="identifier" readonly>
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="form-group">
            <label for="filename"><?php echo $langArray['Filename']; ?> *</label>
            <p><?php echo $langArray['Filename note']; ?></p>
            <input type="text" name="filename" value="<?php echo htmlspecialchars($edit ? $dynamic_qrcode['filename'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="<?php echo $langArray['Filename']; ?>" class="form-control" required="required" id="filename">
        </div> 
    </div>
    
    <div class="col-sm-4">
        <div class="form-group">
            <label for="link"><?php echo $langArray['URL']; ?> *</label>
            <input type="url" pattern="https?://.*" name="link" value="<?php echo htmlspecialchars($edit ? $dynamic_qrcode['link'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="<?php echo $langArray['Link']; ?>" class="form-control" required="required" id="link">
        </div>
    </div>
    
    <div class="col-sm-4">
        <label for="state"><?php echo $langArray['Redirect to url']; ?> *</label>
        <div class="form-group">
            <label class="radio-inline">
            <input type="radio" name="state" value="enable" <?php echo ($edit && $dynamic_qrcode['state'] == 'enable') ? "checked" : ""; ?> required="required" id="enable"/> <?php echo $langArray['Enable']; ?></label>
            
            <label class="radio-inline">
            <input type="radio" name="state" value="disable" <?php echo ($edit && $dynamic_qrcode['state'] == 'disable') ? "checked" : ""; ?> required="required" id="disable"/> <?php echo $langArray['Disable']; ?></label>
        </div>
    </div>

    <?php if($_SESSION['type'] === 'super') { ?>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="id_owner"><?php echo $langArray['Owner']; ?> *</label>
            <select name="id_owner" class="form-control" required="required">
                <?php
                require_once BASE_PATH . '/lib/Users/Users.php';
                $users_instance = new Users();

                if (isset($dynamic_qrcode['id_owner'])) {
                    $owner = $users_instance->getUser($dynamic_qrcode['id_owner']);
                    echo "<option selected value=\"" . $owner["id"] . "\">" . $owner["username"] . "</option>";
                    echo "<option value=\"\">" . $langArray['All'] . "</option>";
                }

                $users = $users_instance->getAllUsers();
                foreach ($users as $user) {
                    ?>
                    <option value="<?php echo $user["id"]; ?>"><?php echo $user["username"]; ?></option>
                <?php } ?>
            </select>
        </div>
    </div>
    <?php } else { ?>
        <input type="hidden" name="id_owner" value="<?php echo $_SESSION["user_id"]; ?>"/>
    <?php } ?>

    <input type="hidden" name="id" value="<?php echo $dynamic_qrcode['id']; ?>"/>
    <input type="hidden" name="edit" value="true"/>
    <input type="hidden" name="old_filename" value="<?php echo $dynamic_qrcode['filename']; ?>"/>
</fieldset>