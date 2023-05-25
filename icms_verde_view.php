<table class='table table-bordered table-sm'>
    <thead class="thead-dark">
        <tr>
            <th colspan=13>ICMS Verde</th>
        </tr>
        <tr>
    </thead>
    <tbody class="table-active">
        <?php

        $query = "select mi.municipio_id, min(year(sd.data)) as 'min', max(year(sd.data)) as 'max' from municipio_indices mi join serie_dados sd 
                    on sd.id = mi.serie_dados_id where municipio_id =$municipio_id";
        $data_indice = mysqli_query($connection, $query);
        ?>
        <tr>
            <td class="text-center">Ano/mês</td>
            <?php for ($i_mes = 1; $i_mes <= 12; $i_mes++) { ?>
                <td class="text-center"><?php echo $i_mes; ?></td>

            <?php } ?>
        </tr>
        <?php
        $sql = "select mi.municipio_id, mi.indice, YEAR (sd.data) as 'ano',MONTH (data) as 'mes' from municipio_indices mi join serie_dados sd 
                    on sd.id = mi.serie_dados_id where municipio_id = $municipio_id order by sd.data asc";
        $indice_municipios = mysqli_query($connection, $sql);

        while ($datas = mysqli_fetch_array($data_indice)) {
            while ($indices = mysqli_fetch_array($indice_municipios)) { ?>

                <?php $vetor_mes = $indices['mes']; ?>
                <?php $vetor_ano = $indices['ano']; ?>
            <?php $indice = $indices['indice'];
                $vetor_ano_mes[$vetor_ano][$vetor_mes] = $indice;

                $ano_max = $datas['max'];
                $ano_min = $datas['min'];
            }
            ?>

            <?php for ($i_ano = $ano_min; $i_ano <= $ano_max; $i_ano++) { ?>
                <tr>
                    <td class="text-center"><strong><?php echo $i_ano; ?></strong></td>
                    <?php ?>
                    <?php for ($i_mes = 1; $i_mes <= 12; $i_mes++) { ?>

                        <td class="text-center"><span><?php echo isset($vetor_ano_mes[$i_ano][$i_mes]) ? $vetor_ano_mes[$i_ano][$i_mes] : ''; ?></span></td>
            <?php }
                }
            } ?>


                </tr>
    </tbody>
</table>