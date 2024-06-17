$(document).ready(controlador);

function controlador() {
    mostrarInicio();

    $('#inicio').click(mostrarInicio);
    $('#registro').click(mostrarRegistro);
    $('#admin').click(mostrarAdmin);
}

function mostrarInicio() {
    actualizarContenido('<h1>Tutorías</h1><p>...', 'parciales/inicio.html');
}

function mostrarRegistro() {
    actualizarContenido('<h1>Registro al programa de tutorías</h1>', 'parciales/registro.html');
}

function mostrarAdmin() {
    actualizarContenido('<h1>Ingreso para administradores</h1>', 'parciales/admin.html');
}

function actualizarContenido(nuevoEncabezado, nuevoContenido) {
    $('#contenido_header').fadeOut(300, function() {
        $(this).html(nuevoEncabezado).fadeIn(300);
    });

    $('#contenido').fadeOut(300, function() {
        $.ajax({
            url: nuevoContenido,
            success: function(data) {
                $('#contenido').html(data).fadeIn(300);
            },
            error: function(xhr, status, error) {
                var msg = "Error al cargar el contenido: ";
                $('#contenido').html(msg + xhr.status + " " + xhr.statusText).fadeIn(300);
            }
        });
    });
}
