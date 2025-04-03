<fieldset>
    <div class="col-sm-12 mb-2">
        <div class="row">
            <div class="col-6 col-md-3">
                <label for="foreground"><?php echo $langArray['Foreground']; ?> *</label>
                <div class="input-group my-colorpicker2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-qrcode"></i></span>
                    </div>
                    <input type="text" class="form-control" id="foreground" name="foreground" value="#000000" required="required">
                </div>
            </div>
                  
            <div class="col-6 col-md-3">
                <label for="background"><?php echo $langArray['Background']; ?> *</label>
                <div class="input-group my-colorpicker2">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-qrcode"></i></span>
                    </div>
                    <input type="text" class="form-control" id="background" name="background" value="#ffffff" required="required">
                </div>
            </div>
                  
            <div class="col-6 col-md-3">
                <label for="level"><?php echo $langArray['Precision']; ?></label>
                <select name="level" class="form-control">
                    <option value="L"><?php echo $langArray['L - Smallest']; ?></option>
                    <option value="M"><?php echo $langArray['M - Medium']; ?></option>
                    <option value="Q"><?php echo $langArray['Q - High']; ?></option>
                    <option value="H"><?php echo $langArray['H - Best']; ?></option>
                </select>
            </div>
        
            <div class="col-6 col-md-3">
                <label for="size"><?php echo $langArray['Size (px)']; ?></label>
                <select name="size" class="form-control">
                    <option value="100">100</option>
                    <option value="200">200</option>
                    <option value="300">300</option>
                    <option value="400">400</option>
                    <option value="500">500</option>
                    <option value="600">600</option>
                    <option value="700">700</option>
                    <option value="800">800</option>
                    <option value="900">900</option>
                    <option value="1000" selected="selected">1000</option>
                </select>
            </div>
        </div>
    </div>

<!-- Its use is not recommended. Read the documentation
    <div class="form-group">
        <label for="logo">Logo</label>
        <?php //include 'logo.php' ?>
    </div>
    -->

    <div class="col-sm-4">
        <div class="form-group">
            <label for="link"><?php echo $langArray['URL']; ?> *</label>
            <input type="url" pattern="http.*://.*" name="link" value="" placeholder="https://example.com" class="form-control" required="required" id="link">
        </div>
    </div>
    
    <div class="col-sm-4">
        <div class="form-group">
            <label for="identifier"><?php echo $langArray['Redirect identifier']; ?></label>
            <p><?php echo $langArray['Auto generated']; ?></p>
        </div>
    </div>
    
    <div class="col-sm-12 mb-2">
        <div class="row">    
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="filename"><?php echo $langArray['Filename']; ?> *</label>
                    <input type="text" name="filename" value="" placeholder="<?php echo $langArray['My first Qrcode']; ?>" class="form-control error" required="required" id="filename">
                </div>
            </div>
            
            <div class="col-6 col-md-1">
                <label for="format"><?php echo $langArray['Format']; ?> *</label>
                <select name="format" class="form-control" required="required">
                    <option value="png" selected>PNG</option>
                    <option value="gif">GIF</option>
                    <option value="jpeg">JPEG</option>
                    <option value="jpg">JPG</option>
                    <option value="svg">SVG</option>
                    <option value="eps">EPS</option>
                </select>
            </div>
        </div>
    </div>

    <?php if($_SESSION['type'] ===  'super') { ?>
    <div class="col-sm-12 mb-2">
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="id_owner"><?php echo $langArray['Owner']; ?> *</label>
                    <select name="id_owner" class="form-control">
                        <option value="" selected><?php echo $langArray['All']; ?></option>
                        <?php
                        require_once BASE_PATH . '/lib/Users/Users.php';
                        $users_instance = new Users();
                        $users = $users_instance->getAllUsers();

                        foreach ($users as $user) {
                        ?>
                        <option value="<?php echo $user["id"];?>"><?php echo $user["username"];?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <input type="hidden" name="id_owner" value="<?php echo $_SESSION["user_id"];?>"/>
    <?php } ?>
</fieldset>
