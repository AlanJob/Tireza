<?php
// Verificamos que el formulario se haya enviado por el método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Recoger y limpiar los datos para evitar inyecciones de código
    $nombre  = htmlspecialchars(trim($_POST['name']));
    $correo  = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefono = htmlspecialchars(trim($_POST['number']));
    $asunto_cliente = htmlspecialchars(trim($_POST['subject']));
    $mensaje = htmlspecialchars(trim($_POST['message']));

    // 2. Configuración del destinatario (TU CORREO)
    $destinatario = "ventas@tireza.com.mx";
    $asunto_email = "Nuevo contacto Web Tireza: " . $asunto_cliente;

    // 3. Estructura del cuerpo del mensaje
    $cuerpo = "Has recibido un mensaje desde el sitio web de Tireza:\n\n";
    $cuerpo .= "Nombre: " . $nombre . "\n";
    $cuerpo .= "Correo: " . $correo . "\n";
    $cuerpo .= "Teléfono: " . $telefono . "\n";
    $cuerpo .= "Asunto: " . $asunto_cliente . "\n";
    $cuerpo .= "Mensaje:\n" . $mensaje . "\n\n";
    $cuerpo .= "--- Fin del mensaje ---";

    // 4. Cabeceras del correo (Permiten que puedas responder directamente al cliente)
    $headers = "From: Tireza Web <ventas@tireza.com.mx>\r\n"; // Cambia esto al dominio de tu hosting si es posible
    $headers .= "Reply-To: " . $correo . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // 5. Envío del correo y validación
    if (mail($destinatario, $asunto_email, $cuerpo, $headers)) {
        // Si se envía con éxito, mostramos una alerta y regresamos al inicio
        echo "<script>
                alert('¡Mensaje enviado con éxito! Nos pondremos en contacto contigo pronto.');
                window.location.href='index.html';
              </script>";
    } else {
        // Si hay un error en el servidor
        echo "<script>
                alert('Error al enviar el mensaje. Por favor, intenta de nuevo o contáctanos por teléfono.');
                window.location.href='index.html';
              </script>";
    }
} else {
    // Si alguien intenta acceder al archivo directamente por la URL, lo mandamos al inicio
    header("Location: index.html");
    exit;
}
?>