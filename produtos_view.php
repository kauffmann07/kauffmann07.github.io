<?php
include 'paginas/connection.php';
$dir = '/docs_nepmv/editais/';
$id = $_GET['municipio'];

$query = "SELECT mp.id, e.descricao as'edital_descricao', m.nome_municipio, et.descricao , em.nome as 'empresa', e.numero 'numero_edital', c.numero as 'numero_contrato',
    p.nome as 'nome_produto', p.arquivo as 'arquivo_produto', c.arquivo as 'arquivo_contrato', e.titulo 
    FROM municipios_produtos mp join produtos p on 
    p.id = mp.produto_id 
    join municipio m on 
    m.id = mp.municipio_id
    join contratos c on 
    c.id = p.contrato_id 
    join editais e on 
    e.id = c.edital_id 
    join empresas em on 
    em.id = c.empresa_id 
    join edital_tipos et on 
    et.id = e.edital_tipo_id 
    where m.id = $id
    order by m.nome_municipio asc";

$resultado = mysqli_query($connection, $query);

?>
<table class="table table-active table-bordered table-sm">
    <thead class="thead-dark">
        
        <tr>
            <th colspan="5" style="text-align: center;"> Projeto Fundo Amazônia: Produtos de Contratos no Município </th>
        </tr>

        <tr>
            <th>Edital</th>
            <th>Contrato</th>
            <th>Descrição</th>
            <th>Empresa</th>
            <th>Produto</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($produtos = mysqli_fetch_array($resultado)) { ?>
            <tr>
                <td><strong><?= $produtos['descricao'] . ' ' . $produtos['numero_edital'] ?><strong></td>
                <td><?= $produtos['numero_contrato'] .PHP_EOL. ' (' . $produtos['titulo'] . ')'?></td>
                <td><?= $produtos['edital_descricao'] ?></td>
                <td><?= $produtos['empresa'] ?></td>
                <?php
                ?>
                <td><a href="<?= $dir . $produtos['arquivo_produto'] ?>" target="_blank"><?= $produtos['arquivo_produto'] ?></a> </td>
            <?php } ?>

            </tr>

    </tbody>

</table>