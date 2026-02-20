cantidadParticipantes=0;

/**
 * Cuando se cargue la página ...
 */
window.onload = function () {
    // Ocultamos los checkbox pagados si no está marcado el activado
    // Enl marcado de los checkbox asistenca es lo 1 que se ha hecho en php
    obtener_check_boxs_sleccionados();
    // Según la información que haya en los inputs se actualiza la media
    actualizar_media();
}
/**
 * Según la información que haya en los inputs se actualiza la media
 */
function actualizar_media(){
    precioTotalInput = document.getElementById('precioTotal').value;
    cantidadParticipantesInput = document.getElementById('cantidadParticipantes').value;
    porCabezaInput = document.getElementById('porCabeza');
    precioTotal = parseInt(precioTotalInput, 10);
    cantidadParticipantes = parseInt(cantidadParticipantesInput, 10);
    media=precioTotal/cantidadParticipantes;
    porCabeza.value=Number(media.toFixed(2));
}

/**
 * Los checkbox de asistencia o pagado se activan o desactivan seguin el click 
 * ya que en su etiqueta le he puesto el evento onclick=checkBox_asistencia_o_pagado_click(this)
 * Después se actualiza la información de la tabla evento en la base de datos, llamando a la función actualizar_evento()
 * y a la función actualizar_media()
 * @param {*} checkbox 
 */
function checkBox_asistencia_o_pagado_click(checkbox) {
    partes=checkbox.id.split("-");
    nombre=partes[0];
    campo=partes[1];
    cantidadParticipantesInput=document.getElementById("cantidadParticipantes");
    const pagado = document.getElementById(nombre+"-pagado");
    const pagadoLabel = document.getElementById(nombre+"-pagado-label");
    const id_evento=document.getElementById("id_evento").value;
    if (checkbox.checked) {
        pagado.style.display = "block";
        pagadoLabel.style.display = "block";
        const asistencia = {
            id_evento: id_evento,
            nombre: nombre,
            campo: campo,
            valor: 1
        };
        if(campo=="asistencia"){
            numero = parseInt(cantidadParticipantesInput.value, 10);
            cantidadParticipantesInput.value=numero+1
        }
        enviar_peticion_post("https://murciadevs.tipolisto.es/files/eventos/api/update_asistencia.php", asistencia);
    } else {
        pagado.style.display = "none";
        pagadoLabel.style.display = "none";
        const asistencia = {
            id_evento: id_evento,
            nombre: nombre,
            campo: campo,
            valor: 0
        };
        if(campo=="asistencia"){
            numero = parseInt(cantidadParticipantesInput.value, 10);
            cantidadParticipantesInput.value=numero-1
        }
        enviar_peticion_post("https://murciadevs.tipolisto.es/files/eventos/api/update_asistencia.php", asistencia);
    }

    
    actualizar_evento();
    actualizar_media();
}
/**
 * Obtiene los datos de los inputs y actualiza el evento de la base de datos
 */
async function actualizar_evento() {
    precioTotal = document.getElementById('precioTotal').value;
    cantidadParticipantes = document.getElementById('cantidadParticipantes').value;
    id_evento=document.getElementById("id_evento").value;
    const evento={
        id_evento: id_evento,
        precio_total: precioTotal,
        cantidad_participantes: cantidadParticipantes
    }
    enviar_peticion_post("https://murciadevs.tipolisto.es/files/eventos/api/update_evento.php", evento);
    //console.log(evento);
}

/**
 * Actualiza el comentario del particpante que tenga el nombrey
 * y el id_evento en la base de datos
 * TODO: Hacerlo con id del participante
 * @param {*} input_comentario 
 */
async function actualizar_comentario(input_comentario) {
    comentario = input_comentario.value;
    partes=input_comentario.id.split("-");
    nombre_participante=partes[0];
    console.log("Actualizado comentario: "+comentario);
    const id_evento=document.getElementById("id_evento").value;
    const evento={
        id_evento: id_evento,
        nombre_participante: nombre_participante,
        comentario: comentario
    }
    enviar_peticion_post("https://murciadevs.tipolisto.es/files/eventos/api/update_comentario.php", evento);
    //console.log(evento);
}


/*
async function obtener_evento() {
    id_evento=document.getElementById("id_evento").value;
    const evento = await fetch("https://murciadevs.tipolisto.es/files/eventos/api/get_evento.php?id_evento="+id_evento);
    const eventoJSON = await evento.json();
    return eventoJSON;
}*/  


/**
 * Realiza una solicitud POST a la API de murciadevs/files/eventos/api
 * @param {*} url 
 * @param {*} data 
 */
async function enviar_peticion_post(url, data) {
    try {
        const response = await fetch(url, {
            method: "POST", // Cambia a "PUT" si tu API lo requiere
            headers: {
                "Content-Type": "application/json", // Especifica que se enviará JSON
            },
            body: JSON.stringify(data), // Convierte el objeto a una cadena JSON
        });
        // Verifica si la respuesta fue exitosa
        if (response.ok) {
            const result = await response.json(); // Convierte la respuesta a JSON            
            console.log("Actualizado con éxito:", result);
        } else {
            console.error("Error al actualizar:", response.status, response.statusText);
        }
    } catch (error) {
        console.error("Hubo un error con la solicitud:", error);
    }
}


/**
 * Recorre los checkboxs y devuelve la cantidad de checkboxs seleccionados
 * @returns (numbero de checkboxs seleccionados)
 */
function obtener_check_boxs_sleccionados(){
    const checkboxesSeleccionados = document.querySelectorAll('input[type="checkbox"]:checked');
    const checkboxesNoSeleccionados = document.querySelectorAll('input[type="checkbox"]:not(:checked)');
    checkboxesNoSeleccionados.forEach(checkbox => {
        partes=checkbox.id.split("-");
        nombre=partes[0];
        cantidadParticipantesInput=document.getElementById("cantidadParticipantes");
        pagado = document.getElementById(nombre+"-pagado");
        pagadoLabel = document.getElementById(nombre+"-pagado-label");      
        if(pagado==null || pagadoLabel==null){
            console.log("No se encuentra el checkbox de "+nombre);
        }else{
            pagado.style.display = "none";
            pagadoLabel.style.display = "none";
        }

    });
    // Mostrar los valores de los checkboxes seleccionados
    checkboxesSeleccionados.forEach(checkbox => {
        partes=checkbox.id.split("-");
        nombre=partes[0];
        cantidadParticipantesInput=document.getElementById("cantidadParticipantes");
        pagado = document.getElementById(nombre+"-pagado");
        pagadoLabel = document.getElementById(nombre+"-pagado-label");    
        if(pagado==null || pagadoLabel==null){
            console.log("No se encuentra el checkbox de "+nombre);
        }else{    
            pagado.style.display = "block";
            pagadoLabel.style.display = "block";
        }
    });
    
    // Si necesitas los valores en un array
    const valoresSeleccionados = Array.from(checkboxesSeleccionados).map(checkbox => checkbox.value);
    //console.log("Los valores selecionados son:", valoresSeleccionados.length);
    return valoresSeleccionados.length;
}



