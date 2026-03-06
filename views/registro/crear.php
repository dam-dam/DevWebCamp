<main class="registro">
    <h2 class="registro__heading"><?php echo $titulo; ?></h2>
    <p class="registro__descripcion">Elige tu plan</p>
    <div class="paquetes__grid">
        <div class="paquete">
            <h3 class="paquete__nombre">Paquete Gratis</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento"> Acceso Virtual</li>
            </ul>
            <p class="paquete__precio">$0</p>

            <form method="POST" action="/finalizar-registro/gratis">
                <input type="submit" class="paquete__submit" value="Inscripcion Gratis">
            </form>

        </div>
        <div class="paquete">
            <h3 class="paquete__nombre">Pase presencial</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento"> Acceso Virtual</li>
                <li class="paquete__elemento"> Pase presencial por 2 dias </li>
                <li class="paquete__elemento"> Acceso al taller y conferencias</li>
                <li class="paquete__elemento"> Acceso a las grabaciones</li>
                <li class="paquete__elemento"> Camina del evento</li>
                <li class="paquete__elemento"> Comida y bebida</li>
            </ul>
            <p class="paquete__precio">$199</p>

            <div id="paypal-button-container"></div>
            <div id="msj-exito"></div>
        </div>
        <div class="paquete">
            <h3 class="paquete__nombre">Pase Virtual</h3>
            <ul class="paquete__lista">
                <li class="paquete__elemento"> Acceso Virtual</li>
                <li class="paquete__elemento"> Pase por 2 dias</li>
                <li class="paquete__elemento"> Enlace a talleres</li>
                <li class="paquete__elemento"> Acceso a las grabaciones</li>
            </ul>
            <p class="paquete__precio">$49</p>
            <div id="paypal-button-container--virtual"></div>

        </div>
    
    </div>
</main>


<script>
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color:  'blue',
            shape:  'rect',
            label:  'paypal'
        },

        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    description: "1", 
                    amount: { value: '199.00' }
                }]
            });
        },

        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // 1. Mostramos TODO el objeto en la consola para que lo revises
                console.log("Objeto completo de la transacción:", details);
                
                // 2. Referenciamos el contenedor
                const element = document.getElementById("paypal-button-container");
                
                // 3. Reemplazamos el contenido (Corregido: usamos .innerHTML)
                element.innerHTML = `
                    <div style="padding: 20px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; text-align: center;">
                        <h3>¡Compra realizada con éxito!</h3>
                        <p>ID de transacción: ${details.purchase_units[0].payments.captures[0].id}</p>
                    </div>
                `;

                // Opcional: Si quieres ocultar otros elementos o hacer algo más, ponlo aquí
                const datos = new FormData();
                datos.append("paquete_id", details.purchase_units[0].description);
                datos.append("pago_id", details.purchase_units[0].payments.captures[0].id);

                fetch("/finalizar-registro/pagar",{
                    method: "POST",
                    body: datos
                })
                .then(respuesta=> respuesta.json())
                .then(resultado=>{
                    if(resultado.resultado){
                        window.location.href = "http://localhost:3000/finalizar-registro/conferencias";
                    }
                })
            });
        },

        onCancel: function (data) {
            alert("Pago cancelado");
        },

        onError: function (err) {
            console.error("Error crítico en PayPal:", err);
            // Esto ayuda a que si falla algo, la consola te diga el motivo exacto
        }
    }).render('#paypal-button-container');
</script>


<script>
  // Inicializamos los botones estándar de PayPal
  paypal.Buttons({
    style: {
      layout: 'vertical',
      color: 'blue',
      shape: 'rect',
      label: 'pay'
    },
    
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          description: "2", 
          amount: {
            value: '49.00' 
          }
        }]
      });
    },

    // Aquí capturamos la transacción para enviarla a tu PHP
    onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                // 1. Mostramos TODO el objeto en la consola para que lo revises
                console.log("Objeto completo de la transacción:", details);
                
                // 2. Referenciamos el contenedor
                const element = document.getElementById("paypal-button-container--virtual");
                
                // 3. Reemplazamos el contenido (Corregido: usamos .innerHTML)
                element.innerHTML = `
                    <div style="padding: 20px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; text-align: center;">
                        <h3>¡Compra realizada con éxito!</h3>
                        <p>ID de transacción: ${details.purchase_units[0].payments.captures[0].id}</p>
                    </div>
                `;

                // Opcional: Si quieres ocultar otros elementos o hacer algo más, ponlo aquí
                const datos = new FormData();
                datos.append("paquete_id", details.purchase_units[0].description);
                datos.append("pago_id", details.purchase_units[0].payments.captures[0].id);

                fetch("/finalizar-registro/pagar",{
                    method: "POST",
                    body: datos
                })
                .then(respuesta=> respuesta.json())
                .then(resultado=>{
                    if(resultado.resultado){
                        window.location.href = "http://localhost:3000/finalizar-registro/conferencias";
                    }
                })
            });
        },
        onCancel: function (data) {
            alert("Pago cancelado");
        },

        onError: function (err) {
            console.error("Error crítico en PayPal:", err);
            // Esto ayuda a que si falla algo, la consola te diga el motivo exacto
        }
  }).render('#paypal-button-container--virtual');
</script>

