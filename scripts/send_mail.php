<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos del formulario
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    
    // Capturar tipos de sesión seleccionados
    $session_types = isset($_POST['session_type']) ? $_POST['session_type'] : array();
    $session_types_str = implode(", ", $session_types);

    // Validar que todos los campos estén completos
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Dirección de correo de destino
        $to = "ornemeolansph@gmail.com";

        // Asunto del correo
        $subject = "Nuevo mensaje de contacto - Ornella Meolans Fotografía";

        // Contenido del correo
        $body = "Nuevo mensaje de contacto\n";
        $body .= "=======================\n\n";
        $body .= "Nombre: $name\n";
        $body .= "Email: $email\n\n";
        
        if (!empty($session_types_str)) {
            $body .= "Tipos de sesión interesados:\n";
            $body .= "$session_types_str\n\n";
        }
        
        $body .= "Mensaje:\n";
        $body .= "$message\n";

        // Encabezados del correo
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Intentar enviar el correo
        if (mail($to, $subject, $body, $headers)) {
            // Redirigir a página de éxito
            header("Location: ../pages/contacto.html?success=1");
            exit();
        } else {
            // Redirigir a página de error
            header("Location: ../pages/contacto.html?error=1");
            exit();
        }
    } else {
        // Redirigir a página de error
        header("Location: ../pages/contacto.html?error=1");
        exit();
    }
} else {
    // Acceso no autorizado
    header("Location: ../index.html");
    exit();
}
?>

