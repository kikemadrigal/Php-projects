window.onload = function () {
    
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
    

    
}