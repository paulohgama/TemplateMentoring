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
                        <a href="http://tarotnovaera.provisorio.ws/painel-consultor/login"><img src="http://www.kbrtec.com.br/teste-tarcisio-thallys/n/header-template.png" width="600"></a>
                    </td>
                </tr>

                <!-- CONTEUDO -->
                <tr>
                    <td bgcolor="#FFFFFF" style="padding: 30px 50px 50px 50px; text-align: center">
                        <font face="Roboto, Arial, Helvetica, sans-serif" weight="700" size="6" color="#7400d4" style="font-weight: 700">Olá! {{$data['nome']}}</font>
                    </td>
                </tr>
                <tr>
                    <td style="font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #272933; padding: 0px 50px 50px 50px;">
                        <font face="Roboto, Arial, Helvetica, sans-serif" size="3" weight="600" color="#272933">
                            Olá {{$data['nome']}},
                            <br/>
                            Você realizou um atendimento no site Tarot Nova Era em {{$data['dia']}} às {{$data['horario']}} com o consultor {{$data['consultor']}}.
                            <br/>
                            Segue abaixo a troca de mensagens.
                            <br><br>
                        </font>
                    </td>
                    <tr>
                    @foreach($data['msg'] as $msg)
                        @if($msg->cd_msgporconsultor)
                        <tr>
                        <td style="font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #272933; padding: 0px 50px 50px 50px;">
                            <?= $data['consultor'].' ' ?>: <?= $msg->ds_mensagem ?>
                        </td>
                        
                        @else
                        <tr>
                        <td style="font-family: Roboto, Arial, Helvetica, sans-serif; font-weight: 600; color: #272933; padding: 0px 50px 50px 50px; text-align:right">
                            <?= $data['nome'].' ' ?>: <?= $msg->ds_mensagem ?>
                        </td>
                        </tr>
                        @endif
                    @endforeach
                    </tr>
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