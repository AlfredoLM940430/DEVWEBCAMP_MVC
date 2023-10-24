<main class="devwebcamp">
    <h2 class="devwebcamp__heading"><?php echo $titulo; ?></h2>
    <p class="devwebcamp__descripcion">Conoce la conferencia mas importante de Latinoamérica</p>

    <div class="devwebcamp__grid">
        <div class="devwebcamp__imagen">
            <picture>
                <source srcset="build/img/sobre_devwebcamp.avif" type="image/avif">
                <source srcset="build/img/sobre_devwebcamp.webp" type="image/webp">
                <img src="build/img/sobre_devwebcamp.jpg" loading="lazy" width="200" height="300" alt="Imagen DevWebCamp">
            </picture>
        </div>

        <div class="devwebcamp__contenido">
            <p <?php aos_animacion();?> class="devwebcamp__texto">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ut enim autem labore animi culpa iure totam maxime doloremque, nihil quaerat aliquid delectus modi at ducimus voluptates accusamus ullam odit assumenda.</p>
            <p <?php aos_animacion();?> class="devwebcamp__texto">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ut enim autem labore animi culpa iure totam maxime doloremque, nihil quaerat aliquid delectus modi at ducimus voluptates accusamus ullam odit assumenda.</p>
        </div>
    </div>
</main>