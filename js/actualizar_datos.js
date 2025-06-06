$(document).ready(function () {
    function mostrarModal(mensaje, esError = false) {
        const modal = new bootstrap.Modal(document.getElementById('modalMensaje'));
        $('#modalMensajeLabel').text(esError ? 'Error' : 'Mensaje');
        $('#modalCuerpoMensaje').html(mensaje);
        $('.modal-header').toggleClass('bg-danger', esError).toggleClass('bg-primary', !esError);
        modal.show();
    }

    function validarContrasena(password) {
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return regex.test(password);
    }

    $('#formActualizar').submit(function (e) {
        e.preventDefault();

        const nombre = $('input[name="nombre"]').val().trim();
        const contrasena = $('input[name="contrasena"]').val().trim();
        const correo = $('input[name="correo"]').val().trim();

        if (!nombre || !contrasena || !correo) {
            mostrarModal('Por favor, completa todos los campos.', true);
            return;
        }

        if (!validarContrasena(contrasena)) {
            mostrarModal('La contraseña no cumple con los requisitos de seguridad.', true);
            return;
        }

        $.ajax({
            url: '../modelo/procesar_actualizacion.php',
            type: 'POST',
            dataType: 'json',
            data: { nombre, contrasena, correo },
            success: function (respuesta) {
                if (respuesta.success) {
                    mostrarModal('Datos actualizados correctamente. Serás redirigido...', false);
                    setTimeout(() => {
                        window.location.href = respuesta.redirect;
                    }, 3000);
                } else {
                    mostrarModal(respuesta.error || 'Error desconocido.', true);
                }
            },
            error: function () {
                mostrarModal('Error al actualizar los datos. Intenta de nuevo.', true);
            }
        });
    });
});