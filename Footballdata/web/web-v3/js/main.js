window.onload = function () {
    
    // Seleccionamos todos los elementos li dentro del ul
    const mostrarListaOpciones=document.getElementById("mostrarListaOpciones");
    const elementosLi = document.querySelectorAll("#miLista li");
    const lista = document.getElementById("miLista");
    var inputTextFieldToSearch=document.getElementById("fieldSearchResult");
    mostrarListaOpciones.addEventListener("click", function() {
        if (lista.style.display === "none" || lista.style.display === "") {
            lista.style.display = "block"; // Mostrar la lista
        } else {
            lista.style.display = "none"; // Ocultar la lista
        }
    })
    elementosLi.forEach(function(li) {
        // Añadimos un evento 'click' a cada li
        li.addEventListener("click", function() {
            // Mostramos un mensaje en la consola cuando se hace clic
            console.log("Has hecho clic en: " + li.textContent);
            inputTextFieldToSearch.value=li.textContent;
        });
    });
    


    const mostrarListaOpcionesOrdenacion=document.getElementById("mostrarListaOpcionesOrdenacion");
    const miListaOrdenacionLi = document.querySelectorAll("#miListaOrdenacion li");
    const miListaOrdenacion = document.getElementById("miListaOrdenacion");
    var inputTextFieldOrder=document.getElementById("fieldOrder");
    mostrarListaOpcionesOrdenacion.addEventListener("click", function() {
        if (miListaOrdenacion.style.display === "none" || miListaOrdenacion.style.display === "") {
            miListaOrdenacion.style.display = "block"; // Mostrar la miListaOrdenacion
        } else {
            miListaOrdenacion.style.display = "none"; // Ocultar la miListaOrdenacion
        }
    })
    miListaOrdenacionLi.forEach(function(li) {
        // Añadimos un evento 'click' a cada li
        li.addEventListener("click", function() {
            // Mostramos un mensaje en la consola cuando se hace clic
            console.log("Has hecho clic en: " + li.textContent);
            inputTextFieldOrder.value=li.textContent;
        });
    });
    

    
}