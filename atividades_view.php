<?php
include 'paginas/connection.php';
//$dir = '/docs_nepmv/editais/';
$id = $_GET['municipio'];

$query = "select ma.id, m.nome_municipio, ap.descricao,i.titulo, i.meta_unidade, ma.meta, ma.fonte from metas_alcancadas ma 
    join fa_acompanhamentos_municipios fam on
    fam.id = ma.fa_acompanhamentos_municipio_id 
    join municipio m on 
    m.id = fam.municipio_id 
    join acoes_padroes_indicadores api on 
    ma.acoes_padroes_indicador_id = api.id 
    join acoes_padroes ap on 
    ap.id = api.acao_id 
    join indicadores i on 
    i.id = api.indicador_id 
    where m.id = $id ";

$resultado = mysqli_query($connection, $query);

?>
<table class="table table-active table-bordered table-sm">
    <thead class="thead-dark">
        <tr>
            <th colspan="5" style="text-align: center;"> Projeto Fundo Amazônia: Resultados Alcançados no Município </th>
        </tr>

        <tr>
            <th>Indicadores</th>
            <th>Resultados Alcançados / Fonte</th>

        </tr>
    </thead>
    <tbody>
        <?php while ($atividades = mysqli_fetch_array($resultado)) { ?>
            <tr>
                <td><?= $atividades['titulo'] ?></td>
                <td><?= ($atividades['meta'].'  ' . unidade($atividades['meta_unidade']) .' / ' . $atividades['fonte']) ?></td>
            <?php } ?>

            </tr>

    </tbody>

</table>