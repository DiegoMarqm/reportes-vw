<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte PDF</title>
    <style>
        @page {
            margin: 0;
        }

        @font-face {
            font-family: "VWHead-Bold";
            src: url('{{ storage_path('fonts/VWHead-Bold.ttf') }}') format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: "VWHead-Light";
            src: url('{{ storage_path('fonts/VWHeadWeb-Light1.ttf') }}') format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: "VWTex-Regular";
            src: url('{{ storage_path('fonts/VWText-Regular.ttf') }}') format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        html {
            margin: 0;
        }

        body {
            font-family: "VWTex-Regular", sans-serif;
            /* border: #b8b8b8 1px solid; */
            /* border-left: #b8b8b8 1px solid;
            border-right: #b8b8b8 1px solid; */
            padding: 25px 30px;
            margin: 0.2cm 0.4cm 0.2cm 0.3cm;
            /* width: 100%; */
        }

        .page-break {
            page-break-after: always;
        }

        .bold {
            font-family: "VWHead-Bold", sans-serif;
            font-weight: normal;
        }

        .light {
            font-family: "VWHead-Light", sans-serif;
            font-weight: normal;
        }

        .titulo {
            position: relative;
            margin-bottom: 20px;
            height: 20px;
            bottom: 50px;
        }

        .titulo h1 {
            text-align: center;
            color: rgb(0, 30, 80);
            font-size: 22px;
            margin: 0;
            padding-top: 15px;
            position: absolute;
            width: 100%;
            top: 40px;
            transform: translateY(-50%);
        }

        .titulo img {
            position: absolute;
            top: 30px;
            right: 10px;
            width: 50px;
            height: auto;
        }

        .seccionuno {
            position: relative;
            padding-bottom: 15px;
            /* margin-bottom: 10px; */
            height: 50px;
            /* border: 1px solid #ccc; */
            width: 100%;

        }

        .departamento {
            /* text-align: start; */
            position: absolute;
            color: rgb(0, 30, 80);
            font-size: 10pt;
            margin: 0;
            top: 0;
            border: 1px solid #ccc;
            width: 70%;
            height: 100%;

        }

        .calificacion {
            text-align: start;
            position: absolute;
            color: rgb(0, 30, 80);
            font-size: 10pt;
            margin: 0;
            top: 0;
            right: 0;
            border: 1px solid #ccc;
            width: 28%;
            height: 100%;

        }

        .departamento p {
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .seccionuno p {
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;

        }

        .departamento label {
            /* display: inline-block; */
            /* padding-left: 20px; */
            /* padding-bottom: 5px; */
            /* margin-right: 15px; */
            font-size: 12px;
            vertical-align: middle;

        }

        .departamento input[type="radio"] {

            padding-left: 20px;
            vertical-align: middle;
        }

        .calificacion input[type="text"] {
            font-size: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            display: block;
            margin: 0 auto;
            text-align: center;
            background: #abdade;
        }


        .secciondos {
            position: relative;
            padding-bottom: 15px;
            /* margin-bottom: 20px; */
            height: 25px;
            font-size: 10px;
            color: rgb(0, 30, 80);
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            /* Align items vertically center */
            /* border: 1px solid #ccc; */
            width: 100%;
        }

        .secciondos p {
            text-align: right;
            font-weight: bold;
            margin-bottom: 5px;
            /* border: 1px solid #ccc; */
            display: inline-block;
            width: 100px;
            align-self: center;
            /* Align individual p elements vertically center */
        }

        .secciondos input[type="date"] {
            font-size: 10px;
            /* border: 1px solid #ccc; */
            border-radius: 2px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            margin-right: 30px;
            text-align: center;
            background: #abdade;
            display: inline-block;
            width: 80px;
            border: 1px solid #ccc;
            height: 12px;

        }

        .secciontres {
            position: relative;
            padding-bottom: 15px;
            /* margin-bottom: 10px; */
            height: 50px;
            border: 1px solid #ccc;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;

            border-radius: 1px;
            width: 100%;
        }

        .secciontres p {
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 11px;
            padding-left: 10px;
        }



        .detectoQueja {
            text-align: start;
            position: absolute;
            color: rgb(0, 30, 80);
            font-size: 10pt;
            bottom: 10px;
            /* margin: 0; */
            /* top: 0; */
            /* border: 1px solid #ccc; */
            width: 100%;
            height: 100%;
            display: inline-block;

        }

        .detectoQueja label {
            display: inline-block;
            /* position: relative; */
            /* padding-left: 20px; */
            padding-bottom: 5px;
            /* margin-right: 15px; */

            font-size: 10px;
            vertical-align: middle;
        }

        .detectoQueja input[type="radio"] {
            padding-left: 20px;
            position: relative;
            text-align: center;
            position: relative;
            vertical-align: middle;
            line-height: 10px;
            text-align: center;

        }


        .detectoQueja input[type='text'] {
            font-size: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
            /* margin: 0 auto; */
            text-align: center;
            background: #abdade;
            width: 100px;
            height: 12px;
            line-height: 12px;
        }

        .seccioncuatro {
            position: relative;
            padding-bottom: 15px;
            /* margin-bottom: 10px; */
            height: 70px;
            border: 1px solid #ccc;
            margin-top: 1px;
            border-radius: 1px;
            width: 100%;
        }

        .seccioncuatro p {
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .datos {
            font: size 10pt;
            position: relative;
            justify-content: space-between;
            display: flex;
            flex-wrap: wrap;
        }

        .datos label {
            color: rgb(0, 30, 80);
            display: inline-block;
            width: auto;
            /* margin-right: 10px; */
            font-size: 10pt;
        }

        .datos input[type="text"] {
            font-size: 9pt;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
            margin: 0 auto;
            text-align: center;
            background: #abdade;
            color: #001E50;
            width: 300px;
            height: 12px;
            line-height: 12px;
            /* This will center the text vertically */
        }

        .seccioncinco {
            position: relative;
            padding-bottom: 15px;
            /* margin-bottom: 10px; */
            height: 90px;
            border: 1px solid #ccc;
            margin-top: 1px;
            border-radius: 1px;
            width: 100%;
        }

        .seccioncinco p {
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .datosIdentificacion {
            font: size 10pt;
            position: relative;
            justify-content: space-between;
            display: flex;
            flex-wrap: wrap;
        }

        .datosIdentificacion label {
            color: rgb(0, 30, 80);
            display: inline-block;
            width: auto;
            /* margin-right: 10px; */
            font-size: 10pt;
        }

        .datosIdentificacion input[type="text"] {
            font-size: 9pt;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            display: inline-block;
            margin: 0 auto;
            text-align: center;
            background: #abdade;
            color: #001E50;
            /* width: 300px; */
            height: 12px;
            line-height: 12px;
            /* This will center the text vertically */
        }

        .seccionseis {
            position: relative;
            padding-bottom: 15px;
            height: 190px;
            /* border: 1px solid #ccc; */
            margin-top: 1px;
            border-radius: 1px;
            display: flex;
            justify-content: space-between;
        }

        .seccionseis p {
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        . .seccionseis small {
            color: #b8b8b8;
        }

        .datosReclamacionUno {
            position: relative;
            font: size 9pt;
            display: flex;
            flex-wrap: wrap;
            width: 49%;
            border: 1px solid #ccc;
        }

        .areareclamacion {
            border: 1px solid #ccc;
            background: #abdade;
            margin: 5px;
            height: 40mm;
            font-size: 9pt;
            color: #001E50;
            /* font-family: "VWHead-Light"; */

        }

        .areareclamacion p {
            color: #0d2753;
            font-size: 9pt;
            /* font-weight: bold; */
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .datosReclamacionDos {
            position: relative;
            font: size 10pt;
            /* bottom: auto; */
            /* justify-content: space-between; */
            display: flex;
            flex-wrap: wrap;
            top: -195px;
            width: 50%;
            border: 1px solid #ccc;
            left: 50%;
            bottom: 205px;
            height: 193px;
        }

        .tipoReclamacion label {
            display: inline-block;
            padding-bottom: 5px;
            margin-right: 55px;
            font-size: 10px;
            vertical-align: middle;
            /* Align text vertically with the center of the radio button */
        }

        .tipoReclamacion input[type="radio"] {
            padding-left: 20px;
            text-align: center;
            position: relative;
            line-height: 10px;
            vertical-align: middle;
            /* border: 1px solid #ccc; */
            color: rgb(0, 30, 80);

            /* Align radio button vertically with the text */
        }

        .otroReclamacion {
            display: flex;
            align-items: center;
            margin-left: 30px;
            height: 20px;

        }

        .otroReclamacion label {
            margin-right: 10px;
            font-size: 10px;
        }

        .otroReclamacion input[type="text"] {
            flex: 1;
            font-size: 10px;
            text-align: center;
            /* vertical-align: center; */
            /* line-height: 10pt; */

            border: 1px solid #ccc;
            border-radius: 4px;
            color: rgb(0, 30, 80);
            box-sizing: border-box;
            /* display: inline-block; */
            /* margin: 0 auto; */
            /* text-align: center; */
            background: #abdade;
            /* width: 300px; */
            /* height: 12px; */
            line-height: 10px;
        }

        .seccionsiete {

            position: relative;
            padding-bottom: 15px;
            height: 200px;
            bottom: 10px;
            /* border: 1px solid #ccc; */
            margin-top: 1px;
            border-radius: 1px;
            display: flex;
            justify-content: space-between;
        }

        .seccionsiete p {
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }


        .causaRaiz {
            position: relative;
            font: size 10pt;
            display: flex;
            flex-wrap: wrap;
            width: 49%;
            border: 1px solid #ccc;
            /* bottom: 205px; */
            height: 203px;
            ;

        }

        .medidas {
            position: relative;
            font: size 10pt;
            /* bottom: auto; */
            /* justify-content: space-between; */
            display: flex;
            flex-wrap: wrap;
            width: 50%;
            border: 1px solid #ccc;
            left: 50%;
            bottom: 205px;
            height: 203px;
        }



        .medidas table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 10px;
            font-size: 8pt;
            height: 10pt;
            color: #747474
        }

        .medidas th {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            background: #d2d9da;
            height: 10px;
        }

        .infomedida table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 10px;
            font-size: 8pt;
            height: 10pt;
            color: #747474
        }

        .infoMedidas th {
            border: 1px solid #ccc;
            padding: 5px;
            text-align: center;
            background: #d2d9da;
            height: 10px;
        }

        .pescado {
            /* border: 1px solid #ccc; */
            /* background: #abdade; */
            /* margin: -6px; */
            margin-right: 10px margin-left: 10px;
            margin-top: -4px;
            margin-bottom: -4px;
            /* height: 40mm; */
        }

        .pescado div {
            height: 30px;
            /* Ajusta esta altura según tus necesidades */
        }


        .seccionocho {
            /* position: relative; */
            /* border: 1px solid #ccc; */
            height: 28px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: row;
            /* text-align: center; */
        }

        .seccionocho p {
            display: inline-flex;
            font-size: 8pt;
            color: #001E50;
            /* font-weight: bold; */
            margin-bottom: 5px;
            padding-left: 10px;
            /* border: 1px solid #ccc; */
            width: 60%;
        }

        .seccionocho label {
            display: inline-flex;
            align-items: center;
            margin-right: 50px;
            color: #001E50;

        }

        .seccionocho input[type="radio"] {
            margin-right: 5px;
            width: 10px;
            color: #001E50;
        }

        .seccionnueve {
            height: 80px;
            /* border: 1px solid #ccc; */
            margin-top: 1px;
            border-radius: 1px;
        }

        .seccionnueve p {
            color: rgb(0, 30, 80);
            font-size: 9pt;
            /* font-weight: bold; */
            margin-bottom: 5px;
            padding-left: 4px;
        }

        .datosnueve {
            font: size 9pt;
            /* position: relative; */
            justify-content: space-between;
            display: flex;
            flex-wrap: wrap;
        }

        .solucion {
            position: relative;
            background: #abdade;
            height: 50px;
            bottom: 10px;
        }

        .secciondiez {
            position: relative;
            padding-bottom: 15px;
            height: 68px;
            /* border: 1px solid #ccc; */
            margin-top: 1px;
            border-radius: 1px;
            display: flex;
            justify-content: space-between;
        }

        .secciondiez p {
            position: relative;
            /* bottom: 10px; */
            text-align: center;
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .personal {
            position: relative;
            font: size 10pt;
            display: flex;
            flex-wrap: wrap;
            width: 79%;
            /* border: 1px solid #ccc; */
            height: 50px;
        }

        .nomfecha {
            /* background-color: #abdade; */
            display: flex;
        }

        .nom {
            position: relative;
            /* background-color: #b8b8b8; */
            width: 300px;
            left: 1px;
            bottom: 12px
        }

        .pnombre {
            position: relative;
            /* text-align: start; */
            right: 120px;
            font-size: 10pt;
        }

        .pfecha {
            position: relative;
            /* text-align: start; */
            right: 105px;
            font-size: 10pt;
        }

        .fecha {
            position: relative;
            /* display: inline-block; */
            /* background-color: #778090; */
            left: 310px;
            bottom: 90px;
            width: 260px;
        }

        .firma {
            position: relative;
            font: size 10pt;
            /* bottom: auto; */
            /* justify-content: space-between; */
            display: flex;
            flex-wrap: wrap;
            width: 20%;
            /* border: 1px solid #ccc; */
            left: 80%;
            bottom: 60px;
            height: 75px;
        }

        .firma p {
            position: relative;
            bottom: 15px;
            right: 54px;
            text-align: center;
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .areafirma {
            position: relative;
            background-color: #abdade;
            height: 57px;
            bottom: 15px;
        }

        .secciononce {
            /* background-color: #f0f0f0; */
            position: relative;
            padding-bottom: 15px;
            height: 20px;
            /* border: 1px solid #ccc; */
            margin-top: 1px;
            border-radius: 1px;
            display: flex;
            justify-content: space-between;
        }

        .garea {
            display: inline-block;
            position: relative;
            /* background-color: #abdade; */
            height: 1px;
            margin-left: 5%;
            width: 25%;
            border-top: 1pt solid #001E50;
            top: 5px;
        }

        .garea p {
            position: relative;
            bottom: 13px;
            font-size: 8pt;
            margin-left: 30%;
        }

        .cexp {
            display: inline-block;
            position: relative;
            /* background-color: #abdade; */
            height: 1px;
            margin-left: 5%;
            width: 25%;
            border-top: 1pt solid #001E50;
            top: 5px;
        }

        .cexp p {
            position: relative;
            bottom: 13px;
            font-size: 8pt;
            margin-left: 20%;
        }

        .crm {
            display: inline-block;
            position: relative;
            /* background-color: #abdade; */
            height: 1px;
            margin-left: 5%;
            width: 25%;
            border-top: 1pt solid #001E50;
            top: 5px;
        }

        .crm p {
            position: relative;
            bottom: 13px;
            font-size: 8pt;
            margin-left: 40%;
        }

        .secciondoce {
            position: relative;
            padding-bottom: 15px;
            height: 68px;
            /* border: 1px solid #ccc; */
            margin-top: 1px;
            border-radius: 1px;
            display: flex;
            justify-content: space-between;
        }

        .secciondoce p {
            position: relative;
            /* bottom: 10px; */
            text-align: center;
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .personalSeg {
            position: relative;
            font: size 9pt;
            display: flex;
            flex-wrap: wrap;
            width: 79%;
            /* border: 1px solid #ccc; */
            height: 50px;
        }

        .nomfechaSeg {
            /* background-color: #abdade; */
            display: flex;
            font-size: 9pt;
        }

        .nomSeg {
            position: relative;
            /* background-color: #b8b8b8; */
            width: 300px;
            left: 1px;
            bottom: 12px
        }

        .pnombreSeg {
            position: relative;
            /* text-align: start; */
            /* margin-right: 10px; */
            right: 120px;
            font-size: 9pt;
        }

        .pfechaSeg {
            position: relative;
            /* text-align: start; */
            right: 105px;
            font-size: 10pt;
        }

        .fechaSeg {
            position: relative;
            /* display: inline-block; */
            /* background-color: #778090; */
            left: 310px;
            bottom: 90px;
            width: 260px;
            font-size: 9pt;
        }

        .firmaSeg {
            position: relative;
            font: size 10pt;
            /* bottom: auto; */
            /* justify-content: space-between; */
            display: flex;
            flex-wrap: wrap;
            width: 20%;
            /* border: 1px solid #ccc; */
            left: 80%;
            bottom: 60px;
            height: 75px;
        }

        .firmaSeg p {
            position: relative;
            bottom: 15px;
            right: 54px;
            text-align: center;
            color: rgb(0, 30, 80);
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .areafirmaSeg {
            position: relative;
            background-color: #abdade;
            height: 57px;
            bottom: 15px;
        }

        .secciontrece {
            height: 80px;
            /* border: 1px solid #ccc; */
            margin-top: 1px;
            border-radius: 1px;
        }

        .secciontrece p {
            color: rgb(0, 30, 80);
            font-size: 9pt;
            /* font-weight: bold; */
            margin-bottom: 5px;
            padding-left: 10px;
        }

        .datostrece {
            font: size 9pt;
            /* position: relative; */
            justify-content: space-between;
            display: flex;
            flex-wrap: wrap;
        }

        .soluciontrece {
            position: relative;
            background: #abdade;
            height: 50px;
            bottom: 10px;
        }
    </style>
</head>

<body>
    <div class="titulo">
        <h1 class="bold">REGISTRO DE QUEJAS</h1>
        <img src="{{ public_path('images/logovw.jpg') }}" alt="Logo VW">
    </div>
    <div class="seccionuno">
        <div class="departamento">
            <p>Departamento:</p>
            <input type="radio" name="departamento" value="Ventas"
                {{ $reporte->departamento == 'Ventas' ? 'checked' : '' }}>
            <label>Ventas</label>
            <label>
                <input type="radio" name="departamento" value="Servicio"
                    {{ $reporte->departamento == 'Servicio' ? 'checked' : '' }}> Servicio
            </label>
            <label>
                <input type="radio" name="departamento" value="Refacciones"
                    {{ $reporte->departamento == 'Refacciones' ? 'checked' : '' }}> Refacciones
            </label>
            <label>
                <input type="radio" name="departamento" value="Seminuevos"
                    {{ $reporte->departamento == 'Seminuevos' ? 'checked' : '' }}> Seminuevos
            </label>
        </div>

        <div class="calificacion">
            <p>Calificación:</p>
            <input type="text" name="calificacion" id="calificacion"
                value="{{ $reporte->calificacion == 1 ? '1 Estrella' : $reporte->calificacion . ' Estrellas' }}">
        </div>
    </div>
    <div class="secciondos">
        <p style="padding-left: 15px;">Fecha de la queja: </p>
        <input type="date" name="fechaQueja" id="fechaQueja" value="{{ $reporte->fechaQueja }}">
        <p style="position: relative; top: 10px">Fecha de la Entrega de la unidad </p>
        <input type="date" name="fechaEntrega" id="fechaEntrega" value="{{ $reporte->fechaEntrega }}">
        <p style="position: relative; top: 10px">Fecha de ingreso: <br> <small>(solo si aplica)</small> </p>
        <input type="date" name="fechaIngreso" id="fechaIngreso" value="{{ $reporte->fechaIngreso }}">
    </div>
    <div class="secciontres">
        <div class="detectoQueja">
            <p>Forma en que se detectó la queja:</p>

            <label>
                <input type="radio" name="decQueja" value="Prescencial"
                    {{ $reporte->formaDeteccion == 'Presencial' ? 'checked' : '' }}>Presencial
            </label>
            <label>
                <input type="radio" name="decQueja" value="HotAlert"
                    {{ $reporte->formaDeteccion == 'HotAlert' ? 'checked' : '' }}> Hot Alert
            </label>
            <label>
                <input type="radio" name="decQueja" value="RedesSociales"
                    {{ $reporte->formaDeteccion == 'Redes sociales' ? 'checked' : '' }}> Redes Sociales
            </label>
            {{-- @if (!empty($reporte->redSocial)) --}}
            <label>
                <input type="text" name="redsocial" id="redsocial" value="{{ $reporte->redSocial }}"
                    style="height: 10px">
            </label>
            {{-- @endif --}}
            <label>
                <input type="radio" name="decQueja" value="Llamadaseguimiento"
                    {{ $reporte->formaDeteccion == 'Llamada de seguimiento' ? 'checked' : '' }}> Llamada de seguimiento
            </label>

            <label>
                <input type="radio" name="decQueja" value="E-mail"
                    {{ $reporte->formaDeteccion == 'E-mail' ? 'checked' : '' }}> E-mail
            </label>

            <label>
                <input type="radio" name="decQueja" value="Profeco"
                    {{ $reporte->formaDeteccion == 'Profeco' ? 'checked' : '' }}> Profeco
            </label>
        </div>
    </div>
    <div class="seccioncuatro">

        <div style="position: relative; bottom: 10px">
            <div class="datos">
                <p>Datos del cliente:</p>
                <div class="nombre">
                    <label for="" style="padding-left: 10px;">Nombre del cliente:</label>
                    <input type="text" value="{{ $reporte->nomCliente }}">
                    <label for="">Celular: </label>
                    <input type="text" value="{{ $reporte->celularCliente }}" style="width: 225px">
                </div>
            </div>
            <div class="datos">
                <div class="nombre">
                    <label for="" style="padding-left: 10px;">E-mail: </label>
                    <input type="text" value="{{ $reporte->emailCliente }}" style="width: 371px;">
                </div>
            </div>
        </div>
    </div>
    <div class="seccioncinco">
        <div style="position: relative; bottom: 10px">
            <div class="datosIdentificacion">
                <p>Datos de Identificación:</p>
                <div class="nombre">

                    <label for="" style="padding-left: 10px;">Asesor/Ejecutivo: </label>
                    <input type="text" value="{{ $reporte->asesor }}" style="width: 600px;">
                </div>
            </div>
            <div class="datosIdentificacion">
                <div class="nombre">
                    <label for="" style="padding-left: 10px;">Tipo/Modelo:</label>
                    <input type="text" value="{{ $reporte->tipoModelo }}" style="width: 170px;">
                    <label for="">Placas: </label>
                    <input type="text" value="{{ $reporte->placas }}" style="width: 180px;">
                    <label for="">Color: </label>
                    <input type="text" value="{{ $reporte->color }}" style="width: 170px;">
                </div>
            </div>

            <div class="datosIdentificacion">
                <div class="nombre">
                    <label for="" style="padding-left: 10px;">No. Orden::</label>
                    <input type="text" value="{{ $reporte->noOrden }}" style="width: 140px;">
                    <label for="">No. de VIN: </label>
                    <input type="text" value="{{ $reporte->vin }}" style="width: 180px;">
                    <label for="">Técnico: </label>
                    <input type="text" value="{{ $reporte->tecnico }}" style="width: 170px;">
                </div>
            </div>
        </div>
    </div>
    <div class="seccionseis">
        <div>
            <div class="datosReclamacionUno">
                <p>Reclamación: <small style="font-style: italic">Describe la reclamación del cliente</small></p>
                <div class="areareclamacion">
                    <p>{{ $reporte->reclamacion }}</p>
                </div>
            </div>
            <div class="datosReclamacionDos">
                <p>Tipo Reclamación: <small style="font-style: italic">Marca con una (X)</small></p>
                <div class="tipoReclamacion">
                    <div style="margin-left: 10px;">
                        <div>
                            <input type="radio" name="tipoReclamacion" value="Garantia"
                                {{ $reporte->tipoReclamacion == 'Reparacion' ? 'checked' : '' }}>
                            <label for="">Reparación</label> <br>
                            <input type="radio" name="tipoReclamacion" value="Seguimiento"
                                {{ $reporte->tipoReclamacion == 'Seguimiento' ? 'checked' : '' }}>
                            <label for="">Seguimiento</label> <br>
                            <input type="radio" name="tipoReclamacion" value="Falla Refacciones"
                                {{ $reporte->tipoReclamacion == 'Falla Refacciones' ? 'checked' : '' }}>
                            <label for="">Falla Refacciones</label> <br>

                            <input type="radio" name="tipoReclamacion" value="Tiempos"
                                {{ $reporte->tipoReclamacion == 'Tiempos' ? 'checked' : '' }}>
                            <label for="">Tiempos</label> <br>

                            <input type="radio" name="tipoReclamacion" value="Otro"
                                {{ $reporte->tipoReclamacion == 'Otro' ? 'checked' : '' }}>
                            <label for="">Otro</label>

                        </div>
                        <div style="position: relative; left: 49%; width: 50%; bottom: 130px">


                            <input type="radio" name="tipoReclamacion" value="Trabajo Que Realiza"
                                {{ $reporte->tipoReclamacion == 'Trabajo que realiza' ? 'checked' : '' }}>
                            <label>Trabajo que realiza</label>
                            <br>

                            <input type="radio" name="tipoReclamacion" value="Daño/Perdida"
                                {{ $reporte->tipoReclamacion == 'Daño/Perdida' ? 'checked' : '' }}>
                            <label for="">Daño/perdida</label>
                            <br>

                            <input type="radio" name="tipoReclamacion" value="Limpieza"
                                {{ $reporte->tipoReclamacion == 'Limpieza' ? 'checked' : '' }}>
                            <label for="">Limpieza</label>
                            <br>

                            <input type="radio" name="tipoReclamacion" value="Explicacion"
                                {{ $reporte->tipoReclamacion == 'Explicacion' ? 'checked' : '' }}>
                            <label for="">Explicación</label>
                            <br>

                            <input type="radio" name="tipoReclamacion" value="Citas"
                                {{ $reporte->tipoReclamacion == 'Citas' ? 'checked' : '' }}>
                            <label for="">Citas</label>

                        </div>
                        <div class="otroReclamacion" style="position: relative; bottom: 80%; width: auto; ">
                            <label for="">¿Cuál?</label>
                            <input type="text" value="{{ $reporte->otroTipoReclamacion }}"
                                style="width: 260px; height: 10px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="seccionsiete">
        <div>
            <div class="causaRaiz">
                <p>Causa - Raíz de la queja</small>
                </p>
                {{-- Div con la gráfica ishikawa --}}
                <div class="pescado">
                    <img src="{{ public_path('images/Problema.jpg') }}" alt="Logo VW"
                        style="width: 340px; height: 160px; margin-left: 10px;">

                    <div style=" position: relative; bottom: 135px; width: 80px; left: -5px;">
                        <p style="font-size: 6pt;">{{ $reporte->causaRaiz['personas'] }}</p>
                    </div>
                    <div style="position: relative; bottom: 177px; width: 80px; left: 91px;">
                        <p style="font-size: 6pt;">{{ $reporte->causaRaiz['proceso'] }}</p>
                    </div>

                    <div style="position: relative; bottom: 221px; width: 80px; left: 187px;">
                        <p style="font-size: 6pt;">{{ $reporte->causaRaiz['equipo'] }}</p>
                    </div>


                    <div style="position: relative; bottom: 200px; width: 80px; left: -5px;">
                        <p style="font-size: 6pt;">{{ $reporte->causaRaiz['material'] }}</p>
                    </div>
                    <div style="position: relative; bottom: 243px; width: 80px; left: 91px;">
                        <p style="font-size: 6pt;">{{ $reporte->causaRaiz['entorno'] }}</p>
                    </div>

                    <div style="position: relative; bottom: 286px; width: 80px; left: 188px;">
                        <p style="font-size: 6pt;">{{ $reporte->causaRaiz['administracion'] }}</p>
                    </div>
                </div>


            </div>

            <div class="medidas">
                <p>Medidas a tomar</p>

                <div style="margin-left: 10px; margin-right: 10px">
                    <table>
                        <th style="width: 120px;">Medida</th>
                        <th style="width: 120px;">Responsable</th>
                        <th style="width: 60px;">Fecha</th>
                    </table>
                </div>


                <div style="">
                    <div style="margin-left: 10px; margin-right: 10px;">

                        @foreach ($reporte->medidas as $medida)
                            <table
                                style="
                                border-collapse: collapse;
                                border-spacing: 0;
                                font-size: 8pt;
                                color: #001E50;
                                ">

                                <td
                                    style="
                                    border: 1px solid #ccc;
                                    text-align: center;
                                    width: 120px;
                                    height: 10px;
                                    background-color: #abdade;">
                                    {{ $medida['medida'] }}</td>
                                <td
                                    style="border: 1px solid #ccc;
                                    text-size: 4pt;
                                    text-align: center;
                                    width: 120px;
                                    height: 10px;
                                    background-color: #abdade;">

                                    {{ $medida['responsable'] }}</td>
                                <td
                                    style="border: 1px solid #ccc;
                                    text-align: center;
                                    width: 60px;
                                    height: 10px;
                                    background-color: #abdade;">
                                    {{ $medida['fecha'] }}</td>
                            </table>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="position: relative; bottom: 10px;">
        <div class="seccionocho">
            <p style="">De acuerdo a este formato y a la información aquí descrita. <strong>¿Procede la
                    queja?</strong></p>
            <input type="radio" name="procede" value="si"
                {{ $reporte->procedeQueja == '1' ? 'checked' : '' }}>
            <label>Si</label>
            <input type="radio" name="procede" value="no"
                {{ $reporte->procedeQueja == '0' ? 'checked' : '' }}>
            <label>No</label>
        </div>
        <div class="seccionnueve">

            <div style="position: relative; bottom: 10px">
                <div class="datosnueve">
                    <p class="bold">¿Qué solución se le dio al cliente?</p>
                    <div class="nombre">
                        <div style="margin-left: 10px; margin-right: 10px;" class="solucion">
                            <p>{{ $reporte->solucion }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="secciondiez">
            <div class="personal">
                <p>Personal que cerro la reclamación:</p>
                <div class="nomfecha">
                    <div class="nom">
                        <p class="pnombre">Nombre:</p>
                        <div
                            style="background-color: #abdade; height: 25px; position: relative; bottom: 15px;">

                            <p style="position: relative; top: 4px; margin-left: 40px; width: 95%; right: 38px; text-align: start;">
                                {{ $reporte->nombreCierre }}</p>
                        </div>
                    </div>
                    <div class="fecha">
                        <p class="pfecha">Fecha:</p>
                        <div
                            style="background-color: #abdade; margin-left: 8px; height: 25px; position: relative; bottom: 15px;">
                            <p style="position: relative; right: 80px; top: 4px;">{{ $reporte->fechaCierre }}</p>
                        </div>
                    </div>

                </div>


            </div>

            <div class="firma">
                <p>Firma:</p>
                <div class="areafirma">

                </div>
            </div>
        </div>
        <div style="height: 10px;">

        </div>
        <div class="secciononce">
            <div class="garea">
                <p>Gerente de Área</p>
            </div>

            <div class="cexp">
                <p>Consultor de Experiencia</p>
            </div>

            <div class="crm">
                <p>CRM</p>
            </div>
        </div>

        <div class="secciondoce">
            <div class="personalSeg">
                <p>Personal que realizó contacto de seguimiento:</p>
                <div class="nomfechaSeg">
                    <div class="nomSeg">
                        <p class="pnombreSeg">Nombre:</p>

                        <div
                            style="background-color: #abdade; height: 25px; position: relative; bottom: 15px;">

                            <p style="position: relative; top: 4px; margin-left: 40px; width: 95%; right: 38px; text-align: start;">
                                {{ $reporte->nombreSeguimiento }}</p>
                        </div>
                    </div>
                    <div class="fechaSeg">
                        <p class="pfechaSeg">Fecha:</p>
                        <div
                            style="background-color: #abdade; margin-left: 8px; height: 25px; position: relative; bottom: 15px;">
                            <p style="position: relative; right: 80px; top: 4px;">{{ $reporte->fechaSeguimiento }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="firmaSeg">
                <p>Firma:</p>
                <div class="areafirmaSeg">
                </div>
            </div>
        </div>

        <div class="secciontrece">
            <div style="position: relative; bottom: 10px">
                <div class="datosnuevetrece">
                    <p class="bold">Comentarios del cliente:</p>
                    <div class="nombretrece">
                        <div style="margin-left: 10px; margin-right: 10px;" class="soluciontrece">
                            <p>{{ $reporte->solucion }} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>




    {{-- <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
            $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
            $pdf->text(270, 890, "Página: " . $PAGE_COUNT, $font, 10);
            ');
        }
    </script> --}}
</body>

</html>
