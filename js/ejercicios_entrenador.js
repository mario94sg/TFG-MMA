$(document).ready(function () {
  cargarAlumnos();
  cargarEjercicios();

  // FORMULARIO PARA ASIGNAR EJERCICIOS
  $("#form-ejercicio").submit(function (e) {
    e.preventDefault();

    const titulo = $("#titulo").val();
    const descripcion = $("#descripcion").val();
    const alumnosSeleccionados = [];

    $("#lista-alumnos input[type=checkbox]:checked").each(function () {
      alumnosSeleccionados.push($(this).val());
    });

    if (!titulo || !descripcion || alumnosSeleccionados.length === 0) {
      alert("Por favor, completa todos los campos y selecciona al menos un alumno.");
      return;
    }

    $.ajax({
      type: "POST",
      url: "../php/gestionar_ejercicios.php",
      data: {
        accion: "asignar",
        titulo,
        descripcion,
        alumnos: alumnosSeleccionados,
      },
      success: function () {
        $("#form-ejercicio")[0].reset();
        cargarEjercicios();
      },
      error: function () {
        alert("Error al asignar el ejercicio.");
      },
    });
  });

  // ELIMINAR EJERCICIO
  let ejercicioAEliminar = null;

  $(document).on("click", ".btn-eliminar-ejercicio", function () {
    ejercicioAEliminar = $(this).data("id");
    $("#modalEliminarEjercicio").modal("show");
  });

  $("#confirmarEliminarBtn").click(function () {
    if (ejercicioAEliminar) {
      $.ajax({
        type: "POST",
        url: "../php/gestionar_ejercicios.php",
        data: { accion: "eliminar", id_ejercicio: ejercicioAEliminar },
        success: function () {
          $("#modalEliminarEjercicio").modal("hide");
          cargarEjercicios();
        },
        error: function () {
          alert("Error al eliminar el ejercicio.");
        },
      });
    }
  });

  // CARGAR ALUMNOS
  function cargarAlumnos() {
    $.ajax({
      url: "../php/obtener_alumnos_registrados.php",
      method: "GET",
      dataType: "json",
      success: function (alumnos) {
        const contenedor = $("#lista-alumnos");
        contenedor.empty();
        alumnos.forEach((alumno) => {
          contenedor.append(`
            <div class="form-check col-md-3">
              <input class="form-check-input" type="checkbox" value="${alumno.id_usuario}" id="alumno-${alumno.id_usuario}">
              <label class="form-check-label" for="alumno-${alumno.id_usuario}">
                ${alumno.nombre}
              </label>
            </div>
          `);
        });
      },
      error: function () {
        alert("Error al cargar la lista de alumnos.");
      }
    });
  }

  // CARGAR EJERCICIOS
  function cargarEjercicios() {
    $.ajax({
      url: "../php/gestionar_ejercicios.php",
      method: "GET",
      data: {
        accion: "listar"
      },
      dataType: "json",
      success: function (respuesta) {
        console.log("Respuesta de ejercicios:", respuesta);

        if (!Array.isArray(respuesta)) {
          alert("Error inesperado al cargar ejercicios.");
          return;
        }

        const tabla = `
          <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
              <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Alumno</th>
                <th>Fecha asignación</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              ${respuesta.map((ej) => {
                const estado = ej.completado == 1 ? "Completado" : "Pendiente";
                const clase = ej.completado == 1 ? "table-success" : "table-danger";
                const fecha = new Date(ej.fecha_asignacion).toLocaleString();

                return `
                  <tr class="${clase}">
                    <td>${ej.titulo}</td>
                    <td>${ej.descripcion}</td>
                    <td>${ej.nombre_alumno}</td>
                    <td>${fecha}</td>
                    <td>${estado}</td>
                    <td>
                      <button class="btn btn-sm btn-danger btn-eliminar-ejercicio" data-id="${ej.id_ejercicio}">
                        <i class="bi bi-trash"></i> Eliminar
                      </button>
                    </td>
                  </tr>
                `;
              }).join("")}
            </tbody>
          </table>
        `;

        $("#tabla-ejercicios").html(tabla);
      },
      error: function (xhr) {
        console.error("Error AJAX:", xhr.responseText);
        alert("Error al obtener los ejercicios asignados.");
      },
    });
  }
});
