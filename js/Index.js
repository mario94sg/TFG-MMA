$(document).ready(function () {
    cargarEventos();
});

function mostrarFormulario(form) {
    if (form === 'login') {
        $('#formLogin').removeClass('hidden');
        $('#formRegistro').addClass('hidden');
        $('#btnLogin').removeClass('btn-secondary').addClass('btn-primary');
        $('#btnRegistro').removeClass('btn-primary').addClass('btn-secondary');
    } else {
        $('#formLogin').addClass('hidden');
        $('#formRegistro').removeClass('hidden');
        $('#btnLogin').removeClass('btn-primary').addClass('btn-secondary');
        $('#btnRegistro').removeClass('btn-secondary').addClass('btn-primary');
    }
}

function mostrarModalMensaje(mensaje, color = 'primary') {
    $('#modalMensajeLabel').text('Mensaje');
    $('#contenidoModalMensaje').html(`<div class="alert alert-${color}" role="alert">${mensaje}</div>`);
    const modal = new bootstrap.Modal(document.getElementById('modalMensaje'));
    modal.show();
}

function cargarEventos() {
    $('#login').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: './modelo/procesar_login.php',
            type: 'POST',
            dataType: 'json',
            data: {
                email: $('#emailLogin').val(),
                contrasena: $('#contrasenaLogin').val()
            },
            success: function (response) {
                if (response.success) {
                    const modal = new bootstrap.Modal(document.getElementById('modal2FA'));
                    modal.show();
                } else {
                    mostrarModalMensaje('Error de inicio de sesión: ' + response.message, 'danger');
                }
            },
            error: function (error) {
                console.error('Error al iniciar sesión:', error);
                mostrarModalMensaje('Ocurrió un error al intentar iniciar sesión.', 'danger');
            }
        });
    });

    $('#verificarCodigo').click(function (e) {
        e.preventDefault();
        const codigo = $('#codigo2FA').val().trim();

        if (!/^\d{6}$/.test(codigo)) {
            $('#codigo2FA').addClass('is-invalid');
            return;
        } else {
            $('#codigo2FA').removeClass('is-invalid');
        }

        $.ajax({
            url: './controlador/verificar_2fa.php',
            type: 'POST',
            dataType: 'json',
            data: { codigo: codigo },
            success: function (res) {
                if (res.validado) {
                    if (res.tipo === 'entrenador') {
                        window.location.href = './vistas/entrenador/vista_entrenador.php';
                    } else if (res.tipo === 'alumno') {
                        window.location.href = './vistas/alumno/vista_alumno.php';
                    } else {
                        mostrarModalMensaje('Tipo de usuario desconocido.', 'danger');
                    }
                } else {
                    mostrarModalMensaje(res.mensaje || 'Código incorrecto.', 'danger');
                }
            },
            error: function () {
                mostrarModalMensaje('Error al verificar el código. Intenta más tarde.', 'danger');
            }
        });
    });

    $('#registrarse').click(function (e) {
        e.preventDefault();

        const datosRegistro = $('#formRegistro').serialize();

        $.ajax({
            url: './modelo/procesar_registro.php',
            type: 'POST',
            dataType: 'json',
            data: datosRegistro,
            success: function (response) {
                if (response.success) {
                    mostrarModalMensaje('Registro exitoso. Redirigiendo...', 'success');
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 2000);
                } else {
                    mostrarModalMensaje('Error en el registro: ' + response.message, 'danger');
                }
            },
            error: function (xhr, status, error) {
                console.error('Error AJAX:', error);
                mostrarModalMensaje('Ocurrió un error al procesar el registro. Intenta de nuevo.', 'danger');
            }
        });
    });
}