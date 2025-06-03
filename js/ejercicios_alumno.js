$(document).ready(function () {
  cargarEjercicios();

  function cargarEjercicios() {
    $.ajax({
      url: "../php/gestionar_ejercicios.php",
      type: "GET",
      data: { accion: "listar", rol: "alumno" },
      dataType: "json",
      success: function (data) {
        const tbody = $("#tablaEjerciciosAlumno tbody");
        tbody.empty();

        if (data.length === 0) {
          tbody.append("<tr><td colspan='5'>No hay ejercicios asignados</td></tr>");
        } else {
          data.forEach((ej) => {
            const estado = ej.completado == 1
              ? "<span class='badge bg-success'>Completado</span>"
              : "<span class='badge bg-danger'>Pendiente</span>";

            const boton = ej.completado == 0
              ? `<button class="btn btn-sm btn-success marcar-completado" data-id="${ej.id_ejercicio}">Marcar como completado</button>`
              : "-";

            tbody.append(`
              <tr>
                <td>${ej.titulo}</td>
                <td>${ej.descripcion}</td>
                <td>${new Date(ej.fecha_asignacion).toLocaleString()}</td>
                <td>${estado}</td>
                <td>${boton}</td>
              </tr>
            `);
          });
        }
      }
    });
  }

  $(document).on("click", ".marcar-completado", function () {
    const id = $(this).data("id");
    if (!confirm("¿Estás seguro de marcar este ejercicio como completado?")) return;

    $.ajax({
      url: "../php/gestionar_ejercicios.php",
      type: "POST",
      data: { accion: "completar", id_ejercicio: id },
      dataType: "json",
      success: function (response) {
        if (response.estado === "ok") {
          cargarEjercicios();
        } else {
          alert("Error al marcar como completado.");
        }
      }
    });
  });
});
