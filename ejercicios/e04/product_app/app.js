// JSON BASE A MOSTRAR EN FORMULARIO
var baseJSON = {
    "precio": 0.0,
    "unidades": 1,
    "modelo": "XX-000",
    "marca": "NA",
    "detalles": "NA",
    "imagen": "img/default.png"
};

let edit = false;

function init() {
    /**
     * Convierte el JSON a string para poder mostrarlo
     * ver: https://developer.mozilla.org/es/docs/Web/JavaScript/Reference/Global_Objects/JSON
     */
    var JsonString = JSON.stringify(baseJSON,null,2);
    document.getElementById("description").value = JsonString;
    fetchProducts();
}

//Funcion de busqueda de productos
$(document).ready(function(){
    $('#product-result').hide();

    $('#search').keyup(function(e) {
        if($('#search').val()){
            let search = $('#search').val();
            $.ajax({
                url: 'http://localhost/tecweb/ejercicios/e04/product_app/backend/products/'+encodeURIComponent(search),
                type: 'GET',
                dataType: 'json', // Asegura que jQuery parseé la respuesta como JSON
                success: function(response) {
                    // response ya es un objeto JavaScript, no necesitas parsearlo
                    let template = '';
                    let tmeplate_dec = '';
                    
                    // Verifica si response es un array
                    if(Array.isArray(response)) {
                        response.forEach(product => {
                    let descripcion = '';
                    descripcion += '<li>precio: '+product.precio+'</li>';
                    descripcion += '<li>unidades: '+product.unidades+'</li>';
                    descripcion += '<li>modelo: '+product.modelo+'</li>';
                    descripcion += '<li>marca: '+product.marca+'</li>';
                    descripcion += '<li>detalles: '+product.detalles+'</li>';

                    tmeplate_dec += `
                        <tr productId="${product.id}">
                            <td>${product.id}</td>
                            <td>${product.nombre}</td>
                            <td><ul>${descripcion}</ul></td>
                            <td>
                                <button class="product-delete btn btn-danger" onclick="eliminarProducto()">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                    `;

                    template += `<li>${product.nombre}</li>`
                });
            } else {
                console.error("La respuesta no es un array:", response);
            }
            
            $('#container').html(template);
            $('#products').html(tmeplate_dec);
            $('#product-result').show();
        },
        error: function(xhr, status, error) {
            console.error("Error en la búsqueda:", error);
        }
    });
}
else {
    fetchProducts();
    $('#product-result').hide();
}
});

$('#product-form').submit(function(e) {
    e.preventDefault();
    let id = $('#productId').val();
    let productoJsonString = $('#description').val();
    let finalJSON;

    try {
        finalJSON = JSON.parse(productoJsonString);
        finalJSON['nombre'] = $('#name').val();
        if (edit) {
            finalJSON.id = id;
        }

        // Convertimos valores numéricos explícitamente
        finalJSON.precio = parseFloat(finalJSON.precio);
        finalJSON.unidades = parseInt(finalJSON.unidades);

        let errores = [];

        if (!finalJSON.nombre) {
            errores.push("No hay nombre de producto");
        }
        if (finalJSON.nombre.length > 100) {
            errores.push("El nombre del producto no puede ser mayor a 100 caracteres");
        }
        if (!finalJSON.marca) {
            errores.push("No hay marca de producto");
        }
        if (!finalJSON.modelo) {
            errores.push("No hay modelo de producto");
        }
        if (finalJSON.modelo.length > 25) {
            errores.push("El modelo no puede ser mayor a 25 caracteres");
        }
        if (isNaN(finalJSON.precio)) {
            errores.push("El precio no es un número");
        } else if (finalJSON.precio < 0) {
            errores.push("El precio no puede ser menor a 99.99");
        }
        if (isNaN(finalJSON.unidades)) {
            errores.push("Las unidades no son un número");
        } else if (finalJSON.unidades < 1) {
            errores.push("Las unidades deben ser al menos 1");
        }
        if (finalJSON.detalles && finalJSON.detalles.length > 250) {
            errores.push("Los detalles no pueden superar los 250 caracteres");
        }
        if (!finalJSON.imagen || finalJSON.imagen === "") {
            finalJSON.imagen = "img/default.jpg";
        }

        if (errores.length > 0) {
            alert("Errores en el formulario:\n\n" + errores.join("\n"));
            return;
        }

        // Envío AJAX usando Slim
        let url = 'http://localhost/tecweb/ejercicios/e04/product_app/backend/products';
        let method = edit ? 'PUT' : 'POST'
        $.ajax({
            url: url,
            type: method,
            contentType: 'application/json; charset=UTF-8',
            dataType: 'json',
            data: JSON.stringify(finalJSON),
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (typeof response === "string") {
                    try {
                        response = JSON.parse(response);
                    } catch (e) {
                        console.error("No se pudo parsear la respuesta:", e);
                        return;
                    }
                }
            
                let template_bar = `
                    <li style="list-style: none;">status: ${response.status}</li>
                    <li style="list-style: none;">message: ${response.message}</li>
                `;
                $("#product-result").addClass("card my-4 d-block");
                $("#container").html(template_bar);
            
                // Retrasa la recarga para no sobreescribir la respuesta
                setTimeout(() => {
                    fetchProducts();
                    edit = false;
                }, 1000);
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", xhr.responseText || error);
            }
        });

    } catch (error) {
        console.error("Error al analizar el JSON:", error);
    }
    });
});

