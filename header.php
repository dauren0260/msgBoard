<?php
echo    "<div class='logo'>
            <a href='message.php'>
                <img class='logoImg' src='./assets/img/logo.jpg' alt='logo'>
            </a>
            <div class='infoArea'>
                <span><a href='memberCenter.php'>Hello, ".$memName."</a></span>
                <button type='button' class='btn btnSecondary' id='logOutBtn'>登出</button>
            </div>
        </div>";
            

echo    "<script>
            logOutBtn.addEventListener('click',logOut,false)
            function logOut(){
                axios('api/logOut.php').then(()=> window.location='index.php')
            }
        </script>";
        ?>


