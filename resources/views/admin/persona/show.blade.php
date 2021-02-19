@extends("theme.$theme.layout")

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">PersonaL {{ $persona->id }}</div>
                <div class="card-body">
                    <a href="{{ route('persona') }}" title="Regresar"><button
                            class="btn btn-outline-secondary btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                            Regresar</button></a>
                    <br />
                    <br />
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <td>{{ $persona->id }}</td>
                                </tr>
                                <tr>
                                    <th> DNI </th>
                                    <td> {{ $persona->dni }} </td>
                                </tr>
                                <tr>
                                    <th> Nombres </th>
                                    <td> {{ $persona->nombres }} </td>
                                </tr>
                                <tr>
                                    <th> Apellido Paterno </th>
                                    <td> {{ $persona->apellidopaterno }} </td>
                                </tr>
                                <tr>
                                    <th> Apellido Materno </th>
                                    <td> {{ $persona->apellidomaterno }} </td>
                                </tr>
                                <tr>
                                    <th>Roles</th>
                                    <td>
                                        @foreach ($persona->roles as $rol)
                                        {{$loop->last ? $rol->descripcion : $rol->descripcion . ', '}}
                                        @endforeach
                                    </td>
                                </tr>  
                                <tr>
                                    <th> Area </th>
                                    <td> {{ $persona->area->descripcion }} </td>
                                </tr>
                                <tr>
                                    <th> Cargo </th>
                                    <td> {{ $persona->cargo->descripcion }} </td>
                                </tr>                             
                                <tr>
                                    <th> Dirección </th>
                                    <td> {{ $persona->direccion }} </td>
                                </tr>                              
                                <tr>
                                    <th> Teléfono </th>
                                    <td> {{ $persona->telefono }} </td>
                                </tr>
                                <tr>
                                    <th> Email </th>
                                    <td> {{ $persona->email }} </td>
                                </tr>                                                             
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection