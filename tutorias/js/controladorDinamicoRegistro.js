$(document).ready(function() {
  const $selectTutor = $("#tutor");
  const $selectGenero = $("#genero_tutor");

  $selectTutor.prop("disabled", true);

  $selectGenero.change(function() {
    const generoSeleccionado = $(this).val();

    $selectTutor.empty();

    $.ajax({
      url: 'php/tutoresDisponibles.php',
      method: 'POST',
      data: { genero: generoSeleccionado },
      success: function(data) {
        $selectTutor.prop("disabled", false);

        data.forEach(tutor => {
          $selectTutor.append(`<option value="${tutor.id}">${tutor.nombre} ${tutor.apellido_paterno} ${tutor.apellido_materno}</option>`);
        });
      },
      error: function() {
        alert("Error al cargar los tutores.");
      }
    });
  });
});


$(document).ready(function() {
    $("#btnRegistrar").click(function(event) {
      event.preventDefault();
  
      const formData = {};
      $("#registroForm").serializeArray().forEach(field => {
        formData[field.name] = field.value;
      });
  
      const $table = $("<table>");
      $.each(formData, function(key, value) {
        $table.append(`<tr><td>${key}:</td><td>${value}</td></tr>`);
      });
  
      const newWindow = window.open("mostrarRegistro.html", "_blank");
  
      $(newWindow).on("load", function() {
        $(this.document).find("#contenido").html($table);
  
        $(this.document).find("#btnConfirmar").click(function() {
          $.ajax({
            url: 'php/registro.php',
            method: 'POST',
            data: formData,
            success: function(response) {
              alert(response);
              newWindow.close();
            },
            error: function() {
              alert("Error al procesar el registro.");
            }
          });
        });
  
        $(this.document).find("#btnModificar").click(function() {
          const formUrl = "registro.html?" + $.param(formData);
          newWindow.location.href = formUrl;
        });
      });
    });
  });
  