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
            url: 'backend/product-search.php?search='+search,
            type: 'GET',
            success: function(response) {
                let product = JSON.parse(response);
                let template = '';
                let tmeplate_dec = '';
                product.forEach(product => {
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
                $('#container').html(template);
                $('#products').html(tmeplate_dec);
                console.log(template);
                $('#product-result').show();
            }

        })
        }
        else{
            fetchProducts();
            $('#product-result').hide();
        }
    });

    $('#product-form').submit(e => {
        e.preventDefault();
        let isValid = true;
        let errorMessages = [];
    
        // Obtener datos del formulario
        let postData = {
            nombre: $('#name').val().trim(),
            marca: $('#marca').val().trim(),
            modelo: $('#modelo').val().trim(),
            precio: parseFloat($('#precio').val()),
            unidades: parseInt($('#unidades').val()),
            detalles: $('#detalles').val().trim(),
            imagen: $('#imagen').val().trim(),
            id: $('#productId').val().trim()
        };
    
        // Validaciones básicas
        $('.form-control').each(function() {
            let field = $(this);
            let value = field.val().trim();
            let fieldName = field.attr('id');
            let errorMessage = "";
            
            if (fieldName !== 'search' && value === "") {
                errorMessage = `El campo ${fieldName} no puede estar vacío.<br>`;
            } else if ((fieldName === 'precio' || fieldName === 'unidades') && isNaN(value)) {
                errorMessage = `El campo ${fieldName} debe ser un número válido.<br>`;
            }
            
            if (errorMessage) {
                isValid = false;
                errorMessages.push(errorMessage);
                let statusBar = $(`#status-${fieldName}`);
                if (statusBar.length === 0) {
                    field.after(`<small id='status-${fieldName}' class='text-danger'>${errorMessage}</small>`);
                } else {
                    statusBar.text(errorMessage);
                }
            }
        });
        
        if (!isValid) {
            $('#container').html(`<ul class='text-danger'><li>${errorMessages.join('</li><li>')}</li></ul>`);
            return;
        }
    
        const url = edit === false ? './backend/product-add.php' : './backend/product-edit.php';
            
        $.post(url, postData, (response) => {
            let respuesta = JSON.parse(response);
            let template_bar = `
                <li style="list-style: none;">status: ${respuesta.status}</li>
                <li style="list-style: none;">message: ${respuesta.message}</li>
            `;
    
            // Reiniciar formulario
            $('#product-form')[0].reset();
            $('#productId').val("");
                
            // Mostrar barra de estado
            $('#product-result').show();
            $('#container').html(template_bar);
                
            // Refrescar lista de productos
            listarProductos();
                
            // Resetear bandera de edición
            edit = false;
            $('button.btn-primary').text("Agregar Producto");
        });
    });
    $('.form-control').on('blur', function() {
        let field = $(this);
        let value = field.val().trim();
        let fieldName = field.attr('id');
        let errorMessage = "";
        
        if (fieldName !== 'search' && value === "") {
            errorMessage = `El campo ${fieldName} no puede estar vacío.<br>`;
        } else if ((fieldName === 'precio' || fieldName === 'unidades') && isNaN(value)) {
            errorMessage = `El campo ${fieldName} debe ser un número válido.<br>`;
        }
        
        let statusBar = $(`#status-${fieldName}`);
        
        if (errorMessage) {
            if (statusBar.length === 0) {
                field.after(`<small id='status-${fieldName}' class='text-danger'>${errorMessage}</small>`);
            } else {
                statusBar.text(errorMessage);
            }
        } else {
            statusBar.remove();
        }
    });
    // Verificar si el nombre del producto ya existe en la BD
    $('#name').on('keyup', function() {
        let productName = $(this).val().trim();
        if (productName.length > 0) {
            $.post('./backend/check-product-name.php', { name: productName }, (response) => {
                let result = JSON.parse(response);
                let statusBar = $('#status-name');
                if (result.exists) {
                    if (statusBar.length === 0) {
                        $('#name').after(`<small id='status-name' class='text-danger'>El nombre del producto ya existe.</small>`);
                    } else {
                        statusBar.text("El nombre del producto ya existe.");
                    }
                } else {
                    statusBar.remove();
                }
            });
        } else {
            $('#status-name').remove();
        }
    });
    function fetchProducts() {
        $.ajax({
        url: 'backend/product-list.php',
        type: 'GET',
        success: function(response) {
            console.log(response);
            let product = JSON.parse(response);
            let template = '';
            product.forEach(product => {
                let descripcion = `
                    <li>precio: ${product.precio}</li>
                    <li>unidades: ${product.unidades}</li>
                    <li>modelo: ${product.modelo}</li>
                    <li>marca: ${product.marca}</li>
                    <li>detalles: ${product.detalles}</li>
                `;
                template += `
                    <tr productId="${product.id}">
                        <td>${product.id}</td>
                        <td>
                            <a href="#" class="product-item">${product.nombre}</a>
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
            $('#products').html(template);
        },
        error: function(status, error) {
            console.error("Error en la solicitud AJAX:", status, error);
        }
    });

    $(document).on('click','.product-delete',function(){
        if(confirm('Quieres eliminarlo?')){
            let element = $(this)[0].parentElement.parentElement;
            let id = $(element).attr('productId')
            $.get('backend/product-delete.php',{id:id},function(response){
                fetchProducts();
            })
        }
    })

    $(document).on('click', '.product-item', function(e) {
        e.preventDefault();
        $('button.btn-primary').text("Modificar Producto");
        
        let element = $(this)[0].parentElement.parentElement;
        let id = $(element).attr('productId');
        
        if (!id) {
            alert("Error: No se encontró el ID del producto.");
            return;
        }
        
        $.post('./backend/product-single.php', { id }, (response) => {
            try {
                let product = JSON.parse(response);
                
                if (!product || Object.keys(product).length === 0) {
                    alert("Error: No se recibió información válida del producto.");
                    return;
                }
                
                // Insertar datos en los campos correspondientes si existen
                $('#name').val(product.nombre || '');
                $('#marca').val(product.marca || 'NA');
                $('#modelo').val(product.modelo || 'XX-000');
                $('#precio').val(product.precio !== undefined ? product.precio : 0.0);
                $('#unidades').val(product.unidades !== undefined ? product.unidades : 1);
                $('#detalles').val(product.detalles || 'NA');
                $('#imagen').val(product.imagen || 'img/default.png');
                
                // Insertar el ID en el campo oculto para su actualización
                $('#productId').val(product.id || '');
                
                // Establecer la bandera de edición en true
                edit = true;
            } catch (error) {
                alert("Error al procesar la información del producto.");
                console.error("Error de JSON:", error);
            }
        }).fail(() => {
            alert("Error en la petición al servidor.");
        });
    })


}
})