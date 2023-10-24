(function() {
    const tags_input = document.querySelector('#tags_input');

    if(tags_input) {

        const tagsDiv = document.querySelector('#tags');
        const tagsInput = document.querySelector('[name="tags"]');

        let tags = [];

        if(tagsInput.value !== '') {
            tags = tagsInput.value.split(',');
            mostrarTags();
        }

        tags_input.addEventListener('keypress', guardarTag)


        function guardarTag(e) {

            if(e.target.value.trim() === '' || e.target.value < 1 ) {
                return;
            }

            if(e.keyCode === 44) {
                e.preventDefault();

                tags = [...tags, e.target.value.trim()];
                tags_input.value = '';

                mostrarTags();
            }
        }

        function mostrarTags() {
            tagsDiv.textContent = '';

            tags.forEach(tag => {
                const etiquetas = document.createElement('LI');
                etiquetas.classList.add('formulario__tag');
                etiquetas.textContent = tag;
                etiquetas.ondblclick = eliminarTag;
                tagsDiv.appendChild(etiquetas);
            });
            actualizarHidden();
        }

        function eliminarTag(e) {
            e.target.remove();
            tags = tags.filter(tag => tag !== e.target.textContent);
            actualizarHidden();
        }

        function actualizarHidden() {
            tagsInput.value = tags.toString();
        }
    }
})();

