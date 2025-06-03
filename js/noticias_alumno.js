$(document).ready(function () {
    cargarNoticias();

    function cargarNoticias() {
        $.getJSON("../php/gestionar_noticias.php", { accion: "obtener" }, function (noticias) {
            const contenedor = $("#listaNoticias");
            contenedor.empty();

            noticias.forEach(n => {
                contenedor.append(`
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <h5 class="card-title">${n.titulo}</h5>
                <p class="card-text">${n.contenido}</p>
                <p class="text-muted small">Publicado por ${n.nombre} el ${new Date(n.fecha_publicacion_noticia).toLocaleString()}</p>
              </div>
            </div>
          </div>
        `);
            });

            if (noticias.length === 0) {
                contenedor.append(`<div class="col"><div class="alert alert-info">No hay noticias disponibles.</div></div>`);
            }
        });
    }
});
