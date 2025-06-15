$(document).ready(function () {
  $('#formBusqueda').on('submit', function (e) {
    e.preventDefault();

    const query = $('#query').val();
    const exclude = $('#exclude').val();
    const health = $('#health').val();
    const diet = $('#diet').val();
    const mealType = $('#mealType').val();
    const minCalories = $('#minCalories').val();
    const maxCalories = $('#maxCalories').val();
    const maxPerServing = $('#maxPerServing').val();
    const maxTime = $('#maxTime').val();
    const sortOrder = $('#sortOrder').val();

    $('#resultadosRecetas').html('<div class="text-center">Buscando recetas...</div>');

    $.ajax({
      url: '../../api/buscar_recetas.php',
      method: 'GET',
      dataType: 'json',
      data: {
        q: query,
        exclude: exclude,
        diet: diet,
        health: health,
        mealType: mealType,
        minCalories: minCalories,
        maxCalories: maxCalories,
        maxPerServing: maxPerServing,
        maxTime: maxTime,
        sort: sortOrder
      },
      success: function (data) {
        if (data.error) {
          $('#resultadosRecetas').html(`<div class="alert alert-danger"><strong>Error:</strong> ${data.error}</div>`);
          return;
        }

        if (!data.length) {
          $('#resultadosRecetas').html('<div class="alert alert-warning">No se encontraron recetas.</div>');
          return;
        }

        let html = '<div class="row">';
        data.forEach((hit, index) => {
          const receta = hit.recipe;
          const calorias = Math.round(receta.calories);
          const porciones = Math.max(1, receta.yield);
          const porPorcion = Math.round(calorias / porciones);
          const ingredientes = receta.ingredientLines.map(i => `<li>${i}</li>`).join("");
          const ingredientesTextoPlano = receta.ingredientLines.join('\n');

          html += `
          <div class="col-md-4 mb-4">
            <div class="card h-100">
              <img src="${receta.image}" class="card-img-top" alt="${receta.label}">
              <div class="card-body" id="receta-${index}">
                <h5 class="card-title">${receta.label}</h5>
                <p>
                  <strong>Porciones:</strong> ${porciones}<br>
                  <strong>Calorías por porción:</strong> ${porPorcion}<br>
                  <strong>Tiempo:</strong> ${receta.totalTime} min<br>
                  <strong>Ingredientes:</strong>
                  <ul class="ingredientes-lista" data-original="${ingredientesTextoPlano}" data-id="${index}">
                    ${ingredientes}
                  </ul>
                </p>
                
                <a href="${receta.url}" target="_blank" class="btn btn-outline-primary">Ver receta</a>
                <button class="btn btn-secondary mt-2 btn-traducir" data-id="${index}">Traducir</button>
                </div>
                
            </div>
          </div>
        `;
        });
        html += '</div>';

        $('#resultadosRecetas').html(html);
      },
      error: function (xhr, status, error) {
        $('#resultadosRecetas').html(`<div class="alert alert-danger">Error: ${error}<br>${xhr.responseText}</div>`);
      }
    });
  });


  // Traducción al pulsar el botón
  $(document).on('click', '.btn-traducir', function () {
    const index = $(this).data('id');
    const $ul = $(`.ingredientes-lista[data-id="${index}"]`);
    const $btn = $(this);

    if ($btn.data('traducido')) {
      const originalTexto = $ul.data('original');
      const originalHTML = originalTexto.split('\n').map(i => `<li>${i}</li>`).join('');
      $ul.html(originalHTML);
      $btn.data('traducido', false).text('Traducir');
      return;
    }

    const textoOriginal = $ul.data('original');
    $btn.prop('disabled', true).text('Traduciendo...');

    $.ajax({
      url: '../../api/traducir.php',
      method: 'POST',
      dataType: 'json',
      data: { texto: textoOriginal },
      success: function (response) {
        if (response.traduccion) {
          const traducido = response.traduccion;
          const traducidoHTML = traducido.split('\n').map(i => `<li>${i}</li>`).join('');
          $ul.html(traducidoHTML);
          $btn.data('traducido', true).text('Mostrar original');
        } else {
          $btn.text('Error al traducir');
        }
        $btn.prop('disabled', false);
      },
      error: function () {
        $btn.text('Error al traducir').prop('disabled', false);
      }
    });
  });

});
