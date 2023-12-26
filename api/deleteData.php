<?php
require_once("connectDB.php");
require_once("memberInfo.php");

$resArray = array();
if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST)){

        
        $sqlSelect = "SELECT commentNo, comment
                        FROM message
                        WHERE commentNo = ?";

        $stmt = $dbLink->prepare($sqlSelect);
        $stmt->bind_param("i" ,$_POST["commentNo"]);
        $stmt->execute();
        $stmt->bind_result($commentNo ,$comment);
        $stmt->fetch();
        $stmt->close();

        if($comment == $_POST["content"]){
                $sql = "DELETE FROM message
                WHERE commentNo = ? AND memberId = ?";

                $stmt = $dbLink->prepare($sql);
                $stmt->bind_param("ii" ,$_POST["commentNo"], $id);
                $stmt->execute();
                $resArray["error"] = false;
                $resArray["affectedRows"] = $stmt->affected_rows;
                $stmt->close();
        }else{
                $resArray["error"] = true;
                $resArray["errorMsg"] = "Ooops，無法刪除";
        }
        echo json_encode($resArray);
}

if($_SERVER["REQUEST_METHOD"]=="GET"){
        header("Location: ../message.php");
}
?>