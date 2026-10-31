<?php
// Cambia estos datos para personalizar tu página.
$nombre = 'Freddy Estrella';
$carrera = 'Estudiante de Ing. de Software y Desarrollo Web';
$correo = 'freddyest2013@gmail.com';

function escapar($valor) {
    return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
}

$numero1 = '';
$numero2 = '';
$operacion = 'sumar';
$resultado = null;
$error = '';
$operaciones = ['sumar' => 'Sumar (+)', 'restar' => 'Restar (−)',
                'multiplicar' => 'Multiplicar (×)', 'dividir' => 'Dividir (÷)'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Comprueba también que no se hayan enviado arreglos en los campos.
    $numero1 = is_string($_POST['numero1'] ?? null) ? trim($_POST['numero1']) : '';
    $numero2 = is_string($_POST['numero2'] ?? null) ? trim($_POST['numero2']) : '';
    $operacion = is_string($_POST['operacion'] ?? null) ? $_POST['operacion'] : '';

    if ($numero1 === '' || $numero2 === '' || !is_numeric($numero1) || !is_numeric($numero2)) {
        $error = 'Ingresa dos números válidos.';
    } elseif (!array_key_exists($operacion, $operaciones)) {
        $error = 'Selecciona una operación válida.';
    } else {
        $a = (float) $numero1;
        $b = (float) $numero2;
        if (!is_finite($a) || !is_finite($b)) {
            $error = 'Los números son demasiado grandes.';
        } else {
            switch ($operacion) {
                case 'sumar': $resultado = $a + $b; break;
                case 'restar': $resultado = $a - $b; break;
                case 'multiplicar': $resultado = $a * $b; break;
                case 'dividir':
                    if ($b == 0) {
                        $error = 'No se puede dividir entre cero.';
                    } else {
                        $resultado = $a / $b;
                    }
                    break;
            }
            if ($resultado !== null && !is_finite($resultado)) {
                $error = 'El resultado es demasiado grande.';
                $resultado = null;
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página personal y calculadora de operaciones básicas en PHP.">
    <title><?= escapar($nombre) ?> | Mi página personal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="encabezado">
    <a class="marca" href="#inicio">Mi espacio<span>.</span></a>
    <nav aria-label="Navegación principal">
        <a href="#sobre-mi">Sobre mí</a>
        <a href="#calculadora">Calculadora</a>
        <a href="#contacto">Contacto</a>
    </nav>
</header>
<main id="inicio">
    <section class="presentacion" aria-labelledby="titulo">
        <div>
            <p class="etiqueta">APRENDER · CREAR · COMPARTIR</p>
            <h1 id="titulo">Hola, soy<br><span><?= escapar($nombre) ?></span></h1>
            <p class="subtitulo"><?= escapar($carrera) ?>.</p>
            <p>Este es mi primer espacio en la web: un lugar para presentarme y poner en práctica lo que aprendo.</p>
            <a class="boton" href="#calculadora">Prueba mi calculadora <span aria-hidden="true">↗</span></a>
        </div>
        <div class="tarjeta-perfil">
            <div class="simbolo" aria-hidden="true">&lt;/&gt;</div>
            <p>Mi primer proyecto web</p>
            <div class="tecnologias"><span>HTML</span><span>CSS</span><span>PHP</span></div>
        </div>
    </section>
    <section id="sobre-mi" class="seccion" aria-labelledby="titulo-sobre-mi">
        <p class="etiqueta">01 / CONÓCEME</p>
        <h2 id="titulo-sobre-mi">Un poco sobre mí</h2>
        <p>Soy estudiante y estoy aprendiendo a desarrollar páginas web. Me interesa comprender cómo la tecnología puede ayudar a resolver problemas cotidianos.</p>
        <div class="intereses">
            <article><h3>Mis intereses</h3><p>Programación, tecnología y diseño web.</p></article>
            <article><h3>Lo que estoy aprendiendo</h3><p>Estructurar contenido con HTML, darle estilo con CSS y procesar datos con PHP.</p></article>
            <article><h3>Mi objetivo</h3><p>Crear proyectos útiles y seguir mejorando mis habilidades de desarrollo.</p></article>
        </div>
    </section>
    <section id="calculadora" class="seccion calculadora" aria-labelledby="titulo-calculadora">
        <div>
            <p class="etiqueta">02 / MI PROYECTO EN ACCIÓN</p>
            <h2 id="titulo-calculadora">Cuentas claras.</h2>
            <p>Introduce dos números y elige una operación. Mi calculadora permite sumar, restar, multiplicar y dividir.</p>
        </div>
        <form method="post" action="#calculadora" class="formulario">
            <div class="numeros">
                <div><label for="numero1">Primer número</label><input id="numero1" name="numero1" type="number" step="any" required value="<?= escapar($numero1) ?>" placeholder="Ej. 12"></div>
                <div><label for="numero2">Segundo número</label><input id="numero2" name="numero2" type="number" step="any" required value="<?= escapar($numero2) ?>" placeholder="Ej. 3"></div>
            </div>
            <label for="operacion">Operación</label>
            <select id="operacion" name="operacion">
                <?php foreach ($operaciones as $valor => $texto): ?>
                <option value="<?= escapar($valor) ?>" <?= $operacion === $valor ? 'selected' : '' ?>><?= escapar($texto) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="boton" type="submit">Calcular resultado</button>
            <div class="respuesta" role="status" aria-live="polite">
                <?php if ($error !== ''): ?>
                    <p class="error"><?= escapar($error) ?></p>
                <?php elseif ($resultado !== null): ?>
                    <span>Resultado</span><strong><?= escapar(sprintf('%.12g', $resultado)) ?></strong>
                <?php else: ?>
                    <p>Tu resultado aparecerá aquí.</p>
                <?php endif; ?>
            </div>
        </form>
    </section>
    <section id="contacto" class="seccion contacto" aria-labelledby="titulo-contacto">
        <p class="etiqueta">03 / SIGAMOS EN CONTACTO</p>
        <h2 id="titulo-contacto">Hablemos.</h2>
        <p>Puedes escribirme a <a href="mailto:<?= escapar($correo) ?>"><?= escapar($correo) ?></a>.</p>
    </section>
</main>
<footer><p>© <?= date('Y') ?> <?= escapar($nombre) ?> · Hecho con HTML, CSS y PHP.</p></footer>
</body>
</html>
