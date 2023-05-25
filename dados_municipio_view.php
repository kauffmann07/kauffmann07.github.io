<?php

$query = "select p.email, mq.cargo, p.nome as 'nome_pessoa', mq.partido
    from municipio_quadro mq join municipio m
    on mq.municipio_id = m.id 
    join pessoa p 
    on mq.pessoa_id = p.id where mq.cargo ='secretario' and m.id = $municipio_id ";

$resultado = mysqli_query($connection, $query);
$secretario = mysqli_fetch_array($resultado);


$query = "select p.email, p.nome as 'nome_pessoa', mq.vigencia_inicio, mq.vigencia_fim, mq.partido from municipio_quadro mq join municipio m
on mq.municipio_id = m.id join pessoa p 
on mq.pessoa_id = p.id where mq.cargo ='prefeito' and m.id = $municipio_id";
$resultado = mysqli_query($connection, $query);
$prefeito = mysqli_fetch_array($resultado);

?>

<table class="table table-sm">
    <thead class="thead-dark">
        <tr>
            <th colspan=2>Dados Complementares</th>
        </tr>

    </thead>
    <tbody class="table-active">
        <tr>
            <td>E-mail Prefeito: <a href="mailto:<?=$prefeito['email']?>"><?= $prefeito['email'] ? $prefeito['email'] : '' ?></a></td>
        
            <td>E-mail Secretaria: <a href="mailto:<?=$secretario['email']?>"><?= $secretario['email'] ? $secretario['email'] : '' ?></td>
        </tr>
    </tbody>
</table>