const fileUploader = document.getElementById("fileTag");
const imgPreviewer = document.querySelector(".preview");
const removeBtn = document.querySelector(".delPreview");
const uploadArea = document.querySelector(".uploadArea");
const fileInputArea = document.querySelector(".fileInputArea");
let urlResult = '';

/** 洗掉兩個 src */
const removeHandler = () => {
    imgPreviewer.removeAttribute("src");
    fileInputArea.classList.remove("hide");
    uploadArea.classList.add("hide");
    fileUploader.value = "";
    window.URL.revokeObjectURL(urlResult)
};

/** 將 input 預設的 bytes 轉為 MB */
const bytesToMegaBytes = (bytes, digits) => {
    return digits ?
        (bytes / (1024 * 1024)).toFixed(digits) :
        bytes / (1024 * 1024);
};

/** 檢查是否為 100 MB 以下 */
const isSizeOk = (size) => {
    console.log(size);
    return (size<2) ? true: false;
};

/** 用副檔名檢查上傳檔案的格式 */
const isFileExtensionOk = (fileName) => {
    // xxx.jpeg 會檢查副檔名
    const fileNameReg = /\.(jpe?g|png|gif)$/i;
    return fileNameReg.test(fileName);
};

const checkMediaIsOk = ({size,fileName}) => {
    if (!isSizeOk(Number(size))) {
        return {
            isFileValid: false,
            errorMessage: "超過 2 MB 的上限"
        };
    }
    if (!isFileExtensionOk(fileName)) {
        return {
            isFileValid: false,
            errorMessage: "檔案類型錯誤"
        };
    }
    return {
        isFileValid: true,
        errorMessage: null
    };
};

const getFileExtension = (name) => {
    const imgFileReg = /\.(jpe?g|png)$/i;
    return imgFileReg.test(name) ? "img" : false;
};

const previewHandler = (file) => {
    const reader = new FileReader();
    const fileExtension = getFileExtension(file.name);

    if (fileExtension) {
        // 把 file 變成 DataURL，轉換完畢就會叫用 load 事件
        reader.readAsDataURL(file);
    }

    // File 讀取完畢就會觸發 load 事件
    reader.addEventListener("load", (event) => {
        // 檢查副檔名

        // 讀取到的file資料轉成的URL存在FileReader.result中
        const {result} = event.target;
        urlResult = result;
        fileInputArea.classList.add("hide");
        uploadArea.classList.remove("hide");
        imgPreviewer.classList.remove("hide");
        imgPreviewer.setAttribute("src", result);
    });
};

/** STEP 1: 上傳檔案觸發 change */
fileUploader.addEventListener("change", (event) => {
    const [file] = event.target.files;
    const {size,name} = file;

    // 將 bytes 轉成 MegaBytes
    const mediaMegaBytes = bytesToMegaBytes(size, 2);

    /** STEP 2: 檢查上傳的檔案是否符合規定 */
    const { isFileValid, errorMessage } = checkMediaIsOk({
        size: mediaMegaBytes,
        fileName: name
    });

    // STEP 3: 失敗，印出錯誤及重新洗掉 input
    if (!isFileValid) {
        alert(errorMessage);
        removeHandler();
    } else {
        // STEP 3: 成功，將 file 轉換成 URL
        previewHandler(file);
    }
});

removeBtn.addEventListener("click", removeHandler);