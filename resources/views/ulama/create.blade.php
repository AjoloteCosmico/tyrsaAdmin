<html>

<head>
    <title>
        ULAMA
    </title>
      <!-- Bootstrap 5.0 -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <!-- Font Awesome 6 Kit LEPER SYSTEMS -->
        <script src="https://kit.fontawesome.com/1bfa36884d.js" crossorigin="anonymous"></script>
        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <!-- Load Source Sans Pro font -->
        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic" rel="stylesheet">
        <!-- Load Nunito font -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Load Roboto font -->
        <link href="http://fonts.googleapis.com/css?family=Roboto:400,300,700&amp;subset=latin,latin-ext" rel="stylesheet">
        <!-- Load Amaranth font -->
        <link href="https://fonts.googleapis.com/css2?family=Amaranth:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

        <!-- DataTables -->
    	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs5/jq-3.3.1/dt-1.10.25/af-2.3.7/b-1.7.1/b-print-1.7.1/cr-1.5.4/date-1.1.0/fc-3.3.3/fh-3.1.9/kt-2.6.2/r-2.2.9/rg-1.1.3/rr-1.2.8/sc-2.0.4/sb-1.1.0/sp-1.3.0/sl-1.3.3/datatables.min.css"/>

        <!-- Select2 -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('vendor/img/ico/apple-touch-icon-144.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('vendor/img/ico/apple-touch-icon-114.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('vendor/img/ico/apple-touch-icon-72.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="57x57" href="{{ asset('vendor/img/ico/apple-touch-icon-57.png') }}">
        <link rel="shortcut icon" href="{{ asset('vendor/img/ico/favicon.ico') }}">

        <!-- My Style -->
        <link href="{{ asset('vendor/mystylesjs/css/datatable_gral.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="estiloEncuesta.css">

</head>


<BODY>  

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<div class="row rounded-b-lg rounded-t-none shadow-xl ">

    <div class="col"><div class="mx-auto" style="width: 30%;"></div></div>
    <div class="d-flex justify-content-center">
        <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
            <div class="card">
                <div class="card-body">
                   
                <form action="{{ route('ulama.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
                 <div class="form-group">
                    <x-jet-label value="* Jugador a quien se entrega" />
                    <select class="form-capture  w-full text-xs uppercase" name="jugador_id">
                    <option  > </option>    
                    @foreach ($Jugadores as $row)
                            <option value="{{$row->id}}" @if ($row->id == old('jugador_id')) selected @endif > {{$row->clave}} {{$row->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='customer_id' />
                </div>
                <div class="form-group">
                    <x-jet-label value="* Pelota" />
                    <select class="form-capture  w-full text-xs uppercase" name="pelota_id" >
                    <option  > </option>    
                    @foreach ($Pelotas as $row)
                            <option value="{{$row->id}}" @if ($row->id == old('pelota')) selected @endif > {{$row->clave}} {{$row->name}}</option>
                        @endforeach
                    </select>
                    <x-jet-input-error for='customer_id' />
                </div>
                <div class="form-group">
                    <x-jet-label value="* Fecha" />
                    <x-jet-input type="date" name="date" class="form-control  w-full text-xs" value="{{old('date')}}" />
                    <x-jet-input-error for='facture' />
                </div>
                <div class="col-12 text-right p-2 gap-2">
                  <a href="{{ route('ulama.index')}}" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>  
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Guardar
                </button>
        </form>
                   
                </div>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
            
</body>
</html>