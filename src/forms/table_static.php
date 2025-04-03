<div class="row">
    <div class="col-12" id="bulk-action-div" style="display: none;">
        <div id="err-msg"></div>
        <div class="bulk-action-wrapper">
            <form id="bulk-action" action="bulk_action.php" method="POST">
                <div class="col-sm-12 mb-2" style="margin-left: 10px">
                    <div class="row">
                        <div class="col-5 col-md-2">
                            <div class="input-group">
                                <select name="action" class="form-control">
                                    <option value="download" selected><?php echo $langArray['Download']; ?></option>
                                    <option value="delete"><?php echo $langArray['Delete']; ?></option>
                                </select>
                                <input type="hidden" name="type" value="static">
                                <button type="submit" class="btn btn-primary"><?php echo $langArray['Apply']; ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-12">
        <div class="card">
            <div class="card-body table-responsive p-0">
      <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th><input type="checkbox" name="bulk-select" value="1"></th>
                <th><?php echo $langArray['ID']; ?></th>
                <th><?php echo $langArray['Owner']; ?></th>
                <th><?php echo $langArray['Filename']; ?></th>
                <th><?php echo $langArray['Type']; ?></th>
                <th><?php echo $langArray['Content']; ?></th>
                <th><?php echo $langArray['Qr code']; ?></th>
                <th><?php echo $langArray['Operations']; ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><input type="checkbox" name="action[]" value="<?=$row['id']?>" onchange="updateBulkActionVisibility()"></td>
                <td><?php echo $row['id']; ?></td>
                <td>
                    <?php
                    if(!isset($row['id_owner']))
                        echo "";
                    else {
                        require_once BASE_PATH . '/lib/Users/Users.php';
                        $users = new Users();
                        $user = $users->getUser($row['id_owner']);
                        if($user !== NULL)
                            echo $user["username"];
                        else
                            echo "";
                    }
                    ?>
                </td>
                <td><?php echo htmlspecialchars($row['filename']); ?></td>
                <td><?php echo htmlspecialchars($row['type']); ?></td>
                <td><?php echo htmlspecialchars_decode($row['content']); ?></td>
                <td>
                    <?php echo '<img src="'.SAVED_QRCODE_FOLDER.htmlspecialchars($row['qrcode']).'" width="100" height="100">'; ?>
                </td>
                <td>
                    <!-- EDIT -->
                    <a href="static_qrcode.php?edit=true&id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                    
                    <!-- DELETE -->
                    <a
                            class="btn btn-danger delete_btn"
                            data-toggle="modal"
                            data-target="#delete-modal"
                            data-del_id="<?php echo $row["id"];?>"
                    ><i class="fas fa-trash"></i></a>

                    <!-- DOWNLOAD -->
                    <a href="<?php echo SAVED_QRCODE_FOLDER.htmlspecialchars($row['qrcode']); ?>" class="btn btn-primary" download><i class="fa fa-download"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
   </div><!-- /.Card body -->
   
   <div class="card-footer clearfix">
       <?php echo paginationLinks($page, $total_pages, 'static_qrcodes.php'); ?>
       </div><!-- /.Card footer -->
       
        </div><!-- /.Card -->
    </div><!-- /.col -->
</div><!-- /.row -->

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="delete-modal" role="dialog">
    <div class="modal-dialog">
        <form action="static_qrcode.php" method="POST">
            <!-- Modal content -->

            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo $langArray['Confirm']; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="del_id" id="del_id" value="">
                    <p><?php echo $langArray['Are you sure you want to delete this row']; ?></p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><?php echo $langArray['Save changes']; ?></button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $langArray['Close']; ?></button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /.Delete Confirmation Modal -->

<script>
    const deleteButtons = document.querySelectorAll('.delete_btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('del_id').value = button.getAttribute('data-del_id');

            const deleteModal = document.querySelector('#delete-modal');
            deleteModal.style.display = 'block';
        });
    });
</script>

<script>
    function updateBulkActionVisibility() {
        const checkboxes = document.querySelectorAll('input[name="action[]"]');
        const bulkActionDiv = document.getElementById('bulk-action-div');

        const selectedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked);

        if (selectedCheckboxes.length > 0) {
            bulkActionDiv.style.display = 'block';
        } else {
            bulkActionDiv.style.display = 'none';
        }
    }

    updateBulkActionVisibility();
</script>