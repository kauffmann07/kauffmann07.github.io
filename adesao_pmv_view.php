<?php
    $query = "select ma.*, m.nome_municipio from municipio_adesoes ma, municipio m where ma.municipio_id = m.id and municipio_id = $municipio_id";
    $resultado = mysqli_query($connection, $query);
    $adesao = mysqli_fetch_array($resultado);
    $dir_TC = "/var/www/html/municipiosverdes/docs_nepmv/docs_municipio_adesao/TC/TC_MPF {$adesao['nome_municipio']}.pdf";
    $dir_adesao = "/var/www/html/municipiosverdes/docs_nepmv/docs_municipio_adesao/adesao/Adesão {$adesao['nome_municipio']}.pdf";

    $querys = "select maa.nome, ma.id as 'id_ma', maa.caminho, ma.municipio_id, maa.municipio_adesoes_id, m.nome_municipio 
    from municipio_adesoes_arquivos maa, municipio_adesoes ma, municipio m
    where maa.municipio_adesoes_id = ma.id and m.id = ma.municipio_id and ma.municipio_id = $municipio_id";
    $resultados = mysqli_query($connection, $querys);
    $arquivo = mysqli_fetch_array($resultados);
?>

<table class="table table-sm">
    <thead class='thead-dark'>
        <tr>
            <th colspan='3'> Adesão ao PMV </th>
        </tr>
    </thead>
    <tbody class="table-active">
        <tr>
            <td>Participa do PMV?</td>
            <td><?= $adesao['adesao_pmv_possui'] ? 'SIM' : 'NÃO'; ?></td>
        </tr>
        <tr>
            <td>Termo de Compromisso com o MPF ?</td>
            <td><?= sim_nao($adesao['tc_mpf_possui']) ?>
                <?php if($adesao['tc_mpf_possui'] == 1 && file_exists($dir_TC)){?>
                    <a href="../../../docs_nepmv/docs_municipio_adesao/TC/TC_MPF <?= $adesao['nome_municipio'] . '.pdf' ?>" target="_blank">Download</a>
                <?php }else{
                    echo "";
                }?>

            </td>
        </tr>
        <tr>
            <td>Acordo específico com o PMV?</td>
            <td><?= sim_nao($adesao['adesao_pmv_possui']) ?>
                <?php if ($adesao['adesao_pmv_possui'] == 1 && file_exists($dir_adesao)) { ?>
                    <a href="../../../docs_nepmv/docs_municipio_adesao/adesao/Adesão <?= $adesao['nome_municipio'] ?>.pdf" target="_blank">Download</a>
                <?php } else {
                    echo "";
                }
                ?>
            </td>
        </tr>
    </tbody>
</table>