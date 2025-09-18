@extends('adminlte::page')

@section('title', 'COMISIONES - PEDIDO INTERNO')

@section('content_header')
    <h1 class="font-bold"><i class="fas fa-percent"></i>&nbsp; Comisiones Pedido Interno</h1>
@stop

@section('content')
<div class="container bg-gray-300 shadow-lg rounded-lg">
    <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
        <h5 class="card-title p-2">
            <i class="fas fa-plus-circle"></i>&nbsp; Comisiones:
        </h5>
    </div>

    <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">
        <div class="row p-4">
            <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('internal_orders.store_comisiones_pos') }}" id="comisiones-form" method="POST">
                            @csrf
                            <x-jet-input type="hidden" name="order_id" value="{{$internal_order->id}}" />
                            <x-jet-input type="hidden" name="firma_id" value="{{$signature_id}}" />

                            <h3>Datos del vendedor principal</h3>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <x-jet-label value="* Vendedor (principal)" />
                                        {{-- Mostrar nombre sólo, seller_id ya está dado --}}

                                        {{-- Visible input: seller name (readonly) --}}
                                        <input class="form-capture w-full text-md" type="text" value="{{ $Seller->seller_name }}" readonly style="width:50%; background-color:#e9ecef;" />

                                        {{-- Hidden input into arrays --}}
                                        <input type="hidden" name="seller_id[]" value="{{ $Seller->id }}" />
                                        {{-- tipo principal --}}
                                        <input type="hidden" name="tipo[]" value="principal" />
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <x-jet-label value="* Comisión principal (%)" />
                                        
                                            <input id="principal_comision" class="form-capture text-md" type="number" name="comision[]" value="{{ $FixedComision}}" style="width:40%" max="100" min="0.01" step="0.01" />
                                        
                                        &nbsp;% 
                                        <div class="small text-muted">La comisión fija establecida es del {{ number_format($FixedComision ?? 0,1) }}% </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            {{-- Sección Comisiones Compartidas --}}
                            <div class="mb-4">
                                <h4><b>Comisiones Compartidas</b></h4>
                                <div id="compartidas-container">
                                    {{-- inicialmente vacío; se pueden agregar filas con JS --}}
                                </div>

                                <div class="mt-2">
                                    <button type="button" id="add-compartida" class="btn btn-green">
                                        <i class="fas fa-plus-circle"></i> Agregar comisión compartida
                                    </button>
                                    <small class="text-muted ml-2">Máx. 4 comisiones compartidas. Suma total (principal + compartidas) no debe superar 3%.</small>
                                </div>
                            </div>

                            <hr>

                            {{-- Sección DGI --}}
                            <div class="mb-4">
                                <h4><b>Comisiones DGI</b></h4>
                                <div id="dgi-container">
                                    {{-- Renderizar las comisiones DGI iniciales provenientes de $DGI --}}
                                    @if(isset($DGI) && $DGI->count() > 0)
                                        @foreach($DGI as $dgi)
                                            <div class="row align-items-center mb-2 dgi-row">
                                                <div class="col-md-5">
                                                    <select class="form-capture w-full seller-select" name="seller_id[]">
                                                        <option value="">-- Seleccionar Vendedor --</option>
                                                        @foreach($Sellers as $s)
                                                            <option value="{{ $s->id }}" @if($s->id == $dgi->seller_id) selected @endif>{{ $s->seller_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-jet-input-error for="seller_id" />
                                                    <input type="hidden" name="tipo[]" value="DGI" />
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="number" name="comision[]" class="form-capture comision-input" value="{{ $dgi->percentage *100 }}" min="0.01" step="0.01" style="width:70%"/> &nbsp; %
                                                </div>
                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-red remove-row"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="mt-2">
                                    <button type="button" id="add-dgi" class="btn btn-green">
                                        <i class="fas fa-plus-circle"></i> Agregar comisión DGI
                                    </button>
                                </div>
                            </div>

                            <div class="w-100"><hr></div>

                            <div class="col-12 text-right p-2 gap-2">
                                <button type="button" id="btn-guardar-comisiones" class="btn btn-green mb-2">
                                    <i class="fas fa-save fa-2x"></i>&nbsp;&nbsp; Guardar
                                </button>
                                <a href="{{ route('internal_orders.index') }}" class="btn btn-black mb-2">
                                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                                </a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('css')
<style>
    /* pequeños ajustes para que botones rojo/verde usen tu estilo */
    .btn-green { background-color: #28a745; color: white; border: none; padding: 8px 12px; border-radius: 6px; }
    .btn-red { background-color: #dc3545; color: white; border: none; padding: 6px 10px; border-radius: 6px; }
    .seller-select { width: 100%; padding: 6px; }
    .form-capture { padding: 6px; border-radius: 4px; border:1px solid #ced4da; }
</style>
@stop

@section('js')
    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    (function(){
        // Opciones de sellers generado desde blade para insertar rápidamente en las selecciones nuevas
        const sellersOptions = `@foreach($Sellers as $s)<option value="{{ $s->id }}">{{ $s->seller_name }}</option>@endforeach`;

        const maxCompartidas = 4;

        const compartidasContainer = document.getElementById('compartidas-container');
        const dgiContainer = document.getElementById('dgi-container');
        const addCompartidaBtn = document.getElementById('add-compartida');
        const addDgiBtn = document.getElementById('add-dgi');
        const guardarBtn = document.getElementById('btn-guardar-comisiones');
        const form = document.getElementById('comisiones-form');

        // Cuenta las filas compartidas actuales
        function countCompartidas(){
            return compartidasContainer.querySelectorAll('.compartida-row').length;
        }

        // Devuelve array de seller_id seleccionados (strings)
        function getAllSelectedSellerIds(){
            const inputs = form.querySelectorAll('select[name="seller_id[]"], input[name="seller_id[]"]');
            const ids = [];
            inputs.forEach(el => {
                // if select, value; if hidden input (principal) also included
                if(el.tagName.toLowerCase() === 'select' || el.tagName.toLowerCase() === 'input'){
                    const v = el.value ? String(el.value) : '';
                    if(v !== '') ids.push(v);
                }
            });
            return ids;
        }

        // Devuelve sum total de comisiones (float)
     function getTotalComision(){
    let total = 0.0;

    // recorremos todos los inputs de comision
    const elems = form.querySelectorAll('input[name="comision[]"]');
    
    elems.forEach(e => {
        const v = parseFloat(e.value);

        // buscamos el hidden tipo[] en la misma fila
        const row = e.closest('.row');
        const tipoInput = row ? row.querySelector('input[name="tipo[]"]') : null;
        const tipo = tipoInput ? tipoInput.value : '';

        // solo sumar si no es dgi
        if(!isNaN(v) && tipo !== 'dgi'){
            total += v;
        }
    });

    return total;
}


        // Crear nueva fila compartida
        function createCompartidaRow(selectedSellerId = '', comisionVal = ''){
            if(countCompartidas() >= maxCompartidas){
                Swal.fire({ icon: 'warning', title: 'Máximo alcanzado', text: `Sólo se permiten hasta ${maxCompartidas} comisiones compartidas.`});
                return;
            }

            const row = document.createElement('div');
            row.className = 'row align-items-center mb-2 compartida-row';

            row.innerHTML = `
                <div class="col-md-5">
                    <select class="form-capture w-full seller-select" name="seller_id[]">
                        <option value="">-- Seleccionar Vendedor --</option>
                        ${sellersOptions}
                    </select>
                    <input type="hidden" name="tipo[]" value="compartida" />
                </div>
                <div class="col-md-3">
                    <input type="number" name="comision[]" class="form-capture comision-input" value="${comisionVal}" min="0.01" step="0.01" style="width:70%"/> &nbsp; %
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-red remove-row"><i class="fas fa-trash"></i></button>
                </div>
            `;

            compartidasContainer.appendChild(row);

            // set selected seller if provided
            if(selectedSellerId){
                const sel = row.querySelector('select[name="seller_id[]"]');
                sel.value = selectedSellerId;
            }

            attachRowListeners(row);
        }

        // Crear nueva fila dgi
        function createDgiRow(selectedSellerId = '', comisionVal = ''){
            const row = document.createElement('div');
            row.className = 'row align-items-center mb-2 dgi-row';

            row.innerHTML = `
                <div class="col-md-5">
                    <select class="form-capture w-full seller-select" name="seller_id[]">
                        <option value="">-- Seleccionar Vendedor --</option>
                        ${sellersOptions}
                    </select>
                    <input type="hidden" name="tipo[]" value="dgi" />
                </div>
                <div class="col-md-3">
                    <input type="number" name="comision[]" class="form-capture comision-input" value="${comisionVal}" min="0.01" step="0.01" style="width:70%"/> &nbsp; %
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-red remove-row"><i class="fas fa-trash"></i></button>
                </div>
            `;

            dgiContainer.appendChild(row);

            if(selectedSellerId){
                const sel = row.querySelector('select[name="seller_id[]"]');
                sel.value = selectedSellerId;
            }

            attachRowListeners(row);
        }

        // Adjuntar eventos a una fila recien creada (select change, remove)
        function attachRowListeners(row){
            const sel = row.querySelector('select[name="seller_id[]"]');
            const com = row.querySelector('input[name="comision[]"]');
            const removeBtn = row.querySelector('.remove-row');

            if(sel){
                sel.addEventListener('change', function(){
                    // si hay duplicado, alert y reset a empty
                    const ids = getAllSelectedSellerIds();
                    const occurrences = ids.filter(i => i === String(this.value)).length;
                    // also include principal seller hidden value (already in ids)
                    if(this.value !== '' && occurrences > 1){
                        Swal.fire({ icon: 'warning', title: 'Vendedor duplicado', text: 'Este vendedor ya tiene una comisión asignada en la lista. No se permiten duplicados.'});
                        this.value = '';
                    }
                });
            }

            if(com){
                com.addEventListener('input', function(){
                    // opcional: forzar 2 decimals?
                });
            }

            if(removeBtn){
                removeBtn.addEventListener('click', function(){
                    row.remove();
                });
            }
        }

        // Delegación para botones remove en filas que existan inicialmente (por ejemplo DGI iniciales)
        function attachRemoveToExisting(){
            const removes = form.querySelectorAll('.remove-row');
            removes.forEach(btn => {
                btn.addEventListener('click', function(){
                    const row = btn.closest('.row');
                    if(row) row.remove();
                });
            });

            // attach change listeners for existing selects
            const selects = form.querySelectorAll('.seller-select');
            selects.forEach(s => {
                s.addEventListener('change', function(){
                    const ids = getAllSelectedSellerIds();
                    const occurrences = ids.filter(i => i === String(this.value)).length;
                    if(this.value !== '' && occurrences > 1){
                        Swal.fire({ icon: 'warning', title: 'Vendedor duplicado', text: 'Este vendedor ya tiene una comisión asignada en la lista. No se permiten duplicados.'});
                        this.value = '';
                    }
                });
            });
        }

        // Evento para agregar compartida
        addCompartidaBtn.addEventListener('click', function(){
            if(countCompartidas() >= maxCompartidas){
                Swal.fire({ icon: 'warning', title: 'Límite', text: `No puede agregar más de ${maxCompartidas} comisiones compartidas.`});
                return;
            }
            createCompartidaRow();
        });

        // Evento para agregar dgi
        addDgiBtn.addEventListener('click', function(){
            createDgiRow();
        });

        // Al hacer click en Guardar: validaciones
        guardarBtn.addEventListener('click', function(){
            // 1) Verificar comisión principal no mayor a 3%
            const principalInput = document.getElementById('principal_comision');
            const principalVal = principalInput ? parseFloat(principalInput.value) : 0;
            if(!isNaN(principalVal) && principalVal > 3.0){
                Swal.fire({
                    icon: 'warning',
                    title: 'Comisión principal excede 3%',
                    text: 'La comisión principal no puede ser mayor a 3%. Corrija antes de guardar.'
                });
                return;
            }

            // 2) Verificar que la suma total de comisiones no supere 3%
            const total = getTotalComision();
            if(total > 3.0){
                Swal.fire({
                    icon: 'warning',
                    title: 'Comisiones totales exceden 3%',
                    html: `La suma de todas las comisiones es <b>${total.toFixed(2)}%</b>. Debe ser <= 3.00%.`
                });
                return;
            }

            // 3) Verificar que no haya vendedores duplicados en toda la lista
            const ids = getAllSelectedSellerIds();
            const dup = findDuplicate(ids);
            if(dup){
                Swal.fire({
                    icon: 'warning',
                    title: 'Vendedor repetido',
                    text: `El vendedor con id ${dup} aparece más de una vez. Cada vendedor solo puede tener una comisión.`
                });
                return;
            }

            // All validations passed -> submit
            form.submit();
        });

        // buscar duplicado simple
        function findDuplicate(arr){
            const seen = {};
            for(let i=0;i<arr.length;i++){
                const v = arr[i];
                if(seen[v]) return v;
                seen[v] = true;
            }
            return null;
        }

        // Inicial attach para filas ya renderizadas (DGI)
        attachRemoveToExisting();

        // Si quieres precargar alguna compartida desde servidor (no solicitado), podrías llamar createCompartidaRow(...) aquí.

        // También asegurar que principal seller (hidden input) no pueda ser duplicado en selects (evitar seleccionar al principal)
        // Obtener id principal (del primer hidden seller_id[])
        const principalHidden = form.querySelector('input[type="hidden"][name="seller_id[]"]');
        let principalId = '';
        if(principalHidden) principalId = principalHidden.value ? String(principalHidden.value) : '';

        // Evitar seleccionar principal en otras selects: on change, if equals principalId -> alert & clear
        form.addEventListener('change', function(e){
            const target = e.target;
            if(target && target.name === 'seller_id[]' && target.tagName.toLowerCase() === 'select'){
                if(principalId !== '' && String(target.value) === principalId){
                    Swal.fire({ icon: 'warning', title: 'Vendedor principal', text: 'No puede asignar comisión a este vendedor otra vez.'});
                    target.value = '';
                }
            }
        });

    })();
    </script>
@stop
