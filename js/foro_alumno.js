$(document).ready(function () {
  const mostrarModal = (mensaje) => {
    $("#modalAlertBody").text(mensaje);
    const modal = new bootstrap.Modal(document.getElementById("modalAlert"));
    modal.show();
  };

  let mensajeAEliminar = null;
  let idAsuntoActivo = null;

  function cargarAsuntos() {
    $.post("../../modelo/gestionar_foro.php", { accion: "obtener_asuntos" }, function (res) {
      if (res.success) {
        $("#asuntos-container").empty();
        res.asuntos.forEach((asunto) => {
          const btn = $(`<button class="btn btn-outline-secondary" data-id="${asunto.id_asunto}">${asunto.titulo}</button>`);
          btn.click(() => toggleConversacion(asunto.id_asunto, asunto.titulo));
          $("#asuntos-container").append(btn);
        });
      }
    }, "json");
  }

  function toggleConversacion(id_asunto, titulo) {
    idAsuntoActivo = id_asunto;
    const cardId = `asunto-${id_asunto}`;
    const existente = $(`#${cardId}`);
    if (existente.length) {
      existente.toggle();
      return;
    }

    const card = $(`
      <div class="card mb-3" id="${cardId}">
        <div class="card-header">
          <h5 class="mb-0">${titulo}</h5>
        </div>
        <div class="card-body">
          <form class="form-enviar-mensaje mb-3" data-id="${id_asunto}">
            <textarea class="form-control mb-2" placeholder="Escribe un mensaje..." required></textarea>
            <button type="submit" class="btn btn-primary">Enviar</button>
          </form>
          <div class="mensajes" style="max-height: 300px; overflow-y: auto;"></div>
        </div>
      </div>
    `);

    $("#conversaciones").append(card);
    cargarMensajes(id_asunto);

    card.find(".form-enviar-mensaje").submit(function (e) {
      e.preventDefault();
      const form = $(this);
      const mensajeInput = form.find("textarea");
      const mensaje = mensajeInput.val();
      const id = form.data("id");

      $.post("../../modelo/gestionar_foro.php", {
        accion: "enviar_mensaje",
        mensaje,
        id_asunto: id
      }, function (res) {
        if (res.success) {
          mensajeInput.val("");
          cargarMensajes(id);
        }
      }, "json");
    });
  }

  function cargarMensajes(id_asunto) {
    $.post("../../modelo/gestionar_foro.php", { accion: "obtener_mensajes", id_asunto }, function (res) {
      if (res.success) {
        const container = $(`#asunto-${id_asunto} .mensajes`);
        container.empty();
        res.mensajes.reverse().forEach((m) => {
          const fecha = new Date(m.fecha_mensaje).toLocaleString();
          const msg = $(`
            <div class="border rounded p-2 mb-2">
              <strong>${m.nombre}:</strong> ${m.contenido}
              <div class="text-end small text-muted">${fecha}</div>
              ${m.propietario ? `<button class="btn btn-sm btn-danger mt-1 eliminar-mensaje" data-id="${m.id_mensaje}">Eliminar</button>` : ""}
            </div>
          `);
          msg.find(".eliminar-mensaje").click(function () {
            mensajeAEliminar = m.id_mensaje;
            idAsuntoActivo = id_asunto;
            const modalConfirmar = new bootstrap.Modal(document.getElementById("modalConfirmarEliminar"));
            modalConfirmar.show();
          });
          container.append(msg);
        });
      }
    }, "json");
  }

  $("#btnConfirmarEliminar").click(function () {
    if (mensajeAEliminar !== null) {
      $.post("../../modelo/gestionar_foro.php", {
        accion: "eliminar_mensaje",
        id_mensaje: mensajeAEliminar
      }, function (r) {
        if (r.success) {
          cargarMensajes(idAsuntoActivo);
          mostrarModal("Mensaje eliminado correctamente");
        } else {
          mostrarModal("Error al eliminar el mensaje");
        }
        mensajeAEliminar = null;
        idAsuntoActivo = null;
        const modalConfirmar = bootstrap.Modal.getInstance(document.getElementById("modalConfirmarEliminar"));
        modalConfirmar.hide();
      }, "json");
    }
  });

  $("#form-nuevo-asunto").submit(function (e) {
    e.preventDefault();
    const titulo = $("#titulo_asunto").val();
    const mensaje = $("#mensaje_inicial").val();

    $.post("../../modelo/gestionar_foro.php", {
      accion: "crear_asunto",
      titulo,
      mensaje
    }, function (res) {
      if (res.success) {
        mostrarModal("Asunto creado correctamente");
        $("#titulo_asunto, #mensaje_inicial").val("");
        cargarAsuntos();
      } else {
        mostrarModal(res.error || "Error al crear asunto");
      }
    }, "json");
  });

  cargarAsuntos();
});
