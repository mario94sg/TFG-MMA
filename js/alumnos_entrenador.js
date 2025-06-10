$(document).ready(function () {
  cargarAlumnos();

  $("#btn-agregar-alumno").click(function () {
    $("#seccion-formulario").removeClass("d-none");
    $("#btn-agregar-alumno").hide();
  });

  $("#btn-cancelar").click(function () {
    $("#seccion-formulario").addClass("d-none");
    $("#btn-agregar-alumno").show();
  });
  $("#form-alumno").submit(function (e) {
    e.preventDefault();
    agregarAlumno();
  });

  $("#confirmarEliminarBtn").click(function () {
    const id = $(this).data("id");

    $.ajax({
      url: "../../modelo/eliminarAlumno.php",
      type: "POST",
      data: { id },
      success: function () {
        const modal = bootstrap.Modal.getInstance(document.getElementById("modalConfirmacionEliminar"));
        modal.hide();
        cargarAlumnos();
        mostrarModalFeedback("Éxito", "Alumno eliminado exitosamente.");
      },
      error: function () {
        mostrarModalFeedback("Error", "Error al eliminar el alumno.");
      },
    });
  });
});

function mostrarModalFeedback(titulo, mensaje) {
  $("#modalFeedbackTitulo").text(titulo);
  $("#modalFeedbackMensaje").text(mensaje);
  const modal = new bootstrap.Modal(document.getElementById("modalFeedback"));
  modal.show();
}

function cargarAlumnos() {
  $.ajax({
    url: "../../modelo/selectAlumnos.php",
    type: "GET",
    dataType: "json",
    success: function (data) {
      let alumnosLista = $("#alumnos-lista");
      alumnosLista.empty();
      data.forEach(function (alumno) {
        const estado = alumno.registrado == 1
          ? '<span class="badge bg-success">Registrado</span>'
          : '<span class="badge bg-danger">No registrado</span>';

        alumnosLista.append(`
            <tr>
                <td>${alumno.nombre}</td>
                <td>${alumno.email}</td>
                <td>${estado}</td>
                <td>
                    <button class="btn btn-danger btn-eliminar" data-id="${alumno.id_usuario}">Eliminar</button>
                </td>
            </tr>
        `);
      });

      $(".btn-eliminar").click(function () {
        const alumnoId = $(this).data("id");
        $("#confirmarEliminarBtn").data("id", alumnoId);
        const modal = new bootstrap.Modal(document.getElementById("modalConfirmacionEliminar"));
        modal.show();
      });
    },
    error: function () {
      mostrarModalFeedback("Error", "Error al cargar los alumnos.");
    },
  });
}

function agregarAlumno() {
  const nombre = $("#nombre").val();
  const email = $("#email").val();
  const contrasena = $("#contrasena").val();

  $.ajax({
    url: "../../modelo/agregarAlumno.php",
    type: "POST",
    data: { nombre, email, contrasena },
    success: function (response) {
      $("#form-alumno")[0].reset();
      $("#formulario-alumno").hide();
      $("#btn-agregar-alumno").show();
      cargarAlumnos();
      mostrarModalFeedback("Éxito", response || "Alumno agregado exitosamente");
    },
    error: function (xhr) {
      mostrarModalFeedback("Error", xhr.responseText || "Error al agregar alumno.");
    },
  });
}





