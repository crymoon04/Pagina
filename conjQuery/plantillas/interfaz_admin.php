<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador - Tutorías ESCOM</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .table-form .form-control {
            width: 100%;
        }
        .table-form .btn {
            margin-top: 10px;
        }
    </style>
    <link rel="stylesheet" href="../style.css">

</head>
<body>
    <header class="header">
        <div class="menu container">
           <a href="https://www.escom.ipn.mx/" class="logo">ESCOM</a>
       
           <input type="checkbox" id="menu">
           <label for="menu">
               <img src="../images/menu.png" class="menu-icono" alt="menu">
           </label>
       
           <nav class="navbar">
               <ul>
                   <li><a href="index.html">Inicio</a></li>
                   <li><a href="registro.html">Registro</a></li>
                   <li><a href="admin.html">Ingreso</a></li>
               </ul>
           </nav>
        </div>
        <div class="header-content container">
            <h1>Administradores</h1>
        </div>
    </header>

    <div class="container mt-4">
        <h2>Admin - Gestión de Estudiantes</h2>

        <!-- Botones para mostrar la tabla de estudiantes y formulario de creación -->
        <div class="mb-3">
            <button id="btnMostrarTabla" class="btn btn-primary">Mostrar Estudiantes</button>
            <button id="btnMostrarFormCrear" class="btn btn-success ml-3">Crear Nuevo Estudiante</button>
        </div>

        <!-- Tabla de estudiantes -->
        <div id="tablaEstudiantes" style="display: none;">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Boleta</th>
                        <th>Nombre</th>
                        <th>Apellido Paterno</th>
                        <th>Apellido Materno</th>
                        <th>Teléfono</th>
                        <th>Semestre</th>
                        <th>Carrera</th>
                        <th>Tutor</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbodyEstudiantes">
                    <!-- Aquí se cargarán dinámicamente los estudiantes -->
                </tbody>
            </table>
        </div>

        <!-- Formulario para crear un nuevo estudiante -->
        <div id="formCrear" style="display: none;">
            <h3>Crear Nuevo Estudiante</h3>
            <form id="formNuevoEstudiante" class="table-form">
                <div class="form-group">
                    <input type="text" class="form-control" id="boleta" name="boleta" placeholder="Boleta" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="AP" name="AP" placeholder="Apellido Paterno" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="AM" name="AM" placeholder="Apellido Materno" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="tel" name="tel" placeholder="Teléfono" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="semestre" name="semestre" placeholder="Semestre" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="carrera" name="carrera" placeholder="Carrera" required>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="tutor" name="tutor" placeholder="Tutor" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn btn-success">Crear Estudiante</button>
            </form>
        </div>

        <!-- Campo de búsqueda por boleta -->
        <div class="mt-4">
            <h3>Buscar Estudiante por Boleta</h3>
            <form id="formBuscarEstudiante" class="form-inline">
                <div class="form-group">
                    <input type="text" class="form-control mr-2" id="boletaBusqueda" name="boleta" placeholder="Boleta">
                </div>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </form>
        </div>

    </div>

    <footer class="footer mt-4">
        <div class="footer-content container">
            <div class="link">
                <h3>Instituto Politécnico Nacional</h3>
                <ul>
                    <li>D.R. Instituto Politécnico Nacional (IPN). Av. Luis Enrique Erro S/N, Unidad Profesional Adolfo López Mateos, Zacatenco, Alcaldía Gustavo A. Madero, C.P. 07738, Ciudad de México. Conmutador: 55 57 29 60 00 / 55 57 29 63 00.</li>
                    <li>Esta página es una obra intelectual protegida por la Ley Federal del Derecho de Autor, puede ser reproducida con fines no lucrativos, siempre y cuando no se mutile, se cite la fuente completa y su dirección electrónica; su uso para otros fines, requiere autorización previa y por escrito de la Dirección General del Instituto.</li>
                </ul>
                <img src="images/educacion2.png" alt="educacion2.png">
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function() {
    // Función para cargar todos los estudiantes en la tabla
    $("#btnMostrarTabla").click(function() {
        $.ajax({
            url: 'crudsAdmin.php',
            type: 'POST',
            data: { operacion: 'load' },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    $("#tbodyEstudiantes").empty(); // Limpiar tabla antes de cargar datos

                    $.each(response.data, function(index, student) {
                        var tr = `<tr id="row-${student.boleta}">
                                    <td>${student.boleta}</td>
                                    <td>${student.nombre}</td>
                                    <td>${student.apellido_paterno}</td>
                                    <td>${student.apellido_materno}</td>
                                    <td>${student.telefono}</td>
                                    <td>${student.semestre}</td>
                                    <td>${student.carrera}</td>
                                    <td>${student.tutor}</td>
                                    <td>${student.correo}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm btnModificar" data-boleta="${student.boleta}">Modificar</button>
                                        <button class="btn btn-danger btn-sm btnEliminar" data-boleta="${student.boleta}">Eliminar</button>
                                    </td>
                                  </tr>`;
                        $("#tbodyEstudiantes").append(tr);
                    });

                    $("#tablaEstudiantes").show();
                    $("#formCrear").hide();
                } else {
                    alert('Error al cargar estudiantes: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX');
                console.error(error);
            }
        });
    });

    // Mostrar formulario para crear nuevo estudiante
    $("#btnMostrarFormCrear").click(function() {
        $("#formCrear").toggle();
    });

    // Crear nuevo estudiante
    $("#formNuevoEstudiante").submit(function(event) {
        event.preventDefault();

        var formData = $(this).serializeArray();
        formData.push({ name: 'operacion', value: 'create' });

        $.ajax({
            url: 'crudsAdmin.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $("#formNuevoEstudiante")[0].reset();
                    $("#btnMostrarTabla").click(); // Actualizar tabla después de crear estudiante
                } else {
                    alert('Error al crear estudiante: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX');
                console.error(error);
            }
        });
    });

    // Mostrar formulario para modificar estudiante
    $(document).on('click', '.btnModificar', function() {
        var boleta = $(this).data('boleta');
        var tr = $(this).closest('tr');

        // Obtener datos del estudiante para prellenar el formulario
        $.ajax({
            url: 'crudsAdmin.php',
            type: 'POST',
            data: { operacion: 'read', boleta: boleta },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    var student = response.data;

                    // Crear formulario de modificación
                    var form = `<form class="table-form">
                                    <td>${student.boleta}</td>
                                    <td><input type="text" class="form-control" name="nombre" value="${student.nombre}"></td>
                                    <td><input type="text" class="form-control" name="AP" value="${student.apellido_paterno}"></td>
                                    <td><input type="text" class="form-control" name="AM" value="${student.apellido_materno}"></td>
                                    <td><input type="text" class="form-control" name="tel" value="${student.telefono}"></td>
                                    <td><input type="text" class="form-control" name="semestre" value="${student.semestre}"></td>
                                    <td><input type="text" class="form-control" name="carrera" value="${student.carrera}"></td>
                                    <td><input type="text" class="form-control" name="tutor" value="${student.tutor}"></td>
                                    <td><input type="email" class="form-control" name="correo" value="${student.correo}"></td>
                                    <td>
                                        <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                        <button type="button" class="btn btn-secondary btn-sm btnCancelar">Cancelar</button>
                                    </td>
                                </form>`;

                    // Reemplazar fila actual por el formulario de modificación
                    tr.replaceWith(form);
                } else {
                    alert('Error al cargar estudiante: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX');
                console.error(error);
            }
        });
    });

    // Cancelar modificación y volver a mostrar los botones de acción
    $(document).on('click', '.btnCancelar', function() {
        var boleta = $(this).closest('form').find('input[name="boleta"]').val();
        var tr = `<tr id="row-${boleta}">
                    <td>${boleta}</td>
                    <td>${$(this).closest('form').find('input[name="nombre"]').val()}</td>
                    <td>${$(this).closest('form').find('input[name="AP"]').val()}</td>
                    <td>${$(this).closest('form').find('input[name="AM"]').val()}</td>
                    <td>${$(this).closest('form').find('input[name="tel"]').val()}</td>
                    <td>${$(this).closest('form').find('input[name="semestre"]').val()}</td>
                    <td>${$(this).closest('form').find('input[name="carrera"]').val()}</td>
                    <td>${$(this).closest('form').find('input[name="tutor"]').val()}</td>
                    <td>${$(this).closest('form').find('input[name="correo"]').val()}</td>
                    <td>
                        <button class="btn btn-info btn-sm btnModificar" data-boleta="${boleta}">Modificar</button>
                        <button class="btn btn-danger btn-sm btnEliminar" data-boleta="${boleta}">Eliminar</button>
                    </td>
                  </tr>`;

        // Reemplazar formulario por la fila original
        $(this).closest('form').replaceWith(tr);
    });

    // Guardar cambios en la modificación del estudiante
    $(document).on('submit', '.table-form', function(event) {
        event.preventDefault();

        var formData = $(this).serializeArray();
        formData.push({ name: 'operacion', value: 'update' });

        $.ajax({
            url: 'crudsAdmin.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert(response.message);
                    $("#btnMostrarTabla").click(); // Actualizar tabla después de modificar estudiante
                } else {
                    alert('Error al modificar estudiante: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX');
                console.error(error);
            }
        });
    });

    // Eliminar estudiante
    $(document).on('click', '.btnEliminar', function() {
        if (confirm('¿Estás seguro de eliminar este estudiante?')) {
            var boleta = $(this).data('boleta');

            $.ajax({
                url: 'crudsAdmin.php',
                type: 'POST',
                data: { operacion: 'delete', boleta: boleta },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        alert(response.message);
                        $("#btnMostrarTabla").click(); // Actualizar tabla después de eliminar estudiante
                    } else {
                        alert('Error al eliminar estudiante: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la solicitud AJAX');
                    console.error(error);
                }
            });
        }
    });

    $("#formBuscarEstudiante").submit(function(event) {
        event.preventDefault();

        var boleta = $("#boletaBusqueda").val().trim();

        if (boleta !== '') {
            $.ajax({
                url: 'crudsAdmin.php',
                type: 'POST',
                data: { operacion: 'read', boleta: boleta },
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $("#tbodyEstudiantes").empty(); // Limpiar tabla antes de cargar datos

                        var student = response.data;
                        var tr = `<tr id="row-${student.boleta}">
                                    <td>${student.boleta}</td>
                                    <td>${student.nombre}</td>
                                    <td>${student.apellido_paterno}</td>
                                    <td>${student.apellido_materno}</td>
                                    <td>${student.telefono}</td>
                                    <td>${student.semestre}</td
                                    <td>${student.carrera}</td>
                                    <td>${student.tutor}</td>
                                <td>${student.correo}</td>
                                <td>
                                    <button class="btn btn-info btn-sm btnModificar" data-boleta="${student.boleta}">Modificar</button>
                                    <button class="btn btn-danger btn-sm btnEliminar" data-boleta="${student.boleta}">Eliminar</button>
                                </td>
                              </tr>`;
                    $("#tbodyEstudiantes").append(tr);

                    $("#tablaEstudiantes").show();
                    $("#formCrear").hide();
                } else {
                    alert('Estudiante no encontrado: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('Error en la solicitud AJAX');
                console.error(error);
            }
        });
        } else {
            alert('Por favor, ingrese una boleta válida.');
        }
    });
});
    </script>
</body>
</html>