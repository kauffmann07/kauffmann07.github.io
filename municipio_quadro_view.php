<?php
$query = "select mq.cargo, p.nome as 'nome_pessoa', mq.partido
    from municipio_quadro mq join municipio m
    on mq.municipio_id = m.id 
    join pessoa p 
    on mq.pessoa_id = p.id where mq.cargo ='secretario' and m.id = $municipio_id ";

    $resultado = mysqli_query($connection, $query);
    $secretario = mysqli_fetch_array($resultado);

$query = "select mq.cargo, p.nome as 'nome_pessoa', mq.partido
    from municipio_quadro mq join municipio m
    on mq.municipio_id = m.id 
    join pessoa p 
    on mq.pessoa_id = p.id where mq.cargo ='Presidente da Camara' and m.id = $municipio_id ";

    $resultado = mysqli_query($connection, $query);
    $presidente = mysqli_fetch_array($resultado);

$query = "select mq.cargo, p.nome as 'nome_pessoa', mq.partido
    from municipio_quadro mq join municipio m
    on mq.municipio_id = m.id 
    join pessoa p 
    on mq.pessoa_id = p.id where mq.cargo ='vice-prefeito' and m.id = $municipio_id";

    $resultado = mysqli_query($connection, $query);
    $vice = mysqli_fetch_array($resultado);

$query = "select p.nome as 'nome_pessoa', mq.vigencia_inicio, mq.vigencia_fim, mq.partido from municipio_quadro mq join municipio m
    on mq.municipio_id = m.id join pessoa p 
    on mq.pessoa_id = p.id where mq.cargo ='prefeito' and m.id = $municipio_id";

    $resultado = mysqli_query($connection, $query);
    $prefeito = mysqli_fetch_array($resultado);
?>
<table class="table table-sm">
    <thead class="thead-dark">
        <tr>
            <th colspan=2>Dados Cadastrais</th>
        </tr>

    </thead>
    <tbody class="table-active">
        <tr>
            <td>Prefeito: <?= $prefeito['nome_pessoa'] ? $prefeito['nome_pessoa'] : '' ?> (<?= date("Y", strtotime($prefeito['vigencia_inicio'])) . '/' . date("Y", strtotime($prefeito['vigencia_fim'])) ?>)</td>
            <td>Vice: <?= $vice['nome_pessoa'] ? $vice['nome_pessoa'] : '' ?></td>
        </tr>
        <tr>
            <td>Presidente da Câmara: <?= $presidente['nome_pessoa'] ? $presidente['nome_pessoa'] : '' ?></td>
            <td>Secretário: <?= $secretario['nome_pessoa'] ? $secretario['nome_pessoa'] : '' ?> </td>
        </tr>
    </tbody>
</table>