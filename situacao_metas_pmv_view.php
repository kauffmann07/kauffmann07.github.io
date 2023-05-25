<?php
$query = "select ma.*,m.nome_municipio from municipio_adesoes ma, municipio m where m.id = ma.municipio_id and municipio_id = $municipio_id";
$resultado = mysqli_query($connection, $query);
$adesao = mysqli_fetch_array($resultado);
$dir_GT = "/var/www/html/municipiosverdes/docs_nepmv/docs_municipio_adesao/GT/GT {$adesao['nome_municipio']}.pdf";
$dir_pacto = "/var/www/html/municipiosverdes/docs_nepmv/docs_municipio_adesao/pacto/Pacto {$adesao['nome_municipio']}.pdf";
?>
<table class="table table-sm">
    <thead class="thead-dark">
        <tr>
            <th colspan='3'>Situação do Município quanto às Metas do PMV</th>
        </tr>
    </thead>
    <tbody class="table-active">
        <tr>
            <td> Pacto contra Desmatamento </td>
            <td><?= sim_nao($adesao['pacto_desm_possui'], array("Realizado", "Não Realizado")) ?>
                <?php if ($adesao['pacto_desm_data'] != '0001-01-01' && !is_null($adesao['pacto_desm_data'])) {
                    echo " em " . date('d/m/Y', strtotime($adesao['pacto_desm_data']));
                    if ($adesao['pacto_desm_possui'] == 1 && file_exists($dir_pacto)) { ?>
                        <a href="../../../docs_nepmv/docs_municipio_adesao/pacto/Pacto <?= $adesao['nome_municipio'] . '.pdf' ?>" target="_blank">Download</a>
                <?php } else {
                        echo "";
                    }
                } else {
                    echo "";
                }

                ?>
        </tr>
        <tr>
            <td>Grupo de combate ao desmatamento</td>
            <td><?= sim_nao($adesao['grupo_trabalho_possui'], array("Criado", "Não Criado")) ?>
                <?php if ($adesao['grupo_trabalho_data'] != '0001-01-01' && !is_null($adesao['grupo_trabalho_data'])) {
                    echo " em " . date('d/m/Y', strtotime($adesao['grupo_trabalho_data']));
                    if ($adesao['pacto_desm_possui'] == 1 && file_exists($dir_GT)) { ?>
                        <a href="../../../docs_nepmv/docs_municipio_adesao/GT/GT <?= $adesao['nome_municipio'] . '.pdf' ?>" target="_blank">Download</a>
                <?php } else {
                        echo "";
                    }
                } else {
                    echo "";
                } ?>
        </tr>

        <?php
        ?>
    </tbody>
</table>