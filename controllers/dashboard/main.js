// Constante para establecer la ruta y parámetros de comunicación con la API.
const API_USUARIOS = SERVER + 'dashboard/usuarios.php?action=';
const API_CLIENTES = SERVER + 'dashboard/clientes.php?action=';
const API_PRODUCTOS = SERVER + 'dashboard/productos.php?action=';

// Método manejador de eventos que se ejecuta cuando el documento ha cargado.
document.addEventListener('DOMContentLoaded', function () {
    // Se llaman a la funciones que generan los gráficos en la página web.
    graficoBarrasPedidosZona();
    graficoClientesPedidos();
    graficoBarraProductosMasVendidos();
    graficoBarraProductosPresentacion();
    graficoPersonalCargo();
    graficoLineaProductoProveedor();
    graficoPoductoLinea();
    graficopersonalPedido();
});

// Función para mostrar la cantidad de pedidos por zona en un gráfico de barras.
function graficoBarrasPedidosZona() {
    // Petición para obtener los datos del gráfico.
    fetch(API_USUARIOS + 'cantidadPedidosZona', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let zonas = [];
                    let pedidos = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        zonas.push(row.nombre_zona);
                        pedidos.push(row.pedidos);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    barGraph('chart1', zonas, pedidos, 'Cantidad de pedidos', 'Cantidad de pedidos por zona');
                } else {
                    document.getElementById('chart1').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Función para mostrar cantidad de clientes con mas pedidos en un gráfico de pastel.
function graficoClientesPedidos() {
    // Petición para obtener los datos del gráfico.
    fetch(API_CLIENTES + 'ClientesPedidos', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let clientes = [];
                    let pedidos = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        clientes.push(row.nombre);
                        pedidos.push(row.pedidos);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    pieGraph('chart2', clientes, pedidos,'Clientes que hacen mas pedidos', 'Clientes con mas cantidad de pedidos');
                } else {
                    document.getElementById('chart2').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
// Función para mostrar la cantidad de productos mas vendidos en un gráfico de barras.
function graficoBarraProductosMasVendidos() {
    // Petición para obtener los datos del gráfico.
    fetch(API_PRODUCTOS + 'productosMasVendidos', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                console.log(response)
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let nombre = [];
                    let productos = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        nombre.push(row.nombre_producto);
                        productos.push(row.cantidad);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    barGraph('chart3', nombre, productos, 'Cantidad', 'Top 5 de productos más vendidos');
                } else {
                    document.getElementById('chart3').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Función para mostrar la cantidad de productos por categoría en un gráfico de barras.
function graficoBarraProductosPresentacion() {
    // Petición para obtener los datos del gráfico.
    fetch(API_PRODUCTOS + 'cantidadProductoPresentacion', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let presentacion= [];
                    let productos = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        presentacion.push(row.presentacio);
                        productos.push(row.producto);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    doughnutGraph('chart4', presentacion, productos, 'Cantidad de productos por presentación');
                } else {
                    document.getElementById('chart4').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

// Función para mostrar cantidad de clientes con mas pedidos en un gráfico de pastel.
function graficoPersonalCargo() {
    // Petición para obtener los datos del gráfico.
    fetch(API_USUARIOS + 'cantidadPersonalCargo', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let cargo = [];
                    let personal = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        cargo.push(row.nombre_cargo);
                        personal.push(row.personal);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    doughnutGraph('chart5', cargo, personal,'Cantidad personal', 'Cantidad de personal por cargo');
                } else {
                    document.getElementById('chart5').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}

function graficoLineaProductoProveedor() {
    // Petición para obtener los datos del gráfico.
    fetch(API_PRODUCTOS + 'cantidadProductosProveedor', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let proveedor= [];
                    let producto = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        proveedor.push(row.nombre);
                        producto.push(row.productos);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    barGraph('chart6',proveedor,producto,'productos por proveedor','Cantidad de productos por proveedor');
                } else {
                    document.getElementById('chart6').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
function graficoPoductoLinea() {
    // Petición para obtener los datos del gráfico.
    fetch(API_PRODUCTOS + 'productolineagraf', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                   let linea = [];
                     let producto = [];
                    
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        linea.push(row.nombre_linea);
                        producto.push(row.producto);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    pieGraph('chart7',linea,producto,'cantidad de productos por linea');
                } else {
                    document.getElementById('chart7').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
function graficoLineaProductoProveedor() {
    // Petición para obtener los datos del gráfico.
    fetch(API_PRODUCTOS + 'cantidadProductosProveedor', {
        method: 'get'
    }).then(function (request) {
        // Se verifica si la petición es correcta, de lo contrario se muestra un mensaje en la consola indicando el problema.
        if (request.ok) {
            request.json().then(function (response) {
                // Se comprueba si la respuesta es satisfactoria, de lo contrario se remueve la etiqueta canvas.
                if (response.status) {
                    // Se declaran los arreglos para guardar los datos a graficar.
                    let proveedor= [];
                    let producto = [];
                    // Se recorre el conjunto de registros devuelto por la API (dataset) fila por fila a través del objeto row.
                    response.dataset.map(function (row) {
                        // Se agregan los datos a los arreglos.
                        proveedor.push(row.nombre);
                        producto.push(row.productos);
                    });
                    // Se llama a la función que genera y muestra un gráfico de barras. Se encuentra en el archivo components.js
                    barGraph('chart6',proveedor,producto,'productos por proveedor','Cantidad de productos por proveedor');
                } else {
                    document.getElementById('chart6').remove();
                    console.log(response.exception);
                }
            });
        } else {
            console.log(request.status + ' ' + request.statusText);
        }
    });
}
