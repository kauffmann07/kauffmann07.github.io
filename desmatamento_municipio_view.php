<table class="table table-sm">
    <thead class='thead-dark'>
        <tr>
            <th colspan='2'>Desmatamento no Municipio </th>
        </tr>
    </thead>
    <tbody class="table-active">
        <tr>
            <td> Desmatamento menor que 40Km² <?= substr($linha['serie_dados_nome'], 13) ?></td>
            <?php if ($linha['area_desmatamento'] < 40) { ?>
                <td>SIM</td>
            <?php } else { ?>
                <td>NÃO</td>
            <?php } ?>
        </tr>
        <tr>
            <td>PRODES <?= substr($linha['serie_dados_nome'], 13) ?></td>
            <td><?= $linha['area_desmatamento'] ?> Km²</td>
        </tr>
    </tbody>
</table>