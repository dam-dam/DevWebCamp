import Swal from "sweetalert2";
(function(){
    let eventos= [];
    const resumen = document.querySelector("#registro_resumen");
    if(resumen){
        const eventosBoton = document.querySelectorAll(".evento__agregar");
        eventosBoton.forEach(boton=> boton.addEventListener("click", seleccionarEvento))


        const formularioRegistro = document.querySelector("#registro")
        formularioRegistro.addEventListener("submit", submitFormulario)

        mostrarEventos();
        function seleccionarEvento(e){
            //desablitar evento
            if(eventos.length < 5){
            e.target.disabled = true

                eventos= [...eventos,{
                id : e.target.dataset.id,
                titulo: e.target.parentElement.querySelector(".evento__nombre").textContent.trim()
                }];
            }else{
                Swal.fire({
                    title: "Error",
                    text: "Maximo 5 eventos por registro",
                    icon: "error",
                    confirmButtonText:"OK",
                    timer: 10000
                })
            }
            

            mostrarEventos();
            

            console.log(eventos)
        }

        function mostrarEventos(){
            //limpiar el html
            limpiarEvento();

            if(eventos.length > 0){
                eventos.forEach(evento=>{
                    const eventoDOM = document.createElement("DIV");
                    eventoDOM.classList.add("registro__evento");

                    const titulo = document.createElement("H3");
                    titulo.classList.add("registro__nombre");
                    titulo.textContent = evento.titulo;

                    //boton eliminar
                    const botonEliminar= document.createElement("BUTTON");
                    botonEliminar.classList.add("registro__eliminar");
                    botonEliminar.innerHTML= `<i class="fa-solid fa-trash"></i>`;
                    botonEliminar.onclick= function(){
                        eliminarEvento(evento.id);
                    }

                    eventoDOM.appendChild(titulo);
                    eventoDOM.appendChild(botonEliminar);
                    resumen.appendChild(eventoDOM);


                })
            }else{
                const noRegistros = document.createElement("P");
                noRegistros.textContent = "No hay eventos seleccionados, añade hasta 5 del lado izquierdo"
                noRegistros.classList.add("registro__texto");
                resumen.appendChild(noRegistros);
            }
        }
        function eliminarEvento(id){
            eventos= eventos.filter(evento=> evento.id !== id);
            const botonAgregar = document.querySelector(`[data-id="${id}"]`);
            botonAgregar.disabled= false;

            mostrarEventos();
        }

        function limpiarEvento(){
            while(resumen.firstChild){
                resumen.removeChild(resumen.firstChild);
            }
        }

        async function submitFormulario(e){
            e.preventDefault();
            //obtener el regalo y los id de las conferencias
            const regaloId = document.querySelector("#regalo").value;
            const eventosId = eventos.map(evento=> evento.id);

            if(eventosId.length === 0 || regaloId === ""){
                 Swal.fire({
                    title: "Error",
                    text: "Elige al menos un evento y un regalo",
                    icon: "error",
                    confirmButtonText:"OK",
                    timer: 10000
                })
                return;
            }

            //objeto de formdata
            const datos= new FormData();
            datos.append("eventos", eventosId)
            datos.append("regalo_id", regaloId)

            const url= "/finalizar-registro/conferencias";
            const respuesta= await fetch(url,{
                method:"POST",
                body: datos
            })
            
            const resultado = await respuesta.json();
            
            console.log(resultado);
            if(resultado.resultado){
                Swal.fire(
                    "Registro Exitoso",
                    "Tus conferencias se han almacenado y tu registro fue exitoso, te esperamos en DevWebCamp",
                    "success"
                ).then(()=> location.href = `/boleto?id=${resultado.token}`)
            }else{
                Swal.fire({
                    title: "Error",
                    text: "Hubo un error",
                    icon: "error",
                    confirmButtonText:"OK",
                    timer: 10000
                }).then(()=> location.reload())
            }
        }
    }    
})();