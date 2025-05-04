

<?php $__env->startSection('title', 'PEDIDO INTERNO'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-clipboard-check"></i>&nbsp; Pedido Interno</h1>

    <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container bg-gray-300 shadow-lg rounded-lg">
        <div class="row rounded-b-none rounded-t-lg shadow-xl bg-white">
            <h5 class="card-title p-2">
                <i class="fas fa-plus-circle"></i>&nbsp; Agregar Pedido Interno:
            </h5>
        </div>
        <form action="<?php echo e(route('internal_orders.capture')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <div class="row rounded-b-lg rounded-t-none mb-4 shadow-xl bg-gray-300">

            <div class="row p-4">
                <div class="col-sm-12 col-xs-12 shadow rounded-xl p4">



                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    
        
<div class="row"></div>

<h1 class="font-bold " > PEDIDO: <?php echo e($NextInvoice); ?></h1>
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('FOLIO MANUAL')): ?>

<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked onclick="automatico();">
<label class="btn btn-outline-primary" for="btnradio1">Folio<br> automatico</label>
<input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off" onclick="manual();">
<label class="btn btn-outline-primary" for="btnradio3">Ingresar <br> Folio </label>
</div>
<br> <br>
<?php else: ?>
<h1 class="font-bold " >EL FOLIO SE AGREGARA DE MANERA AUTOMATICA</h1>

<?php endif; ?>


<div class="form-group" id="folio" style="display:none;">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => 'FOLIO']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'FOLIO']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'number','min' => '0','name' => 'invoice','id' => 'invoice','value' => '0']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','min' => '0','name' => 'invoice','id' => 'invoice','value' => '0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> 
                            </div>      

<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('NOHA MANUAL')): ?>
<br><br>
<div class="btn-group" role="group" aria-label="Basic radio toggle button group">
<input type="radio" class="btn-check" name="btnradio" id="btnradioa" autocomplete="off" checked onclick="automatico2();">
<label class="btn btn-outline-primary" for="btnradioa">NOHA<br> automatico</label>
<input type="radio" class="btn-check" name="btnradio" id="btnradiob" autocomplete="off" onclick="manual2();">
<label class="btn btn-outline-primary" for="btnradiob">Ingresar <br> NOHA </label>
</div>
<br> <br>
<?php else: ?>
<h1 class="font-bold " >EL NOHA SE AGREGARA DE MANERA AUTOMATICA</h1>
<?php endif; ?>


<div class="form-group" id="noha-group" style="display:none;">
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => 'NOHA']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'NOHA']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'number','min' => '0','name' => 'noha','id' => 'noha','value' => '0']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'number','min' => '0','name' => 'noha','id' => 'noha','value' => '0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?> 
                            </div>      
<br><br>

                                    <div class="form-group">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => '* Cliente']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '* Cliente']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <select class="form-capture  w-full text-xs uppercase" name="customer_id" id='customer'>
                                            <?php $__currentLoopData = $Customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row->id); ?>" <?php if($row->id == old('customer_id')): ?> selected <?php endif; ?> > <?php echo e($row->clave); ?> <?php echo e($row->customer); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'customer_id']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'customer_id']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                    <div class="form-group">
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.label','data' => ['value' => '* Medio']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-label'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '* Medio']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <select class="form-capture  w-full text-xs uppercase" name="medio">
                                            <?php $__currentLoopData = $Medios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($row->id); ?>" <?php if($row->id == old('medio')): ?> selected <?php endif; ?> > <?php echo e($row->description); ?> </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input-error','data' => ['for' => 'medio']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['for' => 'medio']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <h1 class="h2 text-center font-bold text-xs uppercase">Seleccione los contactos para este pedido</h1>
                                    <br>
            
            <div class="col-sm-12 col-xs-12 table-responsive">

                
                                        <table class="table tableshippingaddress table-striped text-xs font-medium" >
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Nombre</th>
                                                    <th>Ciudad</th>
                                                    <th>Telefono</th>
                                                    <th>Correo</th>
                                                    <th>Select</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            </table>
                                            <table class="table tableshippingaddress table-striped text-xs font-medium" id='ctable'>
                                            <tbody>
                                                <?php $__currentLoopData = $contactos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr class='<?php echo e($contact->customer_id); ?>'>
                                                <td><?php echo e($contact->customer_contact_name); ?></td>
                                                <td><?php echo e($contact->customer_contact_city); ?></td>
                                                <td><?php echo e($contact->customer_contact_office_phone); ?></td>
                                                <td><?php echo e($contact->customer_contact_email); ?></td>
                                                <td><div class="row">     
                                                    <div class='col'> Seleccionar :</div>
                                                    <div class='col'><input class="form-check-input" type="checkbox" value="<?php echo e($contact->id); ?>" id="flexCheckDefault" name="contacto[]"></div>
                                                </div> 
                                                    &nbsp;&nbsp;&nbsp;  </td>
                                                  </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    <!-- Si no hay contactos boton para agregar contactos -->

            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-right p-2 gap-2">
                <a href="<?php echo e(route('internal_orders.index')); ?>" class="btn btn-black mb-2">
                    <i class="fas fa-times fa-2x"></i>&nbsp;&nbsp; Cancelar
                </a>
                <button type="submit" class="btn btn-green mb-2">
                    <i class="fas fa-save fa-2x"></i>&nbsp; &nbsp; Siguiente
                </button>
            </div>
        </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>

<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/tableitems.js')); ?>"></script>

<script>
    $(document).ready(function(){
        $(".shipment_option").click(function(evento){
          
            var valor = $(this).val();
          
            if(valor == 'Sí'){
                $("#shipment_answer").css("display", "block");
                $("#div2").css("display", "none");
            }else{
                $("#shipment_answer").css("display", "none");
                $("#div2").css("display", "block");
            }
    });
});
</script>

<script>
    $(document).ready(function(){
        $(".shipment_address_equal_option").click(function(evento){
          
            var valor = $(this).val();
          
            if(valor == 'No'){
                $("#shipment_address").css("display", "block");
            }else{
                $("#shipment_address").css("display", "none");
            }
    });
});
</script>

<script>
    function automatico(myRadio) {
    var folio = document.getElementById("folio");
    var invoice = document.getElementById("invoice");
    folio.style.display="none";
    invoice.value=0;
}


function manual(myRadio) {
    var folio = document.getElementById("folio");
    folio.style.display="block";
}
function automatico2(myRadio) {
    var group = document.getElementById("noha-group");
    var noha = document.getElementById("noha");
    group.style.display="none";
    noha.value=0;
}


function manual2(myRadio) {
    var folio = document.getElementById("noha-group");
    folio.style.display="block";
}

$(document).ready(function () {
      $('select').selectize({
          sortField: 'text'
      });
  });
</script>
<script>
var mytable = document.getElementById("ctable");
for (var i = 0, row; row = mytable.rows[i]; i++) {
     
       mytable.style.display='';
        
        
            row.style.display='none';
            
        
    }
    $(document).ready(function () {     
$('#customer').change(function(){
var seleccionado = $(this).val();
console.log('entrando a la funcion');
console.log(seleccionado)
var boxes = document.getElementsByClassName("form-check-input");
for (var i = 0; i < boxes.length; i++) {
    console.log(boxes.item(i).checked);
   boxes.item(i).checked=false;
}
var table = document.getElementById("ctable");
for (var i = 0, row; row = table.rows[i]; i++) {
     
       table.style.display='';
        
        if (row.className==String(seleccionado)) {
            row.style.display='';
            
        }else{
            row.style.display='none';
            
        }
    }

})
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/internal_orders/create.blade.php ENDPATH**/ ?>