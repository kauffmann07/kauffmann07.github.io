<?php

require 'connection.php';
?>
    <label>Escolha um Município: </label>
    <div class='form-row align-itens-center'>
        <div class='col-auto-my-1' >    
        <select class='custom-select mr-sm-2' id= municipio name=municipio required>
        <option value = ""> Selecione um municipio</option>

    <?php while ($row = mysqli_fetch_array($consulta_municipio)){ ?>
        <option value="<?= $row['id']?>"><?= $row['nome_municipio']?></option>
    <?php } ?> 
        </select>
        </div>
    </div>

<hr/>

<input class="btn btn-success" name="pesquisar" type="submit" value="Pesquisar" />


