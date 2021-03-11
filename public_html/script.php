<?php
function int_validation($int_){
    $minus = false;
    for ($i=0;$i<strlen($int_);$i++) {
        if ($int_[$i] == '-') {
            if ($minus)
                return false;
            else
                $minus = true;
        } else
            if (!($int_[$i] >= '0' && $int_[$i] <= '9'))
                return false;
    }
    return true;
} // Проверка строки на соответствие целому числу
function double_validation($double_){
    $minus = false;
    $point = false;
    for ($i=0;$i<strlen($double_);$i++) {
        if ($double_[$i] == '-') {
            if ($minus)
                return false;
            else
                $minus = true;
        } else if ($double_[$i] == '.'||$double_[$i] == ',') {
            if ($point)
                return false;
            else
                $point = true;
        } else if (!($double_[$i] >= '0' && $double_[$i] <= '9'))
            return false;
    }
    return true;
} // Проверка строки на соответствие вещественному числу
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['historyResults'])) { // Инициализация массива с результатами
    $_SESSION['historyResults'] = array();
}
$message="НЕ ПЫТАЙСЯ МЕНЯ ОБМАНУТЬ";
//$for_elected = '<script>document.location.href= "#message";</script>';
//$for_elected = 'ТЫ МЕНЯ НЕ НАЕБЁШЬ';
if (
    (isset($_GET['X']))&&(int_validation($_GET['X']))&&
    (isset($_GET['R']))&&(int_validation($_GET['R']))&&
    (isset($_GET['Y']))&&(double_validation($_GET['Y']))
    )   // Проверка данных на соответствие формату
{
    $X = (int)$_GET['X'];
    $Y = (double)(str_replace(",",".",$_GET['Y']));
    $R = (int)$_GET['R'];
    if ($X==-0) $X=(int)0;
    if ($R==-0) $R=(int)0;
    if ($Y==-0) $Y=(double)0.0;
    if (
        (gettype($X) == "integer" && $X >= -5 && $X <= 3) &&
        (gettype($R) == "integer" && $R >= 1 && $R <= 5) &&
        (gettype($Y) == "double" && $Y >= -5 && $Y <= 5)
    )   // Проверка данных на соответствие допустимого диапазону
    {
//запоминаем время начала работы скрипта
        $start = microtime(true);
//получаем дату и время по москве
        date_default_timezone_set('Europe/Moscow');
        $now = date("d.m.y H:i");

        if (
            (($Y >= -$R / 2 && $Y <= 0) && ($X >= -$R && $X <= 0)) ||
            ($Y >= 0 && $X >= 0 && $Y + $X <= $R / 2) ||
            ($Y <= 0 && $X >= 0 && $Y * $Y + $X * $X <= $R * $R / 4)
        )
            $message = "Точка входит в область";
        else $message = "Точка не входит в область";
//получаем время окончания работы скрипта
        $finish = microtime(true);
//высчитываем время работы (разницу) и округляем
        $timeWork = $finish - $start;
        $timeWork = round($timeWork, 5);
//заполняем переменную сессии для отображения всей таблицы
        $result = array($now, $timeWork, $X, $Y, $R, $message);
        array_push($_SESSION['historyResults'], $result);
    }
    else $message = $message."<br>(данные выходят из допустимого диапазона)";
}
else {
    if (!(isset($_GET['X']) || isset($_GET['Y']) || isset($_GET['R']))) {
        $message = "";
    } else $message = $message."<br>(неверный формат данных)";
}
?>
<!--Выводим сообщение о результате-->
<h3 id="message"> <?php echo $message; ?></h3>
<!--Итоговая Таблица-->
<div>
    <table class="table">
        <thead>
            <tr>
                <th>Дата и время запроса</th>
                <th>Время выполнения</th>
                <th>Координата X</th>
                <th>Координата Y</th>
                <th>Параметр R</th>
                <th>Результат</th>
            </tr>
        </thead>
        <tbody>
        <?php
        for ($m=0;$m<sizeof($_SESSION['historyResults']);$m++){
            echo "<tr>";
            echo "<td>".$_SESSION['historyResults'][$m][0]."</td>";
            echo "<td>".$_SESSION['historyResults'][$m][1]."</td>";
            echo "<td>".$_SESSION['historyResults'][$m][2]."</td>";
            echo "<td>".$_SESSION['historyResults'][$m][3]."</td>";
            echo "<td>".$_SESSION['historyResults'][$m][4]."</td>";
            echo "<td>".$_SESSION['historyResults'][$m][5]."</td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>

