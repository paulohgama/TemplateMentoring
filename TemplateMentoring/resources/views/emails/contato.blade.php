<!DOCTYPE html>
<html>
<head>
    <meta charset="iso-8859-1" />
    <title></title>
</head>
<body>

<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <!-- HEADER -->
                <tr>
                    <td>
                        <!-- <img src="{{--url('/images/header-template.png')--}}" width="600"> -->
                        <a href="http://tarotnovaera.provisorio.ws"><img src="http://www.kbrtec.com.br/teste-tarcisio-thallys/n/header-template.png" width="600"></a>
                    </td>
                </tr>

                <!-- CONTEUDO -->
                <tr>
                    <td bgcolor="#FFFFFF" style="padding: 30px 50px 50px 50px; text-align: center">
                        <font face="Roboto, Arial, Helvetica, sans-serif" weight="700" size="6" color="#7400d4" style="font-weight: 700">Olá! Administrador</font>
                    </td>
                </tr>
                <tr>
                    <td style="font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #272933; padding: 0px 50px 50px 50px;">
                        <font face="Roboto, Arial, Helvetica, sans-serif" size="3" weight="600" color="#272933">
                            Nova mensagem de contato enviada ao site <font face="Roboto, Arial, Helvetica, sans-serif" weight="400" size="3" color="#7400d4" style="font-weight: 700">
                                Tarot Nova Era</font>.
                            <br>
                            Informações do contato abaixo:
                            <br/><br/>
                            Nome: {{$data['nome']}}.<br/>
                            E-mail: {{$data['email']}}.<br/>
                            Telefone: {{$data['telefone']}}.<br/>
                            <br><br>
                            Mensagem enviada:
                            <br>
                            <div style="word-break: break-all;">
                                <?= nl2br($data['msg']); ?>
                            </div>
                        </font>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <!-- FOOTER -->
    <tr>
        <td>
            <table width="600" border="0" align="center" style="background-color: #7400d4; padding: 30px 50px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;" bgcolor="#7400d4">
                <tr>
                    <td style="text-align: center">
                        <img src="{{--url('/images/whats-icon.png')--}}" border="0">
                        <img src="http://www.kbrtec.com.br/teste-tarcisio-thallys/n/whats-icon.png" border="0">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding-top: 0px; font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #FFFFFF;">
                        <a href="tel:00000000" size="4" style="color: #FFFFFF; text-decoration: none; font-size: 25px;">(00) 0000-0000</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding-top: 10px; font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 400; color: #FFFFFF;">
                        <a href="#" target="_blank" style="text-decoration: underline; color: #ffffff" title="Site Tarot Nova Era">www.tarotnovaera.com.br</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

</body>
</html>