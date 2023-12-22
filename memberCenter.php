<?php
require_once("api/connectDB.php");
require_once("api/memberInfo.php");
?>

<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.2/axios.min.js" integrity="sha512-b94Z6431JyXY14iSXwgzeZurHHRNkLt9d6bAHt7BZT38eqV+GyngIi/tVye4jBKPYQ2lBdRs0glww4fmpuLRwA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="./assets/css/index.css" type="text/css">
    <link rel="stylesheet" href="./assets/css/memberCenter.css" type="text/css">
    <title>會員中心</title>
</head>
<body class="memberCenter">
    <?php
        require_once("header.php");
    ?>
    <div class="container">
        <div class="avatar">
            <img src="./assets/img/member/<?php echo $memAvatar?>" alt="avatar">
            <input type="file" name="avatarImg" id="avatarImg">
        </div>
        <div class="uploadArea hide">
            <img src="" alt="preview" class="preview hide" />
            <div class="btnArea">
                <button class="btn btnWarning delPreview">刪除檔案</button>
                <button class="btn btnPrimary" id="uploadImg">上傳</button>
            </div>
        </div>
        <div>姓名：<?php echo $memName?></div>
        <div>信箱：<?php echo $memEmail?></div>
        <button class="btn btnSecondary showChangePsw" id="showChangePsw">更改密碼</button>
        <div class="changePsw hide" id="changeArea">
            請輸入舊密碼：<input type="password" name="oldPsw" id="oldPsw" required minlength="4" autocomplete="off"><br/>
            請輸入新密碼：<input type="password" name="newPsw" id="newPsw" required minlength="4" autocomplete="off">
            <button class="btn btnPrimary" id="sendBtn">送出</button>
            <button class="btn btnSecondary" id="cancelBtn">取消</button>
        </div>
    </div>

    <script>

        // uploadImg.addEventListener("click",function(){
        //     axios.post('api/updateAvatar.php', data)
        //     .then(res=>console.log(res))

        // },false)

        const fileUploader = document.querySelector('[type=file]');
        const imgPreviewer = document.querySelector('.preview');
        const removeBtn = document.querySelector('.delPreview');
        const uploadArea = document.querySelector('.uploadArea');

        /** 洗掉兩個 src */
        const removeHandler = () => {
            uploadArea.classList.add('hide');
            imgPreviewer.removeAttribute('src');
            fileUploader.value = '';
        };

        /** 將 input 預設的 bytes 轉為 MB */
        const bytesToMegaBytes = (bytes, digits) => {
            return digits ? (bytes / (1024 * 1024)).toFixed(digits) : bytes / (1024 * 1024);
        };

        /** 檢查是否為 100 MB 以下 */
        const isSizeOk = size => {
            return size <= 100;
        };

        /** 用副檔名檢查上傳檔案的格式 */
        const isFileExtensionOk = fileName => {
            // xxx.jpeg 會檢查副檔名
            const fileNameReg = /\.(jpe?g|png|gif|mp4)$/i;
            return fileNameReg.test(fileName);
        };

        const checkMediaIsOk = ( {size, fileName} ) => {
            if (!isSizeOk(Number(size))) {
                return { isFileValid: false, errorMessage: '超過 100 MB 的上限' };
            }
            if (!isFileExtensionOk(fileName)) {
                return { isFileValid: false, errorMessage: '檔案類型錯誤' };
            }
            return { isFileValid: true, errorMessage: null };
        };

        /** 依照不同的檔案類型顯示不同的元素（並把另一個隱藏）*/
        const getStrategy = type => {
            const strategies = {
                img: src => {
                    imgPreviewer.classList.remove('hide');
                    imgPreviewer.setAttribute('src', src);
                }
            };
            return strategies[type];
        };

        const getFileExtension = name => {
            const imgFileReg = /\.(jpe?g|png|gif)$/i;
            return imgFileReg.test(name) ? 'img' : false;
        };

        const previewHandler = file => {
            // 建立 FileReader
            const reader = new FileReader();

            // File 讀取完畢就會觸發 load 事件
            reader.addEventListener('load', event => {
                const fileExtension = getFileExtension(file.name);
                const { result } = event.target;
                console.log(result)
                getStrategy(fileExtension)(result);
            });

            if (file) {
                // 把 file 變成 DataURL，轉換完畢就會叫用 load 事件
                reader.readAsDataURL(file);
            }
        };

        /** STEP 1: 上傳檔案觸發 change */
        fileUploader.addEventListener('change', event => {
            uploadArea.classList.remove('hide');
            const [file] = event.target.files;
            console.log(file)
            const { size, name } = file;
            // 將 bytes 轉成 MegaBytes
            const mediaMegaBytes = bytesToMegaBytes(size, name);
            /** STEP 2: 檢查上傳的檔案是否符合規定 */
            const { isFileValid, errorMessage } = checkMediaIsOk({ size: mediaMegaBytes, fileName: name });

            // STEP 3: 失敗，印出錯誤及重新洗掉 input
            if (!isFileValid) {
                console.error(errorMessage);
                removeHandler();
            } else {
                // STEP 3: 成功，將 file 轉換成 URL
                previewHandler(file);
            }
        });
        removeBtn.addEventListener('click', removeHandler);

        showChangePsw.addEventListener("click",function(){
            this.classList.toggle("hide");
            changeArea.classList.toggle("hide");
            oldPsw.value = '';
            newPsw.value = '';
        },false)

        cancelBtn.addEventListener("click",function(){
            changeArea.classList.toggle("hide");
            showChangePsw.classList.toggle("hide");
        },false)

        // 修改密碼
        sendBtn.addEventListener("click",function(){
            if(oldPsw.value.length < 4 || newPsw.value.length < 4){
                alert("密碼最小長度需四位數");
            }else if(oldPsw.value == newPsw.value){
                alert("密碼不可與上次相同!");
                oldPsw.value = '';
                newPsw.value = '';
                oldPsw.focus();
            }else{
                var data = new FormData();
                data.append('oldPsw', oldPsw.value);
                data.append('newPsw', newPsw.value);

                axios.post('api/changePassword.php', data)
                .then( (response) => {
                    console.log(response)
                    if(!response.data.error){
                        alert("修改密碼成功!");
                        changeArea.classList.toggle("hide");
                        showChangePsw.classList.toggle("hide");
                    }else{
                        alert("修改密碼失敗!")
                        oldPsw.value = '';
                        newPsw.value = '';
                        oldPsw.focus();
                    }
                })
            }
        },false)
    </script>
</body>
</html>