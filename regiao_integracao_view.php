<?php
$query = "select cp.nome, cp.id, cpm.municipio_id from categoria_pmv cp join categoria_pmv_municipio cpm
    on cp.id = cpm.categoria_pmv_id where municipio_id = $municipio_id";
    $resultado = mysqli_query($connection, $query);
    $categoria = mysqli_fetch_array($resultado);

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
<table class="table table-sm">

    <thead class='thead-light'>
        <tr>
            <th>Municipio: <?= $linha['nome_municipio'] ?> / <?= $categoria['nome'] ?>
            <th style="text-align: right;"> Região de integração: <?= $linha['regiao_integracao'] ?></th>
        </tr>
    </thead>
</table>