<form class="form" action="static_qrcode.php?type=wifi" method="post" id="static_form" enctype="multipart/form-data">
    <?php include BASE_PATH.'/forms/qrcode_options.php'; ?>
<!-- Input forms -->
<div class="col-sm-12 mb-2">
    <div class="row">

    <div class="col-6 col-md-3">
        <div class="form-group">
            <label><?php echo $langArray['Encryption']; ?> *</label>
            <select name="encryption" class="form-control">
                <option value="WPA" Selected><?php echo $langArray['WPA/WPA2']; ?></option>
                <option value="WEP"><?php echo $langArray['WEP']; ?></option>
                <option value=""><?php echo $langArray['None']; ?></option>
            </select>
        </div>
    </div>
    
    <div class="col-6 col-md-3">
        <div class="form-group">
            <label><?php echo $langArray['SSID']; ?> *</label>
            <input type="text" name="ssid" value="" placeholder="" class="form-control">
        </div>
    </div>
    
    <div class="col-6 col-md-3">
        <div class="form-group">
            <label><?php echo $langArray['Password']; ?></label>
            <input type="text" name="password" value="" placeholder="" class="form-control">
        </div>
    </div>
    </div>
</div>

<div class="col-sm-12 mb-2">
    <div class="row">
        <div class="col-6 col-md-3">
            <button type="submit" class="btn btn-primary"><?php echo $langArray['Submit']; ?></button>
        </div>    
    </div>
</div>
                
</form>