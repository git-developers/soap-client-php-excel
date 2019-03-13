<?php

    require ("function.php");

    $dateTime = new DateTime('@' . $_GET["date"] / 1000);
    $timezone = new DateTimeZone("America/Lima");
    $dateTime->setTimezone($timezone);

    $exportClass = new exportClass();
    $exportClass->process($dateTime);




