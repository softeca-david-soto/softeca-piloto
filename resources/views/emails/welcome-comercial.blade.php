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
                                Bienvenido
                            </p>
                            <h1 style="margin:0 0 24px; font-size:28px; font-weight:700; color:#18181b; letter-spacing:-0.5px; line-height:1.2;">
                                {{ $user->name }}
                            </h1>

                            <p style="margin:0 0 20px; font-size:15px; color:#3f3f46; line-height:1.7;">
                                Enhorabuena por haberte dado de alta en la herramienta de gestión de <strong style="color:#18181b;">Embutidos Soto</strong>. A partir de ahora tienes acceso a todo lo que necesitas para gestionar tu actividad comercial desde un solo lugar.
                            </p>

                            <p style="margin:0 0 8px; font-size:14px; color:#52525b; line-height:1.6;">
                                Desde tu panel podrás:
                            </p>

                            <table cellpadding="0" cellspacing="0" width="100%" style="margin: 16px 0 28px;">
                                <tr>
                                    <td style="padding: 12px 16px; background:#f9fafb; border-radius:8px; border-left: 3px solid #18181b;">
                                        <p style="margin:0; font-size:14px; color:#18181b; font-weight:600;">👥 Clientes</p>
                                        <p style="margin:4px 0 0; font-size:13px; color:#71717a;">Consulta y gestiona tu cartera de clientes.</p>
                                    </td>
                                </tr>
                                <tr><td style="height:8px;"></td></tr>
                                <tr>
                                    <td style="padding: 12px 16px; background:#f9fafb; border-radius:8px; border-left: 3px solid #18181b;">
                                        <p style="margin:0; font-size:14px; color:#18181b; font-weight:600;">🥩 Productos</p>
                                        <p style="margin:4px 0 0; font-size:13px; color:#71717a;">Accede al catálogo completo de productos disponibles.</p>
                                    </td>
                                </tr>
                            </table>

                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-color:#18181b; border-radius:8px;">
                                        <a href="{{ $dashboardUrl ?? url('/dashboard') }}"
                                           style="display:inline-block; padding: 13px 28px; font-size:14px; font-weight:600; color:#ffffff; text-decoration:none; letter-spacing:0.2px;">
                                            Acceder al panel →
                                        </a>
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>
