<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['historyResults'])) {
    $_SESSION['historyResults'] = array();
}
$message="";
//$for_elected='<img id="poshel_nahuy" name="poshel_nahuy" src="https://pbs.twimg.com/profile_banners/1068586715219140608/1558728333/1500x500">';
//$for_elected = '<script>document.location.href= "#message";</script>';
$for_elected = 'ТЫ МЕНЯ НЕ НАЕБЁШЬ';
if (isset($_GET['X'])&&isset($_GET['Y'])&&isset($_GET['R'])) {
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
    )
    {
//запоминаем время начала работы скрипта
        $start = microtime(true);
//получаем дату и время по москве
        date_default_timezone_set('Europe/Moscow');
        $now = date("d.m.y H:i");
//получаем параметры из index.php

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
        $timeWork = round($timeWork, 7);
//заполняем переменную сессии для отображения всей таблицы
        $result = array($now, $timeWork, $X, $Y, $R, $message);
        array_push($_SESSION['historyResults'], $result);
    }
    else {
        $message = $for_elected;
    }
}
else {
    if (isset($_GET['X']) || isset($_GET['Y']) || isset($_GET['R'])) {
        $message = $for_elected;
    }
}
?>
<!--Выводим сообщение о результате-->
<h3 id="message"> <?php echo $message; ?></h3>
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

