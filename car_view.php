<?php 
 $area_pa = 1247689.515;

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

    $query = "select LAST_INSERT_ID(mi.serie_dados_id) as 'serie_dados_id', mi.municipio_id,sd.nome as 'serie_dados_nome', mi.area as 'area_car' from municipio_areas mi join serie_dados sd on 
                mi.serie_dados_id  = sd.id where sd.nome like '%Cadastrada%' and mi.municipio_id = $municipio_id order by LAST_INSERT_ID(mi.serie_dados_id) desc limit 1";
    $resultado = mysqli_query($connection, $query);
    $area_car_cadastrada = mysqli_fetch_array($resultado);

    $query = "select LAST_INSERT_ID(mi.serie_dados_id) as 'serie_dados_id', mi.municipio_id,sd.nome as 'serie_dados_nome', mi.area as 'area_car' from municipio_areas mi join serie_dados sd on 
                mi.serie_dados_id  = sd.id where sd.nome like '%Cadastravel%' and mi.municipio_id = $municipio_id order by LAST_INSERT_ID(mi.serie_dados_id) desc limit 1";
    $resultado = mysqli_query($connection, $query);
    $area_car_cadastravel = mysqli_fetch_array($resultado);

    $percentual = ($area_car_cadastrada['area_car'] / $area_car_cadastravel['area_car']) * 100;
    $meta80 = $percentual >= 80 ? "SIM" : "NÃO";

    $area_meta = ($area_car_cadastravel['area_car'] * 80) / 100;
    $area_diferenca_meta = ($area_car_cadastrada['area_car'] - $area_meta);
    ($area_diferenca_meta < 0) ? ($area_diferenca_meta *= -1) : $area_diferenca_meta;

    $area_cadastral_municipio = ($area_car_cadastravel['area_car'] / $linha['areatotal']) * 100;
    $area_percentual_diferenca_meta = round(($area_diferenca_meta / $area_car_cadastravel['area_car']) * 100, 2);

    $area = $linha['areatotal'];
    $area_percentual = round(($area / $area_pa) * 100, 2);

?>

<table class="table table-sm">
    <thead class='thead-dark'>
        <tr>
            <th colspan='2'>Cadastro Ambiental Rural (CAR)</th>
        </tr>
    </thead>
    <tbody class="table-active">
        <tr>
            <td>80% de CAR <?= substr($area_car_cadastrada['serie_dados_nome'], 20) ?>:</td>
            <td><?= $meta80 ?></td>
        </tr>
        <tr>
            <td> Área CAR Cadastrável <?= substr($area_car_cadastravel['serie_dados_nome'], 22) ?>:</td>
            <td><?= $area_car_cadastravel['area_car'] ?> Km² , <?= areapercentual($area_car_cadastravel['area_car'], $linha['areatotal']) ?>% da área do município </td>
        </tr>
        <tr>
            <td> Área CAR Cadastrada <?= substr($area_car_cadastrada['serie_dados_nome'], 20) ?>:</td>
            <td><?= $area_car_cadastrada['area_car'] ?> Km², <?= areapercentual($area_car_cadastrada['area_car'], $area_car_cadastravel['area_car']) ?>% do total Cadastrável</td>
        </tr>
        <tr>
            <td> Área CAR a ser cadastrada para atingir meta </td>
            <td> <?= $area_diferenca_meta . "Km², " . ($area_percentual_diferenca_meta) . "% do total cadastrável"; ?> </td>
        </tr>

    </tbody>
</table>