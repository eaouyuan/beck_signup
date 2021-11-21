<?php
namespace XoopsModules\Beck_signup;

use XoopsModules\Tadtools\SimpleRest;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Beck_signup\Beck_signup_actions;
use XoopsModules\Beck_signup\Beck_signup_data;


require dirname(dirname(dirname(__DIR__))) . '/mainfile.php';

class Beck_signup_api extends SimpleRest
{
    public $uid = '';
    public $user = [];
    public $groups = [];
    private $token = '';

    public function __construct($token = '')
    {
        $this->token = $token;
        if (!isset($_SESSION['api_mode'])) {
            $_SESSION['api_mode'] = true;
        }

        if ($this->token) {
            $User = $this->getXoopsSUser($this->token);
            $this->uid = (int) $User['uid'];
            $this->groups = $User['groups'];
            $this->user = $User['user'];

            //判斷是否對該模組有管理權限 $_SESSION['beck_signup_adm']
            if (!isset($this->user['beck_signup_adm'])) {
                $this->user['beck_signup_adm'] = $_SESSION['beck_signup_adm'] = ($this->uid) ? $this->isAdmin('beck_signup') : false;
            }

            // 判斷有無開設活動的權限
            if (!isset($this->user['can_add'])) {
                $this->user['can_add'] = $_SESSION['can_add'] = $this->powerChk('beck_signup', 1);
            }

        }
    }

    // 傳回目前使用者資訊
    public function user()
    {
        $data = ['uid' => (int) $this->uid, 'groups' => $this->groups, 'user' => $this->user];
        return $this->encodeJson($data);
    }

    // 轉成 json
    private function encodeJson($responseData)
    {
        if (empty($responseData)) {
            $statusCode = 404;
            $responseData = array('error' => '無資料');
        } else {

            $statusCode = 200;
        }
        $this->setHttpHeaders($statusCode);

        $jsonResponse = json_encode($responseData, 256);
        return $jsonResponse;
    }

    // 取得所有活動
    public function beck_signup_actions_index($only_enable = true)
    {
        $actions = Beck_signup_actions::get_all($only_enable);
        return $this->encodeJson($actions);
    }

    // 取得某活動報名名單
    public function beck_signup_data_index($action_id)
    {
        $action = Beck_signup_actions::get($action_id);
        $data = ($this->user['beck_signup_adm']||($this->user['can_add'] &&  $action['uid'] == $this->uid))  ?Beck_signup_data::get_all($action_id):[];
        // var_dump($this->uid);die();
        // $data = ($this->user['beck_signup_adm'])  ?Beck_signup_data::get_all($action_id):[];
        return $this->encodeJson($data);
    }


}
