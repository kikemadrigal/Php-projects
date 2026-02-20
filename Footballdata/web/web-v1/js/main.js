window.onload = function () {
    /*const button_show_option_list=document.getElementById("button_show_option_list");
    const lis_from_list = document.querySelectorAll("#list li");
    const list = document.getElementById("list");
    var text_where_value=document.getElementById("text_where_value");
    button_show_option_list.addEventListener("click", function() {
        if (list.style.display === "none" || list.style.display === "") {
            list.style.display = "block"; // Mostrar la list
        } else {
            list.style.display = "none"; // Ocultar la lista
        }
    })
    lis_from_list.forEach(function(li) {
        // Añadimos un evento 'click' a cada li
        li.addEventListener("click", function() {
            // Mostramos un mensaje en la consola cuando se hace clic
            console.log("Has hecho clic en: " + li.textContent);
            text_where_value.value=li.textContent;
            if (list.style.display === "none" || list.style.display === "") {
                list.style.display = "block"; // Mostrar la list
            } else {
                list.style.display = "none"; // Ocultar la lista
            }
        });
    });*/
    const lis_from_list = document.querySelectorAll("#list li");
    const list = document.getElementById("list");
    var text_where_name=document.getElementById("where_name");
    lis_from_list.forEach(function(li) {
        // Añadimos un evento 'click' a cada li
        li.addEventListener("click", function() {
            // Mostramos un mensaje en la consola cuando se hace clic
            console.log("Has hecho clic en: " + li.textContent);
            text_where_name.value=li.textContent;
        });
    });


    /*const mostrarListaOpcionesOrdenacion=document.getElementById("mostrarListaOpcionesOrdenacion");
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
    });*/
    

    
}