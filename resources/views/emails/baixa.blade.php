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
                    <tr>
                        <td>
                            <img src="{{url('/images/header-template.png')}}" width="600">
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" style="padding: 30px 50px 50px 50px; text-align: center">
                            <font face="Roboto, Arial, Helvetica, sans-serif" weight="700" size="6" color="#7400d4"
                                style="font-weight: 700">Olá! </font>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #272933; padding: 0px 50px 50px 50px;">
                            <font face="Roboto, Arial, Helvetica, sans-serif" size="3" weight="600" color="#272933">
                                {{$data['inicio']}}
                                <br>
                                <br>
                                <br>
                                {{$data['conteudo']}}
                                <br>
                                <br>
                                {{$data['final']}}
                                <br>
                                <br>
                                {{$data['footer']}}
                            </font>
                        </td>
                    <tr>
                        <td style="text-align: center; padding-bottom: 50px;">
                            <a href="{{url('/painel-consultor')}}" style="display: inline-block" target="_blank" title="Acessar">
                                <img src="{{url('/images/btn-template.png')}}" width="445">
                            </a>
                        </td>
                    </tr>
        </tr>
    </table>
    </td>
    </tr>
    <tr>
        <td>
            <table width="600" border="0" align="center" style="background-color: #7400d4; padding: 30px 50px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;"
                bgcolor="#7400d4">
                <tr>
                    <td style="text-align: center">
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding-top: 0px; font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #FFFFFF;">
                        <a href="tel:00000000" size="4" style="color: #FFFFFF; text-decoration: none; font-size: 25px;">(00)
                            0000-0000</a>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; padding-top: 10px; font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 400; color: #FFFFFF;">
                        <a href="#" target="_blank" style="text-decoration: underline; color: #ffffff" title="Site Tarot Nova Era">www.tarotnovaera.comn</a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    </table>

</body>

</html>
