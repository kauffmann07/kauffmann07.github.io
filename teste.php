<?php
include 'connection.php';
$dir = '/docs_nepmv/geral/produtos/';

$query = 'select p.id, p.nome, e.titulo as "Edital Titulo", c.id as "Contrato", c.numero, c.valor_total, p.arquivo from produtos p inner join contratos c on
    p.contrato_id = c.id inner join editais e on 
    e.id = c.edital_id ';
    $retorno = mysqli_query($connection, $query);
   
?>
<table class="table table-sm">
    <thead class="thead-dark">
        <tr>
            <th>Nome</th>
            <th>N° Contrato</th>
            <th>Arquivo</th>
        </tr>
    </thead>
    <tbody class="table-active">
    <?php while($contrato = mysqli_fetch_array($retorno)){ ?>
        <tr>
            <td><?=$contrato['nome']?></td>
            <td><?=$contrato['numero']?></td>
            <td><a href="<?=$dir.$contrato['arquivo']?>" target="_blank"><img src="/docs_nepmv/imagens/pdf.png"></a></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
