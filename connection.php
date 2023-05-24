
<?php
$servidor = "192.168.0.24";
$user = "nepmv";
$pwd = "Nepmv@2020";
$database = "nepmv";


$connection = mysqli_connect($servidor,$user, $pwd,$database) or die ("Erro ao conectar");

$query = "select * from regiao_integracao";
$consulta_regiao = mysqli_query($connection,$query);


$query = "select * from municipio order by nome_municipio asc";
$consulta_municipio = mysqli_query($connection,$query);

$query = "select * from pessoa where instituicao_id != '1'";
$consulta_pessoa = mysqli_query($connection,$query);


$query = "select * from fonte_dados";
$fonte_dados = mysqli_query($connection,$query);

$query = "select * from natureza_informacao";
$natureza_informacao = mysqli_query($connection,$query);

$query = "select td.id,td.nome, ni.nome as 'natureza_informacao', fd.nome as 'fonte_dados', td.frequencia_atualizacao ,td.unidade_medida 
FROM nepmv.tipo_dados td 
join natureza_informacao ni on 
ni.id = td.natureza_informacao_id 
join fonte_dados fd on 
fd.id = td.fonte_dados_id ";

$tipo_dados = mysqli_query($connection,$query);

$query = "select sd.id, sd.nome as 'serie_dado', td.nome as 'tipo_dado', sd.data from serie_dados sd join tipo_dados td on
sd.tipo_dados_id = td.id order by sd.nome asc";

$serie_dados = mysqli_query($connection,$query);


$query = "select m.id, m.nome_municipio as 'municipio', sd.nome as 'serie_dados', mi.indice 
from municipio_indices mi join serie_dados sd on 
mi.serie_dados_id = sd.id join municipio m on 
mi.municipio_id = m.id order by sd.id asc";

$indice_municipio = mysqli_query($connection,$query);

$query = "select m.id, m.nome_municipio as 'municipio', sd.nome as 'serie_dados',ma.`data` as 'data',ma.area 
from municipio_areas ma join serie_dados sd on 
ma.serie_dados_id = sd.id join municipio m on 
ma.municipio_id = m.id order by sd.id asc";

$municipio_areas = mysqli_query($connection,$query);


$query = "select p.id,m.nome_municipio as 'municipio' ,sd.nome as 'serie_dados', p.total, p.urbana,p.rural from populacoes p 
join municipio m on m.id = p.municipio_id 
join serie_dados sd on p.serie_dado_id = sd.id order by nome_municipio asc";

$populacoes = mysqli_query($connection,$query);

$query = "select * from prodes_dados ";

$prodes_dados = mysqli_query($connection,$query);

$query = "select ma.id, m.nome_municipio, ma.tc_mpf_data as 'TC_MPF', ma.adesao_pmv_data as 'adesao_pmv', ma.pacto_desm_data as 'pacto_desm', ma.grupo_trabalho_data as 'GT'
from municipio_adesoes ma join municipio m on 
m.id = ma.municipio_id ";

$municipio_adesoes = mysqli_query($connection,$query);

$query = "select * from municipio_adesoes_arquivos";
$arquivos = mysqli_query($connection,$query);

?>