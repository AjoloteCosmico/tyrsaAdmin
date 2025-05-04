

<?php $__env->startSection('title', 'PEDIDO INTERNO'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="font-bold"><i class="fas fa-credit-card"></i>&nbsp; CONDICIONES DE PAGO</h1>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-flex m-1 bg-gray-300 shadow-lg rounded-lg">

        <div class="row p-3 m-2 rounded-lg shadow-xl bg-white">
            <div class="row p-4">
                <div class="col-sm-12 text-center font-bold text-sm">
                <table>
                        <tr>
                            <td rowspan="4">
                               <img src="<?php echo e(asset('img/logo/logo.svg')); ?>" alt="TYRSA">
                            </td>
                        </tr>
                        <tr>
                            <td class="text-lg" style="color: red"><?php echo e($CompanyProfiles->company); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo e($CompanyProfiles->motto); ?></td>
                        </tr>
                        <tr class="text-xs">
                            <td>
                                <br>
                                Domicilio Fiscal:<br>
                                <?php echo e($CompanyProfiles->street.' '.$CompanyProfiles->outdoor.' '.$CompanyProfiles->intdoor.' '.$CompanyProfiles->suburb.' '.$CompanyProfiles->city.' '.$CompanyProfiles->state.' '.$CompanyProfiles->zip_code); ?><br>
                                R.F.C: <?php echo e($CompanyProfiles->rfc); ?> &nbsp; Tels: 01-52 <?php echo e($CompanyProfiles->telephone.', '.$CompanyProfiles->telephone2); ?> &nbsp; E-mail: <?php echo e($CompanyProfiles->email); ?> &nbsp; Web: <?php echo e($CompanyProfiles->website); ?>

                            </td>
                        </tr>
                    </table>
                    <br><br>
                    <table class="table">
  <thead>
    <tr>
      <th scope="col">RESUMEN DEL PEDIDO INTERNO (P.I.) NUMERO</th>
      <td ><?php echo e($InternalOrders->invoice); ?></td>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">Moneda</th>
      <td><?php echo e($Coins->code); ?></td>
      
    </tr>
  </tbody>
  
</table>

                    <br><br>
<p style ="font-size:250%;">TABLA PROMESA DE COBROS</p>
<br>
<h2 style='color:#2C426C; font-size: 150%'>* Todos los pagos incluyen IVA</h2>
<br><br>
<form action="<?php echo e(route('internal_orders.pay_conditions')); ?>" method="POST" enctype="multipart/form-data" id="form1">
<?php echo csrf_field(); ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'rowcount','id' => 'rowcount','value' => ''.e($npagos).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'rowcount','id' => 'rowcount','value' => ''.e($npagos).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'customerID','value' => ''.e($InternalOrders->customer_id).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'customerID','value' => ''.e($InternalOrders->customer_id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'sellerID','value' => ''.e($InternalOrders->seller_id).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'sellerID','value' => ''.e($InternalOrders->seller_id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'sellerID','value' => ''.e($InternalOrders->customer_shipping_address_id).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'sellerID','value' => ''.e($InternalOrders->customer_shipping_address_id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'coinID','value' => ''.e($InternalOrders->coin_id).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'coinID','value' => ''.e($InternalOrders->coin_id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'total','id' => 'total','value' => ''.e($InternalOrders->total).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'total','id' => 'total','value' => ''.e($InternalOrders->total).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => 'order_id','value' => ''.e($InternalOrders->id).'']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => 'order_id','value' => ''.e($InternalOrders->id).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'hidden','name' => '','value' => '0']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'hidden','name' => '','value' => '0']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<table class="table table-striped" name="tabla1" id="tabla1">
  <thead class="thead">
    <tr>
      <th scope="col">Entregable</th>
      <th scope="col">% negociado</th>
      <th scope="col">cantidad</th>
      <th scope="col">Fecha MM/DD/AAAA</th>
      <th scope="col">Concepto</th>
    </tr>
  </thead>
  <tbody>
  <?php
    $emision = new DateTime($InternalOrders->reg_date);
    $entrega = new DateTime($InternalOrders->date_delivery);
    ?>
    
   
   <?php for($i = 1; $i <= $npagos; $i++): ?>
    
   <?php
      $aux_count=$aux_count+1;
      ?>
    
    <tr>
        <td><?php echo e('COBRO '.$aux_count); ?></td>
        <td> <input type='number' min='0' max='100' step='1'  style='width: 70%;' name="<?php echo e('porcentaje['.$aux_count.']'); ?>"  id="<?php echo e('P'.$aux_count); ?>">%</td>
        <td><?php echo e($Coins -> symbol); ?> <input type='number' min='0' step='any' max='<?php echo e(number_format( $InternalOrders->total,2)); ?>' id="<?php echo e('R'.$aux_count); ?>" style='width: 70%;' ></td>
        <?php if($i==1): ?>
        
    <td> <input type='date'  required class='w-full text-xs date' name="<?php echo e('date['.$aux_count.']'); ?>"  id="<?php echo e('D'.$aux_count); ?>" value="<?php echo e($emision->format('Y-m-d')); ?>"></td>
        
    <?php else: ?>
    <td> <input type='date'  required class='w-full text-xs date' name="<?php echo e('date['.$aux_count.']'); ?>"  id="<?php echo e('D'.$aux_count); ?>"  value="<?php echo e($entrega->format('Y-m-d')); ?>"></td>
         <?php endif; ?>
        <td> <input type='text' style='width: 50%;'  name="<?php echo e('concepto['.$aux_count.']'); ?>" id="<?php echo e('C'.$aux_count); ?>"onkeyup="javascript:this.value=this.value.toUpperCase();"></td>
        
     </tr>
      

      <?php endfor; ?>
    <tr >
    <th rowspan="3" scope="row">TOTALES: </th>  
    <td> Subtotal: <?php echo e($Coins -> symbol); ?> <?php echo e(number_format($Subtotal,2)); ?></td>
    <td> SUMA:</td>
    </tr>
    <tr>
    <td> Iva: <?php echo e($Coins -> symbol); ?> <?php echo e(number_format( $Subtotal*(1-$InternalOrders->descuento)*0.16,2)); ?></td>
    <td id="monitor">
    </td>
    </tr>
    <tr>
    <td> Total: <?php echo e($Coins -> symbol); ?> <?php echo e(number_format( $InternalOrders->total,2)); ?></td>
    
    </tr>
    
    </tbody>
</table>

<!--
      <td> <span><button type="button" onclick="myFunction()"  class="btn btn-blue mb-2"> </span>
      <i class="fa fa-plus" ></i>
      &nbsp; &nbsp;
      <p>Agregar Concepto</p></button></td>-->
      
  
    <br>
    <button   type="button" class="btn btn-blue mb-2"  onclick="redondear()">
                <i class="fa-regular fa-circle fa-2x" ></i>
                         &nbsp; &nbsp;
                <p>Redondear</p></button>
 
    <br><br>

    <button   type="button" class="btn btn-green mb-2"  onclick="guardar()">
                <i class="fas fa-save fa-2x" ></i>
                         &nbsp; &nbsp;
                <p>Guardar Porcentaje de Avance</p></button>
 

                </div>
                </form>
                
                
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
    
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>

<?php if($actualized == 'SI'): ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/percentage_actualized.js')); ?>"></script>
<?php endif; ?>

<?php if($actualized == 'NO'): ?>
<script type="text/javascript" src="<?php echo e(asset('vendor/mystylesjs/js/percentage_incorrect.js')); ?>"></script>
<?php endif; ?>

<script>
  function actualizarTotal(){
    var npagos=parseInt("<?php echo e($npagos); ?>");
    var total = 0;
    for (var i = 1; i <= npagos; i++) {
      valor=document.getElementById("P"+i).value;
      if( parseFloat(valor)>0){
      total=total+ parseFloat(valor);}
    }
document.getElementById("monitor").innerHTML=String(parseFloat(total))+'%';
  }
</script>

<?php for($i = 1; $i <= $npagos; $i++): ?>
<script>
 document.getElementById("<?php echo e('R'.$i); ?>").addEventListener("input", function(){
  total = parseFloat(document.getElementById('total').value);
    document.getElementById("<?php echo e('P'.$i); ?>").value = (this.value/total)*100;
    actualizarTotal();
    }); 
    
     document.getElementById("<?php echo e('P'.$i); ?>").addEventListener("input", function(){
      total = parseFloat(document.getElementById('total').value);
      document.getElementById("<?php echo e('R'.$i); ?>").value = parseFloat(this.value*total*0.01).toFixed(2);
      actualizarTotal();
    });
</script>
<?php endfor; ?>

<script>
  function redondear(){
    var npagos=parseInt("<?php echo e($npagos); ?>");
    var total = 0;
    for (var i = 1; i <= npagos; i++) {
      valor=document.getElementById("P"+i).value;
      if( parseFloat(valor)>0){
      total=total+ parseFloat(valor);}
    }
    var diferencia=100-total;
    ultimo=document.getElementById("P"+"<?php echo e($npagos); ?>").value;
    console.log(parseFloat(ultimo)+diferencia);
    if(parseFloat(ultimo)+diferencia<0){
      
      alert("No se peude redondear, acerquese mas al 100%");
    }else{
    document.getElementById("P"+"<?php echo e($npagos); ?>").value=parseFloat(ultimo)+parseFloat(diferencia);
    actualizarTotal();}
  }
</script>

<script>
    function guardar() {
      var total=parseInt(0);
      console.log("todo bien");
      var count= parseInt("<?php echo e($npagos); ?>")
      var myForm = document.forms.form1;
      var myControls = myForm.elements['porcentaje'];
      
      for (var i = 1; i <= count; i++) {
      console.log(i);
      var p=document.getElementById("P"+i).value;
      var error=0;
      console.log("todo bien");
      var c=document.getElementById("C"+i).value;
      var d=document.getElementById("D"+i);
      console.log(c)
      //var campo = $('#id_del_input').val();
      total=total+parseFloat(p);
      if (c=="") {
        console.log("concepto vacio")
        alert("Concepto sin nombre");
        console.log("concepto vacio");
        error=1;
      }
      console.log(d)
      if (!d.value) {
        console.log("Fecha vacia");
        alert("Fecha Vacía");
        error=1;
      }
      }
      console.log(total);
      if (total >=101||total<=99) {
      alert("Los porcentajes no suman 100%");
      error=1;
      
         }
      if(error==0){  

      document.getElementById("form1").submit();}


    }
</script>
<script>
$(document).ready(function () {
  $('.date').datetimepicker({
    format: 'MM/DD/YYYY',
    locale: 'en'
  });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\admintyrsa2\tyrsaAdmin\resources\views/internal_orders/payment.blade.php ENDPATH**/ ?>