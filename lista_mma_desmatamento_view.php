<?php
$query = "select cp.nome, cp.id, cpm.municipio_id from categoria_pmv cp join categoria_pmv_municipio cpm
    on cp.id = cpm.categoria_pmv_id where municipio_id = $municipio_id";
$resultado = mysqli_query($connection, $query);
$categoria = mysqli_fetch_array($resultado);
?>

<table class="table table-sm">
    <thead class='thead-dark'>
        <tr>
            <th colspan='2'>Lista do MMA dos municípios que mais desmatam na Amazônia</th>
        </tr>
    </thead>
    <tbody class="table-active">
        <tr>
            <td>Não estar na lista dos municípios que mais desmatam na Amazônia</td>
            <td><?= sim_nao(($categoria['id'] != 2), array("Não está na lista", "Está na Lista")) ?></td>
        </tr>
    </tbody>
</table>