<?php
include 'paginas/connection.php';
$query = "select gestao_ambiental_habilitado, gestao_ambiental_7389_iniciou, gestao_ambiental_079_iniciou, gestao_ambiental_tgadc_iniciou, gestao_ambiental_7389_data, 
gestao_ambiental_079_data, gestao_ambiental_tgadc_data
from gestao_ambientais ga where municipio_id = $municipio_id";

$resultado = mysqli_query($connection, $query);
$ga = mysqli_fetch_array($resultado);
?>

<table class="table table-sm">
    <thead class="thead-dark">
        <tr>
            <th colspan=2>Gestão Ambiental Municipal</th>
        </tr>
        <tr>
    </thead>
    <tbody class="table-active">

        <?php
        $gestao_ambiental_7389  = $ga['gestao_ambiental_7389_iniciou'];
        $gestao_ambiental_079   = $ga['gestao_ambiental_079_iniciou'];
        $gestao_ambiental_tgadc = $ga['gestao_ambiental_tgadc_iniciou'];

        $gestao_ambiental_7389_data  = $ga['gestao_ambiental_7389_data'];
        $gestao_ambiental_079_data   = $ga['gestao_ambiental_079_data'];
        $gestao_ambiental_tgadc_data = $ga['gestao_ambiental_tgadc_data'];


        if ($gestao_ambiental_7389 == 'sim') {
            $gestao_ambiental_instrumento = 'Lei Estadual 7.389';
            $gestao_ambiental_data = $gestao_ambiental_7389_data;
        } elseif ($gestao_ambiental_079 == 'sim') {
            $gestao_ambiental_instrumento = 'Resolução COEMA 079';
            $gestao_ambiental_data = $gestao_ambiental_079_data;
        } elseif ($gestao_ambiental_tgadc == 'sim') {
            $gestao_ambiental_instrumento = 'TGADC';
            $gestao_ambiental_data = $gestao_ambiental_tgadc_data;
        } else {
            $gestao_ambiental_instrumento = 'não disponível';
        }

        $gestao_ambiental_data = isset($gestao_ambiental_data) ? date('d/m/Y', strtotime($gestao_ambiental_data)) : null; ?>
        <tr>
            <td>Relação de Municípios que possuem capacidade de exercer a Gestão Ambiental </td>
            <td><?= $gestao_ambiental_habilitado = (isset($ga['gestao_ambiental_habilitado']) ? "SIM" : "NÃO") ?>

                <?php if ($gestao_ambiental_habilitado == 'SIM') : ?>
                    <?php echo $gestao_ambiental_instrumento ? '/  ' . $gestao_ambiental_instrumento : ''; ?>
                    <?php echo $gestao_ambiental_data ? ' assinado em ' . $gestao_ambiental_data : ''; ?>
                <?php endif; ?>
            </td>
        </tr>

    </tbody>
</table>