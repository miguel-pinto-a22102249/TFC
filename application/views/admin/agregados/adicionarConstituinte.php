<div class="area-adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="/admin/agregados/adicionar" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="NissConstituintePrincipal">Niss</label>
                            <input type="text" name="NissConstituintePrincipal" placeholder="Niss"/>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdAgregado">Agregado</label>
                            <input type="text" name="IdAgregado" placeholder="Agregado"/>
                        </div>
                    </div>
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="IdEscalao">Escalão</label>
                            <input type="text" name="IdEscalao" placeholder="Escalão"/>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Cria</button>
            </form>
        </div>
    </div>
</div>
