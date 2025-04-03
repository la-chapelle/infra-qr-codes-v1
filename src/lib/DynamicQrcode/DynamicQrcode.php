<?php
require_once 'config/config.php';

if (QRCODE_GENERATOR === "external-api.qrserver.com") {
    require_once BASE_PATH . '/lib/Qrcode/Qrcode.php';
}

if (QRCODE_GENERATOR === "internal-chillerlan.qrcode") {
    require_once BASE_PATH . '/lib/Qrcode/Qrcode-intchil.php';
}


class DynamicQrcode {
    private Qrcode $qrcode_instance;
    private array $langArray;

    /**
     *
     */
    public function __construct() {
        global $langArray;
        $this->qrcode_instance = new Qrcode("dynamic");
        $this->langArray = $langArray;
    }

    /**
     *
     */
    public function __destruct() {
    }
    
    /**
     * Set friendly columns names to order tables entries
     * N.B. This function is called to generate the "list all" table
     */
    public function setOrderingValues()
    {
        $ordering = [
            'id' => $this->langArray["ID"],
            'id_owner' => $this->langArray["Owner"],
            'filename' => $this->langArray["Filename"],
            'identifier' => $this->langArray["Identifier"],
            'link' => $this->langArray["Link"],
            'qrcode' => $this->langArray["Qr code"],
            'created_at' => $this->langArray["Created at"],
            'updated_at' => $this->langArray["Updated at"]
        ];

        return $ordering;
    }

    public function getQrcode($id) {
        return $this->qrcode_instance->getQrcode($id);
    }
    
    /**
     * Add qr code
     * Check out http://goqr.me/api/ for more information
     * We save the file obtained with the chosen name and in the selected folder
     * We save into db the url of qrcode image
     */
    public function addQrcode($input_data) {
        if($input_data['id_owner'] != "")
            $data_to_db['id_owner'] = $input_data['id_owner'];
        else
            $data_to_db['id_owner'] = NULL;

        $data_to_db['filename'] = htmlspecialchars($input_data['filename'], ENT_QUOTES, 'UTF-8');
        $data_to_db['created_at'] = date('Y-m-d H:i:s');
        $data_to_db['link'] = htmlspecialchars($input_data['link'], ENT_QUOTES, 'UTF-8');
        $data_to_db['created_by'] = $_SESSION['user_id'];
        $data_to_db['format'] = $input_data['format'];
        $data_to_db['identifier'] = randomString(rand(5,8));
        $data_to_db['qrcode'] = $data_to_db['filename'].'.'.$data_to_db['format'];

        $data_to_qrcode = READ_PATH.$data_to_db['identifier'];
        
        $this->qrcode_instance->addQrcode($input_data, $data_to_db, $data_to_qrcode);
    }
    
    /**
     * Edit qr code
     * 
     */
    public function editQrcode($input_data) {
        if($input_data['id_owner'] != "")
            $data_to_db['id_owner'] = $input_data['id_owner'];
        else
            $data_to_db['id_owner'] = NULL;
        $data_to_db['filename'] = htmlspecialchars($input_data['filename'], ENT_QUOTES, 'UTF-8');
        $data_to_db['created_at'] = date('Y-m-d H:i:s');
        $data_to_db['link'] = htmlspecialchars($input_data['link'], ENT_QUOTES, 'UTF-8');
        $data_to_db['state'] = $input_data['state'];

        $this->qrcode_instance->editQrcode($input_data, $data_to_db);
    }

    
    /**
     * Delete qr code
     * 
     */
    public function deleteQrcode($id, $async = false) {
        if($_SESSION['type'] === "super") {
            $this->qrcode_instance->deleteQrcode($id, $async);
        } else if ($_SESSION['type'] === "admin") {
            $qrcode = $this->getQrcode($id);

            if(!isset($qrcode["id_owner"]))
                $this->failure($this->langArray["You cannot delete this qrcode"]);

            require_once BASE_PATH . '/lib/Users/Users.php';
            $users = new Users();
            $user = $users->getUser($_SESSION['user_id']);

            if($user["id"] === $qrcode["id_owner"])
                $this->qrcode_instance->deleteQrcode($id, $async);
            else
                $this->failure($this->langArray["You cannot delete this qrcode because it belongs to another user"]);
        }
    }


    /**
     * Flash message Failure process
     */
    private function failure($message) {
        $_SESSION['failure'] = $message;
        header('Location: dynamic_qrcodes.php');
    	exit();
    }
    
    /**
     * Flash message Success process
     */
    private function success($message) {
        $_SESSION['success'] = $message;
        header('Location: dynamic_qrcodes.php');
    	exit();
    }
    
    /**
     * Flash message Info process
     */
    private function info($message) {
        $_SESSION['info'] = $message;
        header('Location: dynamic_qrcodes.php');
    	exit();
    }

    public function debug($data) {
        echo '<pre>' . var_export($data, true) . '</pre>';
        exit();
    }
}
?>
