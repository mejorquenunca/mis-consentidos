<?php
// Configura la dirección de correo electrónico a la que se enviarán los mensajes.
// ¡MUY IMPORTANTE! Reemplaza esta dirección con tu correo profesional de Hostinger.
$to_email = "gerencia@mis-consentidos-pe.com";

// Configura la dirección de correo electrónico que aparecerá como "De" en el email.
// Es recomendable usar una dirección del mismo dominio para evitar problemas de spam.
$from_email = "no-reply@mis-consentidos-pe.com"; // Asegúrate de que esta dirección exista en tu Hostinger o de que el servidor permita este "From".

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recopila los datos del formulario de forma segura
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telefono = htmlspecialchars(trim($_POST['telefono']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));

    // Validación básica de los campos
    if (empty($nombre) || empty($email) || empty($mensaje) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Redirige con un mensaje de error si la validación falla
        header("Location: index.html?status=error&message=" . urlencode("Por favor, rellena todos los campos obligatorios y asegúrate de que el email sea válido."));
        exit;
    }

    // Prepara el asunto del correo
    $subject = "Nuevo Mensaje de Contacto desde Mis Consentidos";

    // Construye el cuerpo del correo
    $body = "Has recibido un nuevo mensaje desde el formulario de contacto de tu sitio web.\n\n";
    $body .= "Nombre: " . $nombre . "\n";
    $body .= "Correo Electrónico: " . $email . "\n";
    if (!empty($telefono)) {
        $body .= "Teléfono: " . $telefono . "\n";
    }
    $body .= "Mensaje:\n" . $mensaje . "\n";

    // Cabeceras del correo
    $headers = "From: " . $from_email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n"; // Para que puedas responder directamente al remitente
    $headers .= "Content-type: text/plain; charset=UTF-8\r\n"; // Asegura que los caracteres especiales se muestren correctamente

    // Envía el correo electrónico
    if (mail($to_email, $subject, $body, $headers)) {
        // Redirige con un mensaje de éxito
        header("Location: index.html?status=success&message=" . urlencode("¡Gracias! Tu mensaje ha sido enviado con éxito."));
        exit;
    } else {
        // Redirige con un mensaje de error si el envío falla
        header("Location: index.html?status=error&message=" . urlencode("Hubo un problema al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde."));
        exit;
    }
} else {
    // Si alguien intenta acceder directamente al script PHP, redirige a la página de inicio
    header("Location: index.html");
    exit;
}
?>
