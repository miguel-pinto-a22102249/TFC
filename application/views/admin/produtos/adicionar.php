<div class="area-adicionar">
    <div class="row">
        <div class="column large-8 medium-10 small-12 form-login-wrapper">
            <form action="/admin/produtos/adicionar" method="POST" class="form-ajax" enctype="multipart/form-data">
                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Nome">Nome</label>
                            <input type="text" id="Nome" name="Nome" placeholder="Nome"/>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="Detalhes">Detalhes</label>
                            <textarea type="text" id="Detalhes" name="Detalhes" rows="3" placeholder="Detalhes"></textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="column large-6 medium-6 small-12">
                        <div class="input-group">
                            <label for="StockAtual">Stock Atual</label>
                            <input type="number" step="1" id="StockAtual" name="StockAtual" placeholder="Stock Atual"/>
                        </div>
                    </div>
                </div>
                <button class="bottom btn-style" type="submit">Cria</button>
            </form>
        </div>
    </div>
</div>
