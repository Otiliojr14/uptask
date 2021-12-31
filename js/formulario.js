import { usuario, password, formulario, accion } from "./selectores.js";

const formLogin = {
    usuario: `${usuario.value}`,
    password: `${password.value}`
}

usuario.addEventListener('blur', datosLogin);
password.addEventListener('blur', datosLogin);
const accionValue = accion.value;

window.onload = () => {
    formulario.addEventListener('submit', validarRegistro);
}

function validarRegistro(e) {
    e.preventDefault();
    if (!validarFormulario(formLogin)) {
        swal({
            type: 'error',
            title: 'Error!',
            text: 'Ambos campos son obligatorios',
          });
    } else {
        const {usuario, password} = formLogin;
        const datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('password', password);
        datos.append('accion', accionValue);

        // Consulta AJAX
        
        const xhr = new XMLHttpRequest();

        xhr.open('POST', './inc/models/modelo-admin.php', true);

        xhr.onload = function () {
            if (this.status === 200) {
                var respuesta = (JSON.parse(xhr.responseText));

                // Si la respuesta es correcta
                if (respuesta.respuesta === 'correcto') {
                    // Si es nuevo usuario
                    if (respuesta.tipo === 'crear') {
                        swal({
                            type: 'success',
                            title: 'Usuario Creado',
                            text: 'El usuario se creo correctamente',
                          });                        
                    } else if (respuesta.tipo === 'login') {
                        swal({
                            type: 'success',
                            title: 'Login correcto',
                            text: 'Presiona OK para abrir el dashboard',
                          })
                          .then(resultado => {
                            if (resultado.value) {
                                window.location.href = 'index.php';
                            }
                          });
                    }
                } else {
                    swal({
                        type: 'error',
                        title: 'Error',
                        text: 'Hubo un error',
                      });   
                }
            }
        }

        xhr.send(datos);
    }
}

function datosLogin(e, form) {
    formLogin[e.target.name] = e.target.value;
}

function validarFormulario(obj) {
    return Object.values(obj).every( input => input !== '');
}

