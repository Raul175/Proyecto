<?php 
    require_once('controllers/localidad_controller.php');
    $localidades = selectAllLocalidadesHoteles();
    if (empty($localidades)){
        $localidades = [];
    }
    $cont = 0;
?>
<div class="container-fluid booking pb-5 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="bg-white shadow" style="padding: 35px;">
                    <form class="row g-2" id="searchForm">
                        <div class="col-md-10">
                            <div class="row g-2">
                                <!--Cuando este hecha la función de reservar y pagar-->
                                <div class="col-md-3">
                                    <div class="date" id="date1">
                                        <label for="fechaEntrada">Fecha Entrada</label>
                                        <input type="date" value="<?= isset($_GET['entrada']) ? $_GET['entrada'] : '' ?>" id="entrada" class="form-control" placeholder="Fecha Entrada"/>
                                        <div class="invalid-feedback" style="display: none;" id="entrada-error">
                                            Por favor, selecciona una fecha de entrada.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="date" id="date2">
                                        <label for="fechaEntrada">Fecha Salida</label>
                                        <input type="date" id="salida" value="<?= isset($_GET['salida']) ? $_GET['salida'] : '' ?>" class="form-control" placeholder="Fecha Salida"/>
                                        <div class="invalid-feedback" style="display: none;" id="salida-error">
                                            Por favor, selecciona una fecha de salida.
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="fechaEntrada">Localidad</label>
                                    <select class="form-select" id="lugar" onchange="document.getElementById('lugarTexto').value = this.options[this.selectedIndex].text">
                                        <?php if ($localidades != false && is_array($localidades)): ?>
                                            <?= !isset($_GET['lugar']) || $_GET['lugar'] == 0 || $_GET['lugar'] == '' ? '<option selected value="0">Adónde vas?</option>' : '' ?>
                                            <?php foreach($localidades as $localidad): ?>
                                                <?php 
                                                    if ($localidad['IdLocalidad'] == $_GET['lugar'] && isset($_GET['lugar'])){
                                                        echo '<option value="'.$localidad['IdLocalidad'].'" selected>'.$localidad['Nombre'].'</option>';
                                                    }else{
                                                        echo '<option value="'.$localidad['IdLocalidad'].'">'.$localidad['Nombre'].'</option>' ;
                                                    }
                                                 ?>
                                                <?php $cont=1; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option disabled selected value="0">No hay localidades disponibles</option>
                                        <?php endif; ?>
                                    </select>
                                    <input type="hidden" id="lugarTexto">
                                    <div class="invalid-feedback" style="display: none;" id="lugar-error">
                                        Por favor, selecciona un destino válido.
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <!-- is-invalid -->
                                    <div class="number">
                                        <label for="fechaEntrada">Nº Personas</label>
                                        <input type="number" id="npersonas4" value="<?= isset($_GET['npersonas']) ? $_GET['npersonas'] : '' ?>" class="form-control" min="1" placeholder="Nº Personas" data-target="#npersonas" oninput="this.value = Math.max(1, this.value)"/>
                                    </div>
                                    <div class="invalid-feedback" id="lugar-error2">
                                        Por favor, indica al menos 1 persona.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label></label>
                            <button class="btn btn-personalizado2 w-100">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>