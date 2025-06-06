$(document).ready(function () {
    cargarNoticias();

    $("#formNoticia").on("submit", function (e) {
        e.preventDefault();
        $.post("../../modelo/gestionar_noticias.php", $(this).serialize(), function (res) {
            if (res.success) {
                $("#formNoticia")[0].reset();
                cargarNoticias();
            }
        }, "json");
    });

    // Abrir modal de edición
    $(document).on("click", ".editar-noticia", function () {
        const card = $(this).closest(".card");
        const id = $(this).data("id");
        const titulo = card.find(".titulo").text();
        const contenido = card.find(".contenido").text();

        $("#edit_id_noticia").val(id);
        $("#edit_titulo").val(titulo);
        $("#edit_contenido").val(contenido);
        const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
        modal.show();
    });

    // Guardar cambios editados
    $("#formEditarNoticia").on("submit", function (e) {
        e.preventDefault();
        const datos = {
            accion: "editar",
            id_noticia: $("#edit_id_noticia").val(),
            titulo: $("#edit_titulo").val(),
            contenido: $("#edit_contenido").val()
        };

        $.post("../../modelo/gestionar_noticias.php", datos, function (res) {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEditar')).hide();
                cargarNoticias();
            }
        }, "json");
    });

    // Abrir modal de eliminación
    $(document).on("click", ".eliminar-noticia", function () {
        const id = $(this).data("id");
        $("#delete_id_noticia").val(id);
        const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
        modal.show();
    });


    $("#confirmarEliminar").on("click", function () {
        const id = $("#delete_id_noticia").val();
        $.post("../../modelo/gestionar_noticias.php", { accion: "eliminar", id_noticia: id }, function (res) {
            if (res.success) {
                bootstrap.Modal.getInstance(document.getElementById('modalEliminar')).hide();
                cargarNoticias();
            }
        }, "json");
    });

    function cargarNoticias() {
        $.getJSON("../../modelo/gestionar_noticias.php", { accion: "obtener" }, function (noticias) {
            const contenedor = $("#listaNoticias");
            contenedor.empty();
            noticias.forEach(n => {
                contenedor.append(`
          <div class="col">
            <div class="card shadow-sm">
              <div class="card-body">
                <h5 class="card-title titulo">${n.titulo}</h5>
                <p class="card-text contenido">${n.contenido}</p>
                <p class="text-muted small">Publicado por ${n.nombre} el ${new Date(n.fecha_publicacion_noticia).toLocaleString()}</p>
                <button class="btn btn-sm btn-warning editar-noticia" data-id="${n.id_noticia}">Editar</button>
                <button class="btn btn-sm btn-danger eliminar-noticia" data-id="${n.id_noticia}">Eliminar</button>
              </div>
            </div>
          </div>
        `);
            });
        });
    }
});
