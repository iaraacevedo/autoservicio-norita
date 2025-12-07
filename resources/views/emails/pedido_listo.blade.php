<!DOCTYPE html>
<html>

<head>
    <title>¡Tu pedido está listo!</title>
</head>

<body style="font-family: sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; border: 1px solid #ddd;">
        <h2 style="color: #000; text-align: center;">Autoservicio Norita</h2>
        <hr style="border: 0; border-top: 1px solid #eee;">

        <h3 style="color: #198754; text-align: center;">✅ ¡Tu pedido #{{ $pedido->id }} está listo!</h3>

        <p>Hola <strong>{{ $pedido->user->name }}</strong>,</p>
        <p>Ya preparamos tu compra. Podés pasar a retirarla por nuestro local cuando quieras.</p>

        <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>📍 Dirección:</strong> Av. Sabin 781, Resistencia</p>
            <p style="margin: 5px 0;"><strong>💰 Total:</strong> ${{ number_format($pedido->total, 0, ',', '.') }}</p>
            <p style="margin: 5px 0;"><strong>🕒 Horarios:</strong> 08:00 - 13:00 y 17:00 - 21:00 hs</p>
        </div>

        <p style="text-align: center; font-size: 12px; color: #888;">Gracias por confiar en nosotros.</p>
    </div>
</body>

</html>