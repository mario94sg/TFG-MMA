$(document).ready(function () {
  const calendarEl = document.getElementById('calendar');

  const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    locale: 'es',
    headerToolbar: {
      left: 'prev,next today',
      center: 'title',
      right: 'dayGridMonth,timeGridWeek'
    },
    events: {
      url: '../../modelo/obtener_eventos.php',
      method: 'GET',
      failure: function () {
        alert('Error al cargar eventos');
      }
    },
    eventColor: '#1976d2',
    eventTextColor: '#ffffff',
    eventDisplay: 'block',
    eventDidMount: function (info) {
      $(info.el).css({
        'border-radius': '8px',
        'font-weight': 'bold'
      }).attr('title', info.event.extendedProps.description);
    },
    eventClick: function (info) {
      $("#detalle-titulo").text(info.event.title);
      $("#detalle-descripcion").text(info.event.extendedProps.description);
      $("#detalle-inicio").text(info.event.start.toISOString().split('T')[0]);
      $("#detalle-fin").text(info.event.end
        ? info.event.end.toISOString().split('T')[0]
        : info.event.start.toISOString().split('T')[0]
      );
      $("#evento-detalles table").removeClass("d-none");
    }
  });

  calendar.render();
});