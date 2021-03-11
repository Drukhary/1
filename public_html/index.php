<!DOCTYPE html>
<html lang="en">
<head>
    <title>Лабораторная работа №1 //Крисанов Роман</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
</head>
<body>
<div class="header"><!--Создаём шапку страницы-->
    <h3>Крисанов Роман Валерьевич</h3>
    <p>
        <b>группа:</b> P3212
        <b>вариант:</b> 2316
    </p>
    <hr> <!--горизонтальная линия-->
</div>
<div class="form">
    <form action="index.php" method="GET">
        <div class="elem">
            <p><input id="resetForm" type="reset"></p>
        </div>
        <div class="elem">
            Параметр R:
            <p>
                <button id="setR1" type="button" class="setR" name="R" value=1>1
            </p>
            <p>
                <button id="setR2" type="button" class="setR" name="R" value=2>2
            </p>
            <p>
                <button id="setR3" type="button" class="setR" name="R" value=3>3
            </p>
            <p>
                <button id="setR4" type="button" class="setR" name="R" value=4>4
            </p>
            <p>
                <button id="setR5" type="button" class="setR" name="R" value=5>5
            </p>
        </div>
        <div class="elem" id="image_R">
            <p style="display: inline" class="electR">R = </p>
            <p style="display: inline" class="electR" id="selectedR">
        </div>
        <div class="elem">
            Координата X:
            <label>
                <select name="X" id="selectedX" class="coordinateX" required>
                    <option value="" checked>Выберите Х</option>
                    <option value="-5">-5</option>
                    <option value="-4">-4</option>
                    <option value="-3">-3</option>
                    <option value="-2">-2</option>
                    <option value="-1">-1</option>
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </label>
        </div>
        <div class="elem">
            Координата Y:
            <label>
                <input type="text" class="coordinateY" name="Y" placeholder="1,234" required>
            </label>
        </div>
        <div class="elem">
            <input type="button" class="submit" onclick="CheckPoints()" value="отправить">
        </div>
    </form>
    <div class="elem">
        <p id="errorFields">Ошибка ввода, заполнены не все поля</p>
    </div>
</div>
<div class="picture">
    <img src="task.png" alt="">
</div>
<div>
    <a style="display: none" id="click_me_to_centre_at_picture" href="#message"></a>
</div>
<div id="some-text"><?php include "script.php" ?></div>
<script>
    //здесь мы не даём пользователю ввести в поле для Y ввести не те данные
    function onlyDigits() {
        this.value = this.value.replace(/[^\d\,\-]/g, "");
        let Y = parseFloat(this.value);
        if (Y) {
            if (Y < -5 || Y > 5)
                this.value = this.value.substr(0,0);
        } else {
            this.value = this.value.substr(0,0);
        }

    }

    /*function onlyDigits() {
        this.value = this.value.replace(/[^\d\,\-]/g, "");//разрешаем ввод только цифр 0-9, запятой и минуса

        if (this.value.lastIndexOf("-") > 0) {//если пользователь вводит тире (минус) не самым первым символом...
            this.value = this.value.substr(0, this.value.lastIndexOf("-"));//то удаляем этот минус
        }

        if (this.value[0] === "-") {//если первый символ это минус (число отрицательно)...
            if (new Set().add("6").add("7").add("8").add("9").has(this.value[1]))
                this.value = this.value.substr(0, 1);
            if (this.value[1] === "5" && this.value[2] !== "") {
                this.value = this.value.substr(0, 2);//то запрещаем вводить число больше 0
            }
            if (this.value.length > 2 && this.value[2] !== ",") this.value = this.value[0] + this.value[1] + "," + this.value[2];//если третий символ введён и он не запятая, то вставляем запятую между вторым и третим символом
            if (this.value.length > 8) this.value = this.value.substr(0, 8);//если количество символов равно 8 (5 знаков после запятой), не даём вводить больше
        } else {//если число положительно (первым введён не минус, а цифра)...
            if (new Set().add("6").add("7").add("8").add("9").has(this.value[0])) {
                this.value = this.value.substr(0, 0)//то эта цифра должна быть от 0 до 5
            }
            if (this.value[0] === "5" && this.value[1] !== "") {
                this.value = this.value.substr(0, 1);//то эта цифра должна быть от 0 до 5
            }

            if (this.value.length > 1 && this.value[1] !== ",") this.value = this.value[0] + "," + this.value[1];//если второй символ введён и он не запятая, то вставляем запятую между первым и вторым символом
            if (this.value.length > 7) this.value = this.value.substr(0, 7);//если количество символов равно 7 (5 знаков после запятой), не даём вводить больше
        }

        if (this.value.match(/,/g) !== null && this.value.match(/,/g).length > 1) {//не даём ввести больше одной запятой
            this.value = this.value.substr(0, this.value.lastIndexOf(","));
        }
        if (parseFloat(this.value))

            if (this.value.match(/-/g) && this.value.match(/-/g).length > 1) {//не даём ввести больше одного минуса
                this.value = this.value.substr(0, this.value.lastIndexOf("-"));
            }
    }*/

    //здесь мы выводим выбранное значени R
    $("#image_R").hide();
    $("#errorFields").hide();
    $(".setR").click(function () {
        $("#selectedR").html(this.value);
        $("#image_R").show();
    });
    $("#resetForm").click(function () {
        $("#image_R").hide();
        $("#errorFields").hide();
    });

    // function centre_on_pn() {
    //     document.location.href="#message";
    // }
    // document.getElementsByClassName("submit")[0].addEventListener("click", centre_on_pn);
    document.querySelector(".coordinateY").addEventListener("keyup",onlyDigits);
    document.querySelector("input.coordinateY").addEventListener("keyup", function(event) {
        event.preventDefault();
        if (event.keyCode === 13) {
            CheckPoints();
        }
    });


    function CheckPoints() {
        function validate(R, X, Y) {
            return (!isNaN(parseFloat(R)) && !isNaN(parseFloat(X)) && !isNaN(parseFloat(Y)))
        }

        $("#errorFields").hide();
        let R = $("#selectedR").html();
        let X = $("#selectedX").val();
        let Y = $(".coordinateY").val();
        let body = "";
        if (validate(R, X, Y)) {
            body = "?" + "R=" + R + "&X=" + X + "&Y=" + Y;
            fetch("script.php" + body)
                .then(function (request) {
                    if (request.status === 501) {
                        $("#poshel_nahuy").show();
                    }
                    return request.text();
                })
                .then(result => {
                    $("#some-text").html(result);
                });
        } else {
            $("#errorFields").show();
        }

    }
</script>

</body>
</html>
