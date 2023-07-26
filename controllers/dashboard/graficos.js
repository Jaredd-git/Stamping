// Constante para completar la ruta de la API.
const CLIENTE_API = 'business/dashboard/cliente.php';

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se define una constante tipo objeto con la fecha y hora actual.
    const TODAY = new Date();
    // Se define una variable con el número de horas transcurridas en el día.
    let hour = TODAY.getHours();
    // Se define una variable para guardar un saludo.
    let greeting = '';
    // Dependiendo del número de horas transcurridas en el día, se asigna un saludo para el usuario.
    if (hour < 12) {
        greeting = 'Buenos días';
    } else if (hour < 19) {
        greeting = 'Buenas tardes';
    } else if (hour <= 23) {
        greeting = 'Buenas noches';
    }
    // Se muestra un saludo en la página web.
    document.getElementById('greeting').textContent = greeting;
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoBarrasEstado();
});

/*
*   Función asíncrona para mostrar en un gráfico de barras que muestra la cantidad de clientes por estado.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoBarrasEstado() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(CLIENTE_API, 'clientesActivosInactivos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let estados = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estados.push(row.estado_cliente);
            cantidades.push(row.cantidad);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart5', estados, cantidades, 'Cantidad de clientes', 'Clientes por estado');
    } else {
        document.getElementById('chart5').remove();
        console.log(DATA.exception);
    }
}