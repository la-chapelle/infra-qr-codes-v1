<fieldset>
    <div class="col-sm-4">
        <div class="form-group">
            <label for="username"><?php echo $langArray['Username']; ?> *</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                </div>
                
                <input type="text" name="username" placeholder="<?php echo $langArray['Username']; ?>" class="form-control" required="required" value="<?php echo ($edit) ? $user['username'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="form-group">
            <label for="password"><?php echo $langArray['Password']; ?> *</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                </div>
                
                <input type="password" name="password" placeholder="<?php echo $langArray['Password']; ?>" class="form-control" required="required" autocomplete="off">
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <label for="user-type"><?php echo $langArray['User type']; ?> *</label>
        
        <div class="form-group">
            <div class="radio">
                <label class="radio">
                <input type="radio" name="type" value="super" required="required" <?php echo ($edit && $user['type'] =='super') ? "checked": "" ; ?>/> <?php echo $langArray['Super admin']; ?></label>
            </div>
            
            <div class="radio">
                <label class="radio">
                <input type="radio" name="type" value="admin" required="required" <?php echo ($edit && $user['type'] =='admin') ? "checked": "" ; ?>/> <?php echo $langArray['Admin']; ?></label>
            </div>
        </div>
    </div>
    <?php if($edit) { ?>
        <input type="hidden" name="id" value="<?php echo $user['id'];?>"/>
        <input type="hidden" name="edit" value="true"/>
    <?php } ?>
</fieldset>