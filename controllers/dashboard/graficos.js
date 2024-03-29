// Constante para completar la ruta de la API.
const CLIENTE_API = 'business/dashboard/cliente.php';
const PRODUCTO_API = 'business/dashboard/producto.php';
const PEDIDO_API = 'business/dashboard/pedido.php';
const VALORACION_API = 'business/dashboard/valoracion.php'

// Método manejador de eventos para cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', () => {
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoBarrasEstado();
    graficoBarrasValoracionProducto();
    graficoPastelPedidosEstado();
    graficoLineaPedidosMes();
    graficoDonaExistenciasProducto();
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

/*
*   Función asíncrona para mostrar en un gráfico de barras que muestra el promedio de valoraciones por producto.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoBarrasValoracionProducto() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(VALORACION_API, 'promedioValoracionProducto');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let estados = [];
        let cantidades = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estados.push(row.nombre_producto);
            cantidades.push(row.promedio_valoracion);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        barGraph('chart4', estados, cantidades, 'Valoración promedio', 'Promedio de valoración por producto');
    } else {
        document.getElementById('chart4').remove();
        console.log(DATA.exception);
    }
}

async function graficoPastelPedidosEstado() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PEDIDO_API, 'cantidadPedidosEstado');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let estado = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            estado.push(row.estado);
            cantidad.push(row.cantidad_pedidos);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        pieGraph('chart1', estado, cantidad, 'Estados del pedidos');

    } else {
        document.getElementById('chart1').remove();
        console.log(DATA.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de pastel el porcentaje de productos por categoría.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoLineaPedidosMes() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PEDIDO_API, 'cantidadPedidosMes');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a gráficar.
        let mes = [];
        let cantidad = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            mes.push("Mes "+row.mes);
            cantidad.push(row.cantidad_pedidos);
        });
        // Llamada a la función que genera y muestra un gráfico de pastel. Se encuentra en el archivo components.js
        lineGraph('chart2', mes, cantidad, 'Pedidos por mes');
    } else {
        document.getElementById('chart2').remove();
        console.log(DATA.exception);
    }
}

/*
*   Función asíncrona para mostrar en un gráfico de dona las existencias de cada producto.
*   Parámetros: ninguno.
*   Retorno: ninguno.
*/
async function graficoDonaExistenciasProducto() {
    // Petición para obtener los datos del gráfico.
    const DATA = await dataFetch(PRODUCTO_API, 'existenciasProductos');
    // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
    if (DATA.status) {
        // Se declaran los arreglos para guardar los datos a graficar.
        let producto = [];
        let existencias = [];
        // Se recorre el conjunto de registros fila por fila a través del objeto row.
        DATA.dataset.forEach(row => {
            // Se agregan los datos a los arreglos.
            producto.push(row.nombre_producto);
            existencias.push(row.existencias);
        });
        // Llamada a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
        doughnutGraph('chart3', producto, existencias, 'Existencias de producto', 'Existencias de cada producto');
    } else {
        document.getElementById('chart3').remove();
        console.log(DATA.exception);
    }
}