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
        data.forEach(hit => {
          const receta = hit.recipe;
          const calorias = Math.round(receta.calories);
          const porciones = Math.max(1, receta.yield);
          const porPorcion = Math.round(calorias / porciones);
          const ingredientes = receta.ingredientLines.map(i => `<li>${i}</li>`).join("");

          html += `
            <div class="col-md-4 mb-4">
              <div class="card h-100">
                <img src="${receta.image}" class="card-img-top" alt="${receta.label}">
                <div class="card-body">
                  <h5 class="card-title">${receta.label}</h5>
                  <p>
                    <strong>Porciones:</strong> ${porciones}<br>
                    <strong>Calorías por porción:</strong> ${porPorcion}<br>
                    <strong>Tiempo:</strong> ${receta.totalTime} min<br>
                    <strong>Ingredientes:</strong><ul>${ingredientes}</ul>
                  </p>
                  <a href="${receta.url}" target="_blank" class="btn btn-outline-primary">Ver receta</a>
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
});
