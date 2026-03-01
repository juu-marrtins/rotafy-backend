<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="color-scheme" content="light">
    <meta name="supported-color-schemes" content="light">
    <title>Confirme seu e-mail</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #e8ecf0;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
        }

        .wrapper {
            width: 100%;
            background-color: #e8ecf0;
            padding: 48px 16px;
        }

        .email-card {
            max-width: 560px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 2px 12px rgba(29, 53, 87, 0.10);
        }

        .accent-bar {
            height: 4px;
            background: #a8e63e;
            font-size: 0;
            line-height: 0;
        }

        .email-header {
            background: #1d3557;
            padding: 30px 48px;
        }

        .brand-name {
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .brand-accent {
            color: #a8e63e;
        }

        .email-body {
            padding: 48px 48px 40px;
            background: #ffffff;
        }

        .section-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #457b9d;
            margin-bottom: 16px;
            display: block;
        }

        .greeting {
            font-size: 20px;
            font-weight: 600;
            color: #1d3557;
            margin-bottom: 24px;
            line-height: 1.3;
        }

        .email-body p {
            font-size: 14px;
            line-height: 1.85;
            color: #4a5568;
            margin-bottom: 16px;
        }

        .btn-wrap {
            margin: 32px 0;
        }

        .btn-primary {
            display: inline-block;
            background: #a8e63e;
            color: #1d3557 !important;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 14px 36px;
            border-radius: 0;
        }

        .divider {
            border: none;
            border-top: 1px solid #e8ecf0;
            margin: 32px 0;
        }

        .subcopy {
            font-size: 12px;
            color: #9aa5b4;
            line-height: 1.7;
        }

        .subcopy a {
            color: #457b9d;
            word-break: break-all;
        }

        .email-footer {
            background: #f4f7fb;
            border-top: 1px solid #e8ecf0;
            padding: 22px 48px;
        }

        .footer-table {
            width: 100%;
        }

        .footer-left {
            font-size: 12px;
            color: #9aa5b4;
            vertical-align: middle;
        }

        .footer-left strong {
            display: block;
            color: #1d3557;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 2px;
        }

        .footer-right {
            font-size: 11px;
            color: #b0bcc9;
            text-align: right;
            vertical-align: middle;
            line-height: 1.6;
        }

        @media only screen and (max-width: 600px) {
            .wrapper { padding: 16px 12px !important; }
            .email-header { padding: 24px 24px !important; }
            .email-body { padding: 28px 24px !important; }
            .email-footer { padding: 20px 24px !important; }
            .email-card { width: 100% !important; }
            .btn-primary {
                display: block !important;
                text-align: center !important;
                width: 100% !important;
                padding: 16px !important;
            }
            .footer-table, .footer-left, .footer-right {
                display: block !important;
                width: 100% !important;
                text-align: left !important;
            }
            .footer-right { margin-top: 8px !important; }
        }
    </style>
</head>
<body>
<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr><td>

    <table class="email-card" align="center" width="560" cellpadding="0" cellspacing="0" role="presentation">

        {{-- Accent bar --}}
        <tr><td class="accent-bar" height="4">&nbsp;</td></tr>

        {{-- Header --}}
        <tr>
            <td class="email-header">
                <span class="brand-name">
                    {{ config('app.name') }}<span class="brand-accent">.</span>
                </span>
            </td>
        </tr>

        {{-- Body --}}
        <tr>
            <td class="email-body">
                <span class="section-label">Verificação de conta</span>
                <p class="greeting">Olá, {{ $name }}</p>

                <p>Obrigado por se cadastrar. Para ativar sua conta e garantir a segurança do seu acesso, é necessário confirmar o endereço de e-mail cadastrado.</p>
                <p>Clique no botão abaixo para concluir a verificação.</p>

                <div class="btn-wrap">
                    <a href="{{ $url }}" class="btn-primary" target="_blank">Verificar e-mail</a>
                </div>

                <p>Caso não tenha criado uma conta em nossa plataforma, desconsidere esta mensagem.</p>

                <hr class="divider">

                <p class="subcopy">
                    Se o botão acima não funcionar, copie e cole o endereço abaixo diretamente no seu navegador:<br>
                    <a href="{{ $url }}">{{ $url }}</a>
                </p>
            </td>
        </tr>

        {{-- Footer --}}
        <tr>
            <td class="email-footer">
                <table class="footer-table" cellpadding="0" cellspacing="0" role="presentation">
                    <tr>
                        <td class="footer-left">
                            <strong>{{ config('app.name') }}</strong>
                            © {{ date('Y') }} · Todos os direitos reservados
                        </td>
                        <td class="footer-right">
                            Este é um e-mail automático.<br>
                            Por favor, não responda.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

    </table>

</td></tr>
</table>
</body>
</html>