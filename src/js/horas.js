(function() {

    const horas = document.querySelector('#horas')

    if(horas) {

        let busqueda = {
            categoria_id: '',
            dia: ''
        }

        const categoria = document.querySelector('[name="categoria_id"]');
        const dias = document.querySelectorAll('[name="dia"]');
        const HiddenDia = document.querySelector('[name="dia_id"]');
        const HiddenHora = document.querySelector('[name="hora_id"]');

        categoria.addEventListener('change', terminoBusqueda)
        dias.forEach(dia => dia.addEventListener('change', terminoBusqueda));

        function terminoBusqueda(e) {

            // Reiniciar campos ocultos y selector de horas
            HiddenHora.value = '';
            HiddenDia.value = '';

            // Desavilitar hora previa
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }

            busqueda[e.target.name] = e.target.value;
            
            if(Object.values(busqueda).includes('')) {
                return;
            }

            buscarEventos();
        }

        async function buscarEventos() {
            const {dia, categoria_id} = busqueda
            
            const url = `/api/eventos-horario?dia_id=${dia}&categoria_id=${categoria_id}`;
            const resultado = await fetch(url);
            const eventos = await resultado.json();

            obtenerHorasDisponibles(eventos);
        }

        function obtenerHorasDisponibles(eventos) {

            // Reiniciar hora
            const listadoHoras = document.querySelectorAll('#horas li');
            listadoHoras.forEach(li => li.classList.add('horas__hora--deshabilitada'));
            
            //Comprobar eventos
            const horasTomadas = eventos.map(evento => evento.hora_id);
            const listadoHorasArray = Array.from(listadoHoras);
            
            const resultado = listadoHorasArray.filter(li => !horasTomadas.includes(li.dataset.horaId));
            resultado.forEach(li => li.classList.remove('horas__hora--deshabilitada'));

            const horasDisponibles = document.querySelectorAll('#horas li:not(.horas__hora--deshabilitada)');
            horasDisponibles.forEach(hora => hora.addEventListener('click', seleccionarHora));
        }

        function seleccionarHora(e) {

            // Desavilitar hora previa
            const horaPrevia = document.querySelector('.horas__hora--seleccionada');
            if(horaPrevia) {
                horaPrevia.classList.remove('horas__hora--seleccionada');
            }
            // Agregar clase
            e.target.classList.add('horas__hora--seleccionada');
            HiddenHora.value = e.target.dataset.horaId;

            //LLenar campo dia
            HiddenDia.value = document.querySelector('[name="dia"]:checked').value
        }
    }



})();