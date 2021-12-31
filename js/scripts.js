import { nuevoProyecto, listaProyectos, nuevaTarea, idProyecto, listado, listadoTareas, porcentaje } from "./selectores.js";

window.onload = () => {
    nuevoProyecto.addEventListener('click', newProject);
    nuevaTarea.addEventListener('click', agregarTarea);
    listadoTareas.addEventListener('click', accionesTareas);
    actualizarProgreso();
}

function newProject(e) {
    e.preventDefault();
    
    const agregarProyecto = document.createElement('li');
    agregarProyecto.innerHTML = '<input type="text" id="nuevo-proyecto">';

    //Agregar nodo a la lista de proyectos
    listaProyectos.appendChild(agregarProyecto);
    const inputNuevoProyecto = document.querySelector('#nuevo-proyecto');

    // Verificando que se presiona la tecla enter.
    inputNuevoProyecto.addEventListener('keypress', (e) => {
        const tecla = e.which || e.KeyCode;
        if (tecla === 13) {
            guardarProyectoDB(inputNuevoProyecto.value);
            listaProyectos.removeChild(agregarProyecto);
        }
    });
}

function guardarProyectoDB(nombreProyecto) {
    // Crear conexion AJAX

    const xhr = new XMLHttpRequest();

    // Enviar datos por formdata
    const datos = new FormData();

    datos.append('proyecto', nombreProyecto);
    datos.append('accion', 'crear');

    xhr.open('POST', './inc/models/modelo-proyecto.php', true);

    xhr.onload = function() {
        if (this.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            const proyecto = respuesta.nombre_proyecto,
                  id_proyecto = respuesta.id_insertado,
                  tipo = respuesta.tipo,
                  resultado = respuesta.respuesta;

                  if (resultado === 'correcto') {
                      if (tipo === 'crear') {
                        const agregarProyecto = document.createElement('li');
                        agregarProyecto.innerHTML = `
                            <a href="index.php?id_proyecto=${id_proyecto}" id="proyecto:${id_proyecto}">
                                ${nombreProyecto}
                            </a>
                        `;
                        listaProyectos.appendChild(agregarProyecto);

                        swal({
                            type: 'success',
                            title: 'Proyecto Creado',
                            text: 'El proyecto: ' + proyecto + ' se creo correctamente',
                          })
                          .then(resultado => {
                            if (resultado.value) {
                                window.location.href = 'index.php?id_proyecto=' + id_proyecto;
                            }
                          });  
                      } else {
                          
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

function agregarTarea(e) {
    e.preventDefault();

    const nombreTarea = document.querySelector('.nombre-tarea').value;

    if (nombreTarea === '') {
        swal({
            type: 'error',
            title: 'Error!',
            text: 'Una tarea no puede ir vacia',
          });
    } else {
        // Llamado AJAX
        const xhr = new XMLHttpRequest();

        const datos = new FormData();
        datos.append('tarea', nombreTarea);
        datos.append('accion', 'crear');
        datos.append('id_proyecto', idProyecto.value);

        xhr.open('POST', './inc/models/modelo-tareas.php', true);

        xhr.onload = function () {
            if (this.status === 200) {
                const respuesta = JSON.parse(xhr.responseText);
                
                const resultado = respuesta.respuesta,
                      tarea = respuesta.tarea,
                      id_insertado = respuesta.id_insertado,
                      tipo = respuesta.tipo;

                if (resultado === 'correcto') {
                    // Se agrego correctamente
                    if (tipo === 'crear') {
                        // Alerta de aviso al usuario
                        swal({
                            type: 'success',
                            title: 'Tarea creada',
                            text: 'La tarea: ' + tarea + ' se creó correctamente',
                          });   
                          
                          // Eliminar el mensaje de ninguna tarea asignada
                          const parrafoListaVacia = document.querySelector('.lista-vacia');
                          if (parrafoListaVacia) {
                              parrafoListaVacia.remove();
                          }
                        
                          // Construir el nodo HTML

                          const nuevaTareaHTML = document.createElement('li');
                          // Agregar ID
                          nuevaTareaHTML.id = `tarea:${id_insertado}`;
                          nuevaTareaHTML.classList.add('tarea');

                          // Construir el HTML
                          nuevaTareaHTML.innerHTML = `
                            <p>${tarea}</p>
                            <div class="acciones">
                                <i class="far fa-check-circle"></i>
                                <i class="fas fa-trash"></i>
                            </div>
                          `;

                          listado.appendChild(nuevaTareaHTML);

                          document.querySelector('.agregar-tarea').reset();
                          actualizarProgreso();
                    }
                } else {
                    // Error en la respuesta
                    swal({
                        type: 'error',
                        title: 'Error!',
                        text: 'Hubo un error',
                      });
                }
            }
        }

        xhr.send(datos);
    }

}

function accionesTareas(e) {
    e.preventDefault();

    if (e.target.classList.contains('fa-check-circle')) {
        e.target.classList.toggle('completo');
        if (e.target.classList.contains('completo')) {
            cambiarEstadoTarea(e.target, 1);
        } else {
            cambiarEstadoTarea(e.target, 0);
        }
        
    } else if(e.target.classList.contains('fa-trash')) {
        swal({
            title: 'Seguro(a)?',
            text: "Esta acción no se puede deshacer",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, borrar!',
            cancelButtonText: 'Cancelar'
          }).then((result) => {
            const tareaEliminar = e.target.parentElement.parentElement;

            eliminarTarea(tareaEliminar);

            tareaEliminar.remove();

            swal({
                type: 'success',
                title: 'Eliminado',
                text: 'La tarea fue eliminada!',
              });
              
              // Agregar mensajes de tareas vacias si no hay mas tareas en el proyecto
            const listaTareasRestantes = document.querySelectorAll('li.tarea');
            // Si no hay ninguna tarea, agregar mensaje
            if (listaTareasRestantes.length === 0) {
                listado.innerHTML = '<p class="lista-vacia">No hay tareas en este proyecto</p>';
            }
          });
    }
}

function cambiarEstadoTarea(tarea, estado) {
    const idTarea = tarea.parentElement.parentElement.id.split(':');

    // AJAX

    const xhr = new XMLHttpRequest();

    // Informacion a enviar a AJAX
    const datos = new FormData();
    datos.append('id', idTarea[1]);
    datos.append('accion', 'actualizar');
    datos.append('estado', estado);

    xhr.open('POST', './inc/models/modelo-tareas.php', true);

    xhr.onload = function () {
        if (this.status === 200) {
            JSON.parse(xhr.responseText);
            actualizarProgreso();
        }
    }

    xhr.send(datos);
}

function eliminarTarea(tarea) {
    const idTarea = tarea.id.split(':');

    // AJAX

    const xhr = new XMLHttpRequest();

    // Informacion a enviar a AJAX
    const datos = new FormData();
    datos.append('id', idTarea[1]);
    datos.append('accion', 'eliminar');

    xhr.open('POST', './inc/models/modelo-tareas.php', true);

    xhr.onload = function () {
        if (this.status === 200) {
            console.log(JSON.parse(xhr.responseText));
            actualizarProgreso();
        }
    }

    xhr.send(datos);
}

function actualizarProgreso() {
    const tareas = document.querySelectorAll('li.tarea');
    const tareasCompletadas = document.querySelectorAll('i.completo');

    const avance = Math.round((tareasCompletadas.length / tareas.length) * 100);

    porcentaje.style.width = `${avance}%`;

    if (avance === 100) {
        swal({
            type: 'success',
            title: 'Proyecto terminado',
            text: 'Ya no tienes tareas pendientes',
          });  
    }

}