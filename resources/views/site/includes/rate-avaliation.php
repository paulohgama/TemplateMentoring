<!-- Alert Modal --> 
<div class="modal fade" id="avaliation-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">      
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          Fechar
        </button>        
     

      <div class="modal-title">
        <h4>Envie o seu depoimento</h4>
        <p class="mb-0">Nos conte o que achou deste atendimento.</p>
      </div>

      <div class="modal-body">
            <p class="pinky">Dê uma nota para o atendente: </p>
            <form action="../Depoimento" method="post" class="default" enctype="multipart/form-data">
            <?php echo csrf_field() ?>
            <input type="hidden" name="fk_depoimento_consultor" value="<?php echo $atendimento[0]->cd_consultor ?>">
            <input type="hidden" name="fk_depoimento_visitante" value="<?php echo $atendimento[0]->cd_visitante ?>">
                <div class="wrap-rating">
                    <select class="rating" name="nt_depoimento" required>
                        <option value="1">1</option>                        
                        <option value="2">2</option>                          
                        <option value="3">3</option>                         
                        <option value="4">4</option>                      
                        <option value="5">5</option>
                    </select>
                </div>
                <p class="mb-2">Escreva algum comentário sobre o consultor que te atendeu:</p>
                <div class="form-group">
                    <textarea name="ds_depoimento" placeholder="Digite aqui seu comentário" class="form-control" required></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" id="depoimento">Avaliar</button>
                </div>
            </form>
      </div>
    </div>
  </div>
</div>
