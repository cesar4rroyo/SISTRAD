@extends("theme.$theme.layout")

@section('content')
<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Nacionalidad</div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <a href="{{ route('create_nacionalidad') }}" class="btn btn-outline-success"
                                title="Agregar nueva Nacionalidad">
                                <i class="fa fa-plus" aria-hidden="true"></i> Agregar nuevo
                            </a>
                        </div>                        
                    </div>
                    <div class="row mb-2" id="btnsReport">
                    <div class="table-responsive mt-4">
                        <table class="table text-center table-hover" id="nacionalidad" class="display"
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>País</th>
                                    <th>Acciones</th>                                  
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>País</th>  
                                    <th>Acciones</th>
                                </tr>
                            </tfoot>
                        </table>

                        {{-- <table class="table table-hover text-center" id="tabla-data">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nacionalidad as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nombre }}</td>
                                    <td>
                                        <a href="{{ route('show_nacionalidad', $item->id)  }}"
                                            title="Ver nacionalidad"><button class="btn btn-outline-secondary btn-sm"><i
                                                    class="fa fa-eye" aria-hidden="true"></i>
                                            </button></a>
                                        <a href="{{ route('edit_nacionalidad', $item->id ) }}"
                                            title="Editar nacionalidad"><button
                                                class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"
                                                    aria-hidden="true"></i>
                                            </button></a>

                                        <form class="form-eliminar" method="POST"
                                            action="{{route('destroy_nacionalidad', $item->id)}}" accept-charset="UTF-8"
                                            style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                title="Eliminar nacionalidad"><i class="fas fa-trash-alt"
                                                    aria-hidden="true"></i> </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table> --}}
                        
                    </div>
                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        fetch("{{route('get_nacionalidad')}}", {
                method:'GET',
            }).then(res=>res.json())
            .then((data)=>{                
                $('#btnsReport').show();
                var table= $('#nacionalidad').DataTable( {
                        "language": {
                            "decimal": "",
                            "emptyTable": "No hay información",
                            "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                            "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                            "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                            "infoPostFix": "",
                            "thousands": ",",
                            "lengthMenu": "Mostrar _MENU_ Entradas",
                            "loadingRecords": "Cargando...",
                            "processing": "Procesando...",
                            "search": "Buscar:",
                            "zeroRecords": "Sin resultados encontrados",
                            "paginate": {
                                "first": "Primero",
                                "last": "Ultimo",
                                "next": "Siguiente",
                                "previous": "Anterior"
                            },
                            "buttons":{
                                'excel':'Exportar a Excel',
                                'pdf':'Exportart a PDF',
                                'print':'Imprimir'
                            }
                        },
                        "processing": true,
                        'data': data.data,
                        "columns": [                          
                            
                            { "data": "numero" },
                            { "data": "nombre" },
                            { "data": "acciones" },
                                               
                        ],
                        dom: 'lBfrtip',
                        buttons: [
                            'excel', 'pdf', 'print'
                        ],
                        "lengthMenu": [10,25,50,100],                   
                        "bDestroy": true,
                        "columnDefs":[
                            {
                                "targets": -1,
                                "data": "id",
                                "defaultContent": 
                                "<button title='Ver' class='btn btn-outline-secondary btn-sm ver'><i class='fa fa-eye'></i></button><button title='Editar' class='btn btn-outline-primary btn-sm editar'><i class='fas fa-edit'></i></button><button class='btn btn-outline-danger btn-sm eliminar' title='Eliminar'><i class='fas fa-trash-alt'></i></button>"                           
                            },                           
                        ],
                    });
                    $('#nacionalidad tbody').on( 'click', 'button', function () { 
                        var action = this.className;
                        var data = table.row( $(this).parents('tr') ).data();
                        var id = data.id;
                        if (action.includes('ver')){
                            alert( 'ver: '+id);
                        }else if(action.includes('editar')){
                            alert( 'editar: '+id);
                        }else if(action.includes('eliminar')){
                            alert('eliminar'+id);
                        }
                      
                    });
            })
            .catch(e=>console.log(e));
    });
</script>


