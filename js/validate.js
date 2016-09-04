// =========================== getChar ================================
function getChar(event) {
    if (event.which == null) { // IE
        if (event.keyCode < 32) return null; // спец. символ
        return String.fromCharCode(event.keyCode)
    }

    if (event.which != 0 && event.charCode != 0) { // все кроме IE
        if (event.which < 32) return null; // спец. символ
        return String.fromCharCode(event.which); // остальные
    }

    return null; // спец. символ
}

// =========================== isCharNumber =========================
function isCharNumber(char) {
    switch (char) {
        case "1":
            return true;
        case "2":
            return true;
        case "3":
            return true;
        case "4":
            return true;
        case "5":
            return true;
        case "6":
            return true;
        case "7":
            return true;
        case "8":
            return true;
        case "9":
            return true;
        case "0":
            return true;
        default:
            return false;
    }
}

// ====================================================================
function handleLetter(e) {
    // спец. сочетание - не обрабатываем
    if (e.ctrlKey || e.altKey || e.metaKey) return true;
    var char = getChar(e);
    if (!char) return true; // спец. символ - не обрабатываем
    if (isCharNumber(char)) {
        return false; // цифры - не обрабатываем
    }
    this.value = char(); // выводим
    return false;
}
// ====================================================================
function handleNumber(e) {
    // спец. сочетание - не обрабатываем
    if (e.ctrlKey || e.altKey || e.metaKey) return true;
    var char = getChar(e);
    if (!char) return true; // спец. символ - не обрабатываем
    if (!isCharNumber(char)) {
        return false; // буквы - не обрабатываем
    }
    this.value = char(); // выводим
    return false;
}
// ====================================================================
function isEmailValid() {
    var p = /^[a-z0-9_\.\-]+@([a-z0-9\-]+\.)+[a-z]{2,6}$/i;
    //  Получаем   значение   поля  email
    var email = document.getElementById("email");
    var bs = document.getElementById("password").style.borderColor;

    if (p.test(email.value)) {
        email.style.borderColor = bs;
        return true; //  Продолжаем
    }
    else {
//        window.alert("E-mail  введен   неправильно ");
        email.style.borderColor = "red";
        return false; //  Прерываем
    }
}

window.onload = function () {
// ======================== validate - first_name ======================
    var field_first_name = document.getElementById("first_name");
    var field_second_name = document.getElementById("second_name");
    var field_zip_code = document.getElementById("zip_code");
    var field_phone = document.getElementById("phone");
    var field_email = document.getElementById("email");

    field_first_name.onkeypress = handleLetter;
    field_second_name.onkeypress = handleLetter;
    field_zip_code.onkeypress = handleNumber;
    field_phone.onkeypress = handleNumber;
    field_email.onblur = isEmailValid;


};

