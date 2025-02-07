<?php
    $parqueVehicular = [
        "ABC1234" => [
            "auto" => [
                "marca" => "Toyota",
                "modelo" => 2020,
                "tipo" => "sedan"
            ],
            "propietario" => [
                "nombre" => "Juan Pérez",
                "ciudad" => "Ciudad de México",
                "direccion" => "Av. Reforma 123"
            ]
        ],
        "DEF5678" => [
            "auto" => [
                "marca" => "Honda",
                "modelo" => 2018,
                "tipo" => "hatchback"
            ],
            "propietario" => [
                "nombre" => "María López",
                "ciudad" => "Guadalajara",
                "direccion" => "Calle Independencia 456"
            ]
        ],
        "GHI9101" => [
            "auto" => [
                "marca" => "Ford",
                "modelo" => 2022,
                "tipo" => "camioneta"
            ],
            "propietario" => [
                "nombre" => "Carlos Ramírez",
                "ciudad" => "Monterrey",
                "direccion" => "Av. Constitución 789"
            ]
        ],
        "JKL2345" => [
            "auto" => [
                "marca" => "Chevrolet",
                "modelo" => 2019,
                "tipo" => "sedan"
            ],
            "propietario" => [
                "nombre" => "Ana Torres",
                "ciudad" => "Tijuana",
                "direccion" => "Blvd. Agua Caliente 101"
            ]
        ],
        "MNO6789" => [
            "auto" => [
                "marca" => "Nissan",
                "modelo" => 2021,
                "tipo" => "hatchback"
            ],
            "propietario" => [
                "nombre" => "Roberto Díaz",
                "ciudad" => "Puebla",
                "direccion" => "Calle 5 de Mayo 202"
            ]
        ],
        "PQR1122" => [
            "auto" => [
                "marca" => "Mazda",
                "modelo" => 2020,
                "tipo" => "camioneta"
            ],
            "propietario" => [
                "nombre" => "Elena Gómez",
                "ciudad" => "Querétaro",
                "direccion" => "Av. Universidad 303"
            ]
        ],
        "STU3344" => [
            "auto" => [
                "marca" => "Volkswagen",
                "modelo" => 2017,
                "tipo" => "sedan"
            ],
            "propietario" => [
                "nombre" => "Fernando Ruiz",
                "ciudad" => "Mérida",
                "direccion" => "Paseo Montejo 404"
            ]
        ],
        "VWX5566" => [
            "auto" => [
                "marca" => "Kia",
                "modelo" => 2023,
                "tipo" => "hatchback"
            ],
            "propietario" => [
                "nombre" => "Patricia Herrera",
                "ciudad" => "León",
                "direccion" => "Blvd. Adolfo López Mateos 505"
            ]
        ],
        "YZA7788" => [
            "auto" => [
                "marca" => "Hyundai",
                "modelo" => 2022,
                "tipo" => "camioneta"
            ],
            "propietario" => [
                "nombre" => "Diego Sánchez",
                "ciudad" => "Cancún",
                "direccion" => "Av. Tulum 606"
            ]
        ],
        "BCD8899" => [
            "auto" => [
                "marca" => "Jeep",
                "modelo" => 2021,
                "tipo" => "camioneta"
            ],
            "propietario" => [
                "nombre" => "Luis Fernández",
                "ciudad" => "Toluca",
                "direccion" => "Calle Hidalgo 707"
            ]
        ],
        "EFG9900" => [
            "auto" => [
                "marca" => "Subaru",
                "modelo" => 2020,
                "tipo" => "sedan"
            ],
            "propietario" => [
                "nombre" => "Gabriela Martínez",
                "ciudad" => "Morelia",
                "direccion" => "Av. Camelinas 808"
            ]
        ],
        "HIJ1123" => [
            "auto" => [
                "marca" => "Tesla",
                "modelo" => 2023,
                "tipo" => "sedan"
            ],
            "propietario" => [
                "nombre" => "Ricardo López",
                "ciudad" => "Aguascalientes",
                "direccion" => "Blvd. Zacatecas 909"
            ]
        ],
        "KLM2234" => [
            "auto" => [
                "marca" => "BMW",
                "modelo" => 2022,
                "tipo" => "hatchback"
            ],
            "propietario" => [
                "nombre" => "Sofía Ramírez",
                "ciudad" => "Saltillo",
                "direccion" => "Calle Victoria 1010"
            ]
        ],
        "NOP3345" => [
            "auto" => [
                "marca" => "Mercedes",
                "modelo" => 2021,
                "tipo" => "sedan"
            ],
            "propietario" => [
                "nombre" => "Miguel Ángel Torres",
                "ciudad" => "Culiacán",
                "direccion" => "Av. Obregón 1112"
            ]
        ],
        "QRS4456" => [
            "auto" => [
                "marca" => "Audi",
                "modelo" => 2020,
                "tipo" => "hatchback"
            ],
            "propietario" => [
                "nombre" => "Lucía Fernández",
                "ciudad" => "San Luis Potosí",
                "direccion" => "Calle Carranza 1313"
            ]
        ]
    ];
    $mensaje = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $consulta = $_POST["consulta"];

        if ($consulta == "uno") {
            $matricula = strtoupper(trim($_POST["matricula"]));

            if (isset($parqueVehicular[$matricula])) {
                $auto = $parqueVehicular[$matricula];
                $mensaje = "<h3>Detalles del Vehículo</h3>";
                $mensaje .= "<p><strong>Matrícula:</strong> $matricula</p>";
                $mensaje .= "<p><strong>Marca:</strong> " . $auto["auto"]["marca"] . "</p>";
                $mensaje .= "<p><strong>Modelo:</strong> " . $auto["auto"]["modelo"] . "</p>";
                $mensaje .= "<p><strong>Tipo:</strong> " . $auto["auto"]["tipo"] . "</p>";
                $mensaje .= "<p><strong>Propietario:</strong> " . $auto["propietario"]["nombre"] . "</p>";
                $mensaje .= "<p><strong>Ciudad:</strong> " . $auto["propietario"]["ciudad"] . "</p>";
                $mensaje .= "<p><strong>Dirección:</strong> " . $auto["propietario"]["direccion"] . "</p>";
            } else {
                $mensaje = "<p style='color:red;'>No se encontró la matrícula ingresada.</p>";
            }
        } elseif ($consulta == "todos") {
            $mensaje = "<h3>Todos los Autos Registrados</h3>";
            foreach ($parqueVehicular as $matricula => $auto) {
                $mensaje .= "<p><strong>Matrícula:</strong> $matricula</p>";
                $mensaje .= "<p><strong>Marca:</strong> " . $auto["auto"]["marca"] . "</p>";
                $mensaje .= "<p><strong>Modelo:</strong> " . $auto["auto"]["modelo"] . "</p>";
                $mensaje .= "<p><strong>Tipo:</strong> " . $auto["auto"]["tipo"] . "</p>";
                $mensaje .= "<p><strong>Propietario:</strong> " . $auto["propietario"]["nombre"] . "</p>";
                $mensaje .= "<p><strong>Ciudad:</strong> " . $auto["propietario"]["ciudad"] . "</p>";
                $mensaje .= "<p><strong>Dirección:</strong> " . $auto["propietario"]["direccion"] . "</p>";
                $mensaje .= "<hr>";
            }
        }
    }
?>