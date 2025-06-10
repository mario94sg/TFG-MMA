$(document).ready(function () {
  const mostrarModal = (mensaje) => {
    $("#modalAlertBody").text(mensaje);
    const modal = new bootstrap.Modal(document.getElementById("modalAlert"));
    modal.show();
  };

  let mensajeAEliminar = null;
  let idAsuntoActivo = null;

  // === NUEVAS FUNCIONES DE GESTIÓN DE ASUNTOS ACTIVOS ===
  const getAsuntosActivos = () => {
    const activos = localStorage.getItem("asuntos_activos_alumno");
    return activos ? JSON.parse(activos) : [];
  };

  const setAsuntosActivos = (activos) => {
    localStorage.setItem("asuntos_activos_alumno", JSON.stringify(activos));
  };

  const agregarAsuntoActivo = (id) => {
    const activos = getAsuntosActivos();
    if (!activos.includes(id)) {
      activos.push(id);
      setAsuntosActivos(activos);
    }
  };

  const quitarAsuntoActivo = (id) => {
    const activos = getAsuntosActivos().filter((a) => a !== id);
    setAsuntosActivos(activos);
  };

  function cargarAsuntos() {
    $.post("../../modelo/gestionar_foro.php", { accion: "obtener_asuntos" }, function (res) {
      if (res.success) {
        $("#asuntos-container").empty();
        const asuntosActivos = getAsuntosActivos();

        res.asuntos.forEach((asunto) => {
          const btn = $(`<button class="btn me-2" data-id="${asunto.id_asunto}">${asunto.titulo}</button>`);
          if (asuntosActivos.includes(asunto.id_asunto)) {
            btn.addClass("btn-success");
          } else {
            btn.addClass("btn-outline-secondary");
          }

          btn.click(() => toggleConversacion(asunto.id_asunto, asunto.titulo, btn));
          $("#asuntos-container").append(btn);
        });

        // Reabrir los asuntos activos
        asuntosActivos.forEach(id => {
          const asunto = res.asuntos.find(a => a.id_asunto === id);
          if (asunto) {
            toggleConversacion(asunto.id_asunto, asunto.titulo, $(`button[data-id='${asunto.id_asunto}']`), true);
          }
        });
      }
    }, "json");
  }

  function toggleConversacion(id_asunto, titulo, boton, forzado = false) {
    idAsuntoActivo = id_asunto;
    const cardId = `asunto-${id_asunto}`;
    const existente = $(`#${cardId}`);

    if (existente.length && !forzado) {
      existente.toggle();
      const visible = existente.is(":visible");

      if (visible) {
        boton.removeClass("btn-outline-secondary").addClass("btn-success");
        agregarAsuntoActivo(id_asunto);
      } else {
        boton.removeClass("btn-success").addClass("btn-outline-secondary");
        quitarAsuntoActivo(id_asunto);
      }

      return;
    }

    if (existente.length && forzado) {
      existente.show();
      boton.removeClass("btn-outline-secondary").addClass("btn-success");
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

    $("#conversaciones").prepend(card);
    cargarMensajes(id_asunto);
    agregarAsuntoActivo(id_asunto);
    boton.removeClass("btn-outline-secondary").addClass("btn-success");

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