function fetchProducts() {
    $.get("http://localhost/tecweb/ejercicios/e04/product_app/backend/products", function(data) {
        console.log("Tipo de dato recibido:", typeof data);
        console.log("Respuesta del servidor:", data);
        
        try {
            // Verifica si ya es un objeto (depende de la configuración de jQuery)
            let productos = typeof data === 'string' ? JSON.parse(data) : data;
            
            let template = "";
            
            // Corregido: products -> productos (consistencia en el nombre)
            productos.forEach(producto => {
                let descripcion = `
                    <li>Precio: ${producto.precio}</li>
                    <li>Unidades: ${producto.unidades}</li>
                    <li>Modelo: ${producto.modelo}</li>
                    <li>Marca: ${producto.marca}</li>
                    <li>Detalles: ${producto.detalles}</li>
                `;
                
                template += `
                    <tr productId="${producto.id}">
                        <td>${producto.id}</td>
                        <td>
                            <a href="#" class="product-item">${producto.nombre}</a>
                        </td>
                        <td><ul>${descripcion}</ul></td>
                        <td>
                            <button class="product-delete btn btn-danger">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                `;
            });
            
            $("#products").html(template);
        } catch (error) {
            console.error("Error al procesar los productos:", error);
            $("#products").html('<tr><td colspan="4">Error al cargar los productos</td></tr>');
        }
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.error("Error en la solicitud AJAX:", textStatus, errorThrown);
        $("#products").html('<tr><td colspan="4">No se pudieron cargar los productos</td></tr>');
    });

    $(document).on('click', '.product-delete', function() {
        if (confirm('¿Quieres eliminarlo?')) {
            let element = $(this).closest('tr');
            let id = $(element).attr('productId');
            $.ajax({
                url: 'http://localhost/tecweb/ejercicios/e04/product_app/backend/products',
                type: 'DELETE',
                data: JSON.stringify({ id: id }),  // Asegúrate de que se envíe como JSON
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    console.log("Respuesta del servidor:", response);  // Imprime la respuesta
    
                    // Si la respuesta es una cadena, intenta parsearla
                    if (typeof response === "string") {
                        try {
                            response = JSON.parse(response);
                        } catch (error) {
                            console.error("Error al parsear la respuesta JSON", error);
                        }
                    }
    
                    // Verifica si la respuesta es la esperada
                    if (response && response.status === 'success') {
                        fetchProducts(); // Recarga la lista
                        alert('Producto eliminado correctamente');
                    } else {
                        alert('Error al eliminar: ' + (response?.message || 'Respuesta inválida'));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error en la conexión: ' + error);
                    console.error("Detalles del error:", xhr.responseText);
                }
            });
        }
    });

    $(document).on('click', '.product-item', function () { 
        let element = $(this).closest('tr');
        let id = $(element).attr('productId');
        $('button.btn-primary').text("Modificar Producto");
    
        $.ajax({
            url: 'http://localhost/tecweb/ejercicios/e04/product_app/backend/products/' + id,
            type: 'GET',
            dataType: 'json',
            success: function(product) {
                if (product && Object.keys(product).length > 0) {
                    $('#name').val(product.nombre);
                    var baseJSON = {
                        "precio": product.precio,
                        "unidades": product.unidades,
                        "modelo": product.modelo,
                        "marca": product.marca,
                        "detalles": product.detalles,
                        "imagen": product.imagen
                    };
                    $('#productId').val(product.id);
                    var JsonString = JSON.stringify(baseJSON, null, 2);
                    document.getElementById("description").value = JsonString;
                    edit = true;
                } else {
                    alert("Producto no encontrado");
                }
            },
            error: function(xhr, status, error) {
                console.error("Error al obtener el producto:", error);
                alert("Ocurrió un error al cargar el producto");
            }
        });
    });
}