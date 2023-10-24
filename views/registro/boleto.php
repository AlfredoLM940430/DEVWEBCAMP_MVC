<main class="pagina">
    <h2 class="pagina__heading"><?php echo $titulo; ?></h2>
    <p class="pagina__descripcion">Tu Boleto - Te recomendamos alacenarlo, puedes compartirlo en redes sociales.</p>

    <div class="boleto-virtual">
        <div class="boleto boleto--<?php echo strtolower($registro->paquete->nombre);?> boleto--acceso">
            <div class="boleto__contenido">
                <h4 class="boleto__logo">&#60;DevWebCamp/></h4>
                <P class="boleto__plan"><?php echo ($registro->paquete->nombre);?></P>
                <P class="boleto__nombre"><?php echo ($registro->usuario->nombre . ' ' . $registro->usuario->apellido);?></P>
            </div>
            <P class="boleto__codigo"><?php echo '#' . ($registro->token);?></P>
        </div>
    </div>


</main>