<?php

    $dateTime = DateTime::createFromFormat("Y-m-d", "2018-01-01");
    $timezone = new DateTimeZone("America/Lima");
    $dateTime->setTimezone($timezone);
    $begin2018 = $dateTime->format('Y-m-d');

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Osinermin</title>
    <link rel="shortcut icon" href="http://www.osinergmin.gob.pe/_catalogs/masterpage/starter/images/osinerg.ico" type="image/vnd.microsoft.icon" id="favicon" />

    <link href="https://getbootstrap.com/docs/3.4/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://getbootstrap.com/docs/3.4/dist/js/bootstrap.min.js"></script>

    <style>
        .bs-example {
            margin-right: 0;
            margin-left: 0;
            background-color: #fff;
            border-color: #ddd;
            border-width: 1px;
            border-radius: 4px 4px 0 0;
            -webkit-box-shadow: none;
            box-shadow: none;
        }
    </style>

    <script type="text/javascript">

        $( document ).ready(function() {

            function miliSecondsConvert(hrs, min, sec)
            {
                return ((hrs * 60 * 60 + min * 60 + sec) * 1000);
            }

            function loopDates(loop, end, miliseconds) {
                setTimeout(function () {

                    $strFull = loop.getFullYear() + "-" + parseInt(loop.getMonth() + 1) + "-" + loop.getDate();
                    $str = loop.getTime();

                    console.log("loopDates::: " + $str + " -- loopDatesFull::: " + $strFull);

                    window.open("process.php?date=" + $str, "_blank");

                    if (loop < end) {

                        var newDate = loop.setDate(loop.getDate() + 1);
                        loop = new Date(newDate);

                        loopDates(loop, end, miliseconds);
                    } else {
                        console.log("FIN DEL LOOP");

                        $("div.alert button.btn-warning").hide();
                        $("div.alert button.btn-success").show();
                    }

                }, miliseconds)
            }

            $("form").submit(function(e) {

                e.preventDefault();

                if (!confirm("Esta seguro ?")) {
                    return false;
                }

                $sleepTime = $("input[name=sleepTime]").val();

                $fechaStart = $("input[name=fechaStart]").val();
                $fechaStart = $fechaStart.replace(/-/g, '\/').replace(/T.+/, '');

                $fechaEnd = $("input[name=fechaEnd]").val();
                $fechaEnd = $fechaEnd.replace(/-/g, '\/').replace(/T.+/, '');

                console.dir($fechaStart + " --- " + $fechaEnd);

                if (new Date($fechaStart).getTime() > new Date($fechaEnd).getTime()) {
                    alert("La fecha de INICIO debe de ser menor a la fecha FIN");
                    return false;
                }

                var start = new Date($fechaStart);
                var end = new Date($fechaEnd);
                var loop = new Date(start);

                $("div.alert button.btn-warning").show();
                $("div.alert button.btn-success").hide();

                var miliseconds = miliSecondsConvert(0, $sleepTime, 0);

                loopDates(loop, end, miliseconds);

            });
        });

    </script>

</head>

<body>

<br>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="bs-example" data-example-id="basic-forms">

                <div class="alert alert-info" role="alert">
                    <strong>Formulario</strong> de generacion de EXCEL
                    <button class="btn btn-xs btn-warning" style="display: none">
                        <span class="glyphicon glyphicon-fire" aria-hidden="true"></span> Inicio del proceso
                    </button>
                    <button class="btn btn-xs btn-success" style="display: none">
                        <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Fin del proceso
                    </button>
                </div>

                <form method="post">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    Fecha Start
                                </label>
                                <input
                                    type="date"
                                    name="fechaStart"
                                    class="form-control"
                                    value="<?php echo $begin2018 ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">
                                    <span class="glyphicon glyphicon-superscript" aria-hidden="true"></span>
                                    Sleep time MINUTES
                                </label>
                                <input
                                    type="number"
                                    name="sleepTime"
                                    class="form-control"
                                    value="1"
                                    required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputPassword1">
                                    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                    Fecha End
                                </label>
                                <input
                                    type="date"
                                    name="fechaEnd"
                                    class="form-control"
                                    value="<?php echo $begin2018 ?>"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">

                            </div>
                        </div>
                    </div>

                    <div class="form-group pull-right">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

</html>