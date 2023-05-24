<?php
require 'connection.php';
include 'paginas/controller/functions.php';

if (isset($_GET['pesquisar'])) {
    $municipio_id = $_GET['municipio'];
    header("location: /ficha-resumo/?municipio=$municipio_id&pesquisar=Pesquisar");
    if ($municipio_id != "selecione") {
?>

        <h1>Ficha Resumo <img src="/docs_nepmv/imagens/layout01/ico-relatorio.png"></h1>

        <!-- Município / Região Integração -->
        <?php include_once 'paginas/view/relatorios/regiao_integracao_view.php'; ?>

        <!-- Caracterização Geral -->

        <?php include_once 'paginas/view/relatorios/caracterizacao_geral_view.php'; ?>

        <!-- População -->
        <?php include_once 'paginas/view/relatorios/populacao_view.php'; ?>

        <!-- Adesão ao PMV -->
        <?php include_once 'paginas/view/relatorios/adesao_pmv_view.php'; ?>

        <!-- Situação do Município quanto às Metas do PMV -->
        <?php include_once 'paginas/view/relatorios/situacao_metas_pmv_view.php' ?>

        <!-- Cadastro Ambiental Rural (CAR) -->
        <?php include_once 'paginas/view/relatorios/car_view.php' ?>

        <!-- Desmatamento no Municipio -->
        <?php include_once 'paginas/view/relatorios/desmatamento_municipio_view.php'; ?>

        <!-- Lista do MMA dos municípios que mais desmatam na Amazônia -->
        <?php include_once 'paginas/view/relatorios/lista_mma_desmatamento_view.php' ?>

        <!-- Dados Cadastrais (municipio_quadro) -->
        <?php include_once 'paginas/view/relatorios/municipio_quadro_view.php'; ?>

        <!-- Cadastro Complementar -->
        <?php include_once 'paginas/view/relatorios/dados_municipio_view.php';?>

        <!-- Gestão Ambiental Municipal -->
        <?php include_once 'paginas/view/relatorios/gestao_ambiental_municipal_view.php'; ?>

        <!-- Possuir Sistema e Órgão Municipal de Meio Ambiente Estruturados -->
        <?php include_once 'paginas/view/relatorios/meta7_view.php'; ?>

        <!-- ICMS Verde -->
        <?php include_once 'paginas/view/relatorios/icms_verde_view.php'; ?>

<?php } else {
        header("location: /?page_id=918");
    }
}
?>
<style>
    table {
        font-size: 15px;
    }
</style>