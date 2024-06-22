$(document).ready(function() {
  const $selectTutor = $("#tutor");
  const $selectGenero = $("#genero_tutor");

  $selectTutor.prop("disabled", true);

  $selectGenero.change(function() {
      const generoSeleccionado = $(this).val();
      alert("Género seleccionado en JS: " + generoSeleccionado); // Depuración: Mostrar el género seleccionado

      $selectTutor.empty(); // Limpiar opciones previas

      $.ajax({
          url: 'php/tutoresDisponibles.php',
          method: 'POST',
          data: { genero: generoSeleccionado },
          dataType: 'json', // Indicar que esperamos JSON
          success: function(data) {
              alert("Respuesta del servidor: " + JSON.stringify(data)); // Depuración: Mostrar la respuesta JSON completa
              if (data.length > 0) {
                  $selectTutor.prop("disabled", false); 

                  data.forEach(tutor => {
                      $selectTutor.append(`<option value="${tutor.id}">${tutor.nombre} ${tutor.apellido_paterno} ${tutor.apellido_materno}</option>`);
                  });
              } else {
                  $selectTutor.append('<option value="">No se encontraron tutores.</option>');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              let errorMessage = "Error al cargar los tutores.";
              // ... (manejo de errores más específico como en el ejemplo anterior)
              alert(errorMessage);
              console.error(errorThrown); 
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
  