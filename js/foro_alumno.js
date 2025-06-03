$(document).ready(function () {
  cargarMensajes();

  // Manejo del formulario
  $("#form-mensaje").submit(function (e) {
    e.preventDefault();
    const contenido = $("#mensaje").val().trim();

    if (contenido !== "") {
      $.post("../php/gestionar_foro.php", {
        accion: "insertar",
        contenido: contenido
      }, function (respuesta) {
        if (respuesta.estado === "ok") {
          $("#mensaje").val("");
          cargarMensajes();
        } else {
          alert("Error al publicar el mensaje: " + (respuesta.error || "desconocido"));
        }
      }, "json");
    }
  });

  // Guardar ID del mensaje a eliminar
  let mensajeAEliminar = null;

  $(document).on("click", ".btn-eliminar", function () {
    mensajeAEliminar = $(this).data("id");
    $("#confirmarEliminarModal").modal("show");
  });

  // Confirmar eliminación
  $("#btn-confirmar-eliminar").click(function () {
    if (mensajeAEliminar) {
      $.post("../php/gestionar_foro.php", {
        accion: "eliminar",
        id_mensaje: mensajeAEliminar
      }, function (respuesta) {
        if (respuesta.estado === "ok") {
          cargarMensajes();
          $("#confirmarEliminarModal").modal("hide");
        } else {
          alert("Error al eliminar: " + (respuesta.error || "desconocido"));
        }
      }, "json");
    }
  });

  // Función para cargar mensajes
  function cargarMensajes() {
    $.get("../php/gestionar_foro.php", {
      accion: "listar"
    }, function (mensajes) {
      const contenedor = $("#lista-mensajes");
      contenedor.empty();

      mensajes.forEach(msg => {
        const esPropio = msg.id_usuario == userId;
        const fecha = new Date(msg.fecha_mensaje);
        const hora = fecha.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        const dia = fecha.toLocaleDateString();

        const card = `
          <div class="card mb-3">
            <div class="card-header d-flex justify-content-between">
              <strong>${msg.nombre}</strong>
              <small>${hora} - ${dia}</small>
            </div>
            <div class="card-body">
              <p class="card-text">${msg.contenido}</p>
              ${esPropio ? `<button class="btn btn-sm btn-danger btn-eliminar" data-id="${msg.id_mensaje}">Eliminar</button>` : ""}
            </div>
          </div>
        `;
        contenedor.append(card);
      });
    }, "json").fail(function (xhr) {
      console.error("Error al cargar mensajes:", xhr.responseText);
    });
  }
});
