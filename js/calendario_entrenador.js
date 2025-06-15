$(document).ready(function () {
  const calendarEl = document.getElementById("calendar");
  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: "dayGridMonth",
    locale: "es",
    headerToolbar: {
      left: "prev,next today",
      center: "title",
      right: "dayGridMonth,timeGridWeek",
    },
    events: {
      url: "../../modelo/gestionar_eventos.php",
      method: "GET",
    },
    eventColor: "#1976d2",
    eventTextColor: "#ffffff",
    eventDisplay: "block",
    eventClick: function (info) {
      $("#id_evento").val(info.event.id);
      $("#titulo").val(info.event.title);
      $("#descripcion").val(info.event.extendedProps.description);
      $("#fecha_inicio").val(info.event.startStr);
      $("#fecha_fin").val(info.event.endStr ? info.event.endStr.slice(0, 10) : info.event.startStr);
    },
  });

  calendar.render();
  cargarEventosTabla();

  $("#form-evento").submit(function (e) {
    e.preventDefault();
    const datos = {
      id_evento: $("#id_evento").val(),
      titulo: $("#titulo").val(),
      descripcion: $("#descripcion").val(),
      fecha_evento: $("#fecha_inicio").val(),
      fecha_evento_fin: $("#fecha_fin").val(),
    };

    $.post("../../modelo/gestionar_eventos.php", { action: "guardar", ...datos }, function (response) {
      mostrarModalMensaje("Evento guardado correctamente");
      calendar.refetchEvents();
      cargarEventosTabla();
      $("#form-evento")[0].reset();
    });
  });

  function cargarEventosTabla() {
    $.get("../../modelo/gestionar_eventos.php", function (eventos) {
      const tabla = $("#tabla-eventos").empty();
      eventos.forEach((ev) => {
        tabla.append(`
          <tr>
            <td>${ev.title}</td>
            <td>${ev.description}</td>
            <td>${ev.start}</td>
            <td>${ev.end}</td>
            <td>
              <button class="btn btn-sm btn-info btn-editar" data-id="${ev.id}">Editar</button>
              <button class="btn btn-sm btn-danger btn-eliminar" data-id="${ev.id}">Eliminar</button>
            </td>
          </tr>
        `);
      });

      $(".btn-editar").click(function () {
        const evento = eventos.find(e => e.id == $(this).data("id"));
        $("#id_evento").val(evento.id);
        $("#titulo").val(evento.title);
        $("#descripcion").val(evento.description);
        $("#fecha_inicio").val(evento.start);
        $("#fecha_fin").val(evento.end);
      });

      $(".btn-eliminar").click(function () {
        eventoAEliminar = $(this).data("id");
        $("#modalCuerpoConfirmacion").text("¿Seguro que quieres eliminar este evento?");
        $("#modalConfirmacion").modal("show");
      });
    }, "json");
  }


  function mostrarModalMensaje(mensaje) {
    $("#modalCuerpoMensaje").text(mensaje);
    $("#modalMensaje").modal("show");
  }


  let eventoAEliminar = null;
  $("#btnConfirmarEliminar").click(function () {
    if (eventoAEliminar) {
      $.post("../../modelo/gestionar_eventos.php", { action: "eliminar", id_evento: eventoAEliminar }, function () {
        mostrarModalMensaje("Evento eliminado correctamente");
        calendar.refetchEvents();
        cargarEventosTabla();
        eventoAEliminar = null;
        $("#modalConfirmacion").modal("hide");
      });
    }
  });
});
