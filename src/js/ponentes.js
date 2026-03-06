(function(){
    const ponentesInput = document.querySelector("#ponentes");
    if(ponentesInput){
        let ponentes= [];
        let ponentesFiltrados= [];
        const listadoPonentes = document.querySelector("#listado-ponentes")

        const ponenteHidden = document.querySelector("[name='ponente_id']");

        obtenerPonentes();

        if(ponenteHidden.value){
            (async()=>{
                const ponente= await obntenerPonentes(ponenteHidden.value)
                const {nombre, apellido} = ponente;
                //instertar en html
                const ponenteDOM = document.createElement("LI");
                ponenteDOM.classList.add("listado-ponentes__ponentes", "listado-ponentes__ponentes--seleccionado");
                ponenteDOM.textContent= `${nombre} ${apellido}`;

                listadoPonentes.appendChild(ponenteDOM);

            })();
        }
        ponentesInput.addEventListener("input", buscarPonentes)

        async function obtenerPonentes() {
            const url= `/api/ponentes`;
            
            const respuesta = await fetch(url); //probamos si nos podemos conectar
            const resultado = await respuesta.json();
            formatearPonentes(resultado);
        }
        async function obntenerPonentes(id){
            const url=`/api/ponente?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json()
            return resultado;
        }
        function formatearPonentes(arrayPonentes = []){
            ponentes = arrayPonentes.map(ponente=>{
                return{
                        nombre: `${ponente.nombre.trim()} ${ponente.apellido.trim()}`,
                        id: ponente.id
                    }
                })
        }
        function buscarPonentes(e) {
            //Limpiamos la búsqueda de acentos y la pasamos a minúsculas
            const busqueda = e.target.value
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, "")
                .toLowerCase();

            if (busqueda.length > 3) {
                ponentesFiltrados = ponentes.filter(ponente => {
                    const nombreNormalizado = ponente.nombre
                        .normalize("NFD")
                        .replace(/[\u0300-\u036f]/g, "")
                        .toLowerCase();

                    //Comparamos las versiones "limpias"
                    return nombreNormalizado.includes(busqueda);
                });
            } else {
                ponentesFiltrados = [];
            }
            mostrarPonentes();
        }

        function mostrarPonentes(){
            while(listadoPonentes.firstChild){
                listadoPonentes.removeChild(listadoPonentes.firstChild)
            }

            if(ponentesFiltrados.length>0){
                ponentesFiltrados.forEach(ponente=>{
                const ponenteHTML = document.createElement("LI");
                ponenteHTML.classList.add("listado-ponentes__ponentes")
                ponenteHTML.textContent= ponente.nombre;
                ponenteHTML.dataset.ponenteId = ponente.id;
                ponenteHTML.onclick= seleccionarPonente

                //añadir al dom
                listadoPonentes.appendChild(ponenteHTML)
                })
            }else{
                const noResultados = document.createElement("P")
                noResultados.classList.add("listado-ponentes__no-resultado")
                noResultados.textContent= "No hay ningun resultado para tu busqueda"
                listadoPonentes.appendChild(noResultados)

            }
        }

        function seleccionarPonente(e){
            const ponente = e.target;
            console.log(ponente)

            //remover la clase previa
            const ponentePrevio = document.querySelector(".listado-ponentes__ponentes--seleccionado")
            if(ponentePrevio){
                ponentePrevio.classList.remove("listado-ponentes__ponentes--seleccionado")
            }

            ponente.classList.add("listado-ponentes__ponentes--seleccionado")

            ponenteHidden.value = ponente.dataset.ponenteId
        }
    }
})();