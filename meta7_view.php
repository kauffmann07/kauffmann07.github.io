<?php
include 'paginas/connection.php';
$municipio_id = $_GET['municipio'];

$query = "select * from gestao_ambientais where municipio_id = $municipio_id";
$resultado = mysqli_query($connection, $query);
$meta7 = mysqli_fetch_array($resultado);


?>

<table class='table table-bordered table-sm'>
    <thead class="thead-dark">
        <tr>
            <th colspan=13>Possuir Sistema e Órgão Municipal de Meio Ambiente Estruturados</th>
        </tr>
    </thead>
    <tbody class="table-active">
        <!--<tr>
                    <td>Respondeu Pesquisa IDESP sobre Gestão Ambiental Municipal?</td>
                    <?php
                    /*if ($meta7['fonte_informacao'] == strstr($meta7['fonte_informacao'], "idesp")) { ?>
                        <td>sim</td>
                    <?php } else { ?>
                        <td>não</td>
                    <?php } */
                    ?>
                   
                </tr> 
                <tr>
                    <td>Validação em campo pelo PMV?</td>
                    <?php /*
                    if ($meta7['fonte_informacao'] == strstr($meta7['fonte_informacao'], "pmv")) { ?>
                        <td>sim</td>
                    <?php } else { ?>
                        <td>não</td>
                    <?php } */
                    ?>
                </tr> -->
        <tr>
            <td>Possui Conselho Municipal de Meio Ambiente?</td>
            <td><?= (is_null($meta7['cmma_existe']) || $meta7['cmma_existe'] == '') ? 'Não Informado' : $meta7['cmma_existe'] ?></td>
        </tr>
        <tr>
            <td>Possui Fundo Municipal de Meio Ambiente?</td>
            <td><?= (is_null($meta7['fmma_existe']) || $meta7['fmma_existe'] == '') ? 'Não Informado' : $meta7['fmma_existe'] ?></td>
        </tr>
        <tr>
            <td>Número Total de funcionários no Órgão Municipal de Meio Ambiente:</td>
            <td><?= $total =  ($meta7['emg_funcionarios_permanentes'] + $meta7['emg_funcionarios_temporarios']) ?> funcionario(s)</td>
        </tr>
        <tr>
            <td>Número de funcionários:</td>
            <td><?= $meta7['emg_funcionarios_permanentes'] ?> Permanentes e <?= $meta7['emg_funcionarios_temporarios'] ?> temporários</td>
        </tr>
        <tr>
            <td>Possui Núcleo específico de Licenciamento?</td>
            <td><?= (is_null($meta7['emg_nucleo_lar']) || $meta7['emg_nucleo_lar'] == '') ? 'Não Informado' : $meta7['emg_nucleo_lar'] ?></td>
        </tr>
        <tr>
            <td>Possui Núcleo específico de Suporte Jurídico?</td>
            <td><?= (is_null($meta7['emg_suporte_juridico']) || $meta7['emg_suporte_juridico'] == '') ? 'Não Informado' : $meta7['emg_suporte_juridico'] ?></td>
        </tr>
        <tr>
            <td>Licencia atividades de Impacto local?</td>
            <td><?= (is_null($meta7['lic_atividades_impacto']) || $meta7['lic_atividades_impacto'] == '') ? 'Não Informado' : $meta7['lic_atividades_impacto'] ?></td>
        </tr>
        <tr>
            <td>Licencia atividades rurais?</td>
            <td><?= (is_null($meta7['lic_atividades_rurais']) || $meta7['lic_atividades_rurais'] == '') ? 'Não Informado' : $meta7['lic_atividades_rurais'] ?></td>
        </tr>
        <tr>
            <td>Licencia outras atividades?</td>
            <td><?= (is_null($meta7['lic_demais_atividades']) || $meta7['lic_demais_atividades'] == '') ? 'Não Informado' : $meta7['lic_demais_atividades'] ?></td>
        </tr>
    </tbody>
</table>