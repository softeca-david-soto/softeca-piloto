<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a Embutidos Soto</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f5; font-family: ui-sans-serif, system-ui, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f5; padding: 40px 16px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background:#ffffff; border-radius:12px; overflow:hidden; box-shadow: 0 1px 4px rgba(0,0,0,0.08);">
                    <tr>
                        <td style="padding: 40px 40px 32px;">

                            <p style="margin:0 0 6px; font-size:13px; font-weight:600; color:#71717a; text-transform:uppercase; letter-spacing:1px;">
                                Hola
                            </p>
                            <h1 style="margin:0 0 24px; font-size:28px; font-weight:700; color:#18181b; letter-spacing:-0.5px; line-height:1.2;">
                                {{ $user->name }}
                            </h1>

                            <p style="margin:0 0 20px; font-size:15px; color:#3f3f46; line-height:1.7;">
                                Su cuenta ha sido desactivada. Ya no tendrá acceso a la herramienta de gestión de <strong style="color:#18181b;">Embutidos Soto</strong>.
                            </p>

                            <p style="margin:0 0 8px; font-size:14px; color:#52525b; line-height:1.6;">
                                Si cree que se trata de un error contacte a <a href="mailto:info@embutidossoto.com" style="color:#52525b;">info@embutidossoto.com</a>
                            </p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
