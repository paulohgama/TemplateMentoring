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
                        <a href="http://tarotnovaera.provisorio.ws/painel-consultor/login"><img src="http://www.kbrtec.com.br/teste-tarcisio-thallys/n/header-template.png" width="600"></a>
                    </td>
                </tr>

                <!-- CONTEUDO -->
                <tr>
                    <td bgcolor="#FFFFFF" style="padding: 30px 50px 50px 50px; text-align: center">
                        <font face="Roboto, Arial, Helvetica, sans-serif" weight="700" size="6" color="#7400d4" style="font-weight: 700">Recuperação de senha</font>
                    </td>
                </tr>
                <tr>
                    <td style="font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #272933; padding: 0px 50px 50px 50px;">
                        <font face="Roboto, Arial, Helvetica, sans-serif" size="3" weight="600" color="#272933">
                            <p>Olá {{$data['nome']}}, você solicitou a redefinição de senha.
                            Sua senha foi redefinida para:</p>
                            <p><span style="display: inline-block; background: #00cb94; border-radius: 5px; color: #ffffff; padding: 3px;">
                                {{$data['senha']}}
                            </span></p>
                            <p>Esta é uma senha provisória, você deve trocá-la quando efetuar o login.Caso a redefinição de senha não tenha sido feita por você, contate imediatamente o administrador do sistema.</p>
                        </font>
                    </td>
                </tr>
                <tr>
                    <!-- BOTÃO -->
                    <!--[if mso]>
                        <center style="margin-bottom: 12px;">
                        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="http://tarotnovaera.provisorio.ws/painel-consultor/login" style="height:40px;v-text-anchor:middle;width:300px;" arcsize="10%" stroke="f" fillcolor="#00cb94">
                            <w:anchorlock/>
                            <center style="color:#ffffff;font-family:sans-serif;font-size:16px;font-weight:bold;">
                                Acessar Painel do Consultor
                            </center>
                        </v:roundrect>
                        </center>
                    <![endif]-->
                    <!--[if !mso]> <!-->
                        <td style="text-align: center; padding-bottom: 50px;">
                            <center>
                            <a href="http://tarotnovaera.provisorio.ws/painel-consultor/login" style="display: inline-block; text-decoration: none; background: #00cb94; border-radius: 5px; color: #ffffff; padding: 12px" target="_blank" title="Acessar">
                                <strong>ACESSAR PAINEL DO CONSULTOR</strong>
                            </a>
                            <center>
                        </td>
                    <!-- <![endif]-->
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