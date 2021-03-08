<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">Búsqueda General</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="entrada-tab" data-toggle="tab" href="#entrada" role="tab" aria-controls="entrada" aria-selected="false">Entrada</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="bandeja-tab" data-toggle="tab" href="#bandeja" role="tab" aria-controls="bandeja" aria-selected="false">Bandeja</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="salida-tab" data-toggle="tab" href="#salida" role="tab" aria-controls="salida" aria-selected="false">Salida</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="archivos-tab" data-toggle="tab" href="#archivos" role="tab" aria-controls="archivos" aria-selected="false">Archivos</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="courier-tab" data-toggle="tab" href="#courier" role="tab" aria-controls="courier" aria-selected="false">Courier</a>
  </li>
</ul>  
<script>   
   document.addEventListener("DOMContentLoaded", function(event) {
    $('#acciones_entrada').hide();
		$('#myTab a').on('click', function(e){
            e.preventDefault();  
            // console.log(e.target.id);
            switch (e.target.id) {
                case 'entrada-tab':
                    $('#modo').val('entrada');
                	  buscar('{{ $entidad }}');
                    break;
                case 'bandeja-tab':
                    $('#modo').val('bandeja');
                	buscar('{{ $entidad }}');
                    break;
                case 'salida-tab':
                    $('#modo').val('salida');
                    buscar('{{ $entidad }}');
                    break;            
                case 'general-tab':
                    $('#modo').val('general');
                    buscar('{{ $entidad }}');
                case 'archivos-tab':
                    $('#modo').val('archivos');
                    buscar('{{ $entidad }}');
                    break;           
                case 'courier-tab':
                    $('#modo').val('courier');
                    buscar('{{ $entidad }}');
                    break;           
                
            }          
        });       
	});
 </script>