<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            text-align: center;
        }

        .btncompra {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <form id="formulario">
        <h1>Consultar Usuario</h1>
        <label for="cedula">Cédula:</label>
        <input type="text" id="cedula" name="cedula" required>
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" readonly>
        <label for="edad">Edad:</label>
        <input type="text" id="edad" name="edad" readonly>
        <label for="cuenta_bancaria">Cuenta Bancaria:</label>
        <input type="text" id="cuenta_bancaria" name="cuenta_bancaria" readonly>
        <label for="producto">Nombre del Producto:</label>
        <input type="text" id="producto" name="producto" required>
        <label for="cantidad">Cantidad:</label>
        <input type="text" id="cantidad" name="cantidad" required>
        <button type="button" onclick="consultarDatos()">Consultar</button>
        <button type="button" class="btncompra" onclick="finalizarCompra()">Finalizar Compra</button>
    </form>

    <script>
        async function consultarDatos() {
            const cedula = document.getElementById('cedula').value;
            if (!cedula) {
                alert('Por favor, ingrese una cédula');
                return;
            }

            try {
                const response = await fetch(`http://localhost/web_service_php/index.php?cedula=${cedula}`);
                if (!response.ok) {
                    throw new Error('Usuario no encontrado');
                }

                const data = await response.json();
                document.getElementById('nombre').value = data.nombre;
                document.getElementById('edad').value = data.edad;
                document.getElementById('cuenta_bancaria').value = data.cuenta_bancaria;
            } catch (error) {
                alert(error.message);
            }
        }

        async function finalizarCompra() {
            const cedula = document.getElementById('cedula').value;
            const nombre = document.getElementById('nombre').value;
            const edad = document.getElementById('edad').value;
            const cuenta_bancaria = document.getElementById('cuenta_bancaria').value;
            const producto = document.getElementById('producto').value;
            const cantidad = document.getElementById('cantidad').value;

            if (!cedula || !nombre || !edad || !cuenta_bancaria || !producto || !cantidad) {
                alert('Por favor, llene todos los campos');
                return;
            }

            const datos = { cedula, nombre, edad, cuenta_bancaria, producto, cantidad };

            try {
                const response = await fetch('guardar_compra.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(datos)
                });

                if (!response.ok) {
                    throw new Error('Error al guardar los datos en la base de datos');
                }

                const result = await response.json();
                if (result.error) {
                    throw new Error(result.error);
                }

                // Limpiar el formulario después de la compra
                document.getElementById('formulario').reset();
                alert('Compra finalizada exitosamente');
            } catch (error) {
                alert(error.message);
            }
        }
    </script>
</body>

</html>
