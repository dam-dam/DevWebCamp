(function(){
    const tags_input = document.querySelector("#tags_input");

    if(tags_input){
        const tagsDiv = document.querySelector("#tags");
        const tagsInputHidden = document.querySelector("[name='tags']");
        
        
        let tags=[];

        //recuperar del input oculto para la actualizacion de personal
        if(tagsInputHidden.value !== ""){
            tags= tagsInputHidden.value.split(",");
            mostrarTags();
        }

        //escuchar los cambios en el input
        tags_input.addEventListener("keypress", guardarTag);

        function guardarTag(e){
            if(e.keyCode === 44){

                if(e.target.value.trim() === "" || e.target.value < 1){
                    return
                }
                e.preventDefault();
                tags= [...tags, e.target.value.trim()]
                tags_input.value= "";
                console.log(tags);

                mostrarTags();
            }
        }

        function mostrarTags(){
            tagsDiv.textContent="";
            tags.forEach(tags=>{
                const etiquetas= document.createElement("LI");
                etiquetas.classList.add("fomulario__tag");
                etiquetas.textContent = tags;

                etiquetas.ondblclick = eliminarTag;
                tagsDiv.appendChild(etiquetas);
            })
            actualizarInputHidden();
        }

        function eliminarTag(e){
            e.target.remove();
            tags= tags.filter(tag=> tag !== e.target.textContent);
            actualizarInputHidden();
        }

        function actualizarInputHidden(){
            tagsInputHidden.value= tags.toString();
        }
    }
})();