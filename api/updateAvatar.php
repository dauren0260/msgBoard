<?php
require_once("connectDB.php");
require_once("memberInfo.php");
$avatarImg = '';

$sql = "UPDATE member 
SET memAvatar = ?
WHERE id = ?";

$stmt = $dbLink->prepare($sql);

switch ($_FILES["avatarImg"]["error"]) {
    case UPLOAD_ERR_OK:
        $dir = "../assets/img/member";
        if(file_exists($dir)==false){
            mkdir($dir);
        }

        $from = $_FILES["avatarImg"]["tmp_name"];
        $avatarImg = $_FILES["avatarImg"]["name"];
        $to = "{$dir}/{$avatarImg}";

        if(copy($from, $to)){
            $msg["uploadStatus"] = "success";
            echo json_encode($msg);
        }else{
            $msg["uploadStatus"] = "failed";
            echo json_encode($msg);
        }
        break;
    
    case UPLOAD_ERR_INI_SIZE:
        $msg["uploadStatus"] = "上傳的檔案過大，不得超過". ini_get("upload_max_filesize") . "<br/>";
        echo json_encode($msg);
        break;
    // case UPLOAD_ERR_FROM_SIZE:
    //     $msg["uploadStatus"] = "上傳的檔案過大，不得超過". $_POST["MAX_FILE_SIZE"] . "<br/>";
    //     echo json_encode($msg);
    //     break;
    case UPLOAD_ERR_PARTIAL:
        $msg["uploadStatus"] = "上傳檔案不完整";
        echo json_encode($msg);
        break;
    case UPLOAD_ERR_NO_FILE:
        $msg["uploadStatus"] =  "未選擇檔案";
        echo json_encode($msg);
        break;
    
    default:
        $msg["uploadStatus"] =  "系統暫時發生問題，請稍後再試";
        echo json_encode($msg);
        break;
}

$stmt->bind_param("si", $avatarImg, $id);
$stmt->execute();
$stmt->close();


?>