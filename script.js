document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('formulario').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const nombre = document.getElementById('nombre').value;
        const dni = document.getElementById('dni').value;
        const botonEnviar = document.getElementById('boton-enviar'); // Asegúrate de tener el id del botón "Enviar"
        
        document.getElementById('mensaje-error').style.display = 'none';
        
        // Deshabilitar el botón "Enviar"
        botonEnviar.disabled = true;
        botonEnviar.innerText = "Enviando...";

        // Verificar si el DNI ya existe en la base de datos
        fetch('verificar_dni.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `dni=${dni}`
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }
            return response.json();
        })
        .then(data => {
            if (data.existe) {
                document.getElementById('mensaje-error').innerText = 'El DNI ya está registrado. Por favor, usa otro.';
                document.getElementById('mensaje-error').style.display = 'block';
                // Habilitar el botón de nuevo si hay error
                botonEnviar.disabled = false;
                botonEnviar.innerText = "Enviar";
            } else {
                document.getElementById('formulario').style.display = 'none';
                const animacion = document.getElementById('animacion');
                animacion.style.display = 'block';

                // Selección aleatoria de preguntas
                const randomIndex = Math.floor(Math.random() * 6) + 1;
                setTimeout(() => {
                    window.location.href = `preguntas${randomIndex}/preguntas${randomIndex}.html?nombre=${nombre}&dni=${dni}`;
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // En caso de error, habilitar el botón de nuevo
            document.getElementById('mensaje-error').innerText = 'Ha ocurrido un error. Intenta nuevamente.';
            document.getElementById('mensaje-error').style.display = 'block';
            botonEnviar.disabled = false;
            botonEnviar.innerText = "Enviar";
        });
    });
});
