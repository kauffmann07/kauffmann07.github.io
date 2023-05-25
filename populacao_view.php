<?php
$sql =  "select m.nome_municipio, d.area as 'area_desmatamento', ma.area as 'areatotal', p.total,p.urbana, p.rural,
    ri.regiao as 'regiao_integracao', sd.nome as 'serie_dados_nome'
    from municipio m join municipio_areas ma on
    m.id = ma.municipio_id 
    join populacoes p on 
    m.id = p.municipio_id 
    join regiao_integracao ri on 
    ri.id = m.regiao_integracao_id 
    join desmatamentos d on
    d.municipio_id = m.id
    join serie_dados sd on 
    sd.id  = d.serie_dado_id
    where m.id = $municipio_id order by ma.serie_dados_id asc limit 1";

    $dados = mysqli_query($connection, $sql);
    $linha = mysqli_fetch_array($dados);
?>
<table class='table table-bordered table-sm'>
    <thead class='thead-dark'>
        <tr>
            <th colspan='3'> População </th>
        </tr>
    </thead>
    <tbody class="table-active">
        <tr>
            <td>Total: </td>
            <td>Urbana</td>
            <td>Rural</td>
        </tr>
        <tr>
            <td><?= number_format($linha['total'], 0, ',', '.') ?> hab </td>
            <td><?= number_format($linha['urbana'], 0, ',', '.') ?> hab</td>
            <td><?= number_format($linha['rural'], 0, ',', '.') ?> hab</td>
        </tr>
    </tbody>
</table>