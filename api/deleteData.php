<?php
require_once("connectDB.php");

if($_SERVER["REQUEST_METHOD"]=="POST" && !empty($_POST)){

        $sql = "DELETE FROM message
                WHERE commentNo = ?";

        $stmt = $dbLink->prepare($sql);
        $stmt->bind_param("i" ,$_POST["commentNo"]);
        $stmt->execute();
        $stmt->close();
}

header("Location: ../message.php");
?>