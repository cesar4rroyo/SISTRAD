    <head>
        <style>
            .my-3{
                margin-left:15px;
                margin-right:15px;
            }
            .text-left{
                text-align: left;
            }
            .text-right{
                text-align: right;
            }
            .contacto1 , .contacto2{
                height: 50px;
                width: 50%;
            }
            .text-center{
                text-align: center;
            }
            .footer{
                width: 100%;
                height: 50px;
                background: #05bbf2;
                color: white; 
                display: flex;
            }
            .mt-3{
                margin-top: 15px;
            }
            .d-flex{
                display: flex;
            }
            .header{
                width: 100%;
                height: 150px;
                background: #05bbf2;
            }
            .img-container{
                width: 250px;
                height: 150px;
            }
            .img{
                width: 100%;
                height: 100%;
            }
            .container-titulo{
                height: 150px;
                width:80%;
                text-align: center;
                margin-top: 50px;
            }
            .titulo {
                font-size: 35px;
                color:white;
            }

            p{
                font-size: 20px;
            }

            .c-green{
                color: rgb(24, 154, 24);
            }

            .bold{
                font-weight: bold;
            }
        </style>
    </head>
    <div class="header d-flex">
        <div class="img-container ">
            <img class="img" src="https://www.munijlo.gob.pe/web/images/escudo.jpg" alt="" >
        </div>
        <div class="container-titulo">
            <span class="titulo">REGISTRO DE TRÁMITE MODALIDAD VIRTUAL</span>
        </div>
        <div class="img-container ">
            <img class="img" src="https://www.munijlo.gob.pe/web/images/escudo.jpg" alt="" >
        </div>
    </div>
    <br>
    <div class="text-center">
        <h2>Hola, {{strtoupper($nombre)}}</h2>
        <h3 class="c-green">Tu solicitud de trámite se ha registrado correctamente</h3>
        <p>Puedes consultar su estado haciendo click en el siguiente </p><a href="{{route('consultatramite')}}">enlace</a>
        <p>Número de solicitud : <span class="bold">{{$numero}}</span></p>
    </div>
    <br>
    <div class="footer">
        <div class="contacto1 text-right my-3">
        </div>
        <div class="contacto2 text-left my-3">
        </div>
    </div>


