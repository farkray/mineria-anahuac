<?php
// Configuración de la conexión a la base de datos
$host = '35.215.110.77';
$user = 'ugu1kvcishvbx';
$password = '--------------'; # Aquí introduce la contraseña de tu base de datos
$database = 'dboewuclpuqgcr';

// Establecer la conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los productos
$sql = "SELECT * FROM prueba_productos";
$result = $conn->query($sql);

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Productos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #FF5900; /* Color institucional */
            --secondary-color: #f8f9fa;
            --text-color: #333333;
            --light-gray: #f0f0f0;
            --dark-gray: #666666;
            --white: #ffffff;
            --badge-color:rgb(228, 140, 8);
        }
        
        body {
            padding: 20px;
            background-color: var(--light-gray);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
        }
        
        h1 {
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 30px;
            position: relative;
            display: inline-block;
        }
        
        h1:after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 3px;
            background-color: var(--primary-color);
        }
        
        .product-card {
            height: 100%;
            transition: all 0.3s ease;
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            position: relative;
        }
        
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.12);
        }
        
        .product-img {
            height: 250px;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .product-card:hover .product-img {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 20px;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        
        .card-title {
            font-weight: 700;
            margin-bottom: 15px;
            font-size: 1.1rem;
            color: var(--primary-color);
            min-height: 40px;
        }
        
        .card-text {
            font-size: 0.9rem;
            color: var(--dark-gray);
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            min-height: 60px;
            flex-grow: 1;
            margin-bottom: 15px;
        }
        
        .btn-container {
            margin-top: auto;
            text-align: start;
        }
        
        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--badge-color);
            color: var(--white);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 1;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            border-radius: 50px;
            padding: 8px 20px;
            font-weight: 600;
            margin-top: 15px;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #e65000; /* Versión más oscura del color principal */
            border-color: #e65000;
            transform: translateY(-2px);
            box-shadow: 0 5px 10px rgba(255, 89, 0, 0.3);
        }
        
        .alert {
            margin-bottom: 20px;
            border-radius: 10px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        /* Efecto de carga animada */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .col {
            animation: fadeIn 0.5s ease forwards;
        }
        
        /* Diferentes tiempos de delay para una carga escalonada */
        .col:nth-child(1) { animation-delay: 0.1s; }
        .col:nth-child(2) { animation-delay: 0.2s; }
        .col:nth-child(3) { animation-delay: 0.3s; }
        .col:nth-child(4) { animation-delay: 0.4s; }
        
        /* Barra superior */
        .top-bar {
            background-color: var(--primary-color);
            padding: 15px 0;
            margin-bottom: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        .top-bar h1 {
            color: white;
            margin: 0;
            text-align: center;
        }
        
        .top-bar h1:after {
            display: none;
        }
        
        /* Estilos para el footer */
        .footer {
            background-color: var(--primary-color);
            color: white;
            padding: 20px 0;
            margin-top: 50px;
            border-radius: 10px;
            text-align: center;
        }
        
        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>
    <!-- Barra superior con título -->
    <div class="top-bar">
        <div class="container">
            <h1><i class="fas fa-shoe-prints me-2"></i> Catálogo de Productos</h1>
        </div>
    </div>
    
    <div class="container">
        <?php
        // Verificar si hay errores en la consulta
        if (!$result) {
            echo '<div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i> Error en la consulta: ' . $conn->error . '
            </div>';
        }
        ?>
        
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            <?php
            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
                <div class="col">
                    <div class="card product-card">
                        <?php if (rand(0, 3) == 1): ?>
                            <span class="product-badge">Destacado</span>
                        <?php endif; ?>
                        <img src="<?php echo htmlspecialchars($row['Imagen']); ?>" class="card-img-top product-img" alt="<?php echo htmlspecialchars($row['Producto']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['Producto']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($row['Descripcion']); ?></p>
                            <div class="btn-container">
                                <a href="#" class="btn btn-primary btn-sm">Ver detalle</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
                }
            } else {
            ?>
                <div class="col-12">
                    <div class="alert alert-info">No se encontraron productos en la base de datos.</div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>