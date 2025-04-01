$('.CancelReg').submit(function(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Estás seguro de querer Cancelar el pedido?',
        text: "El status pasara a CANCELADO",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, Cancelar pedido!'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    })
});